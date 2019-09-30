<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 系统配置
 * @author chaituan@126.com
 */
class Config extends AdminCommon {

	public function __construct(){
		parent::__construct();
		$this->load->model(array('admin/Config_model'));
	}
	
	public function index(){
		$data['items'] = get_Cache('admin_config');
		$this->load->view('admin/config/index',$data);
	}
		
	public function edit(){
		if(is_ajax_request()){
			$id = Posts('id','checkid');
			$data = Posts('data');
			$r = $this->Config_model->updates($data,"id=$id");
			if($r){
				$this->Config_model->cache();
				AjaxResult_ok();
			}else{
				AjaxResult_error();
			}
		}else{
			$data['item'] = $this->Config_model->getItem(array('id'=>Gets('id','checkid')));
			$this->load->view('admin/config/edit',$data);
		}
	}
	
	public function add(){
		if(is_ajax_request()){
			$data = Posts('data');
			$data['key'] = $data['tkey'].'_'.$data['key'];
			$r = $this->Config_model->add($data);
			if($r){
				$this->Config_model->cache();
				AjaxResult_ok();
			}else{
				AjaxResult_error();
			}
		}else{
			$this->load->view('admin/news/add');
		}
	}
	
	public function quicksave(){
		if(is_ajax_request()){
			$data = Posts('data');
			foreach ($data['hids'] as $k=>$id){
				if(!isset($data[$k]['val'])){//当checkbox不选中的时候 ，不传过来值 也不传过来name
					$v = 0;
				}else{
					$v = $data[$k]['val'];
				}
				$r = $this->Config_model->updates(array('val'=>$v),"id=$id");
			}
			if($r){
				$this->Config_model->cache();
				AjaxResult_ok();
			}else{
				AjaxResult_error();
			}
		}
	}
	
	public function delete(){
		$r = $this->Config_model->deletes("id=".Gets('id','checkid'));
		if($r){
			$this->Config_model->cache();
			AjaxResult_ok();
		}else{
			AjaxResult_error();
		}
	}
	
}
