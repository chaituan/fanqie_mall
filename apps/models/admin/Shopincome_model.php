<?php
/**
 * 店铺收益
 * @author  chaituan@126.com
 */
class Shopincome_model extends MY_Model {
	public function __construct() {
		parent::__construct ();
		$this->table_name = 'shop_income';
	}
} 