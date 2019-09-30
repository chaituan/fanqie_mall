<?php
/**
 * 店铺
 * @author  chaituan@126.com
 */
class Shop_model extends MY_Model {
	public function __construct() {
		parent::__construct ();
		$this->table_name = 'shop';
	}
	
	// 登录后存session
	function set_LoginUser($data) {
		return $this->session->set_userdata ( self::SHOP_SESSION_USER, $data );
	}
	// 取登录后的信息
	function get_LoginUser() {
		return $this->session->{self::SHOP_SESSION_USER};
	}
	
	//使用数组更新session
	function up_user_session($data){
		$user = self::get_LoginUser();
		foreach ($user as $key=>$v){
			if(array_key_exists($key, $data)){
				$new[$key] = $data[$key];
			}else{
				$new[$key] = $v;
			}
		}
		self::set_LoginUser($new);
	}
	//更新数据库和session
	function updates_se($data,$where){
		$r = $this->updates($data, $where);
		$this->up_user_session($data);
		return $r;
	}
	
	// 退出系统
	function logout() {
		$this->session->unset_userdata(self::SHOP_SESSION_USER);
		redirect (site_url('shop/login/index'));
	}
} 