<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 用户管理
 *
 * @author chaituan@126.com
 */
class UserGroup_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'user_group';
	}
	
	function cache(){
		$items = $this->getItems();
		set_Cache("UserGroupCache", $items);
	}
}