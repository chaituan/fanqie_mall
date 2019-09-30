<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 登录注册退出都在这里
 *
 * @author chaituan@126.com
 */
class Info extends CI_Controller {
	public function register() {
		if($this->session->{USERFQ_SESSION})AjaxResult_error ( 2, '帐号已经登录' );
		$this->load->model ( 'admin/User_model' );
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$nickname = $data ['nickname'];
			$mobile = $data ['mobile'];
			$user = $this->User_model->getItem ( "nickname='$nickname' or mobile='$mobile'", 'nickname,mobile' );
			if ($user ['nickname'] == $nickname) {
				AjaxResult ( 2, "昵称已存在" );
			} elseif ($user ['mobile'] == $mobile) {
				AjaxResult ( 2, "手机号已存在" );
			} else {
				$pwd = set_password ( $data ['password'] );
				$data ['password'] = $pwd ['password'];
				$data ['encrypt'] = $pwd ['encrypt'];
				$data ['addtime'] = time ();
				$data ['username'] = $data ['mobile'];
				$id = $this->User_model->add ( $data );
				if ($id) {
					$data ['id'] = $id;
					unset ( $data ['password'], $data ['encrypt'] );
					$this->session->set_userdata ( USERFQ_SESSION, $data );
					AjaxResult_ok ();
				} else {
					AjaxResult_error ();
				}
			}
		} else {
			AjaxResult_error ();
		}
	}
	
	public function login() {
		if ($this->session->{USERFQ_SESSION})
			AjaxResult_error ( 2, '帐号已经登录' );
		$this->load->model ( 'admin/User_model' );
		if (is_ajax_request ()) {
			$check_data = Posts ( 'data' );
			// 获取登录口令
			$adminuser = $this->User_model->getItem ( array (
					'mobile' => $check_data ['mobile'] 
			) );
			if (! $adminuser ['mobile'])
				AjaxResult ( 2, '帐号不存在' );
				
				// 密码错误剩余重试次数
			$ip = $this->input->ip_address ();
			$this->load->model ( 'admin/Times_model' );
			$rtime = $this->Times_model->getItem ( array (
					'username' => $check_data ['mobile'],
					'is_admin' => 1 
			) );
			$maxloginfailedtimes = 6;
			if ($rtime) {
				if ($rtime ['failure_times'] >= $maxloginfailedtimes) {
					$minute = 60 - floor ( (time () - $rtime ['login_time']) / 60 );
					if ($minute > 1) {
						AjaxResult ( 2, '密码尝试次数过多，被锁定一个小时' );
					} else { // 到时间后删除
						$this->Times_model->deletes ( array (
								'username' => $adminuser ['mobile'] 
						) );
					}
				}
			}
			// 验证密码
			if ($adminuser ['password'] == get_password ( $check_data ['password'], $adminuser ['encrypt'] )) {
				$this->Times_model->deletes ( array (
						'username' => $adminuser ['mobile'] 
				) ); // 登录成功删除记录
				unset ( $adminuser ['password'], $adminuser ['encrypt'] );
				$this->session->{USERFQ_SESSION} = $adminuser;
				AjaxResult_ok ();
			} else {
				// 更新登录次数
				if ($rtime && $rtime ['failure_times'] < $maxloginfailedtimes) {
					$times = $maxloginfailedtimes - intval ( $rtime ['failure_times'] );
					$this->Times_model->updates ( array (
							'login_ip' => $ip,
							'is_admin' => 1,
							'failure_times' => '+=1' 
					), array (
							'username' => $adminuser ['mobile'] 
					) );
				} else {
					$this->Times_model->add ( array (
							'username' => $adminuser ['mobile'],
							'login_ip' => $ip,
							'is_admin' => 1,
							'login_time' => time (),
							'failure_times' => 1 
					), false );
					$times = $maxloginfailedtimes;
				}
				AjaxResult ( 2, '密码错误,您还有' . $times . '机会' );
			}
		}
	}
	public function logout() {
		$this->session->sess_destroy ();
		redirect ( site_url ( 'home/info/login' ) );
	}
}
