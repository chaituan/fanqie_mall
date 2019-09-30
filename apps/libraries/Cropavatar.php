<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 头像裁剪
 * @author chaituan@126.com
 *
 */
class Cropavatar {
	private $src;
	private $data;
	private $dst;
	private $type;
	private $extension;
	private $msg;
	private $path;
	private $maxsize;
	function __construct($params) {
		$this->maxsize = 1048576 * 2;
		$this->path = 'res/upload/images/' . date ( 'Ymd' ) . '/';
		if ($this->makeDir ()) {
			$src = $params ['src'];
			$data = $params ['data'];
			$file = $params ['file'];
			$this->setSrc ( $src );
			$this->setData ( $data );
			$this->setFile ( $file );
			$this->crop ( $this->src, $this->dst, $this->data );
		}
	}
	private function setSrc($src) {
		if (! empty ( $src )) {
			$type = exif_imagetype ( $src );
			if ($type) {
				$this->src = $src;
				$this->type = $type;
				$this->extension = image_type_to_extension ( $type );
				$this->setDst ();
			}
		}
	}
	private function setData($data) {
		if (! empty ( $data )) {
			$this->data = json_decode ( stripslashes ( $data ) );
		}
	}
	private function setFile($file) {
		$errorCode = $file ['error'];
		
		if ($errorCode === UPLOAD_ERR_OK) {
			if ($this->maxsize < $file ['size']) {
				$this->msg = "上传的图片不能大于1M";
				return false;
			}
			$types = getimagesize ( $file ['tmp_name'] );
			$type = $types [2];
			if ($type) {
				$extension = image_type_to_extension ( $type );
				$src = $this->path . date ( 'YmdHis' ) . '.original' . $extension;
				if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {
					if (file_exists ( $src )) {
						unlink ( $src );
					}
					// $result = move_uploaded_file($file['tmp_name'], $src);
					// if ($result) {
					$this->src = $file ['tmp_name'];
					$this->type = $type;
					$this->extension = $extension;
					$this->setDst ();
					// } else {
					// $this -> msg = 'Failed to save file';
					// }
				} else {
					$this->msg = '本程序支持的图片格式: JPG, PNG, GIF';
				}
			} else {
				$this->msg = '请上传图片文件';
			}
		} else {
			$this->msg = $this->codeToMessage ( $errorCode );
		}
	}
	private function setDst() {
		$this->dst = $this->path . date ( 'YmdHis' ) . '.png';
	}
	private function makeDir() {
		if (! file_exists ( $this->path )) {
			$files = preg_split ( '/[\/|\\\]/s', $this->path );
			$_dir = '';
			foreach ( $files as $value ) {
				$_dir .= $value . DIRECTORY_SEPARATOR;
				if (! file_exists ( $_dir )) {
					if (mkdir ( $_dir )) {
						chmod ( $_dir, 0777 );
						return true;
					} else {
						$this->msg = "创建文件夹错误";
						return false;
					}
				} else {
					chmod ( $_dir, 0777 );
				}
			}
		} else {
			return true;
		}
	}
	private function crop($src, $dst, $data) {
		if (! empty ( $src ) && ! empty ( $dst ) && ! empty ( $data )) {
			switch ($this->type) {
				case IMAGETYPE_GIF :
					$src_img = imagecreatefromgif ( $src );
					break;
				
				case IMAGETYPE_JPEG :
					$src_img = imagecreatefromjpeg ( $src );
					break;
				
				case IMAGETYPE_PNG :
					$src_img = imagecreatefrompng ( $src );
					break;
			}
			
			if (! $src_img) {
				$this->msg = "Failed to read the image file";
				return;
			}
			
			$size = getimagesize ( $src );
			$size_w = $size [0]; // natural width
			$size_h = $size [1]; // natural height
			
			$src_img_w = $size_w;
			$src_img_h = $size_h;
			
			$degrees = $data->rotate;
			
			// Rotate the source image
			if (is_numeric ( $degrees ) && $degrees != 0) {
				// PHP's degrees is opposite to CSS's degrees
				$new_img = imagerotate ( $src_img, - $degrees, imagecolorallocatealpha ( $src_img, 0, 0, 0, 127 ) );
				
				imagedestroy ( $src_img );
				$src_img = $new_img;
				
				$deg = abs ( $degrees ) % 180;
				$arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;
				
				$src_img_w = $size_w * cos ( $arc ) + $size_h * sin ( $arc );
				$src_img_h = $size_w * sin ( $arc ) + $size_h * cos ( $arc );
				
				// Fix rotated image miss 1px issue when degrees < 0
				$src_img_w -= 1;
				$src_img_h -= 1;
			}
			
			$tmp_img_w = $data->width;
			$tmp_img_h = $data->height;
			
			if ($tmp_img_w > 800) {
				$b = 500 / $tmp_img_w;
				$dst_img_w = $tmp_img_w * $b;
				$dst_img_h = $tmp_img_h * $b;
			} else {
				$dst_img_w = $tmp_img_w;
				$dst_img_h = $tmp_img_h;
			}
			
			$src_x = $data->x;
			$src_y = $data->y;
			
			if ($src_x <= - $tmp_img_w || $src_x > $src_img_w) {
				$src_x = $src_w = $dst_x = $dst_w = 0;
			} else if ($src_x <= 0) {
				$dst_x = - $src_x;
				$src_x = 0;
				$src_w = $dst_w = min ( $src_img_w, $tmp_img_w + $src_x );
			} else if ($src_x <= $src_img_w) {
				$dst_x = 0;
				$src_w = $dst_w = min ( $tmp_img_w, $src_img_w - $src_x );
			}
			
			if ($src_w <= 0 || $src_y <= - $tmp_img_h || $src_y > $src_img_h) {
				$src_y = $src_h = $dst_y = $dst_h = 0;
			} else if ($src_y <= 0) {
				$dst_y = - $src_y;
				$src_y = 0;
				$src_h = $dst_h = min ( $src_img_h, $tmp_img_h + $src_y );
			} else if ($src_y <= $src_img_h) {
				$dst_y = 0;
				$src_h = $dst_h = min ( $tmp_img_h, $src_img_h - $src_y );
			}
			// Scale to destination position and size
			$ratio = $tmp_img_w / $dst_img_w;
			$dst_x /= $ratio;
			$dst_y /= $ratio;
			$dst_w /= $ratio;
			$dst_h /= $ratio;
			
			$dst_img = imagecreatetruecolor ( $dst_img_w, $dst_img_h );
			// Add transparent background to destination image
			imagefill ( $dst_img, 0, 0, imagecolorallocatealpha ( $dst_img, 0, 0, 0, 127 ) );
			imagesavealpha ( $dst_img, true );
			
			$result = imagecopyresampled ( $dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h );
			
			if ($result) {
				if (! imagepng ( $dst_img, $dst )) {
					$this->msg = "Failed to save the cropped image file";
				}
			} else {
				$this->msg = "Failed to crop the image file";
			}
			unlink ( $this->src );
			imagedestroy ( $src_img );
			imagedestroy ( $dst_img );
		}
	}
	private function codeToMessage($code) {
		$errors = array (
				UPLOAD_ERR_INI_SIZE => '上传的文件尺寸过大 php.ini',
				UPLOAD_ERR_FORM_SIZE => '上传的文件尺寸过大',
				UPLOAD_ERR_PARTIAL => '只上传了部分文件',
				UPLOAD_ERR_NO_FILE => '没有上传文件',
				UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
				UPLOAD_ERR_CANT_WRITE => '写入出错',
				UPLOAD_ERR_EXTENSION => '拓展出错' 
		);
		if (array_key_exists ( $code, $errors )) {
			return $errors [$code];
		}
		return 'Unknown upload error';
	}
	public function getResult() {
		return $this->dst ? $this->dst : '';
	}
	public function getMsg() {
		return $this->msg;
	}
}

