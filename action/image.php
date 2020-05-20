<?php

require dirname(__FILE__).'/../../../../wp-load.php';

$file = $_FILES['images'];

if ( !function_exists('file_type') ) {
	function file_type( $file_name ) {
		$file = fopen( $file_name, 'rb' );
		$bin = fread( $file, 2 );
		fclose( $file );
		$str_info = @unpack( 'C2chars', $bin );
		$format_code = intval( $str_info['chars1'] . $str_info['chars2'] );
		$file_format = '';
		switch ( $format_code ) {
			case 255216:
				$file_format = 'jpg';
				break;
			case 13780:
				$file_format = 'png';
				break;
			case 7173:
				$file_format = 'gif';
				break;
			default:
				$file_format = 'unknown: ' . $format_code;
		}
		if ($str_info['chars1'] == '-1' && $str_info['chars2'] == '-40') {
			return 'jpg';
		}
		if ($str_info['chars1'] == '-119' && $str_info['chars2'] == '80') {
			return 'png';
		}
		return $file_format;
	}
}

if ( !empty( $file ) ) {
	if (!function_exists('wp_handle_upload')) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	$file_format = file_type($_FILES['images']['tmp_name']);
	if ( $file_format == 'jpg' || $file_format == 'png' || $file_format == 'gif' ) {
		$file['name'] = '' . time() . '.' . $file_format;
		$uploaded_file = array('test_form' => !1);
		$action = wp_handle_upload( $file, $uploaded_file );
		if ( $action && !isset($action['error']) ) {
			$data = array( 'data'=>array(
				'status'    => 1,
				'src'       => $action['url'],
				'file_type' => $file_format,
				'tips'      => '上传成功'
			) );
		} else {
			$data = array( 'data'=>array(
				'status'    => 0,
				'tips'      => '上传失败，请稍后在试！'
			) );
		}
	} else {
		$data = array( 'data'=>array(
			'status'    => 0,
			'tips'      => '上传失败，请上传 .jpg .png .gif 类型的图片文件'
		) );
	}
	print_r(json_encode($data));
};

?>