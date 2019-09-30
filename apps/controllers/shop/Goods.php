<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 商品
 *
 * @author chaituan@126.com
 */
class Goods extends ShopCommon {
	function __construct() {
		parent::__construct();
		$this->load->model(array('admin/Goods_model','admin/Goods_cat_model'));
	}
	public function index() {
		$name = Gets('name');
		$where = '';
		if($name){
			$where['names like'] = "%$name%";
		}
		$where['shopid'] = $this->shop_user['id'];
		$data['name'] = $name;
		$items = $this->Goods_model->getItems($where,'','id desc', Gets('per_page','checkid'), PAGESIZE);
		$data ['items'] = $items;
		$data ['pagemenu'] = $this->Goods_model->pagemenu; // 经过模型处理后返回的分页
		$this->load->view ( 'shop/goods/index', $data );
	}
	public function add() {
		if (is_ajax_request ()) {
			$sid = $this->shop_user['id'];
			$data = Posts('data');
			$data['is_stock'] = Posts('is_stock');
// 			$data['p_start_time'] = strtotime($data['p_start_time']);
// 			$data['p_end_time'] = strtotime($data['p_end_time']);
			$data['addtime'] = time();
			$data['shopid'] = $sid;
			$count = $this->Goods_model->count(array('shopid'=>$sid));
			if($count>=10)AjaxResult_error(2,'最多添加10个产品');
			if ($this->Goods_model->add ( $data )) {
				AjaxResult_ok ();
			} else {
				AjaxResult_error ();
			}
		} else {
			$items = $this->Goods_cat_model->get_catcachetree ();
			$data ['parent'] = $items;
			$item = $this->Goods_model->getItem ( "", 'max(sort) as sort' );
			$data ['sort'] = $item ['sort'] ? $item ['sort'] + 1 : 0;
			$this->load->view ( 'shop/goods/add', $data );
		}
	}
	public function edit() {
		$sid = $this->shop_user['id'];
		if (is_ajax_request ()) {
			$data = Posts('data');
			$data['is_stock'] = Posts('is_stock');
// 			$data['p_start_time'] = strtotime($data['p_start_time']);
// 			$data['p_end_time'] = strtotime($data['p_end_time']);
			if ($this->Goods_model->updates($data,"id=".Posts('id','checkid').' and shopid='.$sid)){
				AjaxResult_ok ();
			}else{
				AjaxResult_error ();
			}
		}else{
			$data ['item'] = $this->Goods_model->getItem(array('id' => Gets( 'id', 'checkid' ),'shopid'=>$sid));
			$items = $this->Goods_cat_model->get_catcachetree ();
			$data ['parent'] = $items;
			$this->load->view('shop/goods/edit', $data);
		}
	}
	
	public function delete() {
		$r = $this->Goods_model->deletes ("id=".Gets ( 'id', 'checkid' ).' and shopid='.$sid);
		if ($r) {
			AjaxResult_ok ();
		} else {
			AjaxResult_error ();
		}
	}
	
	function order_by(){
		$data = Posts ('data');
		if (! $data) {
			AjaxResult ('2','不能为空');
		}
		foreach($data as $k=>$v) {
			$datas[] = array ('id' => $k,'sort' => $v);
		}
		$result = $this->Goods_model->update_batchs($datas,'id');
		if ($result) {
			AjaxResult_ok ();
		} else {
			AjaxResult_error ();
		}
	}
}
