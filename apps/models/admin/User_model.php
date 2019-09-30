<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 用户管理
 *
 * @author chaituan@126.com
 */
class User_model extends MY_Model {
	const sess = 'wechat_user_session';
	function __construct() {
		parent::__construct ();
		$this->table_name = 'user';
	}
	
	//关注微信后添加数据库
	function wechat_add_user($userinfo,$pid) {
		if($pid){
			$parent = $this->getItem("id=$pid",'p_1');
		}else{
			$pid = 0;$parent['p_1'] = 0;
		}
		$datas = array(
				'nickname'=>$userinfo['nickname'],
				'openid'=>$userinfo['openid'],
				'p_1'=>$pid,
				'p_2'=>$parent['p_1'],
				'thumb'=>$userinfo['headimgurl'],
				'sex'=>$userinfo['sex'],
				'groupid'=>1,
				'addtime'=>time()
		);
		$this->add($datas);
		$name = $userinfo['nickname'];
		return $name;
	}
	
	
	// 登录后存session
	function set_LoginUser($data) {
		return $this->session->set_userdata (self::sess, $data );
	}
	
	// 取登录后的信息
	function get_LoginUser() {
		return $this->session->{self::sess};
	}
	
	// 获取用户信息通过id或者openid
	function get_user($key, $value) {
		if ($key == 'id') {
			$where ['id'] = $value;
		} else {
			$where ['openid'] = $value;
		}
		$item = $this->getItem ( $where );
		return $item;
	}
	
	// 更新用户的session 根据id或者openid
	function update_usersession($key, $value) {
		$item = self::get_user ( $key, $value );
		self::set_LoginUser ( $item );
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
		$this->session->unset_userdata(self::sess);
		redirect ( site_url ( 'wechat/tips/logout' ) );
	}
}