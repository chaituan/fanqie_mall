<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Welcome extends CI_Controller {
	public function index() {
		$this->load->view('welcome_message');
	}
}
