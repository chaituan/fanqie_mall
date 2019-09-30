<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * 订单子列表（为了多订单合并）
 * @author chaituan@126.com
 */
class Orderlists_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'order_lists';
	}
}