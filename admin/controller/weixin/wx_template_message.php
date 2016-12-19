<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-26
 * 描述: 微信模板消息设置
 */
class ControllerWeixinWxTemplateMessage extends Controller {
	private $error = array();
	
	/*
	 * 新订单提醒消息模板设置
	 */
	public function newOrder() {
		$this->load->language('weixin/wx_template_message');
		
		$this->load->model('setting/setting');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateNewOrder()) {
			$weixin = $this->model_setting_setting->getSetting('weixin');
			
			$weixin['weixin_new_order_deliverer_template_id'] = $this->request->post['weixin_new_order_deliverer_template_id'];
			$weixin['weixin_new_order_deliverer_url'] = $this->request->post['weixin_new_order_deliverer_url'];
			$weixin['weixin_new_order_business_template_id'] = $this->request->post['weixin_new_order_business_template_id'];
			$weixin['weixin_new_order_business_url'] = $this->request->post['weixin_new_order_business_url'];
			
			$this->model_setting_setting->editSetting('weixin', $weixin);
		
			$this->session->data['success'] = $this->language->get('text_new_order_success');
		
			$this->response->redirect($this->url->link('weixin/wx_template_message/newOrder', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('text_new_order_heading_title');
		
		$data['text_new_order_edit'] = $this->language->get('text_new_order_edit');

		$data['entry_new_order_deliverer_message_id']  = $this->language->get('entry_new_order_deliverer_message_id');
		$data['entry_new_order_deliverer_url']         = $this->language->get('entry_new_order_deliverer_url');
		$data['entry_new_order_business_message_id']   = $this->language->get('entry_new_order_business_message_id');
		$data['entry_new_order_business_url']          = $this->language->get('entry_new_order_business_url');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->error['new_order_deliverer_template_id'])) {
			$data['error_new_order_deliverer_template_id'] = $this->error['new_order_deliverer_template_id'];
		} else {
			$data['error_new_order_deliverer_template_id'] = '';
		}
		
		if (isset($this->error['new_order_deliverer_url'])) {
			$data['error_new_order_deliverer_url'] = $this->error['new_order_deliverer_url'];
		} else {
			$data['error_new_order_deliverer_url'] = '';
		}
		
		if (isset($this->error['new_order_business_template_id'])) {
			$data['error_new_order_business_template_id'] = $this->error['new_order_business_template_id'];
		} else {
			$data['error_new_order_business_template_id'] = '';
		}
		
		if (isset($this->error['new_order_business_url'])) {
			$data['error_new_order_business_url'] = $this->error['new_order_business_url'];
		} else {
			$data['error_new_order_business_url'] = '';
		}
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_new_order_extension'),
				'href' => $this->url->link('weixin/wx_template_message', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['action'] = $this->url->link('weixin/wx_template_message/newOrder', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		
		
		$data['entry_new_order_deliverer_template_id']  = $this->language->get('entry_new_order_deliverer_template_id');
		$data['entry_new_order_deliverer_url']         = $this->language->get('entry_new_order_deliverer_url');
		$data['entry_new_order_business_template_id']   = $this->language->get('entry_new_order_business_template_id');
		$data['entry_new_order_business_url']          = $this->language->get('entry_new_order_business_url');
		
		
		if (isset($this->request->post['weixin_new_order_deliverer_template_id'])) {
			$data['weixin_new_order_deliverer_template_id'] = $this->request->post['weixin_new_order_deliverer_template_id'];
		} else {
			$data['weixin_new_order_deliverer_template_id'] = $this->config->get('weixin_new_order_deliverer_template_id');
		}
		
		if (isset($this->request->post['weixin_new_order_deliverer_url'])) {
			$data['weixin_new_order_deliverer_url'] = $this->request->post['weixin_new_order_deliverer_url'];
		} else {
			$data['weixin_new_order_deliverer_url'] = $this->config->get('weixin_new_order_deliverer_url');
		}
		
		if (isset($this->request->post['weixin_new_order_business_template_id'])) {
			$data['weixin_new_order_business_template_id'] = $this->request->post['weixin_new_order_business_template_id'];
		} else {
			$data['weixin_new_order_business_template_id'] = $this->config->get('weixin_new_order_business_template_id');
		}
		
		if (isset($this->request->post['weixin_new_order_business_url'])) {
			$data['weixin_new_order_business_url'] = $this->request->post['weixin_new_order_business_url'];
		} else {
			$data['weixin_new_order_business_url'] = $this->config->get('weixin_new_order_business_url');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('weixin/wx_template_message_new_order.tpl', $data));
	}
		
	protected function validateNewOrder() {
		if (!$this->user->hasPermission('modify', 'weixin/wx_template_message')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->request->post['weixin_new_order_deliverer_template_id']) {
			$this->error['new_order_deliverer_template_id'] = $this->language->get('error_new_order_deliverer_template_id');
		}
	
		if (!$this->request->post['weixin_new_order_deliverer_url']) {
			$this->error['new_order_deliverer_url'] = $this->language->get('error_new_order_deliverer_url');
		}
	
		if (!$this->request->post['weixin_new_order_business_template_id']) {
			$this->error['new_order_business_template_id'] = $this->language->get('error_new_order_business_template_id');
		}
	
		if (!$this->request->post['weixin_new_order_business_url']) {
			$this->error['new_order_business_url'] = $this->language->get('error_new_order_business_url');
		}
	
		return !$this->error;
	}
}