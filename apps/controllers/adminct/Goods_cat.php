<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 商品分类
 *
 * @author chaituan@126.com
 */
class Goods_cat extends AdminCommon {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/Goods_cat_model' );
	}
	public function index() {
		$items = $this->Goods_cat_model->get_catcachetree ( false );
		$data ['items'] = $items;
		$this->load->view ( 'admin/goods_cat/index', $data );
	}
	public function add() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['isrecommand'] = Posts ( 'isrecommand' ); // 推荐
			$data ['enabled'] = Posts ( 'enabled' ); // 显示
			if ($this->Goods_cat_model->add ( $data )) {
				$this->Goods_cat_model->cache ();
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$items = $this->Goods_cat_model->get_catcachetree ();
			$data ['parent'] = $items;
			$item = $this->Goods_cat_model->getItem ( "", 'max(sort) as sort' );
			$data ['sort'] = $item ['sort'] ? $item ['sort'] + 1 : 0;
			$this->load->view ( 'admin/goods_cat/add', $data );
		}
	}
	public function edit() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['isrecommand'] = Posts ( 'isrecommand' ); // 推荐
			$data ['enabled'] = Posts ( 'enabled' ); // 显示
			if ($this->Goods_cat_model->updates ( $data, "id=" . Posts ( 'id', 'checkid' ) )) {
				$this->Goods_cat_model->cache ();
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$data ['item'] = $this->Goods_cat_model->getItem ( array (
					'id' => Gets ( 'id', 'checkid' ) 
			) );
			$items = $this->Goods_cat_model->get_catcachetree ();
			$data ['parent'] = $items;
			$this->load->view ( 'admin/goods_cat/edit', $data );
		}
	}
	public function delete() {
		$r = $this->Goods_cat_model->deletes ( "id=" . Gets ( 'id', 'checkid' ) );
		if ($r) {
			$this->Goods_cat_model->cache ();
			AjaxResult_ok ();
		} else {
			AjaxResult_error ();
		}
	}
	function order_by() {
		$data = Posts ( 'data' );
		if (! $data) {
			AjaxResult ( '2', '不能为空' );
		}
		foreach ( $data as $k => $v ) {
			$datas [] = array (
					'id' => $k,
					'sort' => $v 
			);
		}
		$result = $this->Goods_cat_model->update_batchs ( $datas, 'id' );
		if ($result) {
			$this->Goods_cat_model->cache ();
			AjaxResult_ok ();
		} else {
			AjaxResult_error ();
		}
	}
}
