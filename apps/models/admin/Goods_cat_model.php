<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 商品分类
 *
 * @author chaituan@126.com
 */
class Goods_cat_model extends MY_Model {
	function __construct() {
		parent::__construct ();
		$this->table_name = 'goods_cat';
	}
	function get_cat($html = true) {
		$items = $this->getItems ( '', '', 'sort' );
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
			$name = 'goodscatTreeHtml';
		} else {
			$name = 'goodscatTree';
		}
		$items = get_Cache ( $name );
		if ($items) {
			return $items;
		} else {
			// 如果没有缓存则存储树形缓存
			$items = $this->getItems ( '', '', 'sort' );
			if (! $items)
				return '';
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
	function set_catcachetree() {
		$items = $this->getItems ( '', '', 'sort' );
		if (! $items)
			return '';
		$this->load->library ( 'Tree' );
		$data = $this->tree->makeTreeForHtml ( $items );
		set_Cache ( 'goodscatTreeHtml', $data );
		$data = $this->tree->makeTree ( $items );
		set_Cache ( 'goodscatTree', $data );
	}
	
	// 缓存分类
	function cache() {
		$item = $this->getItems ( '', '', 'sort' );
		foreach ( $item as $v ) {
			$items [$v ['id']] = $v;
		}
		set_Cache ( 'goodscat', $items );
		$this->set_catcachetree ();
	}
}