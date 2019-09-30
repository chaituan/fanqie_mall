<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 提示页面，为其他页面跳转用的
 *
 * @author chaituan@126.com
 */
class Tips extends CI_Controller {
	public function yao() {
		$data ['title'] = "demo活动";
		$this->load->view ( 'wechat/tips/yao', $data );
	}
	public function logout() {
		exit ( '退出成功' );
	}
}
