<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 新闻列表
 *
 * @author chaituan@126.com
 */
class News extends AdminCommon {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( array (
				'admin/News_model',
				'admin/NewsCat_model' 
		) );
	}
	public function index() {
		$get = Gets ();
		$con = "";
		if ($get) {
			if (isset ( $get ['cid'] ) && $get ['cid']) { // 分类id
				$con .= 'news.catid=' . $get ['cid'];
				$data ['cid'] = $get ['cid'];
			}
			if (isset ( $get ['name'] ) && $get ['name']) { // 搜索的名字
				$con = $con ? $con . ' and ' : '';
				$con .= "news.title like '%" . $get ['name'] . "%' ESCAPE '!'";
				$data ['name'] = $get ['name'];
			}
		}
		$data ['items'] = $this->News_model->getItems_join ( array (
				'newscat' => "news.catid=newscat.id+left" 
		), $con, 'news.*,newscat.catname', 'news.addtime desc', Gets ( 'per_page', 'checkid' ), PAGESIZE );
		$data ['pagemenu'] = $this->News_model->pagemenu; // 经过模型处理后返回的分页
		$data ['cat'] = $this->NewsCat_model->get_catcachetree ();
		$this->load->view ( 'admin/news/index', $data );
	}
	public function add() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['state'] = Posts ( 'state' );
			$data ['addtime'] = time ();
			is_AjaxResult ( $this->News_model->add ( $data ) );
		} else {
			$data ['cat'] = $this->NewsCat_model->get_catcachetree ();
			$this->load->view ( 'admin/news/add', $data );
		}
	}
	public function edit() {
		if (is_ajax_request ()) {
			$data = Posts ( 'data' );
			$data ['state'] = Posts ( 'state' );
			is_AjaxResult ( $this->News_model->updates ( $data, "id=" . Posts ( 'id', 'checkid' ) ) );
		} else {
			$id = Gets ( "id", "checkid" );
			$data ['cat'] = $this->NewsCat_model->get_cat ();
			$data ['item'] = $this->News_model->getItem ( "id=$id" );
			$this->load->view ( 'admin/news/edit', $data );
		}
	}
	public function delete() {
		is_AjaxResult ( $this->News_model->deletes ( "id=" . Posts ( 'id', 'checkid' ) ) );
	}
	public function deletes() {
		$data = Posts ();
		if (! $data) {
			AjaxResult ( '2', '没有选中要删除的' );
		}
		$ids = implode ( ',', $data ['ids'] );
		if ($this->News_model->deletes ( "id in ($ids)" )) {
			AjaxResult ( 1, "删除成功", $data ['ids'] );
		} else {
			AjaxResult ( 2, "删除失败" );
		}
	}
	private function get_cat() {
		$cat = $this->NewsCat_model->get_cat ();
		if ($cat) {
			foreach ( $cat as $v ) {
				$new [$v ['id']] = $v;
			}
		} else {
			redirect ( site_url ( 'adminct/newscat/index' ) );
		}
		return $new;
	}
}
