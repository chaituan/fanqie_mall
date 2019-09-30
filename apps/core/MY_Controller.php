<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 后台公共类
 * @author chaituan@126.com
 */
class AdminCommon extends CI_Controller {
	
	protected $loginUser; // 管理员信息
	public function __construct() {
		parent::__construct ();
		// 处理url的参数问题
		parseURL ( $this->uri->segment ( 4 ) );
		// 实例化菜单数据模型
		$this->load->model (array(
				'admin/AdminMenuGroup_model',
				'admin/AdminMenu_model',
				'admin/AdminUser_model' 
		)); // 加载数据模型
		     // 判断登录状态
		$this->loginUser = $this->AdminUser_model->get_LoginUser ();
		
		if (! $this->AdminUser_model->get_LoginUser ()) {
			redirect ( site_url ( 'adminct/login/index' ) );
		} else {
			$this->load->vars ( 'loginUser', $this->loginUser );
		}
		
		// 获取菜单分组缓存
		$groupCache = $this->AdminMenuGroup_model->getGroupCache ();
		
		$__menuGroups = changeArrayKey ( $groupCache, 'id' );
		
		// 初始化左侧菜单的选中状态
		$sort_num = array ();
		foreach ( $__menuGroups as $_m ) {
			$sort_num [] = $_m ['sort_num'];
		}
		array_multisort ( $sort_num, SORT_ASC, $__menuGroups );
		$current = current ( $__menuGroups );
		// 获取mid
		$mid = Gets ( 'm', 'checkid' );
		if ($mid > 0) {
			$this->session->set_userdata ( 'm', $mid );
			$menu = $this->AdminMenu_model->getItem ( "id=$mid" );
			$mpid = $menu ['pid'];
			$mgroup = $menu ['groupkey'];
			$this->session->set_userdata ( 'mpid', $mpid );
			$this->session->set_userdata ( 'mgroup', $mgroup );
		} else {
			$mpid = $this->session->mpid;
			$mgroup = $this->session->mgroup ? $this->session->mgroup : $current ['tkey'];
			$mid = $this->session->m;
		}
		// 获取菜单数据
		$permissions = $this->AdminUser_model->getPermissions ();
		$systemMenu = $this->AdminMenu_model->getMenuByUser ( $this->loginUser );
		$this->load->vars ( '__menuGroups', $__menuGroups );
		$this->load->vars ( 'systemMenu', $systemMenu );
		$this->load->vars ( 'mpid', $mpid );
		$this->load->vars ( 'mgroup', $mgroup );
		$this->load->vars ( 'mid', $mid );
		$this->load->vars ( 'add_url', '/' . $this->router->directory . $this->router->class . '/add' );
		$this->load->vars ( 'edit_url', '/' . $this->router->directory . $this->router->class . '/edit' );
		$this->load->vars ( 'index_url', '/' . $this->router->directory . $this->router->class . '/index' );
		
		$currentOpt = '/' . $this->router->directory . $this->router->class . '/' . $this->router->method;
		$this->load->vars ( 'currentOpt', $currentOpt );
		
		// 权限认证
		$opt = $this->router->class . '@' . $this->router->method;
		if (! $this->AdminUser_model->hasPermission ( $opt, $permissions )) {
			// 判断请求的类型,如果是ajax请求则使用ajax返回
			if (is_ajax_request ()) {
				ajaxResult ( '2', "您没有权限进行该操作，请联系管理员添加权限！" );
			} else {
				exit ( '您没有权限进行该操作，请联系管理员添加权限！' );
			}
		}
		$this->load->vars ( 'emptyRecord', 'O(∩_∩)O~ 抱歉，暂无记录！' );
	}
}

use EasyWeChat\Foundation\Application;
class WechatCommon extends CI_Controller {
	protected $User;
	function __construct() {
		parent::__construct ();
		parseURL($this->uri->segment(4));
		// 本地测试使用
		$this->load->model('admin/User_model');
		$a = $this->User_model->set_LoginUser($this->User_model->getItem("id=2"));
		//本地测试结束 上线屏蔽
		
		//获取class 为了菜单选中
		$this->load->vars('action',$this->router->class);
		$this->User = $this->session->wechat_user_session; // 获取session
		$this->load->vars('U',$this->User );
	}
	function check() {
		if ($this->User) {
			//购物车
			$this->load->library('fcart');
			$cart = $this->fcart->contents();
			$this->load->vars('cart_num', $cart['total_items'] );
		} else {
			$url = $_SERVER ['REQUEST_URI']; // 为了从哪里进的跳转到哪里去
			$fwd = http_build_query(array('fwd' =>str_replace('.html','',$url)));
			$forward = base_url('/wechat/login/signin/?'.$fwd);
			$config = array(
					'oauth' => [
					'scopes'   => ['snsapi_userinfo'],
					'callback' => $forward,
					]
			);
			$app = new Application($config);
			$response = $app->oauth->scopes(['snsapi_userinfo'])->redirect();
			$response->send();
			die();
		}
	}
}

// 必须登录先
class NeedLoginAction extends WechatCommon {
	function __construct() {
		parent::__construct ();
		// 检测登录
		$this->check ();
	}
}

/**
 * 用户
 * @author chaituan
 */
class UserCommon extends CI_Controller {
	protected $User;
	function __construct() {
		parent::__construct ();
		$this->User = $this->session->{USERFQ_SESSION};
		// 菜单
		$menu = get_Cache ( 'admin_qmeun' );
		$this->load->vars ( 'menu', $menu );
		$this->load->vars ( 'U', $this->User );
	}
	function check() {
		if ($this->User) {
		} else {
			exit ( '跳转登录页面，战士没有开发' );
		}
	}
}

class ShopCommon extends CI_Controller {
	protected $shop_user; // 商户信息
	public function __construct() {
		parent::__construct ();
		parseURL($this->uri->segment(4));
		$this->load->model ('admin/Shop_model'); // 加载数据模型
		// 判断登录状态
		$this->shop_user = $this->Shop_model->get_LoginUser();
		
		if (!$this->shop_user) {
			redirect(site_url('shop/login/index'));
		} else {
			$this->load->vars('loginUser',$this->shop_user);
		}
		
		// 获取菜单数据
		$this->load->vars('add_url', '/' . $this->router->directory . $this->router->class . '/add' );
		$this->load->vars('edit_url', '/' . $this->router->directory . $this->router->class . '/edit' );
		$this->load->vars('index_url', '/' . $this->router->directory . $this->router->class . '/index' );
		$this->load->vars('class_active',$this->router->class);
		
		$this->load->vars('emptyRecord','O(∩_∩)O~ 抱歉，暂无记录！');
	}
}
// require_once 'Test_Controller.php';