<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 商户中心
 * @author chaituan@126.com
 */
class Center extends ShopCommon {
	
	public function index() {
		$this->load->view('shop/index');
	}
	
}
