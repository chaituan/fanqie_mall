<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * 订单管理
 * @author chaituan@126.com
 */
class Order_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'order';
	}
}