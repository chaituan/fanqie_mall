<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 后台登录页面
 *
 * @author chaituan@126.com
 */
class Login extends CI_Controller {
	public function index() {
		$this->output->cache(525600);
		$this->load->view('admin/login');
	}
	public function add() {
		$this->load->model ('admin/AdminUser_model');
		if (is_ajax_request ()) {
			$check_data = Posts ();
			// 获取登录口令
			$adminuser = $this->AdminUser_model->getItem (array('username' => $check_data ['username']),'username,encrypt');
			if(!$adminuser)AjaxResult('2','帐号不存在');
			// 密码错误剩余重试次数
			$ip = $this->input->ip_address();
			$this->load->model ( 'admin/Times_model' );
			$rtime = $this->Times_model->getItem ( array (
					'username' => $check_data ['username'],
					'is_admin' => 1 
			) );
			$maxloginfailedtimes = 6;
			if ($rtime) {
				if ($rtime ['failure_times'] >= $maxloginfailedtimes) {
					$minute = 60 - floor ( (time () - $rtime ['login_time']) / 60 );
					if ($minute > 1) {
						AjaxResult ( '2', '密码尝试次数过多，被锁定一个小时' );
					} else { // 到时间后删除
						$this->Times_model->deletes ( array (
								'username' => $adminuser ['username'] 
						) );
					}
				}
			}
			// 验证口令
			$item = $this->AdminUser_model->getItem ( array (
					'username' => $adminuser ['username'],
					'password' => get_password ( $check_data ['password'], $adminuser ['encrypt'] ) 
			) );
			if ($item) {
				unset($item['password'],$item['encrypt']);//销毁重要数据
				$this->Times_model->deletes ( array (
						'username' => $adminuser ['username'] 
				) ); // 登录成功删除记录
				$this->AdminUser_model->set_LoginUser ( $item );
				$this->AdminUser_model->updateUserPermission ( $item ); // 获取权限
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
							'username' => $adminuser ['username'] 
					) );
				} else {
					$this->Times_model->add ( array (
							'username' => $adminuser ['username'],
							'login_ip' => $ip,
							'is_admin' => 1,
							'login_time' => time (),
							'failure_times' => 1 
					), false );
					$times = $maxloginfailedtimes;
				}
				AjaxResult ( '2', '密码错误,您还有' . $times . '机会' );
			}
		}
		$this->load->view ( 'admin/login' );
	}
	public function logout() {
		$this->load->model ( 'admin/AdminUser_model' );
		$this->AdminUser_model->logout ();
	}
}
