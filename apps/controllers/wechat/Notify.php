<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 公众号服务器配置
 *
 * @author chaituan@126.com
 */
use EasyWeChat\Foundation\Application;
class Notify extends CI_Controller {
	public function index() {
		$options = ['token'  => 'ctfanqie'];
		$app = new Application($options);
		$server = $app->server;
		$server->setMessageHandler(function($message){
			switch ($message->MsgType) {
		        case 'event':
		        	$openid = $message->FromUserName;
		        	$pid = str_replace ('qrscene_', '', $message->EventKey ); // 二维码中的key
		        	if (strstr($pid,'last_trade_no'))$pid = 0; // 二维码中的key
		        	$this->load->model("admin/User_model");
		        	if($message->Event == "subscribe"){
		        		$user = $this->User_model->get_user('openid',$openid);
		        		if($user){
		        			$content = "欢迎回来，亲爱的 {$user['nickname']} 小伙伴";
		        		}else{
		        			$userService = $app->user; // 用户API
		        			$wuser = $userService->get($openid)->toArray();
		        			$username = $this->User_mode->wechat_add_user($wuser,$pid);//添加数据库
		        			$content = "欢迎您，加入我们，亲爱的 $username 小伙伴";
		        		}
		        	}elseif($message->Event == "SCAN"){
		        		$content = "进商城，看看您的团队如何了";
		        	}
		            break;
		        default:
		        	$content = '';
		            break;
			}
			return $content;
		});
		$server->serve()->send();
	}
		
	public function pay(){
		$options = ['payment' => ['merchant_id'=> WX_MCHID,'key'=> WX_KEY,'cert_path'=> SSLCERT_PATH,'key_path'=> SSLKEY_PATH,'notify_url'=> NOTIFY_URL]];
		$app = new Application($options);
		$response = $app->payment->handleNotify(function($notify, $successful){
			if($successful){
				$data = json_decode($notify,true);
				$total = $data['total_fee']/100;
				$order_no = $data['out_trade_no'];
				$time = strtotime($data['time_end']);
				$this->load->model('admin/Order_model');
				$item = $this->Order_model->updates(array('state'=>2,'pay_time'=>$time,'transaction_id'=>$data['transaction_id']),array("pay_order_no"=>$order_no,'price'=>$total,'openid'=>$data['openid']));
				if(!$item){//异常记录
					$this->load->model('admin/Orderlog_model');
					$this->Orderlog_model->add(array('order_no'=>$order_no,'openid'=>$data['openid'],'update_error'=>'支付通知异常，金额'.$total));
				}
				return true;
			}
		});
		$response->send();
		exit();
	}
	
}
