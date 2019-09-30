<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 前台菜单
 *
 * @author chaituan@126.com
 *        
 */
class Qmenu_model extends MY_Model {
	public function __construct() {
		parent::__construct ();
		$this->table_name = 'qmenu';
	}
}