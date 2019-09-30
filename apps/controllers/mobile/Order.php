<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 订单
 * @author chaituan@126.com
 */
class Order extends NeedLoginAction {
	
	function __construct(){
		parent::__construct();
		$this->load->model(array('admin/Order_model','admin/Orderlists_model'));
	}
	
	//选择完毕商品后保存规格跳转到 确认订单页面
	function save_goods(){
		if(is_ajax_request()){
			$data = Posts();
			$price = str_replace('￥', '', $data['price']);
			$items = array(array(
					'id' => $data['id'].str_replace(',', '', $data['selPath']),//生成特别id
					'qty' => $data['num'],//数量
					'price' => $price,//单架
					'name' => $data['names'],//产品名字
					'options' => array('options' => $data['options'],'selPath' =>  $data['selPath'],'thumb' =>$data['thumb'],'total'=>$data['num']*$price,'gid'=> $data['id'])
			));
			$this->session->set_userdata('goods_sku',$items);
			$this->session->set_userdata('source','direct');//直接购买
			AjaxResult(1, '玩命为你加载中...',array('url'=>site_url('mobile/order/index').'#paypage'));
		}else{
			showmessage('错误请求','error','mobile/mall/index');
		}
	}
	
	//购车跳转页面，然后确认订单
	function save_cart(){
		if(is_ajax_request()){
			$this->load->library('fcart');
			$cart = Posts('ids');//提交过来的产品id
			if(!$cart)AjaxResult_error('数据失效，请重新购买');
			foreach ($cart as $v){
				$items[] = $this->fcart->contents()[$v];
			}
			$this->session->set_userdata('goods_sku',$items);
			$this->session->set_userdata('source','cart');//购物车购买
			AjaxResult(1, '提交成功');
		}else{
			showmessage('错误请求','error','mobile/mall/index');
		}
	}
	/**
	 * 确认订单页面
	 * 因为购物车里面可能是多家商店的多个产品，所以这里要合并，首页合并多店铺 在合成多多店铺里面的多订单
	 */
	function index(){
		$goods_sku = $this->session->goods_sku;
		if(!$goods_sku)showmessage('数据已经失效','info','mobile/mall/index');
		foreach ($goods_sku as $v){
			$idArr[] = $v['options']['gid'];
		}
		$idString = implode(',', array_unique($idArr));
		//检测实际价格
		$this->load->model('admin/Goods_model');
		$items = $this->Goods_model->getItems("id in ($idString)",'id,names,shopid,stock,price,catid,is_sku,is_stock,sku_price,sku_stock,thumb');
		if($items){
			//把查询出来的数组key 更换成id
			foreach ($items as $v){
				$newItem[$v['id']] = $v;
			}
			$total = 0;
			foreach ($goods_sku as $v){
				$goods = $newItem[$v['options']['gid']];//获取产品的所有参数
				if($goods['is_sku']){//根据是否开始规格来判断产品是否已经没有库存了
					$sku_stock = json_decode($goods['sku_stock'],true);
					if($sku_stock[$v['options']['selPath']] <= 0)showmessage('抱歉，商品已经下架','error');
					//为减少库存配置
					if(!$goods['is_stock']){//是否开启库存永不减少 0 减少  1不减少
						$sku_stock[$v['options']['selPath']] = $sku_stock[$v['options']['selPath']] - $v['qty'];
						$newItems['sku'][] = array(
							'sku_stock' =>json_encode((object)$sku_stock),
								'id'    =>$v['options']['gid']
						);
					}
				}else{
					if($goods['stock'] <= 0)showmessage('抱歉，商品已经下架','error');
					
					//为减少库存配置
					if(!$goods['is_stock']){//是否开启库存永不减少 0 减少  1不减少
						$stock = $goods['stock'] - $v['qty'];
						$newItems['sku'][] = array(
								'stock' =>$stock,
								'id'    =>$v['options']['gid']
						);
					}
				}
				$sku_price = json_decode($goods['sku_price'],true);//获取当前产品的价格 转换成数组
				$price = $v['options']['selPath']?$sku_price[$v['options']['selPath']]:$goods['price'];//单价 根据选择路径获取真实数据价格 如果没有则正常价格
				$price_total = $price * $v['qty'];
				$newItems['detail'][$goods['shopid']][] = array(//通过店铺id 生成三维数组来区分
						'id'=>$goods['id'],
						'catid'=>$goods['catid'],
						'price'=>$price,
						'names'=>$goods['names'],
						'thumb'=>$goods['thumb'],
						'selPath'=>$v['options']['selPath'],
						'num' => $v['qty'],
						'options'=>$v['options']['options'],
						'prices' =>$price_total,
				);
				$newItems['total'][$goods['shopid']][] = $price_total;//为安全订单配置
				
				$total += $price_total;
			}
			$data['items'] = $newItems['detail'];//合并成功
			//整合好的数据存入新的session
			$this->session->set_userdata('new_goods',$newItems);
			$data['total'] = $total;
		}else{//当确认订单的时候，如果没有了库存，则不进去
			$this->load->library('fcart');//销毁购物车
			$this->fcart->destroy();
			showmessage('商品已被删除','error','mobile/mall/index');
		}
		//获取地址
		$this->load->model('admin/Address_model');
		$data['aitem'] = $this->Address_model->getItem(array('id'=>$this->User['address']));
		$this->load->view('mobile/order/index',$data);
	}
	//确认订单后，生成订单
	function create_order(){
		if(is_ajax_request()){
			$data = $this->safe_order(Posts('data'));
			//生成订单
			$result = $this->Orderlists_model->add_batch($data);
			is_AjaxResult($result,'提交成功','提交失败');
		}else{
			showmessage('数据失效','waiting','mobile/mall/index');
		}
	}
	
