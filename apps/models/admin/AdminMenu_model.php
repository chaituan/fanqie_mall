<?php
/**
 * 后台管理菜单数据模型
 * @author  chaituan@126.com
 */
class AdminMenu_model extends MY_Model {
	
	/**
	 * 菜单缓存key
	 *
	 * @var string
	 */
	protected static $CACHE_KEY = 'admin.menu.data';
	public function __construct() {
		parent::__construct ();
		$this->table_name = 'admin_menu';
	}
	
	// 快速保存
	public function quicksave($data) {
		$counter = 0;
		// 保存数据
		foreach ( $data ['hids'] as $key => $id ) {
			if (! isset ( $data ['data'] [$key] ['ishow'] )) {
				$data ['data'] [$key] ['ishow'] = 0;
			}
			if ($this->updates ( $data ['data'] [$key], "id=" . $id )) {
				$counter ++;
			}
		}
		// 只要一条数据保存成功，则该操作成功
		if ($counter > 0) {
			// 更新菜单缓存
			$this->updateMenuCache ();
			AjaxResult ( 1, '保存成功！' );
		} else {
			AjaxResult ( 2, '保存失败！' );
		}
	}
	
	// 获取菜单缓存
	public function getMenuCache() {
		$items = get_Cache ( self::$CACHE_KEY );
		if (! $items) {
			return $this->updateMenuCache ();
		}
		return $items;
	}
	
	// 更新菜单缓存
	public function updateMenuCache() {
		// 获取菜单分组
		$this->load->model ( array (
				'admin/AdminMenuGroup_model' 
		) ); // 加载数据模型
		$groups = $this->AdminMenuGroup_model->getItems ( null, 'tkey' );
		// 获取所有的菜单
		$menus = $this->getItems ( 'ishow=1', 'id,groupkey,name,url,pid', 'sort_num ASC' );
		
		$menuData = array ();
		foreach ( $groups as $values ) {
			// 获取当前分组的一级菜单
			$conditions = array (
					'pid' => 0,
					'groupkey' => $values ['tkey'],
					'ishow' => 1 
			);
			$topMemus = $this->getItems ( $conditions, 'id,groupkey,name,url,pid', 'sort_num ASC' );
			
			foreach ( $topMemus as $key => $val ) {
				$topMemus [$key] ['sub'] = filterArrayByKey ( 'pid', $val ['id'], $menus );
			}
			$menuData [$values ['tkey']] = $topMemus;
		}
		set_Cache ( self::$CACHE_KEY, $menuData );
		return $menuData;
	}
	
	/**
	 * 获取顶级菜单
	 */
	public function getMenuGroups() {
		$this->load->model ( array (
				'admin/AdminMenuGroup_model' 
		) ); // 加载数据模型
		     // 获取菜单分组
		$menuGroups = $this->AdminMenuGroup_model->getItems ( null, 'id,name,tkey' );
		return changeArrayKey ( $menuGroups, 'tkey' );
	}
	
	// 管理员有权限的菜单
	public function getMenuByUser($user) {
		$menus = $this->getMenuCache ();
		
		// 如果是超级管理员，则直接返回所有菜单
		$this->load->model ( 'admin/AdminUser_model' ); // 加载数据模型
		if ($this->AdminUser_model->isSuperManager ( $user )) {
			return $menus;
		}
		$permissions = $this->AdminUser_model->getPermissions ();
		$data = array ();
		foreach ( $menus as $key => $value ) {
			$data [$key] = array ();
			$i = 0;
			foreach ( $value as $_value ) {
				if ($this->hasSubMenu ( $_value ['sub'], $permissions )) {
					
					$data [$key] [$i] = $_value;
					$data [$key] [$i] ['sub'] = array ();
					foreach ( $_value ['sub'] as $val ) {
						$__key = $this->url2PermissionKey ( $val ['url'] );
						if ($permissions [$__key] == 1) {
							$data [$key] [$i] ['sub'] [] = $val;
						}
					}
				}
				$i ++;
			}
		}
		return $data;
	}
	
	/**
	 * 是否有子菜单
	 *
	 * @param
	 *        	$subMenus
	 * @param
	 *        	$permissions
	 * @return bool
	 */
	private function hasSubMenu($subMenus, &$permissions) {
		foreach ( $subMenus as $value ) {
			$key = $this->url2PermissionKey ( $value ['url'] );
			if ($permissions [$key] == 1) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 将菜单的url转为权限数组的key
	 *
	 * @param
	 *        	$url
	 * @return string
	 */
	private function url2PermissionKey($url) {
		$url = substr ( $url, 1 );
		$url = explode ( '/', $url );
		return $url [1] . '@' . $url [2];
	}
	function version() {
		return $this->db->version ();
	}
} 