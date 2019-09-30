<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 微信登录
 *
 * @author chaituan@126.com
 */
use EasyWeChat\Foundation\Application;
class Login extends CI_Controller {
	
	// 注册
	public function signin() {
		$this->load->model('admin/User_model');
		$fwd = $_GET['fwd'];
		// 获取授权登录的微信用户信息
		$app = new Application(array());
		$user = $app->oauth->user()->toArray();
		if ($user['id']) {
			// 数据库是否存在
			$item = $this->User_model->get_user('openid',$user['id']);
			if (!$item) {
				$data = array (
						'openid' => $user['id'],
						'thumb' => $user['avatar'],
						'nickname' => $user['nickname'],
						'sex' => $user['original']['sex'],
						'groupid' => 1,
						'addtime' => time () 
				);
				$userid = $this->User_model->add ( $data );
				$item = $this->User_model->getItem("id=$userid");
			}
			$this->User_model->set_LoginUser ( $item );
		} else {
			showmessage ( "获取信息失败", 'error' );
		}
		if ($fwd) {
			if (urldecode ( $fwd ) == '/' || urldecode ( $fwd ) == '/?winzoom=1')redirect ( base_url ( urldecode('/' )));
			redirect ( site_url(urldecode($fwd)));
		} else {
			redirect ('http://www.1m15.com');
		}
	}
}
