<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 文章评价
 *
 * @author chaituan@126.com
 */
class News_comment_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'news_comment';
	}
}