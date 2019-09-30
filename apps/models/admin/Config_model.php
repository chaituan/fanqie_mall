<?php
/**
 * 系统配置
 * @author  chaituan@126.com
 */
class Config_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->table_name = 'config';
    }
    
    public function cache(){
    	$data = $this->getItems('','','tkey,id');
    	set_Cache('admin_config', $data);
    }
} 