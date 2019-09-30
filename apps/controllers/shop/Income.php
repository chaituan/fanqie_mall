<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 收益计算
 * @author chaituan@126.com
 */
class Income extends ShopCommon {
	
	public function index() {
		$sid = $this->shop_user['id'];
		$this->load->model('admin/Order_model');
		$items = $this->Order_model->getItems(array('shopid'=>$sid,'state !='=>5),'price,state,confirm_time');
		//预计收益  （订单支付后的收益）
		$yuji = 0;
		foreach ($items as $v){
			if($v['state']==2){
				$yuji += $v['price'];
			}
		}
		$data['yuji'] = $yuji;
		//可提现收益 （订单确认后的收益）
		$ok = 0;
		foreach ($items as $v){
			if($v['state']==4){
				$c = time() - $v['confirm_time'] + (60*60*24)*7;//7天后才可以提现
				if($c>0){
					$ok += $v['price'];
				}
			}
		}
		
		$data['yuji'] = $yuji;
		$data['ok'] = $ok;
		$this->load->view('shop/income/index',$data);
	}
	
	public function income_list(){
		if(is_ajax_request()){
			$datas = Posts('data');
			$this->load->model('admin/Shop_model');
			$data = array('username'=>$datas['username'],'company'=>$datas['company'],'thumb'=>$datas['thumb']);
			$result = $this->Shop_model->updates_se($data,'id='.$this->shop_user['id']);
			is_AjaxResult($result);
		}
	}
	
	function sub_income(){
		$data['items'] = $this->Shopincome_model->getItems(array('shopid'=>$this->shop_user['id']));
		$this->load->view('shop/income/lists',$data);
	}
}
