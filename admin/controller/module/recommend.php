<?php
/**
 * 作者: myzhou
 * 时间: 2015-9-5
 * 描述: 导航条模块
 */
class ControllerModuleRecommend extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/recommend');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('recommend', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_one_week']  = $this->language->get('text_one_week');
		$data['text_two_week']  = $this->language->get('text_two_week');
		$data['text_one_month'] = $this->language->get('text_one_month');
		
		$data['holder_review_score_limit'] = $this->language->get('holder_review_score_limit');
		$data['holder_limit'] = $this->language->get('holder_limit');

		$data['entry_name']                = $this->language->get('entry_name');
		$data['entry_status']              = $this->language->get('entry_status');
		$data['entry_latest_limit']       = $this->language->get('entry_latest_limit');
		$data['entry_latest_interval_day'] = $this->language->get('entry_latest_interval_day');
		$data['entry_special_limit']      = $this->language->get('entry_special_limit');
		$data['entry_best_seller_limit']  = $this->language->get('entry_best_seller_limit');
		$data['entry_best_seller_interval_day'] = $this->language->get('entry_best_seller_interval_day');
		$data['entry_best_review_limit']  = $this->language->get('entry_best_review_limit');
		$data['entry_review_score_limit']  = $this->language->get('entry_review_score_limit');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['latest_limit'])) {
			$data['error_latest_limit'] = $this->error['latest_limit'];
		} else {
			$data['error_latest_limit'] = '';
		}
		
		if (isset($this->error['special_limit'])) {
			$data['error_special_limit'] = $this->error['special_limit'];
		} else {
			$data['error_special_limit'] = '';
		}
		
		if (isset($this->error['best_seller_limit'])) {
			$data['error_best_seller_limit'] = $this->error['best_seller_limit'];
		} else {
			$data['error_best_seller_limit'] = '';
		}
		
		if (isset($this->error['best_review_limit'])) {
			$data['error_best_review_limit'] = $this->error['best_review_limit'];
		} else {
			$data['error_best_review_limit'] = '';
		}
		
		if (isset($this->error['review_score_limit'])) {
			$data['error_review_score_limit'] = $this->error['review_score_limit'];
		} else {
			$data['error_review_score_limit'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/recommend', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/recommend', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/recommend', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/recommend', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = 0;
		}
		
		if (isset($this->request->post['latest_limit'])) {
			$data['latest_limit'] = $this->request->post['latest_limit'];
		} elseif (!empty($module_info)) {
			$data['latest_limit'] = $module_info['latest_limit'];
		} else {
			$data['latest_limit'] = 0;
		}
		
		if (isset($this->request->post['latest_interval_day'])) {
			$data['latest_interval_day'] = $this->request->post['latest_interval_day'];
		} elseif (!empty($module_info)) {
			$data['latest_interval_day'] = $module_info['latest_interval_day'];
		} else {
			$data['latest_interval_day'] = '';
		}
		
		if (isset($this->request->post['special_limit'])) {
			$data['special_limit'] = $this->request->post['special_limit'];
		} elseif (!empty($module_info)) {
			$data['special_limit'] = $module_info['special_limit'];
		} else {
			$data['special_limit'] = 0;
		}
		
		if (isset($this->request->post['best_seller_limit'])) {
			$data['best_seller_limit'] = $this->request->post['best_seller_limit'];
		} elseif (!empty($module_info)) {
			$data['best_seller_limit'] = $module_info['best_seller_limit'];
		} else {
			$data['best_seller_limit'] = 0;
		}
		
		if (isset($this->request->post['best_seller_interval_day'])) {
			$data['best_seller_interval_day'] = $this->request->post['best_seller_interval_day'];
		} elseif (!empty($module_info)) {
			$data['best_seller_interval_day'] = $module_info['best_seller_interval_day'];
		} else {
			$data['best_seller_interval_day'] = '';
		}
		
		if (isset($this->request->post['best_review_limit'])) {
			$data['best_review_limit'] = $this->request->post['best_review_limit'];
		} elseif (!empty($module_info)) {
			$data['best_review_limit'] = $module_info['best_review_limit'];
		} else {
			$data['best_review_limit'] = 0;
		}
		
		if (isset($this->request->post['review_score_limit'])) {
			$data['review_score_limit'] = $this->request->post['review_score_limit'];
		} elseif (!empty($module_info)) {
			$data['review_score_limit'] = $module_info['review_score_limit'];
		} else {
			$data['review_score_limit'] = 0;
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/recommend.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/recommend')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!is_numeric($this->request->post['latest_limit']) || ($this->request->post['latest_limit']) < 0) {
			$this->error['latest_limit'] = $this->language->get('error_latest_limit');
		}
		
		if (!is_numeric($this->request->post['special_limit']) || ($this->request->post['special_limit']) < 0) {
			$this->error['special_limit'] = $this->language->get('error_special_limit');
		}
		
		if (!is_numeric($this->request->post['best_seller_limit']) || ($this->request->post['best_seller_limit']) < 0) {
			$this->error['best_seller_limit'] = $this->language->get('error_best_seller_limit');
		}
		
		if (!is_numeric($this->request->post['best_review_limit']) || ($this->request->post['best_review_limit']) < 0) {
			$this->error['best_review_limit'] = $this->language->get('error_best_review_limit');
		}
		
		if (!is_numeric($this->request->post['review_score_limit']) || ($this->request->post['review_score_limit']) < 0 || ($this->request->post['review_score_limit']) > 5) {
			$this->error['review_score_limit'] = $this->language->get('error_review_score_limit');
		}

		return !$this->error;
	}
}