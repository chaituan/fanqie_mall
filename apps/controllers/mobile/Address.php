<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 地址管理
 * @author chaituan@126.com
 */
class Address extends NeedLoginAction {
	
	function __construct(){
		parent::__construct();
		$this->load->model('admin/Address_model');
	}
	
	function index(){
		$this->load->view('mobile/center/address');
	}
	
	function lists(){
		if(is_ajax_request()){
			$isdefa = $this->User['address'];
			$items = $this->Address_model->getItems("uid=".$this->User['id'],'','id desc');
			if($items){
				foreach ($items as $val){
					if($val['id'] == $isdefa){
						$val['isdefa']=1;
					}else{
						$val['isdefa']=0;
					}
					$item[] = $val;
				}
			}else{
				$item ="";
			}
			AjaxResult(1, "ok", $item);
		}
	}
	
	function insert(){
		$id = $this->User['id'];
		$data = Posts();
		$data['uid'] = $id;
		$data['addtime'] = time();
		$count = $this->Address_model->count("uid=$id");
		if($count>10){
			AjaxResult(2, '最多添加10个地址');
		}
		$d = 0;
		if($data['default']){
			$d = 1;
		}
		unset($data['default']);
		$result = $this->Address_model->add($data);
		if($result){
			if($d){
				$this->load->model('admin/User_model');
				$this->User_model->updates_se(array('address'=>$result),"id=".$id);
			}
			AjaxResult(1,'添加成功');
		}else{
			AjaxResult_error();
		}
	}
	
	function edit(){
		$uid = $this->User['id'];
		$id = Posts('id','checkid');
		$default = Posts('default');
		$data = Posts('data');
		$data['addtime'] = time();
		$result = $this->Address_model->updates($data, "uid=$uid and id=$id");
		if($result){
			if($default){
				$this->load->model('admin/User_model');
				$this->User_model->updates_se(array('address'=>$id),"id=".$uid);
			}
			AjaxResult(1, '编辑成功');
		}else{
			AjaxResult_error();
		}
	}
	
	function del(){
		$id = Gets('id','checkid');
		$result = $this->Address_model->deletes(array('id'=>$id,'uid'=>$this->User['id']));
		if($result){
			AjaxResult(1, '删除成功');
		}else{
			AjaxResult_error();
		}
	}
	
}
