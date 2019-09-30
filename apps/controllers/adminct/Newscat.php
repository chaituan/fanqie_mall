<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 新闻分类
 *
 * @author chaituan@126.com
 */
class Newscat extends AdminCommon {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/NewsCat_model' );
	}
	public function index() {
		$items = $this->NewsCat_model->get_cat ( false );
		$data ['items'] = $items;
		$this->load->view ( 'admin/newscat/index', $data );
	}
	public function add() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['addtime'] = time ();
			if ($this->NewsCat_model->add ( $data )) {
				$this->NewsCat_model->cache ();
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$items = $this->NewsCat_model->get_cat ();
			$data ['parent'] = $items;
			$this->load->view ( 'admin/newscat/add', $data );
		}
	}
	public function edit() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			if ($this->NewsCat_model->updates ( $data, "id=" . Posts ( 'id', 'checkid' ) )) {
				$this->NewsCat_model->cache ();
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$data ['item'] = $this->NewsCat_model->getItem ( array (
					'id' => Gets ( 'id', 'checkid' ) 
			) );
			$items = $this->NewsCat_model->get_cat ();
			$data ['parent'] = $items;
			$this->load->view ( 'admin/newscat/edit', $data );
		}
	}
	public function delete() {
		is_AjaxResult ( $this->NewsCat_model->deletes ( "id=" . Gets ( 'id', 'checkid' ) ) );
	}
}
