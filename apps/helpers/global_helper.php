<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 常用函数
 * 
 * @author chaituan@126.com
 */

if (! function_exists ( 'template' )) {
	/**
	 * 模板调用
	 * 
	 * @param $name 目录名字        	
	 * @param $data 传值进入        	
	 */
	function template($name, $data = null) {
		get_CI ()->load->view ( $name, $data );
	}
}

if (! function_exists ( 'get_Cache' )) {
	/**
	 * 获取缓存
	 * 
	 * @param unknown $cache_name
	 *        	'adapter' => 'apc' 从php5.5以后已经去掉了用了 opcache
	 */
	function get_Cache($cache_name,$dir = '') {
		get_CI()->load->driver('cache');
		return get_CI()->cache->file->gets($cache_name,$dir);
	}
}

if (! function_exists ( 'set_Cache' )) {
	/**
	 * 设置缓存
	 * 
	 * @param unknown $name        	
	 * @param unknown $data        	
	 * @param number $timesec        	
	 */
	function set_Cache($name, $data, $timesec = 0,$dir = '') {
		get_CI()->load->driver('cache');
		return get_CI ()->cache->file->saves($name, $data, $timesec,$dir);
	}
}

if (! function_exists ( 'AjaxResult' )) {
	/**
	 *
	 * @param state int 0感叹号 1 正确 2错误 3 问号 4锁 5哭 6微笑
	 * @param string $message        	
	 * @param
	 *        	arr or string $data
	 */
	function AjaxResult($state, $message, $data = array()) {
		die ( json_encode ( array (
				'state' => $state,
				'message' => $message,
				'data' => $data 
		) ) );
	}
}

if (! function_exists ( 'AjaxResult_ok' )) {
	/**
	 * ajax 快捷操作成功
	 */
	function AjaxResult_ok($msg=false) {
		die ( json_encode ( array (
				'state' => "1",
				'message' => $msg?$msg:'操作成功' 
		) ) );
	}
}
if (! function_exists ( 'AjaxResult_error' )) {
	/**
	 * ajax 快捷操作失败
	 */
	function AjaxResult_error($msg=false) {
		die ( json_encode ( array (
				'state' => '2',
				'message' => $msg?$msg:'操作失败' 
		) ) );
	}
}

if (! function_exists ( 'is_AjaxResult' )) {
	/**
	 * $result 快捷执行ajax
	 */
	function is_AjaxResult($result,$ok_msg=false,$error_msg=false) {
		if ($result) {
			AjaxResult_ok($ok_msg);
		} else {
			AjaxResult_error($error_msg);
		}
	}
}

if (! function_exists ( 'set_password' )) {
	function set_password($pwd) {
		$encrypt = random_string ( 'alnum', 7 );
		$pwd = md5 ( md5 ( $pwd . $encrypt ) );
		return array (
				'password' => $pwd,
				'encrypt' => $encrypt 
		);
	}
}
if (! function_exists ( 'get_password' )) {
	function get_password($pwd, $encrypt) {
		$pwd = md5 ( md5 ( $pwd . $encrypt ) );
		return $pwd;
	}
}

if (! function_exists ( 'changeArrayKey' )) {
	/**
	 * 更改hash数组的key值, 注意：如果key不唯一则会产生覆盖
	 * 
	 * @param array $array        	
	 * @param string $key        	
	 * @return array
	 */
	function changeArrayKey(&$array, $key = 'id') {
		$newArray = array ();
		foreach ( $array as $value )
			$newArray [$value [$key]] = $value;
		return $newArray;
	}
}
if (! function_exists ( 'filterArrayByKey' )) {
	/**
	 * 按照某一键值过滤数组，只适用与 key => value数组
	 * 
	 * @param string $key
	 *        	要筛选的键
	 * @param mixed $val
	 *        	筛选的边界值(多个边界值可以用数组)
	 * @param array $array
	 *        	被筛选的数组
	 * @return array
	 */
	function filterArrayByKey($key, $val, &$array) {
		$newArray = array ();
		foreach ( $array as $value ) {
			if ($value [$key] == $val || (is_array ( $val ) && in_array ( $value [$key], $val )))
				$newArray [] = $value;
		}
		return $newArray;
	}
}
if (! function_exists ( 'parseURL' )) {
	/**
	 * 重写url里面的参数
	 * 
	 * @param unknown $url        	
	 */
	function parseURL($url) {
		if (isset ( $url )) {
			$params = explode ( '-', $url );
			for($i = 0; $i < count ( $params ); $i ++) {
				if ($i % 2 == 0) {
					if (trim ( $params [$i] ) == '') {
						continue;
					}
					if(isset($params [$i + 1])){
						$_GET [$params [$i]] = $params [$i + 1];
					}
				}
			}
		}
	}
}

