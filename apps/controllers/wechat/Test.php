<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 摇一摇进入
 *
 * @author chaituan@126.com
 */
class Test extends CI_Controller {
	public function index() {
		$this->load->model('admin/test_model');
		$stime=microtime(true); 
		for($i=0;$i<10;$i++){
			$this->test_model->add(array('code'=>$this->get_code()));
// 			echo $this->get_code().'<br>';
		}
		$etime=microtime(true);
		$total=$etime-$stime;	
		var_dump($total);
		exit;
	}
	
	function get_code(){
		$yCode= array('A','B','C','D','E','F','G','H','I','J');	
		return $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))). date('d'). substr(time(),-5) . substr(microtime(), 2, 5) . sprintf('%02d',rand(0, 99));
	}
}
