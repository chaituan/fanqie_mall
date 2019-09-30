<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 微信支付
 *
 * @author chaituan@126.com
 */
include_once 'lib/WxPay.Data.php';
include_once 'lib/WxPay.Api.php';
include_once 'lib/WxPay.Notify.php';
class Wechat_pay_api extends WxPayNotify{
	
	//支付
	function pay($data){
		$total_fee = $data['total_fee']*100;
		$openId = $data['openid'];
		$input = new WxPayUnifiedOrder();
		$input->SetBody($data['title']);
// 		$input->SetAttach("襄阳市番茄科技");//商家数据包，原样返回
		$input->SetOut_trade_no($data['out_trade_no']);
		$input->SetTotal_fee($total_fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("FQ");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		return $this->GetJsApiParameters($order);
	}
	
	/**
	 * 获取jsapi支付的参数
	 * @param array $UnifiedOrderResult 统一支付接口返回的数据
	 * @throws WxPayException
	 * @return json数据，可直接填入js函数作为参数
	 */
	public function GetJsApiParameters($UnifiedOrderResult){
		if(!array_key_exists("appid", $UnifiedOrderResult)|| !array_key_exists("prepay_id", $UnifiedOrderResult)|| $UnifiedOrderResult['prepay_id'] == ""){
			showmessage("参数错误",'error');
		}
		$jsapi = new WxPayJsApiPay();
		$jsapi->SetAppid($UnifiedOrderResult["appid"]);
		$timeStamp = time();
		$jsapi->SetTimeStamp("$timeStamp");
		$jsapi->SetNonceStr(WxPayApi::getNonceStr());
		$jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
		$jsapi->SetSignType("MD5");
		$jsapi->SetPaySign($jsapi->MakeSign());
		$parameters = json_encode($jsapi->GetValues());
		return $parameters;
	}
	//回调
	public function result_pay(){
		$this->Handle();
	}
	//重写 写业务逻辑
	public function NotifyProcess($data, &$msg){
		if($data){
			//开始写业务逻辑
			if($data['return_code']=='SUCCESS'&&$data['result_code']=='SUCCESS'){
				$total = $data['total_fee']/100;
				$order_no = $data['out_trade_no'];
				$time = strtotime($data['time_end']);
				get_CI()->load->model('admin/Order_model');
				$item = get_CI()->Order_model->updates(array('state'=>2,'pay_time'=>$time,'transaction_id'=>$data['transaction_id']),array("pay_order_no"=>$order_no,'price'=>$total,'openid'=>$data['openid']));
				if(!$item){
					get_CI()->load->model('admin/Orderlog_model');
					get_CI()->Orderlog_model->add(array('order_no'=>$order_no,'openid'=>$data['openid'],'update_error'=>'支付通知异常，金额'.$total));
				}
				return true;
			}else{
				log_message('error', $data['return_msg'].$data['err_code'].$data['err_code_des']);
				return false;
			}
			
		}else{
			$msg = 'sign或者签名错误';
			return false;
		}
	}
	
	//红包
	public function hongbao($openid,$money,$data){
		include_once 'Wxpaypubhelper.php';
		$wx = new \Wxpay_client_pub();
		$wx->setParameter("send_name", $data['hongbao_name']);
		$trade_no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		$wx->setParameter("mch_billno", "$trade_no");
		$wx->setParameter("re_openid", "$openid");
		$money = $money*100;
		$wx->setParameter("total_amount", "$money");
		$wx->setParameter("total_num", '1');
		$wx->setParameter("wishing", $data['hongbao_wish']);
		$ip=$_SERVER['REMOTE_ADDR'];
		$wx->setParameter("client_ip", "$ip");
		$wx->setParameter("act_name", $data['hongbao_activity']);
		$wx->setParameter("remark", $data['hongbao_mark']);
		$wx->url="https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
		$wx->postXmlSSL_hb();
		$res = $wx->xmlToArray($wx->response);
		return $res;
	}
}
