<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 后台首页
 *
 * @author chaituan@126.com
 */
class Manager extends AdminCommon {
	
	public function index() {
		$data ['sql_version'] = $this->AdminMenu_model->version ();
		$this->load->view ( 'admin/index', $data );
	}
	
	public function password() {
		if(is_ajax_request()){
			$this->load->model('admin/AdminUser_model');
			$oldpass = Posts('oldpass');
			$item = $this->AdminUser_model->getItem(array('id'=>$this->loginUser['id']),'password,encrypt');
			$pwd = get_password($oldpass, $item['encrypt']);
			if($pwd != $item['password'])AjaxResult_error('原始密码不正确');
			$new = set_password(Posts('password'));
			$result = $this->AdminUser_model->updates(array('password'=>$new['password'],'encrypt'=>$new['encrypt']),"id=".$this->loginUser['id']);
			is_AjaxResult($result);
		}
	}
}
