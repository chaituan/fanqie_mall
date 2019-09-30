<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 * 评价
 * @author chaituan@126.com
 */
class Comment_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'comment';
	}
}