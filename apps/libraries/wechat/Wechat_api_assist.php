<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 微信类库辅助类，主要操作数据库
 * @author chaituan@126.com
 */
class Wechat_api_assist {
	
	/**
	 * 添加用户
	 * @param unknown $pid 二维码里面的id
	 */
	public function add_user($userinfo,$pid) {
		$CI = get_CI();
		$CI->load->model('admin/User_model');
		if($pid){
			$parent =$CI->User_model->getItem("id=$pid",'p_1');
		}else{
			$pid = 0;$parent['p_1'] = 0;
		}
		$datas = array(
				'nickname'=>$userinfo['nickname'],
				'openid'=>$userinfo['openid'],
				'p_1'=>$pid,
				'p_2'=>$parent['p_1'],
				'thumb'=>$userinfo['headimgurl'],
				'sex'=>$userinfo['sex'],
				'groupid'=>1,
				'addtime'=>time()
		);
		$CI->User_model->add($datas);
		$name = $userinfo['nickname'];
		return "您好{$name}，欢迎关注我们";
	}
	public function get_user($openid){
		$CI = get_CI();
		$CI->load->model('admin/User_model');
		$user = $CI->User_model->getItem(array('openid'=>$openid));
		return $user;
	}
	/**
	 * 微信文字回复
	 *
	 * @param unknown $object
	 * @param unknown $content
	 * @param number $flag
	 * @return string
	 */
	function transmitText($object, $content, $flag = 0) {
		$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<MsgId>%d</MsgId></xml>";
		$resultStr = sprintf ( $textTpl, $object->FromUserName, $object->ToUserName, time (), $content, $flag );
		return $resultStr;
	}
	
	/**
	 * 微信图片回复
	 *
	 * @param unknown $object
	 * @param unknown $content
	 * @param number $flag
	 * @return string
	 */
	function transmitImage($object, $content, $flag = 0) {
		$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[image]]></MsgType>
					<Image><MediaId><![CDATA[%s]]></MediaId></Image>
					<MsgId>%d</MsgId></xml>";
		$resultStr = sprintf ( $textTpl, $object->FromUserName, $object->ToUserName, time (), $content, $flag );
		return $resultStr;
	}
	/**
	 * 微信图文回复
	 *
	 * @param unknown $object
	 * @param unknown $arr_item
	 * @param number $funcFlag
	 * @return void string
	 */
	 function transmitNews($object, $arr_item, $funcFlag = 0) {
		// 首条标题28字，其他标题39字
		if (! is_array ( $arr_item ))
			return;
		$itemTpl = "<item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url></item>";
		$item_str = "";
		foreach ( $arr_item as $item ) {
			$item_str .= sprintf ( $itemTpl, $item ['Title'], $item ['Description'], $item ['PicUrl'], $item ['Url'] );
		}
		$newsTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[news]]></MsgType>
		<Content><![CDATA[]]></Content>
		<ArticleCount>%s</ArticleCount>
		<Articles>
		$item_str</Articles>
		<FuncFlag>%s</FuncFlag>
		</xml>";
		$resultStr = sprintf ( $newsTpl, $object->FromUserName, $object->ToUserName, time (), count ( $arr_item ), $funcFlag );
		return $resultStr;
	}
}
