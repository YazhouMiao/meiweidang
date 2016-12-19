<?php
/**
 * 作者: myzhou
 * 时间: 2015-9-17
 * 描述: 支付宝扩展设置
 */
class ControllerAlipayApSetting extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('alipay/ap_setting');

		$this->document->settitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('alipay', $this->request->post);
				
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->response->redirect($this->url->link('alipay/ap_setting', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		
		$data['entry_seller_email'] = $this->language->get('entry_seller_email');
		$data['entry_security_code'] = $this->language->get('entry_security_code');
		$data['entry_partner'] = $this->language->get('entry_partner');
		$data['entry_logo_image'] = $this->language->get('entry_logo_image');
		$data['entry_seller_email_holder'] = $this->language->get('entry_seller_email_holder');
		$data['entry_security_code_holder'] = $this->language->get('entry_security_code_holder');
		$data['entry_partner_holder'] = $this->language->get('entry_partner_holder');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['secrity_code'])) {
			$data['error_secrity_code'] = $this->error['secrity_code'];
		} else {
			$data['error_secrity_code'] = '';
		}
		
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		
		if (isset($this->error['partner'])) {
			$data['error_partner'] = $this->error['partner'];
		} else {
			$data['error_partner'] = '';
		}
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=common/dashboard&token=' . $this->session->data['token'],
			'text'      => $this->language->get('text_home')
		);
		
		$data['breadcrumbs'][] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=alipay/ap_setting&token=' . $this->session->data['token'],
			'text'      => $this->language->get('heading_title')
		);
		
		$data['action'] = HTTPS_SERVER . 'index.php?route=alipay/ap_setting&token=' . $this->session->data['token'];
		
		$data['cancel'] =  HTTPS_SERVER . 'index.php?route=common/dashboard&token=' . $this->session->data['token'];
		
		if (isset($this->request->post['alipay_seller_email'])) {
			$data['alipay_seller_email'] = $this->request->post['alipay_seller_email'];
		} else {
			$data['alipay_seller_email'] = $this->config->get('alipay_seller_email');
		}

		if (isset($this->request->post['alipay_security_code'])) {
			$data['alipay_security_code'] = $this->request->post['alipay_security_code'];
		} else {
			$data['alipay_security_code'] = $this->config->get('alipay_security_code');
		}

		if (isset($this->request->post['alipay_partner'])) {
			$data['alipay_partner'] = $this->request->post['alipay_partner'];
		} else {
			$data['alipay_partner'] = $this->config->get('alipay_partner');
		}		

		if (isset($this->request->post['logo_image']) && is_file(DIR_IMAGE . $this->request->post['logo_image'])) {
			$data['alipay_logo'] = $this->request->post['logo_image'];
		} else if ($this->config->has('alipay_logo') && $this->config->get('alipay_logo')){
			$data['alipay_logo'] = $this->config->get('alipay_logo');
		} else {
			$data['alipay_logo'] = 'no_image.png';
		}

		$this->load->model('tool/image');
		
		$data['thumb'] = $this->model_tool_image->resize($data['alipay_logo'], 150, 50);
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 150, 50);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('alipay/ap_setting.tpl', $data));
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'alipay/ap_setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['alipay_seller_email']) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (!$this->request->post['alipay_security_code']) {
			$this->error['secrity_code'] = $this->language->get('error_secrity_code');
		}

		if (!$this->request->post['alipay_partner']) {
			$this->error['partner'] = $this->language->get('error_partner');
		}

		return !$this->error;	
	}
}