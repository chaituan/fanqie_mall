<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 后台用户管理
 *
 * @author chaituan@126.com
 */
class AdminUser_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'admin_user';
	}
	// 登录后存session
	function set_LoginUser($data) {
		return $this->session->set_userdata ( self::ADMIN_SESSION_USER, $data );
	}
	// 取登录后的信息
	function get_LoginUser() {
		return $this->session->{self::ADMIN_SESSION_USER};
	}
	// 获取管理员权限
	function updateUserPermission($user) {
		$this->load->model ( 'admin/AdminRole_model' );
		$permissions = $this->AdminRole_model->getItem ( 'id=' . $user ['role_id'] );
		$this->session->set_userdata ( self::ADMIN_SESSION_PERMISSION, json_decode ( urldecode ( $permissions ['permissions'] ), true ) );
	}
	
	// 获取当前登录管理员权限
	function getPermissions() {
		return $this->session->{self::ADMIN_SESSION_PERMISSION};
	}
	
	// 管理员权限
	function hasPermission($opt, &$permissions) {
		$__opt = explode ( '@', $opt );
		// 加载权限选项
		$this->config->load ( 'adminpermission', false, true );
		$permissionOptions = $this->config->item ( 'adminpermission' );
		
		if (! isset ( $permissionOptions [$__opt [0]] ['methods'] [$__opt [1]] )) {
			// 不需要进行权限验证
			return true;
		} else {
			return ($permissions [$opt] == 1);
		}
	}
	
	// 是否是超级管理员
	function isSuperManager($user) {
		return in_array ( $user ['id'], array (
				1 
		) );
	}
	
	// 退出系统
	function logout() {
		$this->session->unset_userdata(self::ADMIN_SESSION_PERMISSION);
		redirect ( site_url ( 'adminct/login/index' ) );
	}
}