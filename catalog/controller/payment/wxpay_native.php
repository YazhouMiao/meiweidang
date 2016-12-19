<?php
/**
 * 作者: myzhou
 * 时间: 2015-7-11
 * 描述: 微信扫码支付接口(模式二)实现 Controller
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */

ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once "lib/WxPay.NativePay.php";

class ControllerPaymentWxpayNative extends Controller {
	public function index() {
		$this->load->language('payment/wxpay_native');
		
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['continue'] = $this->url->link('checkout/success');
		
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_title'] = $this->language->get('text_title');
		$data['text_tip'] = $this->language->get('text_tip');
		$data['text_error_info'] = $this->language->get('text_error_info');
		
		$this->load->model('checkout/order');
		
		$order_id = $this->session->data['order_id'];
		
		$order_info = $this->model_checkout_order->getOrder($order_id);
		
		$params = array();
		// TODO:完善参数设置
		// 商品描述
		$params['body'] = $this->config->get('config_name').'订单：'.$order_id;
		// 附加数据
		$params['attach'] = '请在一个小时内完成支付!';
		// 订单号
		$params['out_trade_no'] = $order_id;
		// 总金额(整数/分)
		$params['total_fee'] = number_format($order_info['total'], 2, '.', '') * 100;
		// 商品标记
		$params['goods_tag'] = 'NORMAL';
		// 通知地址
		$params['notify_url'] = HTTP_SERVER . 'catalog/controller/payment/wxpay_notify_index.php';;
		// 商品ID
		$params['product_id'] = $order_id;
		
		// 取得二维码内容
		$url = $this->getNativePayUrl($params);
		
		// 生成二维码
		$filename = date('Ymd') . '_' . $order_id . '.png';
		$setting['size'] = $this->config->get('wxpay_native_qrcode_size');
		$setting['margin'] = $this->config->get('wxpay_native_qrcode_margin');
		$setting['level'] = $this->config->get('wxpay_native_qrcode_level');
		if($this->config->get('wxpay_native_qrcode_logo') != 'no_image.png'){
			$logo = $this->config->get('wxpay_native_qrcode_logo');
		} else {
			$logo = '';
		}
		
		$qrimage = new QrcodeImage();
		if (isset($this->request->server['HTTPS'])) {
			$server = $this->config->get('config_ssl') . 'image/';
		} else {
			$server = $this->config->get('config_url') . 'image/';
		}
		$data['qr_image'] = $server . $qrimage->generate($url, $filename, $setting, $logo);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/wxpay_native.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/wxpay_native.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/wxpay_native.tpl', $data);
		}
	}
	
	/*
	 * 调用微信扫码支付接口取得要生成的二维码内容(URL)
	 * @param $params 参数数组
	 */
	protected function getNativePayUrl($params = array()) {
		// wxpay start
		$notify = new NativePay();
		
		$input = new WxPayUnifiedOrder();
		
		// 商品描述
		$input->SetBody($params['body']);
		// 附加数据
		$input->SetAttach($params['attach']);
		// 订单号
		$input->SetOut_trade_no($params['out_trade_no']);
		// 总金额(整数/分)
		$input->SetTotal_fee($params['total_fee']);
		// 交易起始时间
		$input->SetTime_start(date("YmdHis"));
		// 交易结束时间 (1小时)
		$input->SetTime_expire(date("YmdHis", time() + 3600));
		// 商品标记
		$input->SetGoods_tag($params['goods_tag']);
		// 通知地址
		$input->SetNotify_url($params['notify_url']);
		// 交易类型
		$input->SetTrade_type("NATIVE");
		// 商品ID
		$input->SetProduct_id($params['product_id']);
		// 执行扫码支付接口
		$result = $notify->GetPayUrl($input);
		// 扫码支付二维码内容(URL)
		$url = $result["code_url"];
		
		return $url;
	}
	
	/*
	 * 验证是否已经完成支付
	 */
	public function confirm(){
		$this->load->model('checkout/order');
		
		$order_id = $this->session->data['order_id'];
		
		$order_info = $this->model_checkout_order->getOrder($order_id);
		
		// 验证订单状态,判断是否已经完成支付
		if ($order_info['order_status_id'] == $this->config->get('wxpay_native_order_status_id')) {
			$json['return_code'] = 'SUCCESS'; 
		} else {
			$json['return_code'] = 'FAIL';
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
