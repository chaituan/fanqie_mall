<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 微信
 * @author chaituan@126.com
 */
use EasyWeChat\Foundation\Application;
class Wechat extends AdminCommon {
	
	public function config(){
		$data = get_Cache('admin_config');
		foreach ($data as $v){
			if($v['tkey']=='wechat'){
				$datas['items'][] = $v;
			}
		}
		$this->load->view('admin/config/views',$datas);
	}
	
	public function menu(){
		if(is_ajax_request()){
			$data = json_decode(Posts('menu'),true);
			if($data['button']){
				set_Cache('wechat_menu', $data,0,'wechat');
				$button = $data['button'];
				$app = new Application(array());
				$menu = $app->menu->add($button);
				if($menu->errcode == 0){
					AjaxResult_ok("发布成功");
				}else{
					AjaxResult_error($menu->errmsg);
				}
			}else{
				AjaxResult_error("请添加一个菜单");
			}
		}else{
			$this->load->view('admin/wechat/menu');
		}
	}
	//获取线上菜单
	function get_menus(){
		if(is_ajax_request()){
			$app = new Application(array());
			$menu = $app->menu->all();
			AjaxResult(1, '拉取微信菜单成功',$menu);
		}
	}
	//初始化获取菜单
	function get_load(){
		if(is_ajax_request()){
			$menu = get_Cache('wechat_menu','wechat');
			if($menu){
				AjaxResult(1, '初始化成功',$menu);
			}else{
				AjaxResult_error("请添加菜单");
			}
		}
	}
	
	
}
