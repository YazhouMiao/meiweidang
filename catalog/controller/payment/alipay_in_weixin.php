<?php
/**
 * 作者: myzhou
 * 时间: 2015-10-14
 * 描述: 微信中使用支付宝-提醒页面-controller
 */
class ControllerPaymentAlipayInWeixin extends Controller {
	public function index() {

		$this->load->language('payment/alipay_in_weixin');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_pay_error'] = $this->language->get('text_pay_error');

		$data['button_success'] = $this->language->get('button_success');
		$data['button_reselect'] = $this->language->get('button_reselect');
		
		$data['continue'] = $this->url->link('checkout/success');
		
		if ($this->request->server['HTTPS']) {
			$data['base'] = $this->config->get('config_ssl');
		} else {
			$data['base'] = $this->config->get('config_url');
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/alipay_in_weixin.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/alipay_in_weixin.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/payment/alipay_in_weixin.tpl', $data));
		}
	}
	
	/*
	 * 验证是否已经完成支付
	*/
	public function confirm(){
		$this->load->model('checkout/order');
	
		$order_id = $this->session->data['order_id'];
	
		$order_info = $this->model_checkout_order->getOrder($order_id);
	
		// 验证订单状态,判断是否已经完成支付
		if ($order_info['order_status_id'] == $this->config->get('alipay_wap_order_status_id')) {
			$json['return_code'] = 'SUCCESS';
		} else {
			$json['return_code'] = 'FAIL';
		}
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
