<?php
/**
 * 系统配置
 * @author  chaituan@126.com
 */
class Banner_model extends MY_Model {
	
	public function __construct() {
		parent::__construct ();
		$this->table_name = 'banner';
	}
	
	public function cache(){
		$data = $this->getItems("",'','id desc');
		set_Cache('Banner_cache', $data);
	}
} 