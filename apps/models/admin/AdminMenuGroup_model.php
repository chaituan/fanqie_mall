<?php
/**
 * 后台管理菜单分组数据模型
 * @author  chaituan@126.com
 */
class AdminMenuGroup_model extends MY_Model {
	protected static $CACHE_KEY = 'admin.menu.group';
	public function __construct() {
		parent::__construct ();
		$this->table_name = 'admin_menu_group';
	}
	public function getGroupCache() {
		$items = get_Cache ( self::$CACHE_KEY );
		if (! $items) {
			return $this->updateCache ();
		}
		return $items;
	}
	public function updateCache() {
		$items = $this->getItems ();
		set_Cache ( self::$CACHE_KEY, $items );
		return $items;
	}
	
	// 快速保存
	public function quicksave($data) {
		$counter = 0;
		// 保存数据
		foreach ( $data ['hids'] as $key => $id ) {
			if ($this->updates ( $data ['data'] [$key], "id=" . $id )) {
				$counter ++;
			}
		}
		// 只要一条数据保存成功，则该操作成功
		if ($counter > 0) {
			$this->updateCache ();
			AjaxResult ( 1, '保存成功！' );
		} else {
			AjaxResult ( 2, '保存失败！' );
		}
	}
} 