<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 我的钱包
 * @author chaituan@126.com
 */
class Wallet extends NeedLoginAction {
	
	function index(){
		$uid = $this->User['id'];
		$this->load->model(array('admin/Earnings_detail_model',"admin/Withdraw_cash_model"));
		//总收益
		$item = $this->Earnings_detail_model->getItem("uid=$uid","sum(money) as money",'id desc');
		$money_ttl = $item['money']?$item['money']:0;//总收益
		//提现收益 
		$witems = $this->Withdraw_cash_model->getItems("uid=$uid","money,state");
		$w_error = 0;
		foreach ($witems as $v){
			if($v['state']==1){
				$w_ok += $v['money'];
			}elseif($v['state']==2){
				$w_error += $v['money'];
			}else{
				$w_error += $v['money'];
			}
		}
		$data['total'] = $money_ttl;
		$this->session->set_userdata("ktx_money",$data['total']);//可提现金额，放带会话中
		$this->load->view('mobile/wallet/index',$data);
	}
	//提取现金
	function withdraw_cash(){
		$uid = $this->User['id'];
		$ktx = $this->session->ktx_money;//可提现金额
		if(!$ktx)showmessage("数据异常，请返回",'error');
		$this->load->model("admin/Withdraw_cash_model");
		if(is_ajax_request()){
			//对比提交数据
			$money = Posts('money','checkid');
			$this->session->unset_userdata('ktx_money');//销毁session
			if($ktx>=$money){
				$data = array('uid'=>$uid,'money'=>$money,'addtime'=>time());
				$this->Withdraw_cash_model->add($data);
				AjaxResult_ok("提现成功,请耐心等待审核");
			}else{
				AjaxResult_error("可提现金额错误");
			}
		}else{
			$item = $this->Withdraw_cash_model->getItem("state=0 and uid=$uid");
			if($item)showmessage('你有一笔提现正在审核中','waiting');
			$data['ktx'] = $ktx;
			$this->load->view('mobile/wallet/withdraw_cash',$data);
		}
	}
	
	//列表明细
	function lists(){
		$items = $this->Earnings_detail_model->getItems_join(array('user' =>"earnings_detail.cid=user.id+left"),"earnings_detail.uid=$uid","earnings_detail.*,user.nickname,user.thumb", 'earnings_detail.id desc',Gets('per_page','checkid'), PAGESIZE);
		if($items){
			$total = 0;
			foreach ($items as $v){
				$total += $v['money'];
			}
			$data['total'] = $total;
		}else{
			$data['total'] = 0;
		}
	}
	
}