	//生成安全订单
	private function safe_order($data){
		//多家店铺 考虑到 订单问题，支付完成后 异步通知只能传一个订单好，这时候我们设置一个pay_order_no 支付订单号来批量完成 支付状态
		$goods = $this->session->new_goods;
		if(!$goods)AjaxResult_error("时间太长，页面失效");
		$timg = time();
		$total = 0;
		$t = count($goods['detail']);//为了一下多个订单号，同时刷新支付状态
		$pay_order_no = order_trade_no().'X'.$t;
		foreach ($goods['detail'] as $k=>$item){//第一次循环生成 订单，
			$order_no = order_trade_no();
			$orderm = array(
					'openid'=>$this->User['openid'],
					'order_no'=>$order_no,
					'uid' =>$this->User['id'],
					'price' =>  array_sum($goods['total'][$k]),//计算出每家店铺 所有产品的总价格
					'addtime' =>$timg,
					'message' =>$data[$k]['message'],
					'shopid' =>$k,
					'pay_order_no' =>$pay_order_no,
					'buy_name'=>$data['add']['buy_name'],'buy_mobile'=>$data['add']['buy_mobile'],'buy_address'=>$data['add']['buy_address']
			);
			//插入数据库 生成订单
			$oid = $this->Order_model->add($orderm);
			foreach ($item as $v){//第二次循环生成订单的详情 ，也就是一个订单号多个子订单
				$datas[] = array(
						'oid' => $oid,
						'title'=>$v['names'],
						'order_no'=>$order_no,
						'uid'=>$this->User['id'],
						'prices'=>$v['price'],
						'thumb'=>$v['thumb'],
						'catid'=>$v['catid'],
						'gid'=>$v['id'],
						'sku'=>$v['options'],
						'num'=>$v['num'],
				);
				$names = $v['names'];
				$total += $v['prices'];
			}
		}
		//生成传递给微信的 参数
		if($this->session->source == 'direct'){
			$title = $names;
		}else{
			$title = '多产品合并支付';
		}
		$wechat = array(
				'openid'=>$this->User['openid'],
				'title'=>$title,
				'out_trade_no'=>$pay_order_no,
				'total_fee'=>$total,
				'product_id'=>1
		);
		if($wechat){//设置订单信息
			$this->session->set_userdata('order_info',$wechat);
		}
		if(isset($goods['sku'])&&$goods['sku']){//更新库存
			$this->load->model('admin/Goods_model');
			$this->Goods_model->update_batchs($goods['sku'],'id');
		}
		if($this->session->source == 'cart'){//销毁购车
			$this->load->library('fcart');
			$this->fcart->destroy();
		}
		return $datas;
	}
	//收银台
	function syt(){
		$order_info = $this->session->order_info;
		if($order_info){
			$this->load->library('wechat/wechat_pay_api');//支付功能
			$data['pay_api'] = $this->wechat_pay_api->pay($order_info);
			$data['total'] = $order_info['total_fee'];
			$data['pay_order_no'] = $order_info['out_trade_no'];
			$this->session->unset_userdata(array('order_info','new_goods','goods_sku'));//销毁数据
			$this->load->view('mobile/order/syt',$data);
		}else{
			showmessage('数据失效','waiting','mobile/order/lists/id-1');
		}
	}
	
