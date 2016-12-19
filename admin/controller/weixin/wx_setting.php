<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-21
 * 描述: 微信公众号的基本设置  controller
 */
class ControllerWeixinWxSetting extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('weixin/wx_setting');

		$this->load->model('setting/setting');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$weixin = $this->model_setting_setting->getSetting('weixin');
			
			$weixin['weixin_app_id'] = $this->request->post['weixin_app_id'];
			$weixin['weixin_app_secret'] = $this->request->post['weixin_app_secret'];
			$weixin['weixin_token'] = $this->request->post['weixin_token'];
			$weixin['weixin_EncodingAESKey'] = $this->request->post['weixin_EncodingAESKey'];
			$weixin['weixin_debug'] = $this->request->post['weixin_debug'];
			$weixin['weixin_customer_group_id'] = $this->request->post['weixin_customer_group_id'];
			$weixin['weixin_status'] = $this->request->post['weixin_status'];
			
			$this->model_setting_setting->editSetting('weixin', $weixin);
		
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->response->redirect($this->url->link('weixin/wx_setting', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_app_id'] = $this->language->get('entry_app_id');
		$data['entry_app_secret'] = $this->language->get('entry_app_secret');
		$data['entry_token'] = $this->language->get('entry_token');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['entry_placeholder'] = $this->language->get('entry_placeholder');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_EncodingAESKey'] = $this->language->get('entry_EncodingAESKey');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_debug_logging'] = $this->language->get('help_debug_logging');
		$data['help_customer_group'] = $this->language->get('help_customer_group');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
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

		if (isset($this->error['app_id'])) {
			$data['error_app_id'] = $this->error['app_id'];
		} else {
			$data['error_app_id'] = '';
		}

		if (isset($this->error['app_secret'])) {
			$data['error_app_secret'] = $this->error['app_secret'];
		} else {
			$data['error_app_secret'] = '';
		}
		
		if (isset($this->error['token'])) {
			$data['error_token'] = $this->error['token'];
		} else {
			$data['error_token'] = '';
		}
		
		if (isset($this->error['EncodingAESKey'])) {
			$data['error_EncodingAESKey'] = $this->error['EncodingAESKey'];
		} else {
			$data['error_EncodingAESKey'] = '';
		}

		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('weixin/wx_setting', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['action'] = $this->url->link('weixin/wx_setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['weixin_app_id'])) {
			$data['weixin_app_id'] = $this->request->post['weixin_app_id'];
		} else {
			$data['weixin_app_id'] = $this->config->get('weixin_app_id');
		}
		
		if (isset($this->request->post['weixin_app_secret'])) {
			$data['weixin_app_secret'] = $this->request->post['weixin_app_secret'];
		} else {
			$data['weixin_app_secret'] = $this->config->get('weixin_app_secret');
		}
		
		if (isset($this->request->post['weixin_token'])) {
			$data['weixin_token'] = $this->request->post['weixin_token'];
		} else {
			$data['weixin_token'] = $this->config->get('weixin_token');
		}
		
		if (isset($this->request->post['weixin_EncodingAESKey'])) {
			$data['weixin_EncodingAESKey'] = $this->request->post['weixin_EncodingAESKey'];
		} else {
			$data['weixin_EncodingAESKey'] = $this->config->get('weixin_EncodingAESKey');
		}
		
		if (isset($this->request->post['weixin_debug'])) {
			$data['weixin_debug'] = $this->request->post['weixin_debug'];
		} else {
			$data['weixin_debug'] = $this->config->get('weixin_debug');
		}
		
		$this->load->model('sale/customer_group');
		
		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		if (isset($this->request->post['weixin_customer_group_id'])) {
			$data['weixin_customer_group_id'] = $this->request->post['weixin_customer_group_id'];
		} else {
			$data['weixin_customer_group_id'] = $this->config->get('weixin_customer_group_id');
		}
		
		if (isset($this->request->post['weixin_status'])) {
			$data['weixin_status'] = $this->request->post['weixin_status'];
		} else {
			$data['weixin_status'] = $this->config->get('weixin_status');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('weixin/wx_setting.tpl', $data));
	}
		
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'weixin/wx_setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->request->post['weixin_app_id']) {
			$this->error['app_id'] = $this->language->get('error_app_id');
		}
	
		if (!$this->request->post['weixin_app_secret']) {
			$this->error['app_secret'] = $this->language->get('error_app_secret');
		}
	
		if (!$this->request->post['weixin_token']) {
			$this->error['token'] = $this->language->get('error_token');
		}
		
		if (!$this->request->post['weixin_EncodingAESKey']) {
			$this->error['EncodingAESKey'] = $this->language->get('error_EncodingAESKey');
		}

		return !$this->error;
	}
}