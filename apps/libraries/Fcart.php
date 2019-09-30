<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 购物车类
 * @author		chaituan@126.com
 */
class Fcart {
	//物品id及名称规则,调试信息控制
	private $product_id_rule = '\.a-z0-9-_';    //小写字母 | 数字 | ._-
	private $product_name_rule = '\.\:a-z0-9-_';//小写字母 | 数字 | ._-:
	private $debug = TRUE;
	 
	//购物车
	private $_cart_contents = array();
	/**
	 * 构造函数
	 *
	 * @param array
	*/
	public function __construct() {
		//是否第一次使用?
		if(isset($_SESSION['cart_contents'])) {
			$this->_cart_contents = $_SESSION['cart_contents'];
		} else {
			$this->_cart_contents['cart_total'] = 0;
			$this->_cart_contents['total_items'] = 0;
		}
		 
		if($this->debug === TRUE) {
			//$this->_log("cart_create_success");
		}
	}
	 
	/**
	 * 将物品加入购物车
	 *
	 * @access  public
	 * @param   array   一维或多维数组,必须包含键值名:
	 id -> 物品ID标识,
	 qty -> 数量(quantity),
	 price -> 单价(price),
	 name -> 物品姓名
	 * @return  bool
	 */
	public function insert($items = array()) {
		//输入物品参数异常
		if( ! is_array($items) OR count($items) == 0) {
			if($this->debug === TRUE) {
				$this->_log("cart_no_items_insert");
			}
			return FALSE;
		}
		 
		//物品参数处理
		$save_cart = FALSE;
		if(isset($items['id'])) {
			if($this->_insert($items) === TRUE) {
				$save_cart = TRUE;
			}
		} else {
			foreach($items as $val) {
				if(is_array($val) AND isset($val['id'])) {
					if($this->_insert($val) == TRUE) {
						$save_cart = TRUE;
					}
				}
			}
		}
		 
		//当插入成功后保存数据到session
		if($save_cart) {
			$this->_save_cart();
			return TRUE;
		}
		 
		return FALSE;
	}
	 
	/**
	 * 更新购物车物品信息
	 *
	 * @access  public
	 * @param   array
	 * @return  bool
	 */
	public function update($items = array()) {
		//输入物品参数异常
		if( !is_array($items) OR count($items) == 0) {
			if($this->debug === TRUE) {
				$this->_log("cart_no_items_insert");
			}
			return FALSE;
		}
		 
		//物品参数处理
		$save_cart = FALSE;
		if(isset($items['rowid']) AND isset($items['qty'])) {
			if($this->_update($items) === TRUE) {
				$save_cart = TRUE;
			}
		} else {
			foreach($items as $val) {
				if(is_array($val) AND isset($val['rowid']) AND isset($val['qty'])) {
					if($this->_update($val) === TRUE) {
						$save_cart = TRUE;
					}
				}
			}
		}
		 
		//当更新成功后保存数据到session
		if($save_cart) {
			$this->_save_cart();
			return TRUE;
		}
		 
		return FALSE;
	}
	 
	/**
	 * 获取购物车物品总金额
	 *
	 * @return  int
	 */
	public function total() {
		return $this->_cart_contents['cart_total'];
	}
	 
	/**
	 * 获取购物车物品种类
	 *
	 * @return  int
	 */
	public function total_items() {
		return $this->_cart_contents['total_items'];
	}
	
	/**
	 * Remove Item
	 *
	 * Removes an item from the cart
	 *
	 * @param	int
	 * @return	bool
	 */
	public function remove($id){
		if(!isset($this->_cart_contents[$id]))return false;
		unset($this->_cart_contents[$id]);
		$this->_save_cart();
		return TRUE;
	}
	/**
	 * 获取购物车
	 *
	 * @return  array
	 */
	public function contents() {
		return $this->_cart_contents;
	}
	 
	/**
	 * 获取购物车物品options
	 *
	 * @param   string
	 * @return  array
	 */
	public function options($rowid = '') {
		if($this->has_options($rowid)) {
			return $this->_cart_contents[$rowid]['options'];
		} else {
			return array();
		}
	}
	 
	/**
	 * 清空购物车
	 *
	 */
	public function destroy() {
		unset($this->_cart_contents);
		 
		$this->_cart_contents['cart_total'] = 0;
		$this->_cart_contents['total_items'] = 0;
		 
		unset($_SESSION['cart_contents']);
	}
	 
	/**
	 * 判断购物车物品是否有options选项
	 *
	 * @param   string
	 * @return  bool
	 */
	private function has_options($rowid = '') {
		if( ! isset($this->_cart_contents[$rowid]['options']) OR count($this->_cart_contents[$rowid]['options']) === 0) {
			return FALSE;
		}
		 
		return TRUE;
	}
	 