	//未支付收银台s
	function syts(){
		$id = Gets('id','checkid');
		if($id){
			$items = $this->Order_model->getItems_join(array('order_lists'=>'order.id=order_lists.oid'),"order.id=$id",'order.price,order.pay_order_no,order_lists.title');
			$count = count($items);
			$item = $items[0];
			if($count>1){
				$title = '多产品合并支付';
			}else{
				$title = $item['title'];
			}
			$wechat = array(
					'openid'=>$this->User['openid'],
					'title'=>$title,
					'out_trade_no'=>$item['pay_order_no'],
					'total_fee'=>$item['price'],
					'product_id'=>1
			);
			$this->load->library('wechat/wechat_pay_api');//支付功能
			$data['pay_api'] = $this->wechat_pay_api->pay($wechat);
			$data['total'] = $item['price'];
			$data['pay_order_no'] = $item['pay_order_no'];
			$this->load->view('mobile/order/syt',$data);
		}else{
			showmessage('数据失效','waiting','mobile/order/lists/id-1');
		}
	}
	//测试支付
	function test_pay(){sleep(2);exit;
// 		$order_no = Gets("id");
// 		$item = $this->Order_model->updates(array('state'=>2),array("pay_order_no"=>$order_no));
// 		is_AjaxResult($item,'支付成功','支付失败');
	}
	
