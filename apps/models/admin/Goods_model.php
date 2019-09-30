<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 商品
 *
 * @author chaituan@126.com
 */
class Goods_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'goods';
	}
}