	/**
	 * 插入数据
	 *
	 * @access  private
	 * @param   array
	 * @return  bool
	 */
	private function _insert($items = array()) {
		//输入物品参数异常
		if( ! is_array($items) OR count($items) == 0) {
			if($this->debug === TRUE) {
				$this->_log("cart_no_data_insert");
			}
			return FALSE;
		}
		 
		//如果物品参数无效（无id/qty/price/name）
		if( ! isset($items['id']) OR ! isset($items['qty']) OR ! isset($items['price']) OR ! isset($items['name'])) {
			if($this->debug === TRUE) {
				$this->_log("cart_items_data_invalid");
			}
			return FALSE;
		}
		 
		//去除物品数量左零及非数字字符
		$items['qty'] = trim(preg_replace('/([^0-9])/i', '', $items['qty']));
		$items['qty'] = trim(preg_replace('/^([0]+)/i', '', $items['qty']));
		 
		//如果物品数量为0，或非数字，则我们对购物车不做任何处理!
		if( ! is_numeric($items['qty']) OR $items['qty'] == 0) {
			if($this->debug === TRUE) {
				$this->_log("cart_items_data(qty)_invalid");
			}
			return FALSE;
		}
		
		//物品ID正则判断
		if( ! preg_match('/^['.$this->product_id_rule.']+$/i', $items['id'])) {
			if($this->debug === TRUE) {
				$this->_log("cart_items_data(id)_invalid");
			}
			return FALSE;
		}
		 
		//物品名称正则判断
		if(!$items['name']) {
			if($this->debug === TRUE) {
				$this->_log("cart_items_data(name)_invalid");
			}
			return FALSE;
		}
		 
		//去除物品单价左零及非数字（带小数点）字符
		$items['price'] = trim(preg_replace('/([^0-9\.])/i', '', $items['price']));
		$items['price'] = trim(preg_replace('/^([0]+)/i', '', $items['price']));
		 
		//如果物品单价非数字
		if( ! is_numeric($items['price'])) {
			if($this->debug === TRUE) {
				$this->_log("cart_items_data(price)_invalid");
			}
			return FALSE;
		}
		 
		//生成物品的唯一id
		if(isset($items['options']) AND count($items['options']) >0) {
			$rowid = md5($items['id'].implode('', $items['options']));
		} else {
			$rowid = md5($items['id']);
		}
		
		//加入物品到购物车
		unset($this->_cart_contents[$rowid]);
		$this->_cart_contents[$rowid]['rowid'] = $rowid;
		foreach($items as $key => $val) {
			$this->_cart_contents[$rowid][$key] = $val;
		}
		return TRUE;
	}
	 
	/**
	 * 更新购物车物品信息（私有）
	 *
	 * @access  private
	 * @param   array
	 * @return  bool
	 */
	private function _update($items = array()) {
		//输入物品参数异常
		if( ! isset($items['rowid']) OR ! isset($items['qty']) OR ! isset($this->_cart_contents[$items['rowid']])) {
			if($this->debug == TRUE) {
				$this->_log("cart_items_data_invalid");
			}
			return FALSE;
		}
		 
		//去除物品数量左零及非数字字符
		$items['qty'] = preg_replace('/([^0-9])/i', '', $items['qty']);
		$items['qty'] = preg_replace('/^([0]+)/i', '', $items['qty']);
		 
		//如果物品数量非数字，对购物车不做任何处理!
		if( ! is_numeric($items['qty'])) {
			if($this->debug === TRUE) {
				$this->_log("cart_items_data(qty)_invalid");
			}
			return FALSE;
		}
		 
		//如果购物车物品数量与需要更新的物品数量一致，则不需要更新
		if($this->_cart_contents[$items['rowid']]['qty'] == $items['qty']) {
			if($this->debug === TRUE) {
				$this->_log("cart_items_data(qty)_equal");
			}
			return FALSE;
		}
		 
		//如果需要更新的物品数量等于0，表示不需要这件物品，从购物车种清除
		//否则修改购物车物品数量等于输入的物品数量
		if($items['qty'] == 0) {
			unset($this->_cart_contents[$items['rowid']]);
		} else {
			$this->_cart_contents[$items['rowid']]['qty'] = $items['qty'];
		}
		 
		return TRUE;
	}
	 
	/**
	 * 保存购物车数据到session
	 *
	 * @access  private
	 * @return  bool
	 */
	private function _save_cart() {
		//首先清除购物车总物品种类及总金额
		unset($this->_cart_contents['total_items']);
		unset($this->_cart_contents['cart_total']);
		 
		//然后遍历数组统计物品种类及总金额
		$total = 0;
		foreach($this->_cart_contents as $key => $val) {
			if( ! is_array($val) OR ! isset($val['price']) OR ! isset($val['qty'])) {
				continue;
			}
			 
			$total += ($val['price'] * $val['qty']);
			 
			//每种物品的总金额
			$this->_cart_contents[$key]['subtotal'] = ($val['price'] * $val['qty']);
		}
		 
		//设置购物车总物品种类及总金额
		$this->_cart_contents['total_items'] = count($this->_cart_contents);
		$this->_cart_contents['cart_total'] = $total;
		 
		//如果购物车的元素个数少于等于2，说明购物车为空
		if(count($this->_cart_contents) <= 2) {
			unset($_SESSION['cart_contents']);
			return FALSE;
		}
		 
		//保存购物车数据到session
		$_SESSION['cart_contents'] = $this->_cart_contents;
		return TRUE;
	}
	 
	/**
	 * 日志记录
	 *
	 * @access  private
	 * @param   string
	 * @return  bool
	 */
	private function _log($msg) {
		return @file_put_contents('cart_err.log', $msg, FILE_APPEND);
	}
}
