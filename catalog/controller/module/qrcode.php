<?php  
/*
 *二维码生成模块 前台controller
 *myzhou 2015/2/5
 *
*/

class ControllerModuleQrcode  extends Controller {		 

	public function index() {

		$this->language->load('module/qrcode');

		$status  = $this->config->get('qrcode_status');
		$settings = $this->config->get('qrcode_module');
		$setting  = $settings[0];
		
		if($status) {
			
			$this->load->model('catalog/product');
			
			//当前页面URL
			$myUrl = $this->curPageURL() ;
			
			$this->tmp = $this->link(html_entity_decode($myUrl));
			
			if (1 == $this->config->get('config_seo_url')) {
				
				$string = substr(strrchr($myUrl, "/"), 1);
				
				if (!$setting['title']==''){
					$data['heading_title'] = html_entity_decode($string);
				}
				
			}else{
				
// 				$product_info = $this->model_catalog_product->getProduct($_GET["product_id"]);
				
				if (!$setting['title']==''){
					$data['heading_title'] = html_entity_decode($product_info['name']);
				}
			}
			
		}else{
		
			$data['heading_title'] = html_entity_decode($setting['title'] );
			
			$this->tmp = $this->link(html_entity_decode($setting['gen']));
		}

		$data['size']  = $setting['image_size'] ;
		
		$data['qr_code']="<img src='".$this->get_link($text = $setting['gen'],$size = $setting['image_size'] )."' border='0' width='200' height='200'/>";
		
		$data['gen']    = $setting['gen'] ;
    
		$this->id = 'qrcode';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/qrcode.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/qrcode.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/module/qrcode.tpl', $data));
		}
		
	}
	
	protected function link($url){
		if (preg_match('/^http:\/\//', $url) || preg_match('/^https:\/\//', $url)) 
		{
			$this->data2 = $url;
		}
		else
		{
			$this->data2 = "http://".$url;
		}
	}
	
	//getting link for image
	protected function get_link($text,$size, $EC_level = 'H', $margin = '2'){
		//test
		$this->data2 = urlencode($this->data2); 
		$text = 'localhost/ibaiwei';
		$param = array("size"=>200,"level"=>$EC_level,"margin"=>$margin);
		$logo = DIR_IMAGE.$this->config->get('config_icon');
		$file = DIR_IMAGE.'catalog/qrcode/'.date('YmdHis').'.png';
		$qrcode = new QrcodeImage($text,$file,$param,false);
		
		return $qrcode->generate();
	}
	
	//forsing image download
	protected function download_image($file){
		
		header('Content-Description: File Transfer');
		header('Content-Type: image/png');
		header('Content-Disposition: attachment; filename=QRcode.png');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		echo $file;
	}
	
	// current page
	protected function curPageURL() {
		$pageURL = 'http';
		
		if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
		} else {
			$pageURL .= "s";
		}
		
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
	 	return $pageURL;
	}
}
?>