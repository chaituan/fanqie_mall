<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 用户中心
 * @author chaituan@126.com
 */
class Center extends NeedLoginAction {
	
	function index(){
		$uid = $this->User['id'];
		//订单统计 未支付和待收货的
		$this->load->model('admin/Order_model');
		$order = $this->Order_model->getItems("uid=$uid and state in (1,4)",'state');
		$pay = 0;$receive=0;$comment=0;
		foreach ($order as $v){
			if($v['state']==1){
				$pay++;
			}elseif($v['state']==4){
				$comment++;
			}else{
				$receive++;
			}
		}
		$data['order'] = array('pay'=>$pay,'receive'=>$receive,'comment'=>$comment);
		//团队名称
		
		$data['config'] = admin_config_cache('user');
		$this->load->view ('mobile/center/index',$data);
	}
	
	function child(){
		$uid = $this->User['id'];
		$id = Gets('id','checkid');
		$this->load->model('admin/User_model');
		$data['items'] = $this->User_model->getItems("p_$id=$uid");
		$data['xz'] = $id;
		$this->load->view ('mobile/center/child',$data);
	}
	
	//我的二维码
	function qrcode(){
		if(is_ajax_request()){
			$uid = $this->User['id'];
			if($this->User['qrcode']){//是否已经存在二维码
				$expire = strtotime("+24 day", $this->User['qrcode_time']) - strtotime("now");//到期时间差
				if($expire < 0){//二维码是否过期小于0 过期重新生成
					$this->qrcode_creat();
				}
			}else{
				$this->qrcode_creat();
			}
			AjaxResult(1, '生成成功');
		}else{
			$expire = strtotime("+24 day", $this->User['qrcode_time']) - strtotime("now");//到期时间差
			if($expire < 0){//二维码是否过期小于0  显示生成二维码图片
				$data['img'] = '';
			}else{
				$data['img'] = $this->User['qrcode'];
			}
			$data['expire'] = date('Y-m-d',strtotime("+24 day", $this->User['qrcode_time']));
			$this->load->view('mobile/center/qrcode',$data);
		}
	}
	
	private function qrcode_creat(){
		$uid = $this->User['id'];
		$this->load->library('wechat/wechat_api');
		$img = $this->wechat_api->creatQrcode($uid);
		$this->load->model('admin/User_model');
		$time = time();
		$this->User_model->updates(array('qrcode'=>$img,'qrcode_time'=>$time),"id=$uid");//更新数据库
		$this->User_model->up_user_session(array('qrcode'=>$img,'qrcode_time'=>$time));//更新session
		return $img;
	}
	
	function edit_user(){
		if(is_ajax_request()){
			$uid = $this->User['id'];
			$data = Posts('data');
			if($data['mobile']==$this->User['mobile'])AjaxResult_error("没有修改");
			$this->load->model('admin/User_model');
			$mobile = $this->User_model->getItem(array('mobile'=>$data['mobile']),'id');
			if($mobile)AjaxResult_error("号码已经存在");
			$result = $this->User_model->updates($data,"id=$uid");
			if($result){
				$this->User_model->updates_se($data,"id=".$uid);//更新session
				AjaxResult_ok();
			}else{
				AjaxResult_error();
			}
		}else{
			$this->load->view('mobile/center/edit_user');
		}
	}
	
}
