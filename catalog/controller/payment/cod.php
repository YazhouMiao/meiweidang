<?php
class ControllerPaymentCod extends Controller {
	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$this->load->model('checkout/order');
		
		$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
			
		// 发送新订单提醒
		$this->load->controller('weixin/wx_message/newOrderNotify', $this->session->data['order_id']);
		
		return $this->url->link('checkout/success');
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'cod') {
			// TODO:暂时不需要
		}
	}
}