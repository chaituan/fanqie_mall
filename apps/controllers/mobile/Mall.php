<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 商城
 * @author chaituan@126.com
 */
class Mall extends NeedLoginAction {
	
	function index(){
		//获取轮播
		$data['banner'] = get_Cache('Banner_cache');
		//获取分类
		$this->load->model(array('admin/Goods_cat_model','admin/News_model'));
		$data['cat'] = $this->Goods_cat_model->get_catcachetree(false);
		
		//获取产品 
		$this->load->model('admin/Goods_model');
		//商品列表条件
		$where = array(
			'thumb !='=>''
		); 
		$data['items'] =  $this->Goods_model->getItems($where,'id,names,thumb,sales,price','id desc',1,10,null,null,true);
		$data['pagemenu'] = $this->Goods_model->pagemenu;
		
		//头条
		$data['toutiao'] = $this->News_model->getItem('','id,title','hits desc');
		$this->load->view ('mobile/mall/index',$data);
	}
	
	function goods_ajax(){
		if(is_ajax_request()){
			$this->load->model('admin/Goods_model');
			//商品列表条件
			$where = array(
					'thumb !='=>''
			);
			$page = Posts('page','checkid');
			$items =  $this->Goods_model->getItems($where,'id,names,thumb,sales,price','id desc',$page,4,null,null,true);
			$pagemenu = $this->Goods_model->pagemenu;
			
			AjaxResult(1, 'ok',array('items'=>$items,'page_end'=>$pagemenu['end']));
		}
	}
	
	//商品详情
	function detail(){
		$id = Gets('id','checkid');
		$this->load->model(array('admin/Goods_model','admin/Comment_model'));
		$data['item'] =  $this->Goods_model->getItem("id=$id");
		if(!$data['item'])showmessage('产品不存在','error','mobile/mall/index');
		$data['comment_items'] = $this->Comment_model->getItems_join(array('user'=>"comment.uid=user.id+left"),"comment.gid=$id",'comment.content,comment.addtime,user.thumb,user.nickname','comment.id desc',1,20,null,null,true);
		$data['pagemenu'] = $this->Comment_model->pagemenu;
		$this->load->view('mobile/mall/detail',$data);
	}
	
	//商品评价
	function detail_comment(){
		if(is_ajax_request()){
			$id = Posts('gid','checkid');
			$page = Posts('page','checkid');
			$this->load->model('admin/Comment_model');
			$items = $this->Comment_model->getItems_join(array('user'=>"comment.uid=user.id+left"),"comment.gid=$id",'comment.content,comment.addtime,user.thumb,user.nickname','comment.id desc',$page,1,null,null,true);
			$pagemenu = $this->Comment_model->pagemenu;
			AjaxResult(1, 'ok',array('items'=>$items,'page_end'=>$pagemenu['end']));
		}
	}
	
	//商品列表
	function lists(){
		$id = Gets('id','checkid');
		$this->load->model('admin/Goods_cat_model');
		$cats = $this->Goods_cat_model->get_catcachetree(false);
		$first = 0;
		$catid = null;
		foreach ($cats as $v){
			if ($v['id'] == $id) {
				$first = 1;
				$data['adimg'] = $v['thumbadv'];
				if(isset($v['children'])){
					$cat = $v['children'];
					foreach ($v['children'] as $vs){
						$catid [] = $vs ['id'];
					}
				}
			}
		}
		if(!$first){//如果不是一级分类 就循环出二级分类  最多二级
			foreach ($cats as $v){
				if(isset($v['children'])){
					foreach ($v['children'] as $vs){
						if ($vs['id'] == $id) {
							$data['adimg'] = $vs['thumbadv'];
							$catid[] = $id;
							break;
						}
					}
				}
			}
		}else{
			$catid[] = $id;//加上本身的分类id
		}
		$data['cat'] = isset($cat)?$cat:null;//获取下级
		if($catid){
			$this->load->model('admin/Goods_model');
			$catstring = implode(',', $catid);//下级id的所有产品
			$data['items'] =  $this->Goods_model->getItems("putaway=1 and catid in ($catstring)");
		}else{
			$data['items'] = 0;
		}
	
		$this->load->view ('mobile/mall/lists',$data);
	}
	
}