	//全部订单列表 1待付款   2(已支付)待发货   3(已发货)待收货   4(收到货)待评价 5退货
	function lists(){
		$id = Gets('id','checkid');
		$zd = "order.id,order.order_no,order.state,order_lists.thumb,order_lists.title,order_lists.prices,order_lists.num,order_lists.sku,order_lists.oid";
		$where = "";
		if($id){
			$where = "and order.state=$id";
		}else{
			$id="";
		}
		$uid = $this->User['id'];
		$items = $this->Order_model->getItems_join(array('order_lists' =>"order.id=order_lists.oid+left"),"order.uid=$uid $where","$zd", 'order.id desc',Gets('per_page','checkid'), PAGESIZE );
		if($items){
			foreach ($items as $v){
				$newItems[$v['oid']]['child'][] = $v;
				$newItems[$v['oid']]['order_no'] = $v['order_no'];
				$newItems[$v['oid']]['id'] = $v['id'];
				$newItems[$v['oid']]['state'] = $v['state'];
			}
		}else{
			$newItems = "";
		}
		$data['newItems'] = $newItems;
		$data['xz'] = $id;
		$this->load->view('mobile/order/lists',$data);
	}
	//订单详情
	function detail(){
		$zd = "order_lists.gid,order_lists.id,order.order_no,order.exp_company,order.exp_no,order.state,order.buy_name,order.buy_mobile,order.buy_address,order.price,order.addtime,order_lists.thumb,order_lists.title,order_lists.prices,order_lists.num,order_lists.sku,order_lists.oid,order.message";
		$id = Gets('id','checkid');
		$uid = $this->User['id'];
		if($id){
			$items = $this->Order_model->getItems_join(array('order_lists' =>"order.id=order_lists.oid+left"),"order.uid=$uid and order.id=$id","$zd");
			if($items){
				foreach ($items as $v){
					$newItems['item'] = array('order_no'=>$v['order_no'],'state'=>$v['state'],'name'=>$v['buy_name'],'mobile'=>$v['buy_mobile'],'address'=>$v['buy_address'],'message'=>$v['message'],'price'=>$v['price'],'addtime'=>$v['addtime'],'exp_company'=>$v['exp_company'],'exp_no'=>$v['exp_no']);
					$newItems['child'][] = $v;
				}
			}else{
				showmessage('页面错误','error');
			}
			$data['newItems'] = $newItems;
			$this->load->view('mobile/order/detail',$data);
		}else{
			showmessage('页面错误','error');
		}
	}
	//确认收货
	function affirm_receive(){
		if(is_ajax_request()){
			$uid = $this->User['id'];
			$id = Gets('id','checkid');
			$order = $this->Order_model->getItem("id=$id and uid=$uid and state=3",'price,shopid,order_no');
			$this->Order_model->start();
			if(!$order)AjaxResult_error("非法操作");
			$time = time();
			//开始计算收益
			$config = $this->admin_config_cache('user');
			if($config['user_is_fx']){//是否开启分销
				$userGroup = get_Cache("UserGroupCache");//获取会员等级制度缓存
				foreach ($userGroup as $v){
					if($v['id'] == $this->User['groupid']){
						$earnings = $v;//获取给上级会员提成比例
					}
				}
				$this->load->model(array('admin/Earnings_detail_model','admin/Earnings_details_model'));//收益表
				$percentage1 = $earnings['p_1'];//一级的百分比
				$t = $time;
				$price = $order['price'];
				if($percentage1){//一级
					$uid_1 = $this->User['p_1'];//上一级id
					if($uid_1){
						$money = $price * ($earnings['p_1']/100);
						$e_detail[] = array('uid'=>$uid_1,'cid'=>$uid,'money'=>$money,'addtime'=>$t);
// 						$this->User_model->updates(array('money'=>"+=$money"),"id=$uid_1");//更新数据和session 关闭用户表中的money，直接根据明细表计算
					}
				}
				$percentage2 = $earnings['p_2'];//二级的百分比
				if($percentage2){//二级
					$uid_2 = $this->User['p_2'];//上二级id
					if($uid_2){
						$money = $price * ($earnings['p_2']/100);
						$e_detail[] = array('uid'=>$uid_2,'cid'=>$uid,'money'=>$money,'addtime'=>$t);
// 						$this->User_model->updates(array('money'=>"+=$money"),"id=$uid_2");//更新数据和session
					}
				}
				$this->Earnings_detail_model->add_batch($e_detail);//批量添加一级和二级添加明细
				$this->Earnings_details_model->add_batch($e_detail);//备用表也加入数据  如果出错，备用表为正确
			}
			//添加商户的收益
			$this->load->model('admin/Shopincome_model');
			$data = array(
					'shopid'=>$order['shopid'],
					'order_no'=>$order['order_no'],
					'money'=>$order['price'],
					'addtime'=>$time
			);
			$r = $this->Shopincome_model->add($data);
			if(!$r)AjaxResult_error('添加income错误');
			//更新状态和收货时间
			$result = $this->Order_model->updates(array('state'=>4,'confirm_tim'=>$time),"id=$id and uid=$uid and state=3");
			$this->Order_model->complete();//事物结束，开启事物是为了防止 收益明细多次执行
			is_AjaxResult($result);
		}else{
			showmessage('页面错误','error');
		}
	}
	//评价
	function comment(){
		$uid = $this->User['id'];
		if(is_ajax_request()){
			$data = Posts('data');
			$id = Posts('id','checkid');
			$v['uid'] = 0;
			foreach ($data as $v){
				$v['uid'] = $uid;
				$v['addtime'] = time();
				$newdata[] = $v;
			}
			$this->load->model('admin/Comment_model');
			$this->Order_model->updates(array('state'=>5),"id=$id");
			$result = $this->Comment_model->add_batch($newdata);
			is_AjaxResult($result);
		}else{
			$id = Gets('id','checkid');
			$items = $this->Orderlists_model->getItems("oid=$id and uid=$uid");
			if(!$items)showmessage('页面错误','error');
			$data['items'] = $items;
			$this->load->view("mobile/order/comment",$data);
		}
	}
	
	
	
}