if (! function_exists ( 'is_ajax_request' )) {
	function is_ajax_request() {
		return get_CI ()->input->is_ajax_request ();
	}
}

if (! function_exists ( 'showmessage' )) {
	/**
	 * 错误消息提示
	 * 
	 * @param string $status error success  info warn waiting
	 * @param string $msg       	
	 * @param string $url_forward        	
	 * @param number $ms        	
	 */
	function showmessage($msg, $status = '', $url_forward = '', $ms = '',$show_btn = true) {
		if (is_ajax_request ()) {//增加判断 当他是异步提交的时候 直接报错
			AjaxResult (2,$msg);
		} else {
			if ($url_forward == ''){
				$url_forward = PREV_URL;
			}else{
				if($url_forward=='#'){
					$url_forward = '';
				}else{
					$url_forward = site_url($url_forward);
				}
			}
			switch ($status) {
				case 'error' :
					$tipsico = '<p ><i class="weui-icon-warn weui-icon_msg"></i></p>';
					break;
				case 'success' :
					$tipsico = '<p ><i class="weui-icon-success weui-icon_msg"></i></p>';
					break;
				case 'info' :
					$tipsico = '<p ><i class="weui-icon-info weui-icon_msg"></i></p>';
					break;
				case 'warn' :
					$tipsico = '<p ><i class="weui-icon-warn weui-icon_msg-primary"></i></p>';
					break;
				case 'waiting' :
					$tipsico = '<p ><i class="weui-icon-waiting weui-icon_msg"></i></p>';
					break;
				default:
					$tipsico = '<p ><i class="weui-icon-success weui-icon_msg"></i></p>';
			}
			if (strpos ( PREV_URL, '/adminct/' )) {
				$index = site_url ( 'adminct/manager/index' );
			} elseif (strpos ( PREV_URL, '/mobile/' )) {
				$index = site_url ( 'mobile/mall/index' ); // 待定
			} else {
				$index = base_url ();
			}
			$datainfo = array (
					"msg" => $msg,
					"url_forward" => $url_forward,
					"ms" => $ms?$ms:3000,
					"index" => $index,
					'tipsico' => $tipsico ,
					'show_btn' =>$show_btn
			);
			echo get_CI ()->load->view ( 'message/message', $datainfo, true );
			exit ();
		}
	}
}

if (! function_exists ( 'Posts' )) {
	/**
	 * post
	 * $conditions 需要检测的条件
	 */
	function Posts($name = null, $conditions = null, $gl = true) {
		$post = get_CI ()->input->post ( $name, $gl );
		if ($post === null) { // 当post为空的时候
			if (is_ajax_request ()) {
				AjaxResult ( '2', '获取不到参数' );
			} else {
				showmessage ( 'error', '获取不到参数' );
			}
		}
		// 是否检测ID
		if ($conditions == 'checkid' && $post) {
			check_id ( $post );
		} else {
			$post = check_input ( $post );
		}
		return $post;
	}
}

if (! function_exists ( 'Gets' )) {
	/**
	 * get
	 * $conditions 需要检测的条件
	 * $gl 过滤 默认true
	 */
	function Gets($name = null, $conditions = null, $gl = true) {
		$get = get_CI ()->input->get ( $name, $gl );
		
		// 是否检测ID
		if ($conditions == 'checkid' && $get) {
			check_id ( $get );
		} else {
			$get = check_input ( $get );
		}
		return $get;
	}
}

if (! function_exists ( 'url_value' )) {
	/**
	 * 网页前端get到URL的参数值
	 */
	function url_value($num, $is_num = false) {
		// get到的数据为null的时候返回0， 默认开启
		$get = get_CI ()->uri->segment ( $num, 0 );
		// ID是否是数字
		if ($is_num == 'number') {
			check_id ( $get );
		}
		return $get;
	}
}

if (! function_exists ( 'format_time' )) {
	/**
	 * get
	 * $conditions 需要检测的条件
	 */
	function format_time($time, $string = 'Y-m-d H:i:s') {
		return date ( $string, $time );
	}
}

