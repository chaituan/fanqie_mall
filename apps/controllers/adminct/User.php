<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 会员列表
 *
 * @author chaituan@126.com
 */
class User extends AdminCommon {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/User_model' );
	}
	public function config() {
		$data = get_Cache ( 'admin_config' );
		foreach ( $data as $v ) {
			if ($v ['tkey'] == 'user') {
				$datas ['items'] [] = $v;
			}
		}
		$this->load->view ( 'admin/config/views', $datas );
	}
	public function index() {
		$name = Gets('name');
		$where = '';
		if($name){
			$where = "nickname like '%$name%'";
		}
		$data['name'] = $name;
		$data ['items'] = $this->User_model->getItems ($where, '', 'addtime desc', Gets ( 'per_page', 'checkid' ), PAGESIZE );
		$data ['pagemenu'] = $this->User_model->pagemenu; // 经过模型处理后返回的分页
		$this->load->view ( 'admin/user/index', $data );
	}
	public function deletes() {
		$data = Posts ();
		if (! $data) {
			AjaxResult ( '2', '没有选中要删除的' );
		}
		$ids = implode ( ',', $data ['ids'] );
		if ($this->User_model->deletes ( "id in ($ids)" )) {
			AjaxResult ( 1, "删除成功", $data ['ids'] );
		} else {
			AjaxResult ( 2, "删除失败" );
		}
	}
}
