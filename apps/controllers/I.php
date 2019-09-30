<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 前端首页
 *
 * @author chaituan@126.com
 */
class I extends UserCommon {
	public function index() {
		$this->load->model ( array (
				'admin/Banner_model' 
		) );
		$data ['banner'] = $this->Banner_model->getItems ();
		
		$this->load->model ( array (
				'admin/News_model' 
		) );
		$this->load->model ( array (
				'admin/Shop_model' 
		) );
		
		// 服装
		$data ['yifu'] = $this->News_model->getItems ( 'state<>1 and catid in (1,3,4,10,11)', 'id,thumb,buy_url,title', '', 0, 8 );
		
		// 美食
		$data ['meishi'] = $this->News_model->getItems ( 'state<>1 and catid=5', 'id,thumb,buy_url,title', '', 0, 8 );
		
		// 美文
		$data ['meiwen'] = $this->News_model->getItems ( 'state<>1 and catid in (6,7,8,9)', 'id,thumb,buy_url,title,summary', '', 0, 5 );
		
		// 店铺列表
		$data ['shop'] = $this->Shop_model->getItems ( '', '', 0, 18 );
		
		// 热点
		$data ['newsrd'] = $this->News_model->getItems ( 'state=1', 'id,title', 'id desc', 0, 9 );
		
		$this->load->view ( 'home/index', $data );
	}
}
