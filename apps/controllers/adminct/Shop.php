<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 店铺列表
 *
 * @author chaituan@126.com
 */
class Shop extends AdminCommon {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/Shop_model' );
	}
	
	public function index() {
		$name = Gets('name');
		$where = '';
		if($name){
			$where = "username like '%$name%'";
		}
		$data['name'] = $name;
		$data ['items'] = $this->Shop_model->getItems ($where, '', 'add_time desc', Gets ( 'per_page', 'checkid' ), PAGESIZE);
		$data ['pagemenu'] = $this->Shop_model->pagemenu; // 经过模型处理后返回的分页
		$this->load->view ( 'admin/shop/index', $data );
	}
	
	public function add() {
		if (is_ajax_request ()) {
			$data = Posts('data');
			$username = $data['username'];
			$mobile = $this->Shop_model->getItem("username='$username'");
			if($mobile)AjaxResult_error('用户名已存在,请刷新');
			$pwd = set_password($data['pwd']);
			$id = $this->Shop_model->add(array('username'=>$data['username'],'password'=>$pwd['password'],'encrypt'=>$pwd['encrypt'],'add_time'=>time()));
			is_AjaxResult ($id);
		} else {
			$this->load->view('admin/shop/add');
		}
	}
	
	public function edit() {
		if (is_ajax_request()) {
			$id = Posts ('id','checkid' );
			$data = Posts ('data');
			if($data['pwd'])AjaxResult_ok();
			$pwd = set_password($data['pwd']);
			$id = $this->Shop_model->updates(array('password'=>$pwd['password'],'encrypt'=>$pwd['encrypt']),array('id'=>$id));
			is_AjaxResult ( $id );
		} else {
			$id = Gets('id','checkid');
			$data ['item'] = $this->Shop_model->getItem (array("id" => $id));
			$this->load->view ('admin/shop/edit',$data);
		}
	}
	
	public function disable(){//shop 0禁用  1启用
		if (is_ajax_request()) {
			$id = Gets('id','checkid' );
			$result = $this->Shop_model->updates(array('state'=>0),array('id'=>$id));
			is_AjaxResult ($result);
		}
	}
	
	public function enable(){//shop 0禁用
		if (is_ajax_request()) {
			$id = Gets('id','checkid');
			$result = $this->Shop_model->updates(array('state'=>1),array('id'=>$id));
			is_AjaxResult ($result);
		}
	}
	
// 	public function delete() {
// 		is_AjaxResult ( $this->Shop_model->deletes ( "id=" . Posts ( 'id', 'checkid' ) ) );
// 	}
// 	public function deletes() {
// 		$data = Posts ();
// 		if (! $data) {
// 			AjaxResult ( '2', '没有选中要删除的' );
// 		}
// 		$ids = implode ( ',', $data ['ids'] );
// 		if ($this->Shop_model->deletes ( "id in ($ids)" )) {
// 			AjaxResult ( 1, "删除成功", $data ['ids'] );
// 		} else {
// 			AjaxResult ( 2, "删除失败" );
// 		}
// 	}
}
