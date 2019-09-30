<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 分享
 *
 * @author chaituan@126.com
 */
class Share extends WechatCommon {
	public function index() {
		$url = Posts ( 'url' );
		$this->load->library ( 'wechat/wechatapi' );
		$data = $this->wechatapi->share ( $url );
		if ($data) {
			AjaxResult ( '1', '成功', json_encode ( $data ) );
		} else {
			AjaxResult_error ();
		}
	}
	// 获取卡券
	public function card() {
		$cardid = Posts ( 'cardid' );
		$this->load->library ( 'wechat/wechatapi' );
		$result = json_encode ( $this->wechatapi->cardExt ( $cardid ) );
		if ($result) {
			AjaxResult ( 1, $cardid, $result );
		} else {
			AjaxResult_error ();
		}
	}
	
	// 领取卡券成功后执行
	public function card_success() {
		$id = $this->User ['id'];
		$this->User_model->update_usersession ( 'id', $id );
		AjaxResult ( 1, '领取成功' );
	}
	public function card_state() {
		$id = $this->User ['id'];
		$user = $this->User_model->getItem ( 'id=' . $id );
		// 判断卡券领够三张了没
		$c_numA = explode ( ',', $user ['card_num'] );
		$c_num = count ( $c_numA );
		if ($c_num != 3)
			AjaxResult_error ();
			// 领取并且使用了
		$c_state = explode ( ',', $user ['card_state'] );
		if (count ( $c_state ) == 3) {
			if ($user ['mobile']) {
				AjaxResult ( 3, '已经填写了' );
			} else {
				AjaxResult_ok ();
			}
		} else {
			AjaxResult_error ();
		}
	}
	
	// 分享出去的url 用户打开的url
	public function url() {
		$uid = Gets ( 'uid', 'checkid' );
		$item = $this->User_model->getItem ( "id=$uid" );
		if ($item ['map']) {
			redirect ( site_url ( 'wechat/yao/index' ) );
		} else {
			$data ['title'] = "demo活动";
			$this->load->view ( "wechat/share/index", $data );
		}
	}
}
