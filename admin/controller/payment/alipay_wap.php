<?php 
class ControllerPaymentAlipayWap extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/alipay_wap');

		$this->document->settitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('alipay_wap', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		
		$data['entry_logo_image'] = $this->language->get('entry_logo_image');
		$data['entry_order_status'] = $this->language->get('entry_order_status');	
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
 		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}
		
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
				'href' => $this->url->link('payment/alipay_wap', 'token=' . $this->session->data['token'], 'SSL')
		);


		$data['action'] = HTTPS_SERVER . 'index.php?route=payment/alipay_wap&token=' . $this->session->data['token'];
		
		$data['cancel'] =  HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		
		if (isset($this->request->post['logo_image']) && is_file(DIR_IMAGE . $this->request->post['logo_image'])) {
			$data['alipay_wap_logo'] = $this->request->post['logo_image'];
		} else if ($this->config->has('alipay_logo') && $this->config->get('alipay_wap_logo')){
			$data['alipay_wap_logo'] = $this->config->get('alipay_wap_logo');
		} else {
			$data['alipay_wap_logo'] = 'no_image.png';
		}

		$this->load->model('tool/image');
		
		$data['thumb'] = $this->model_tool_image->resize($data['alipay_wap_logo'], 150, 50);
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 150, 50);
		
		if (isset($this->request->post['alipay_wap_order_status_id'])) {
			$data['alipay_wap_order_status_id'] = $this->request->post['alipay_wap_order_status_id'];
		} else {
			$data['alipay_wap_order_status_id'] = $this->config->get('alipay_wap_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			
		if (isset($this->request->post['alipay_wap_status'])) {
			$data['alipay_wap_status'] = $this->request->post['alipay_wap_status'];
		} else {
			$data['alipay_wap_status'] = $this->config->get('alipay_wap_status');
		}
		
		if (isset($this->request->post['alipay_wap_sort_order'])) {
			$data['alipay_wap_sort_order'] = $this->request->post['alipay_wap_sort_order'];
		} else {
			$data['alipay_wap_sort_order'] = $this->config->get('alipay_wap_sort_order');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('payment/alipay_wap.tpl', $data));
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/alipay_wap')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
