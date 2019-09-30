<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 产品分类
 * @author chaituan@126.com
 */
class Cat extends NeedLoginAction {
	
	function index(){
		$this->load->view ('mobile/cat/index');
	}
	
	function list_load(){
		AjaxResult(1, '获取成功',array(array('time'=>time()),array('time'=>time())));
	}
	
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
		}
		
		$data['cat'] = isset($cat)?$cat:null;//获取下级
		if($catid){
			$this->load->model('admin/Goods_model');
			$catstring = implode(',', $catid);//下级id的所有产品
			$data['items'] =  $this->Goods_model->getItems("putaway=1 and catid in ($catstring)");
		}else{
			$data['items'] = 0;
		}
		
		$this->load->view ('mobile/cat/lists',$data);
	}
}
