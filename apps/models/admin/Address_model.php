<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 地址管理
 *
 * @author chaituan@126.com
 */
class Address_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'address';
	}
}