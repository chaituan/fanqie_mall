<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 商户中心
 * @author chaituan@126.com
 */
class Mall extends ShopCommon {
	
	public function index() {
		$this->load->view('shop/mall/index');
	}
	
	public function edit(){
		if(is_ajax_request()){
			$datas = Posts('data');
			$this->load->model('admin/Shop_model');
			$data = array('username'=>$datas['username'],'company'=>$datas['company'],'thumb'=>$datas['thumb']);
			$result = $this->Shop_model->updates_se($data,'id='.$this->shop_user['id']);
			is_AjaxResult($result);
		}
	}
}
