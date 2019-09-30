<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 文章分类
 *
 * @author chaituan@126.com
 */
class NewsCat_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'newscat';
	}
	function get_cat($html = true) {
		$items = $this->getItems ( '', '', 'id desc' );
		$this->load->library ( 'Tree' );
		if (! $items)
			return '';
		if ($html) {
			$data = $this->tree->makeTreeForHtml ( $items );
		} else {
			$data = $this->tree->makeTree ( $items );
		}
		return $data;
	}
	
	// 带有树形列表的缓存分类
	function get_catcachetree($html = true) {
		if ($html) {
			$name = 'newscatTreeHtml';
		} else {
			$name = 'newscatTree';
		}
		$items = get_Cache ( $name );
		if ($items) {
			return $items;
		} else {
			// 如果没有缓存则存储树形缓存
			$items = $this->getItems ( '', '', 'id desc' );
			$this->load->library ( 'Tree' );
			if ($html) {
				$data = $this->tree->makeTreeForHtml ( $items );
			} else {
				$data = $this->tree->makeTree ( $items );
			}
			set_Cache ( $name, $data );
			return $data;
		}
	}
	
	// 缓存分类
	function cache() {
		$item = $this->getItems ( '', '', 'id desc' );
		foreach ( $item as $v ) {
			$items [$v ['id']] = $v;
		}
		set_Cache('newscat',$items);
		//另外保存2个树形缓存
		$this->load->library ('Tree');
		set_Cache ('newscatTreeHtml',$this->tree->makeTreeForHtml($item));
		set_Cache ('newscatTree',$this->tree->makeTree($item));
		
	}
}