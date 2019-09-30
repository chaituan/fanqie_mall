<?php
/**
 * 管理员角色数据模型
 * @author  chaituan@126.com
 */
class AdminRole_model extends MY_Model {
	public function __construct() {
		parent::__construct ();
		$this->table_name = 'admin_role';
	}
} 