if (! function_exists ( 'str_cut' )) {
	/**
	 * 字符截取 支持UTF8/GBK
	 * 
	 * @param
	 *        	$string
	 * @param
	 *        	$length
	 * @param
	 *        	$dot
	 */
	function str_cut($string, $length, $character = '...') {
		$string = strip_tags ( $string );
		$string = str_replace ( array (
				"\r",
				"\n",
				"'",
				'"' 
		), array (
				'',
				'',
				'\'',
				'\"' 
		), $string );
		if (getStringLength ( $string ) > $length) {
			return subString ( $string, 0, $length ) . $character;
		} else {
			return subString ( $string, 0, $length );
		}
	}
}
function getStringLength($text) {
	if (function_exists ( 'mb_substr' )) {
		$length = mb_strlen ( $text, 'UTF-8' );
	} elseif (function_exists ( 'iconv_substr' )) {
		$length = iconv_strlen ( $text, 'UTF-8' );
	} else {
		preg_match_all ( "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar );
		$length = count ( $ar [0] );
	}
	return $length;
}
function subString($text, $start = 0, $limit = 12) {
	if (function_exists ( 'mb_substr' )) {
		$more = (mb_strlen ( $text, 'UTF-8' ) > $limit) ? TRUE : FALSE;
		$text = mb_substr ( $text, 0, $limit, 'UTF-8' );
		return $text;
	} elseif (function_exists ( 'iconv_substr' )) {
		$more = (iconv_strlen ( $text, 'UTF-8' ) > $limit) ? TRUE : FALSE;
		$text = iconv_substr ( $text, 0, $limit, 'UTF-8' );
		// return array($text, $more);
		return $text;
	} else {
		preg_match_all ( "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar );
		if (func_num_args () >= 3) {
			if (count ( $ar [0] ) > $limit) {
				$more = TRUE;
				$text = join ( "", array_slice ( $ar [0], 0, $limit ) );
			} else {
				$more = FALSE;
				$text = join ( "", array_slice ( $ar [0], 0, $limit ) );
			}
		} else {
			$more = FALSE;
			$text = join ( "", array_slice ( $ar [0], 0 ) );
		}
		return $text;
	}
}

if (! function_exists ( 'get_fileinput_initview' )) {
	/**
	 * 上传图片插件 返回初始的html 和配置
	 *
	 * @param unknown $thumb        	
	 * @return string
	 */
	function get_fileinput_initview($thumb, $config = false) {
		$thumb = explode(',', $thumb);
		$str = '';
		if ($config) {
			$url = site_url ( 'images/upload/del' );
			$str .='[';
			foreach ($thumb as $v){
				$str .= '{"url":"' . $url . '","key":"' . $v . '"},';
			}
			$str .=']';
			return str_replace(',]', ']', $str);
		} else {
			if ($thumb[0]) {
				$str .='[';
				foreach ($thumb as $v){
					$str .= '"<img src='.$v.'  class=file-preview-image style=height:160px;width:auto >",';
				}
				$str .=']';
				return str_replace(',]', ']', $str);
			} else {
				return null;
			}
		}
	}
}


if (! function_exists ( 'order_trade_no' )) {
	/**
	 * 订单号
	 * @return string
	 */
	function order_trade_no(){
		$yCode= array('A','B','C','D','E','F','G','H','I','J');
		return $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))). date('d'). substr(time(),-5) . substr(microtime(), 2, 5) . sprintf('%02d',rand(0, 99));
	}
}

if(!function_exists('admin_config_cache')){
	/**
	 * 后台配置文件
	 */
	function admin_config_cache($tkey=false){
		
		$cache_data = get_Cache('admin_config');
		if(!$cache_data)showmessage("读取配置文件出错",'error');
		
		if($tkey){
			foreach ($cache_data as $v){
				if($v['tkey'] == $tkey){
					$new_data[$v['key']] = $v['val'];
				}
			}
		}else{
			foreach ($cache_data as $v){
				$new_data[$v['key']] = $v['val'];
			}
		}
		
		return $new_data;
	}
}

if (! function_exists ( 'get_CI' )) {
	/**
	 * 实例化CI
	 */
	function get_CI() {
		global $CI;
		if (! $CI)
			$CI = & get_instance ();
		return $CI;
	}
}

