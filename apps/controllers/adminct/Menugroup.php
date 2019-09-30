<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 后台菜单分组
 *
 * @author chaituan@126.com
 */
class Menugroup extends AdminCommon {
	public function index() {
		$data ['items'] = $this->AdminMenuGroup_model->getItems ( "", '', "sort_num ASC" );
		$this->load->view ( 'admin/menugroup/index', $data );
	}
	
	// 快速保存
	public function quicksave() {
		$data = Posts ( null );
		$this->AdminMenuGroup_model->quicksave ( $data );
	}
	
	// 编辑
	public function edit() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$id = Posts ( 'id', 'checkid' );
			$tkeyBak = Posts ( 'tkey_bak' );
			// 修改了tkey需要重新验证
			if ($tkeyBak != trim ( $data ['tkey'] )) {
				$exists = $this->AdminMenuGroup_model->getItem ( 'tkey="' . $data ['tkey'] . '"' );
				if ($exists) {
					AjaxResult ( 2, "{$data['tkey']}在数据库中已存在，请更换！" );
				}
			}
			
			if ($this->AdminMenuGroup_model->updates ( $data, "id=$id" )) {
				$this->AdminMenuGroup_model->updateCache ();
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$id = Gets ( 'id', 'checkid' );
			$item = $this->AdminMenuGroup_model->getItem ( "id=$id" );
			$data ['item'] = $item;
			$this->load->view ( 'admin/menugroup/edit', $data );
		}
	}
	
	// 添加
	public function add() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['add_time'] = time ();
			if ($this->AdminMenuGroup_model->getItem ( 'tkey="' . $data ['tkey'] . '"' )) {
				AjaxResult ( 2, "{$data['tkey']}在数据库中已存在，请更换！" );
			}
			if ($this->AdminMenuGroup_model->add ( $data )) {
				$this->AdminMenuGroup_model->updateCache ();
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$this->load->view ( 'admin/menugroup/add' );
		}
	}
	public function delete() {
		$id = Gets ( 'id', 'checkid' );
		if ($id <= 0)
			AjaxResult_error ();
		if ($this->AdminMenuGroup_model->deletes ( "id=$id" )) {
			$this->AdminMenuGroup_model->updateCache ();
			AjaxResult_ok ();
		} else {
			AjaxResult_error ();
		}
	}
}
