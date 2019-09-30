<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 评价管理
 * @author chaituan@126.com
 */
class Comment extends ShopCommon {
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('admin/Goods_model','admin/Comment_model'));
	}
	
	public function index() {
		$gid = Gets('name','checkid');
		$data ['items'] = '';
		if($gid){
			$item = $this->Goods_model->getItem(array('id'=>$gid,'shopid'=>$this->shop_user['id']));
			if($item){
				$data ['items'] = $this->Comment_model->getItems(array('gid'=>$gid));
			}
			$data ['name'] = $gid;
		}
		$this->load->view('shop/order/comment',$data);
	}
}
