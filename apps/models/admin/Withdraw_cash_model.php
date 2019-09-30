<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 用户提现表
 * @author chaituan@126.com
 */
class Withdraw_cash_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'withdraw_cash';
	}
}