<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 后台菜单
 *
 * @author chaituan@126.com
 */
class Menu extends AdminCommon {
	public function index() {
		$adminMenuService = $this->AdminMenu_model;
		// 初始化菜单分组
		$menuGroups = $adminMenuService->getMenuGroups ();
		// 一级菜单
		$items = array ();
		// 二级菜单
		$subItems = array ();
		foreach ( $menuGroups as $value ) {
			$groupItems = $adminMenuService->getItems ( "groupkey='{$value['tkey']}' AND pid=0", null, "sort_num ASC" );
			$items [$value ['tkey']] = $groupItems;
			foreach ( $groupItems as $val ) {
				$subItems [$val ['id']] = $adminMenuService->getItems ( "pid={$val['id']}", null, "sort_num ASC" );
			}
		}
		$data ['items'] = $items;
		$data ['subitems'] = $subItems;
		$data ['menuGroups'] = $menuGroups;
		$this->load->view ( 'admin/menu/index', $data );
	}
	
	// 快速保存
	public function quicksave() {
		$data = Posts ();
		$this->AdminMenu_model->quicksave ( $data );
	}
	
	// 编辑
	public function edit() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$id = Posts ( 'id', 'checkid' );
			if ($id <= 0) {
				AjaxResult_error ();
			}
			if (! isset ( $data ['ishow'] )) {
				$data ['ishow'] = 0;
			}
			if ($this->AdminMenu_model->updates ( $data, "id=$id" )) {
				// 更新菜单缓存
				$this->AdminMenu_model->updateMenuCache ();
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$id = Gets ( 'id', 'checkid' );
			$item = $this->AdminMenu_model->getItem ( "id=$id" );
			$menuData = $this->AdminMenu_model->getItems ( "pid=0 AND groupkey='{$item['groupkey']}'", null, 'sort_num ASC' );
			$data ['menuData'] = $menuData;
			$data ['item'] = $item;
			$data ['menuGroups'] = $this->AdminMenu_model->getMenuGroups ();
			$this->load->view ( 'admin/menu/edit', $data );
		}
	}
	
	// 添加
	public function add() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['add_time'] = time ();
			if ($this->AdminMenu_model->add ( $data )) {
				// 更新菜单缓存
				$this->AdminMenu_model->updateMenuCache ();
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$pid = Gets ( 'pid' );
			$groupkey = null;
			// 添加子菜单
			if ($pid > 0) {
				// 查找该菜单所属的groupkey
				$item = $this->AdminMenu_model->getItem ( 'id=' . $pid, 'groupkey' );
				$groupkey = $item ['groupkey'];
				$data ['pid'] = $pid;
			} else {
				// 默认加载一个分组的所有一级菜单
				$item = $this->AdminMenuGroup_model->getItem ( null, 'tkey', 'sort_num ASC' );
				$groupkey = $item ['tkey'];
			}
			$menuData = $this->AdminMenu_model->getItems ( "pid=0 AND groupkey='{$groupkey}'", null, 'sort_num ASC' );
			$data ['menuData'] = $menuData;
			$data ['groupkey'] = $groupkey;
			$data ['menuGroups'] = $this->AdminMenu_model->getMenuGroups ();
			$this->load->view ( 'admin/menu/add', $data );
		}
	}
	public function delete() {
		$id = Gets ( 'id', 'checkid' );
		if ($id <= 0)
			AjaxResult_error ();
		if ($this->AdminMenu_model->deletes ( "id=$id" )) {
			// 更新菜单缓存
			$this->AdminMenu_model->updateMenuCache ();
			AjaxResult_ok ();
		} else {
			AjaxResult_error ();
		}
	}
	
	// 获取指定分组的一级菜单
	public function getTopMemnu() {
		$groupkey = Posts ( 'groupkey' );
		$items = $this->AdminMenu_model->getItems ( "pid=0 AND groupkey='{$groupkey}'", null, "sort_num ASC" );
		if (! empty ( $items )) {
			AjaxResult ( 'ok', $items );
		} else {
			AjaxResult_error ();
		}
	}
}
