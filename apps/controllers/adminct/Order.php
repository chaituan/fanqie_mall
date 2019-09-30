<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 订单
 * @author chaituan@126.com
 */
class Order extends AdminCommon {
	
	function __construct() {
		parent::__construct();
		$this->load->model('admin/Order_model');
	}
	
	public function index() {
		$name = Gets('name');
		$where = '';
		if($name){
			$where = "order_no like '%$name%'";
		}
		$items = $this->Order_model->getItems($where,'','id desc',Gets('per_page','checkid'),PAGESIZE);
		$data ['items'] = $items;
		$data ['pagemenu'] = $this->Order_model->pagemenu; // 经过模型处理后返回的分页
		$this->load->view('admin/order/index',$data);
	}
	
	function detail(){
		$data['exp'] = array('圆通速递','中通速递','韵达快运','优速物流','天天快递','速尔物流','顺丰','申通','如风达','汇通快运','ems快递');
		$id = Gets('id','checkid');
		$zd = "order_lists.id,order.id as ids,order.order_no,order.exp_company,order.exp_no,order.state,order.buy_name,order.buy_mobile,order.buy_address,order.price,order.addtime,order_lists.thumb,order_lists.title,order_lists.prices,order_lists.num,order_lists.sku,order_lists.oid,order.message";
		$items = $this->Order_model->getItems_join(array('order_lists' =>"order.id=order_lists.oid+left"),"order.id=$id","$zd");
		if($items){
			foreach ($items as $v){
				$newItems['item'] = array('id'=>$v['ids'],'order_no'=>$v['order_no'],'state'=>$v['state'],'name'=>$v['buy_name'],'mobile'=>$v['buy_mobile'],'address'=>$v['buy_address'],'message'=>$v['message'],'price'=>$v['price'],'addtime'=>$v['addtime'],'exp_company'=>$v['exp_company'],'exp_no'=>$v['exp_no']);
				$newItems['child'][] = $v;
			}
		}else{
			show_404();
		}
		$data ['items'] = $newItems;
		$this->load->view('admin/order/detail',$data);
	}
	
	//发货
	function edit(){
		if(is_ajax_request()){
			$data = Posts('data');
			$data['state'] = 3;
			$result = $this->Order_model->updates($data,'id='.Posts('id','checkid'));
			is_AjaxResult($result);
		}
	}
	
	public function delete() {
		exit("不支持删除");
		$r = $this->Goods_model->deletes ( "id=" . Gets ( 'id', 'checkid' ) );
		if ($r) {
			AjaxResult_ok ();
		} else {
			AjaxResult_error ();
		}
	}
}
