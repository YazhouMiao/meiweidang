<?php
/*
 * myzhou 2015/2/7
 * 二维码的生成
 */

class QrcodeImage {
	
	/*
	 * 参数说明
	 * @param $text 二维码信息内容
	 * @param $logo 二位码中间的logo图片文件
	 * @param $outfile 二维码文件
	 * @param $setting 生成二维码的参数数组(包括level,size,margin)
	 * 
	 */
	public function __construct() {
		//初始化参数信息
		// TODO:待完善
	}
	
	/*
	 * 生成二维码（如果$logo存在则生成带有logo图标的二维码）
	 * 参数说明：
	 * @param $text 二维码信息内容
	 * @param $filename 二维码文件名称(不带任何路径)
	 * @param $setting 生成二维码的参数数组(包括level,size,margin)
	 * @param $logo 二位码中间的logo图片文件
	 * 
	 */
	public function generate($text, $filename, $setting = array(), $logo){
		
		//引入phpqrcode.php
		include_once(dirname(__FILE__).'/qrlib/phpqrcode.php');
		
		// 二维码图片都放到临时qrcode目录中 TODO:待改善
		$qr_image = 'cache/catalog/qrcode/' . $filename;
		
		//生成原始二维码图片
		QRcode::png($text, DIR_IMAGE . $qr_image, $setting['level'], $setting['size'], $setting['margin']);
		
		$QR = imagecreatefromstring(file_get_contents(DIR_IMAGE . $qr_image));

		//将logo图片插入到原始二维码
		if (is_file(DIR_IMAGE . $logo)) {
			$logo_image = imagecreatefromstring(file_get_contents(DIR_IMAGE . $logo));
			$QR_width = imagesx($QR);//二维码图片宽度
			$QR_height = imagesy($QR);//二维码图片高度
			$logo_width = imagesx($logo_image);//logo图片宽度
			$logo_height = imagesy($logo_image);//logo图片高度
			$logo_qr_width = $QR_width / 5;
			$scale = $logo_width/$logo_qr_width;
			$logo_qr_height = $logo_height/$scale;
			$from_width = ($QR_width - $logo_qr_width) / 2;
			//重新组合图片并调整大小
			imagecopyresampled($QR, $logo_image, $from_width, $from_width, 0, 0, $logo_qr_width,$logo_qr_height, $logo_width, $logo_height);
		}
		
		//输出图片到文件
		imagepng($QR, DIR_IMAGE . $qr_image); 
		
		return $qr_image;
	}
}