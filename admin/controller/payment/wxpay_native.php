<?php
/**
 * 作者: myzhou
 * 时间: 2015-7-11
 * 描述: 微信扫码支付后台controller
 */
class ControllerPaymentWxpayNative extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/wxpay_native');

		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('wxpay_native', $this->request->post);
				
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->document->settitle($this->language->get('heading_title'));
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['qrcode_size'])) {
			$data['error_qrcode_size'] = $this->error['qrcode_size'];
		} else {
			$data['error_qrcode_size'] = '';
		}
		
		if (isset($this->error['qrcode_margin'])) {
			$data['error_qrcode_margin'] = $this->error['qrcode_margin'];
		} else {
			$data['error_qrcode_margin'] = '';
		}
		
		$this->document->breadcrumbs = array();
		
		$this->document->breadcrumbs[] = array(
				'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
				'text'      => $this->language->get('text_home'),
				'separator' => FALSE
		);
		
		$this->document->breadcrumbs[] = array(
				'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
				'text'      => $this->language->get('text_payment'),
				'separator' => ' :: '
		);
		
		$this->document->breadcrumbs[] = array(
				'href'      => HTTPS_SERVER . 'index.php?route=payment/wxpay_native&token=' . $this->session->data['token'],
				'text'      => $this->language->get('heading_title'),
				'separator' => ' :: '
		);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_logo_image'] = $this->language->get('entry_logo_image');
		$data['entry_qrcode_logo'] = $this->language->get('entry_qrcode_logo');
		$data['entry_qrcode_size'] = $this->language->get('entry_qrcode_size');
		$data['entry_qrcode_level'] = $this->language->get('entry_qrcode_level');
		$data['entry_qrcode_margin'] = $this->language->get('entry_qrcode_margin');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_payment'),
				'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('payment/alipay', 'token=' . $this->session->data['token'], 'SSL')
		);


		$data['action'] = HTTPS_SERVER . 'index.php?route=payment/wxpay_native&token=' . $this->session->data['token'];

		$data['cancel'] =  HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];

		if (isset($this->request->post['wxpay_native_qrcode_size'])) {
			$data['wxpay_native_qrcode_size'] = $this->request->post['wxpay_native_qrcode_size'];
		} else {
			$data['wxpay_native_qrcode_size'] = $this->config->get('wxpay_native_qrcode_size');
		}

		// 二维码纠错等级
		$data['levels'] = array('QR_H,30%' => 3, 'QR_Q,25%' => 2, 'QR_M,15%' => 1, 'QR_L,7%' => 0);
		
		if (isset($this->request->post['wxpay_native_qrcode_level'])) {
			$data['wxpay_native_qrcode_level'] = $this->request->post['wxpay_native_qrcode_level'];
		} else {
			$data['wxpay_native_qrcode_level'] = $this->config->get('wxpay_native_qrcode_level');
		}

		if (isset($this->request->post['wxpay_native_qrcode_margin'])) {
			$data['wxpay_native_qrcode_margin'] = $this->request->post['wxpay_native_qrcode_margin'];
		} else {
			$data['wxpay_native_qrcode_margin'] = $this->config->get('wxpay_native_qrcode_margin');
		}

		if (isset($this->request->post['wxpay_native_logo']) && is_file(DIR_IMAGE . $this->request->post['wxpay_native_logo'])) {
			$data['wxpay_native_logo'] = $this->request->post['wxpay_native_logo'];
		} else if ($this->config->has('wxpay_native_logo') && $this->config->get('wxpay_native_logo')){
			$data['wxpay_native_logo'] = $this->config->get('wxpay_native_logo');
		} else {
			$data['wxpay_native_logo'] = 'no_image.png';
		}
		
		if (isset($this->request->post['wxpay_native_qrcode_logo']) && is_file(DIR_IMAGE . $this->request->post['wxpay_native_qrcode_logo'])) {
			$data['wxpay_native_qrcode_logo'] = $this->request->post['wxpay_native_qrcode_logo'];
		} else if ($this->config->has('wxpay_native_qrcode_logo') && $this->config->get('wxpay_native_qrcode_logo')){
			$data['wxpay_native_qrcode_logo'] = $this->config->get('wxpay_native_qrcode_logo');
		} else {
			$data['wxpay_native_qrcode_logo'] = 'no_image.png';
		}

		$this->load->model('tool/image');

		$data['logo_image'] = $this->model_tool_image->resize($data['wxpay_native_logo'], 150, 50);
		
		$data['qrcode_logo_image'] = $this->model_tool_image->resize($data['wxpay_native_qrcode_logo'], 150, 50);

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 150, 50);

		if (isset($this->request->post['wxpay_native_order_status_id'])) {
			$data['wxpay_native_order_status_id'] = $this->request->post['wxpay_native_order_status_id'];
		} else {
			$data['wxpay_native_order_status_id'] = $this->config->get('wxpay_native_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			
		if (isset($this->request->post['wxpay_native_status'])) {
			$data['wxpay_native_status'] = $this->request->post['wxpay_native_status'];
		} else {
			$data['wxpay_native_status'] = $this->config->get('wxpay_native_status');
		}

		if (isset($this->request->post['wxpay_native_sort_order'])) {
			$data['wxpay_native_sort_order'] = $this->request->post['wxpay_native_sort_order'];
		} else {
			$data['wxpay_native_sort_order'] = $this->config->get('wxpay_native_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/wxpay_native.tpl', $data));
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/wxpay_native')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['wxpay_native_qrcode_size']) {
			$this->error['qrcode_size'] = $this->language->get('error_qrcode_size');
		}

		if (!$this->request->post['wxpay_native_qrcode_margin']) {
			$this->error['qrcode_margin'] = $this->language->get('error_qrcode_margin');
		}

		return !$this->error;
	}
}
