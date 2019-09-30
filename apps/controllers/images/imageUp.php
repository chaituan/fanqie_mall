<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * 百度编辑器上传图片
 */
class ImageUp extends CI_Controller {
	function index() {
		header ( "Content-Type:text/html;charset=utf-8" );
		error_reporting ( E_ERROR | E_WARNING );
		date_default_timezone_set ( "Asia/chongqing" );
		// 上传配置
		$config = array (
				"savePath" => "res/upload/baiduedit/", // 存储文件夹
				"maxSize" => 2000, // 允许的文件最大尺寸，单位KB
				"allowFiles" => array (
						".gif",
						".png",
						".jpg",
						".jpeg",
						".bmp" 
				)  //允许的文件格式
		);
		//上传文件目录
		$Path = "res/upload/baiduedit/";
		//背景保存在临时目录中
		$config["savePath"] = $Path;
		$this->load->library ( 'Uploader', array (
				'fileField' => 'upfile',
				'config' => $config,
				'base64' => false 
		) );
		$type = $_REQUEST ['type'];
		$callback = $_GET ['callback'];
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
		}
		/**
		 * 返回数据
		 */
		if ($callback) {
			echo '<script>' . $callback . '(' . json_encode ( $info ) . ')</script>';
		} else {
			echo json_encode ( $info );
		}
		exit ();
	}
	function ueditor() {
		header ( "Content-Type:text/html;charset=utf-8" );
		error_reporting ( E_ERROR | E_WARNING );
		date_default_timezone_set ( "Asia/chongqing" );
		//上传配置
		$config = array (
				"savePath" => "res/upload/baiduedit/", //存储文件夹
				"maxSize" => 2000, //允许的文件最大尺寸，单位KB
				"allowFiles" => array (
						".gif",
						".png",
						".jpg",
						".jpeg",
						".bmp" 
				)  //允许的文件格式
		);
		//上传文件目录
		$Path = "res/upload/baiduedit/";
		//背景保存在临时目录中
		$config["savePath"] = $Path;
		$this->load->library ( 'Uploader', array (
				'fileField' => 'upfile',
				'config' => $config,
				'base64' => false 
		) );
		$type = $_REQUEST ['type'];
		$callback = $_GET ['callback'];
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
		}
		/**
		 * 返回数据
		 */
		if ($callback) {
			echo '<script>' . $callback . '(' . json_encode ( $info ) . ')</script>';
		} else {
			echo json_encode ( $info );
		}
		exit ();
	}
}
	
	
