<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 头条
 * @author chaituan@126.com
 */
class News extends NeedLoginAction {
	
	function index(){
		$id = Gets('id','checkid');
		$where = '';
		if($id){
			$where['catid'] = $id;
		}
		$this->load->model('admin/News_model');
		
		$data['newItems'] = $this->News_model->getItems($where,'','id desc',1,30,null,null,true);
		$data['pagemenu'] = $this->News_model->pagemenu;
		
		$cat = get_Cache('newscat');
		$data['cat'] = $cat?$cat:showmessage("获取分类失败",'error'); 
		$data['xz'] = $id?$id:0;
		$this->load->view ('mobile/news/index',$data);
	}
	
	function detail(){
		$id = Gets('id','checkid');
		if($id){
			$this->load->model(array('admin/News_model','admin/News_comment_model'));
			$where['id'] = $id;
			$data['item'] = $this->News_model->getItem($where,'');
			$this->News_model->updates(array('hits'=>'+=1'),$where);
			
			//留言
			$data['comment_items'] = $this->News_comment_model->getItems("nid=$id",'','id desc',1,2,null,null,true);
			$data['pagemenu'] = $this->News_comment_model->pagemenu;
			
			$this->load->view ('mobile/news/detail',$data);
		}
	}
	
	//添加文章评价
	function message(){
		if(is_ajax_request()){
			$data = Posts('data');
			if(!$data)AjaxResult_error();
			$uid =  $this->User['id'];
			$data['uid'] = $uid;$data['nickname'] = $this->User['nickname'];$data['thumb'] = $this->User['thumb'];$data['addtime'] = time();
			$this->load->model('admin/News_comment_model');
			$count = $this->News_comment_model->count(array('uid'=>$uid,'nid'=>$data['nid']));
			if($count>4)AjaxResult_error('留言次数上线');
			$result = $this->News_comment_model->add($data);
			is_AjaxResult($result);
		}
	}
	
	function get_message(){
		if(is_ajax_request()){
			$id = Posts('nid','checkid');
			$page = Posts('page','checkid');
			$this->load->model('admin/News_comment_model');
			$items = $this->News_comment_model->getItems("nid=$id",'','id desc',$page,2,null,null,true);
			$pagemenu = $this->News_comment_model->pagemenu;
			AjaxResult(1, 'ok',array('items'=>$items,'page_end'=>$pagemenu['end']));
		}
	}
	

}
