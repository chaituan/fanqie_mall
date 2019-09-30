<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 轮播
 *
 * @author chaituan@126.com
 */
class Banner extends AdminCommon {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( array (
				'admin/Banner_model' 
		) );
	}
	public function index() {
		$data ['items'] = $this->Banner_model->getItems ();
		$this->load->view ( 'admin/banner/index', $data );
	}
	public function add() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['addtime'] = time ();
			is_AjaxResult ( $this->Banner_model->add ( $data ) );
		} else {
			$this->load->view ( 'admin/banner/add' );
		}
	}
	public function edit() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$r = $this->Banner_model->updates($data,"id=".Posts('id','checkid'));
			if($r){
				$this->Banner_model->cache();
				AjaxResult_ok();
			}else{
				AjaxResult_error();
			}
		} else {
			$id = Gets("id","checkid");
			$data['item'] = $this->Banner_model->getItem("id=$id");
			$this->load->view('admin/banner/edit',$data);
		}
	}
	public function delete() {
		is_AjaxResult ( $this->Banner_model->deletes ( "id=" . Posts ( 'id', 'checkid' ) ) );
	}
}
