<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 用户收益明细表---备用表  因为主表用了
 * @author chaituan@126.com
 */
class Earnings_details_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'earnings_details';
	}
}