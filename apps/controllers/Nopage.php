<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 404页面
 *
 * @author chaituan@126.com
 */
class Nopage extends CI_Controller {
	public function index() {
		$this->load->view ( '404' );
	}
}
