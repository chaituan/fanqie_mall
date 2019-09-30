<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 摇一摇进入
 *
 * @author chaituan@126.com
 */
class Yao extends Yaoneed {
	public function index() {
		$this->output->cache ( 5000 );
		$data ['title'] = "demo活动";
		$this->load->view ( "wechat/yao/index", $data );
	}
	public function map() {
		$data ['title'] = "寻宝地图";
		$this->load->view ( "wechat/yao/map", $data );
	}
	public function edit_user() {
		$id = $this->User ['id'];
		$data = Posts ( 'data' );
		$r = $this->User_model->updates ( $data, "id=$id" );
		is_AjaxResult ( $r );
	}
	
	// 卡包
	public function card_bag() {
		$id = $this->User ['id'];
		$item = $this->User_model->getItem ( "id=$id" );
		$data ['user'] = $item;
		$data ['title'] = "卡包";
		$this->load->view ( "wechat/yao/card_bag", $data );
	}
	public function logout() {
		$this->User_model->logout ();
	}
}
