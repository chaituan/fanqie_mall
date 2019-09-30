<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 裁剪
 *
 * @author chaituan@126.com
 *        
 */
class Crop extends AdminCommon {
	function index() {
		if (Posts ( 'avatar_data' )) {
			$data = array (
					'src' => Posts ( 'avatar_src' ),
					'data' => Posts ( 'avatar_data' ),
					'file' => $_FILES ['avatar_file'] 
			);
			$this->load->library ( 'cropavatar', $data );
			$response = array (
					'state' => 200,
					'message' => $this->cropavatar->getMsg (),
					'result' => $this->cropavatar->getResult () 
			);
			if (! $this->cropavatar->getMsg ()) {
				$result = $this->save_db ( $this->cropavatar->getResult () );
				if (! $result) {
					$response = array (
							'state' => 200,
							'message' => 'save database error',
							'result' => '' 
					);
				}
			}
			echo json_encode ( $response );
		}
		exit ();
	}
	private function save_db($file) {
		$this->load->model ( 'Image_model' );
		$size = round ( filesize ( $file ) / 1024, 2 );
		$result = $this->Image_model->add ( array (
				'userid' => 0,
				'thumb' => '/' . $file,
				'filesize' => $size,
				'type' => '.jpg',
				'addtime' => time () 
		) );
		return $result;
	}
}