<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 后台首页
 * @author chaituan@126.com
 */
class Usergroup extends AdminCommon {
	
	public function __construct() {
		parent::__construct ();
		$this->load->model('admin/UserGroup_model');
	}
	
	public function index() {
		$data ['items'] = $this->UserGroup_model->getItems ();
		$this->load->view ( 'admin/usergroup/index', $data );
	}
	
	public function add() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['addtime'] = time ();
			$result = $this->UserGroup_model->add($data);
			if($result){
				$this->UserGroup_model->cache();
				AjaxResult_ok();
			}else{
				AjaxResult_error();
			}
		} else {
			$this->load->view ( 'admin/usergroup/add' );
		}
	}
	
	public function edit() {
		if (is_ajax_request ()) {
			$data = Posts('data');
			$id = Posts('id','checkid');
			$result = $this->UserGroup_model->updates($data,"id=$id");
			if($result){
				$this->UserGroup_model->cache();
				AjaxResult_ok();
			}else{
				AjaxResult_error();
			}
		} else {
			$data ['item'] = $this->UserGroup_model->getItem ( "id=" . Gets ( 'id', 'checkid' ) );
			$this->load->view ( 'admin/usergroup/edit', $data );
		}
	}
	
	public function delete() {
		$id = Gets('id','checkid');
		$result = $this->UserGroup_model->deletes(array('id' => $id));
		if($result){
			$this->UserGroup_model->cache();
			AjaxResult_ok();
		}else{
			AjaxResult_error();
		}
	}
}
