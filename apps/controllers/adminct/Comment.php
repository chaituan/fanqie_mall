<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 评价管理
 * @author chaituan@126.com
 */
class Comment extends AdminCommon {
	
	function __construct() {
		parent::__construct();
		$this->load->model('admin/Comment_model');
	}
	
	public function index() {
		$items = $this->Comment_model->getItems();
		$data ['items'] = $items;
		$this->load->view('admin/order/comment',$data);
	}
	//审核
	function check(){
		
	}
	
	public function del() {
		$result = $this->Comment_model->deletes("id=".Gets('id','checkid' ));
		is_AjaxResult($result);
	}
}
