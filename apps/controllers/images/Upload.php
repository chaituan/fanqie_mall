<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 普通图片上传
 *
 * @author chaituan@126.com
 */
class Upload extends CI_Controller {
	function index() {
		header ( "Content-Type:text/html;charset=utf-8" );
		error_reporting ( E_ERROR | E_WARNING );
		date_default_timezone_set ( "Asia/chongqing" );
		// 上传配置
		$config = array (
				"savePath" => "res/upload/images/", // 存储文件夹
				"maxSize" => 2000, // 允许的文件最大尺寸，单位KB
				"allowFiles" => array (
						".gif",
						".png",
						".jpg",
						".jpeg" 
				)  //允许的文件格式
		);
		//上传文件目录
		$Path = "res/upload/baiduedit/";
		//背景保存在临时目录中
		$config["savePath"] = $Path;
		$this->load->library ( 'Uploader', array (
				'fileField' => array_keys ( $_FILES )[0],
				'config' => $config,
				'base64' => false 
		) );
		$info = $this->uploader->getFileInfo ();
		if ($info ['state'] == 'SUCCESS') {
			$this->load->model ( 'Image_model' );
			$this->Image_model->add ( array (
					'userid' => 0,
					'thumb' => '/' . $info ['url'],
					'filesize' => $info ['size'],
					'type' => $info ['type'],
					'addtime' => time () 
			) );
			AjaxResult ( 1, 'ok', $info );
		} else {
			exit ( json_encode ( array (
					'error' => '上传失败' 
			) ) );
		}
	}
	function del() {
		$thumb = Posts ( 'key' );
		$thumb = substr ( $thumb, 1 );
		if (is_file ( $thumb )) {
			if (unlink ( $thumb )) {
				$this->load->model('Image_model');
				$r = $this->Image_model->deletes(array('thumb' => $thumb));
				is_AjaxResult($r);
			} else {
				exit(json_encode(array('error' =>'删除失败')));
			}
		} else {
			exit(json_encode(array('error'=>'操作失败,文件路径出问题')));
		}
	}
}
	
	
