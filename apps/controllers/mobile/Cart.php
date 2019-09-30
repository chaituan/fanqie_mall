<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 购物车
 * @author chaituan@126.com
 */
class Cart extends NeedLoginAction {

	function __construct(){
		parent::__construct();
		$this->load->library('fcart');
	}
	
	function index(){
		$items = $this->fcart->contents();
		$newItem = array();
		if($items){
			foreach ($items as $v){
				if(is_array($v)){
					$newItem[$v['options']['shopid']][$v['rowid']] = $v;
				}
			}
			$data['total'] = array('total_items'=>$items['total_items'],'cart_total'=>$items['cart_total']);
			unset($items['total_items']);unset($items['cart_total']);
		}
		$data['newitems'] = $newItem;
		$this->load->view('mobile/cart/index',$data);
	}
	
	//添加购物车
	function add_cart(){
		if(is_ajax_request()){
			$this->load->library('fcart');
			$data = Posts();
			$price = str_replace('￥', '', $data['price']);
			$shopid = $data['shopid'];
			$items = array(
				'id' => $data['id'].str_replace(',', '', $data['selPath']),//生成特别id
				'qty' => $data['num'],//数量
				'price' => $price,//单架
				'name' => $data['names'],//产品名字
				'options' => array('options' => $data['options'],'selPath' =>  $data['selPath'],'thumb' =>$data['thumb'],'gid'=> $data['id'],'shopid'=>$shopid)
			);
			
			$this->fcart->insert(array($items));
			AjaxResult(1, '添加成功');
		}else{
			showmessage('错误请求','error');
		}
	}
	//编辑
	function edit_cart(){
		if(is_ajax_request()){
			$data = Posts('data');
			$items = $this->fcart->contents();
			$item = $items[$data['cid']];
			$item['qty'] = $data['num'];
			$r = $this->fcart->update(array($item));
			is_AjaxResult($r,"修改成功",'没有修改');
		}else{
			showmessage('错误请求','error');
		}
	}
	//删除
	function del(){
		$id = Gets('id');
		$result = $this->fcart->remove($id);
		is_AjaxResult($result,"删除成功","删除失败");
	}
	
	function xh(){
		$this->fcart->destroy();
	}
}
