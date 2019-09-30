<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 微信类库
 *
 * @author chaituan@126.com
 */
require_once 'Wechat_api_assist.php';
class Wechat_api extends Wechat_api_assist{
	public function test(){
		$u = $this->get_user('otpTQjgYu-I3wgxPwseIfdthPNqs');
		var_dump($u);
		exit;
	}
	// 为了后台服务器配置
	public function is_token() {
		$echoStr = $_GET ["echostr"];
		if (self::checkSignature ()) {
			echo $echoStr;
			exit ();
		}
	}
	// 检测token
	private function checkSignature() {
		$signature = $_GET ["signature"];
		$timestamp = $_GET ["timestamp"];
		$nonce = $_GET ["nonce"];
		$token = 'e53e46d800d99a9e';
		$tmpArr = array (
				$token,
				$timestamp,
				$nonce 
		);
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
	
	// 登录
	function login($uri, $scope, $state = '') {
		$url = array (
				'appid' => WX_APPID,
				'redirect_uri' => $uri,
				'response_type' => 'code',
				'scope' => $scope,
				'state' => $state ? $state : 0 
		);
		redirect ( 'https://open.weixin.qq.com/connect/oauth2/authorize?' . http_build_query ( $url ) . '#wechat_redirect' );
	}
	
	/**
	 * 获取微信用户，授权后获取
	 */
	function Get_WechatUser() {
		$code = Gets('code');
		if (empty($code))showmessage("code错误",'error');// 获取token
		$token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . WX_APPID . '&secret=' . WX_APPSecret . '&code=' . $code . '&grant_type=authorization_code';
		$token = json_decode(file_get_contents($token_url));
		if(isset($token->errcode)) {
			showmessage($token->errcode.$token->errmsg,'error');
		}
		// $refresh= $token->refresh_token ;
		// $url="https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$appid&grant_type=refresh_token&refresh_token=$refresh";
		// 拉去信息
		$user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $token->access_token . '&openid=' . $token->openid . '&lang=zh_CN';
		$user_info = json_decode(file_get_contents($user_info_url),true);
		if (isset ( $user_info ['errcode'] )) {
			showmessage ( $user_info ['errcode'] . $user_info ['errmsg'], 'error' );
		}
		return $user_info;
	}
	
	/**
	 * snsapi_base 静默授权，用户无感知
	 * 只能获取openid
	 */
	function Get_Openid() {
		$code = Gets('code');
		$state = Gets('state');
		if (empty($code))return '';
		$token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . WX_APPID . '&secret=' . WX_APPSecret . '&code=' . $code . '&grant_type=authorization_code';
		$user = json_decode ( file_get_contents ( $token_url ), true );
		if (isset($user['errcode'])){
			showmessage($user['errcode'].$user['errmsg'],'error');
		}
		if ($user ['openid']) {
			return $user ['openid'];
		} else {
			showmessage ( '获取openid错误', 'error' );
		}
	}
	
	/**
	 * 通过Openid 获取用户是否关注
	 */
	function Get_Openid_user($openid) {
// 		$openid = self::Get_Openid (); // 获取openid
		$accesstoken = self::getAccessToken (); // 获取token
		$api = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accesstoken&openid=$openid&lang=zh_CN";
		$result = json_decode ( file_get_contents ( $api ), true );
		if (isset ( $result ['errcode'] )) {
			showmessage( 'user错误：' . $result ['errcode'],'error');
		}
		return $result;
	}
	
	/**
	 * 接受微信推送的消息
	 */
	public function responseMsg() {
		$postxml = $GLOBALS ["HTTP_RAW_POST_DATA"];
		if (! empty ( $postxml )) {
			$xml = simplexml_load_string ( $postxml, 'SimpleXMLElement', LIBXML_NOCDATA );
			$ms_type = trim ( $xml->MsgType );
			switch ($ms_type) {
				case 'event': // 事件
					$result = self::receiveEvent ( $xml );
					break;
				case 'text': // 普通消息
					$content = '你好，年青人！'."\n <a href='http://demo.1m15.com/mobile/center/index'>点我赚钱</a>";
				 	$result = $this->transmitText($xml,$content);
					break;
				default :
					break;
			}
			echo $result;
		}
		exit ();
	}
	
	/**
	 * 事件类型
	 *
	 * @param unknown $xml        	
	 */
	private function receiveEvent($xml) {
		$openid = $xml->FromUserName;
		$key = str_replace ( 'qrscene_', '', $xml->EventKey ); // 二维码中的key
		if (strstr($key,'last_trade_no')) {
			$key = 0;
		} // 二维码中的key
		$event = trim($xml->Event ); // 事件类型
		$content = 'success';
		switch (trim ( $xml->Event )) {
			case 'subscribe' : // 新用户关注
				$user = $this->get_user($openid);
				if($user){
					$content = "欢迎你{$user['nickname']}";
				}else{
					$data = $this->Get_Openid_user($openid);
					$content = $this->add_user($data, $key);
				}
				$content = $content."\n <a href='http://demo.1m15.com/mobile/center/index'>点我赚钱</a>";
				break;
			case 'SCAN' : // 已关注
				$user = $this->get_user($openid);
				if($user){
					$content = "欢迎你{$user['nickname']}";
				}else{
					$data = $this->Get_Openid_user($openid);
					$content = $this->add_user($data, $key);
				}
				$content = $content."\n <a href='http://demo.1m15.com/mobile/center/index'>点我赚钱</a>";
				break;
			case 'CLICK' : // 触发时间
				break;
			case 'user_get_card' : // 用户领取卡券事件
				$card_code = $xml->CardId . '|' . $xml->UserCardCode; // 卡券code
				$card_num = $xml->CardId; // 卡券code
				get_CI ()->load->model ( 'admin/User_model' );
				// 更新卡券领取的数量
				$data ['card_num'] = "sq case when card_num is null or card_num='' then '$card_num' else CONCAT(card_num,',','$card_num') end";
				$data ['card_code'] = "sq case when card_code is null or card_code='' then '$card_code' else CONCAT(card_code,',','$card_code') end";
				get_CI ()->User_model->updates ( $data, "openid='$openid'" );
				break;
			case 'user_consume_card' :
				$cardid = $xml->CardId . '|ok'; // 卡券code
				get_CI ()->load->model ( 'admin/User_model' );
				// 更新卡券领取的数量
				$data ['card_state'] = "sq case when card_state is null or card_state='' then '$cardid' else CONCAT(card_state,',','$cardid') end";
				get_CI ()->User_model->updates ( $data, "openid='$openid'" );
				break;
			case 'ShakearoundUserShake' :
				break;
		}
		if ($content) {
			if (is_array ( $content )) {
				$resultStr = $this->transmitNews ( $xml, $content );
			} else {
				$resultStr = $this->transmitText ( $xml, $content );
			}
		}
		
		return $resultStr;
	}
	
	/**
	 * 创建二维码
	 * @param unknown $id
	 * @param string $type 默认永久 10万个  false生成零时二维码 25天
	 * @return string
	 */
	public  function creatQrcode($id,$type=true){
		$access_token = $this->getAccessToken();
		if($type){
			$tempJson = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$id.'"}}}';
		}else{
			$tempJson = '{"expire_seconds": 2160000, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}';
		}
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
		$tempArrs = json_decode($this->JsonPost($url, $tempJson),true);
		if(isset($tempArrs['errcode'])){
			$e = $tempArrs['errcode'];
			showmessage("请重新获取,获取二维码错误$e",'error');
		}
		$url ='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($tempArrs['ticket']);
		$qrcode = $this->downImage($url, $id);
		return $qrcode;
	}
	//下载图片到本地
	public function downImage($url,$id){
		$imageinfo = $this->httpImage($url);
		$filename = FCPATH.IMG_PATH.'mobile/qrcode/'.$id.'.jpg';
		$local_file = fopen($filename, 'w');
		if(false!==$local_file){
			if(false!==fwrite($local_file, $imageinfo['body'])){
				fclose($local_file);
			}
		}
		return IMG_PATH.'mobile/qrcode/'.$id.'.jpg';
	}
	

	
	/**
	 * 摇一摇进入
	 */
	function get_yao($state = '') {
		if ($state) {
			$ticket = $state;
		} else {
			$ticket = Gets ( 'ticket' );
		}
		$token = self::getAccessToken ();
		$url = "https://api.weixin.qq.com/shakearound/user/getshakeinfo?access_token=$token";
		$result = json_decode ( self::JsonPost ( $url, json_encode ( array (
				'ticket' => $ticket 
		) ) ), true );
		if ($result ['errmsg'] == 'success.') {
			return $result;
		} else {
			showmessage ( '请从摇一摇进入，数据出错' . $result ['errmsg'], 'error' );
		}
	}
	
	// 卡券状态
	public function card_state($data) {
		$token = self::getAccessToken ();
		$url = "https://api.weixin.qq.com/card/code/get?access_token=$token";
		$result = json_decode ( self::JsonPost ( $url, json_encode ( $data ) ), true );
		return $result;
	}
	
	// 卡券
	public function cardExt($cardid) {
		$api_ticket = self::getApiTicket ();
		$nonceStr = self::createNonceStr ();
		$timestamp = time ();
		$string = $timestamp . $nonceStr . $api_ticket . $cardid;
		// $string = $timestamp.$nonceStr.WX_APPSecret.$cardid;
		$signature = sha1 ( "$string" );
		$signPackage = array (
				"timestamp" => $timestamp,
				"signature" => $signature,
				'nonce_str' => $nonceStr 
		);
		return $signPackage;
	}
	
	// 卡券专用ticket
	public function getApiTicket() {
		$data = get_Cache ( 'api_ticket' );
		if (! $data) {
			$accessToken = self::getAccessToken ();
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&type=wx_card";
			$res = json_decode ( $this->httpGet ( $url ) );
			if ($res->errcode) {
				if (is_ajax_request ()) {
					AjaxResult ( '2', "获取ticket错误，" . $res->errmsg );
				} else {
					showmessage ( "获取ticket错误，" . $res->errmsg, 'error' );
				}
			}
			$ticket = $res->ticket;
			if ($ticket) {
				$data ['jsapi_ticket'] = $ticket;
				set_Cache ( 'api_ticket', $data, 7100 );
			}
		} else {
			$ticket = $data ['jsapi_ticket'];
		}
		return $ticket;
	}
	
	// 分享
	public function share($url) {
		$jsapiTicket = self::getJsApiTicket ();
		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
		// $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$timestamp = time ();
		$nonceStr = self::createNonceStr ();
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		$signature = sha1 ( $string );
		$signPackage = array (
				"appId" => WX_APPID,
				"nonceStr" => $nonceStr,
				"timestamp" => $timestamp,
				"signature" => $signature 
		);
		return $signPackage;
	}
	
	// 加密
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i = 0; $i < $length; $i ++) {
			$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
		}
		return $str;
	}
	// 获取jspaiticket
	private function getJsApiTicket() {
		// jsapi_ticket 应该全局存储与更新
		$data = get_Cache ( 'jsapi_ticket' );
		if (! $data) {
			$accessToken = self::getAccessToken ();
			// 如果是企业号用以下 URL 获取 ticket
			// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken&type=jsapi";
			$res = json_decode ( $this->httpGet ( $url ) );
			if ($res->errcode) {
				if (is_ajax_request ()) {
					AjaxResult ( '2', "获取ticket错误，" . $res->errmsg );
				} else {
					showmessage ( "获取ticket错误，" . $res->errmsg, 'error' );
				}
			}
			$ticket = $res->ticket;
			if ($ticket) {
				$data ['jsapi_ticket'] = $ticket;
				set_Cache ( 'jsapi_ticket', $data, 7000 );
			}
		} else {
			$ticket = $data ['jsapi_ticket'];
		}
		return $ticket;
	}
	
	// 获取token
	function getAccessToken() {
		$data = get_Cache('accesstokenct');
		if (! $data) {
			$appid = WX_APPID;
			$appser = WX_APPSecret;
			$api = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appser";
			$result = json_decode ( file_get_contents ( $api ) );
			if (isset ( $result->errcode )) {
				showmessage ( $access_token->errcode . $access_token->errmsg, 'error' );
			}
			$token = $result->access_token;
			if ($token) {
				$data ['access_token'] = $token;
				set_Cache ( 'accesstokenct', $data,7000 );
			}
		} else {
			$token = $data ['access_token'];
		}
		return $token;
	}
	private function JsonPost($url, $jsonData) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $jsonData );
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 30 );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$result = curl_exec ( $curl );
		if (curl_errno ( $curl )) {
			showmessage ( 'curl falied. Error Info: ' . curl_error ( $curl ) );
		}
		curl_close ( $curl );
		return $result;
	}
	private function https_request($url, $data = null) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		if (! empty ( $data )) {
			curl_setopt ( $curl, CURLOPT_POST, 1 );
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
		}
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$output = curl_exec ( $curl );
		curl_close ( $curl );
		return $output;
	}
	private function httpGet($url) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 500 );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $curl, CURLOPT_URL, $url );
		$res = curl_exec ( $curl );
		curl_close ( $curl );
		return $res;
	}
	private function httpImage($url) {
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_NOBODY, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo ($ch);
		curl_close($ch);
		return array_merge(array('body' => $package), array ('header' => $httpinfo));
	}
}
