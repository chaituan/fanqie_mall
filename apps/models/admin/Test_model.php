<?php
/**
 * 测试表
 * @author  chaituan@126.com
 */
class Test_model extends MY_Model {
	public function __construct() {
		parent::__construct ();
		$this->table_name = 'test';
	}
} 