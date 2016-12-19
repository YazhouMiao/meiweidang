<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-9
 * 描述: 服务区管理相关的类  controller
 */
class ControllerLocalisationServiceZone extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('localisation/service_zone');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/service_zone');

		$this->getList();
	}

	public function add() {
		$this->load->language('localisation/service_zone');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/service_zone');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_service_zone->addServiceZone($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('localisation/service_zone');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/service_zone');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_service_zone->editServiceZone($this->request->get['service_zone_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('localisation/service_zone');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/service_zone');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $service_zone_id) {
				$this->model_localisation_service_zone->deleteServiceZone($service_zone_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'c.city_name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('localisation/service_zone/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('localisation/service_zone/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['service_zones'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$service_zone_total = $this->model_localisation_service_zone->getTotalServiceZones();

		$results = $this->model_localisation_service_zone->getServiceZones($filter_data);

		foreach ($results as $result) {
			$data['service_zones'][] = array(
				'service_zone_id' => $result['service_zone_id'],
				'city'    => $result['city'],
				'name'    => $result['service_zone_name'],
				'code'    => $result['service_zone_code'],
				'edit'    => $this->url->link('localisation/service_zone/edit', 'token=' . $this->session->data['token'] . '&service_zone_id=' . $result['service_zone_id'] . $url, 'SSL')
			);
		}
 
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_city'] = $this->language->get('column_city');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_city'] = $this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . '&sort=c.city_name' . $url, 'SSL');
		$data['sort_name'] = $this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . '&sort=sz.service_zone_name' . $url, 'SSL');
		$data['sort_code'] = $this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . '&sort=sz.service_zone_code' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $service_zone_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($service_zone_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($service_zone_total - $this->config->get('config_limit_admin'))) ? $service_zone_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $service_zone_total, ceil($service_zone_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('localisation/service_zone_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['service_zone_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_admin_name'] = $this->language->get('entry_admin_name');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_openid'] = $this->language->get('entry_openid');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['help_description'] = $this->language->get('help_description');

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
		
		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}
		
		if (isset($this->error['admin_name'])) {
			$data['error_admin_name'] = $this->error['admin_name'];
		} else {
			$data['error_admin_name'] = '';
		}
		
		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}
		
		if (isset($this->error['openid'])) {
			$data['error_openid'] = $this->error['openid'];
		} else {
			$data['error_openid'] = '';
		}
		
		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['service_zone_id'])) {
			$data['action'] = $this->url->link('localisation/service_zone/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('localisation/service_zone/edit', 'token=' . $this->session->data['token'] . '&service_zone_id=' . $this->request->get['service_zone_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('localisation/service_zone', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['service_zone_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$service_zone_info = $this->model_localisation_service_zone->getServiceZone($this->request->get['service_zone_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($service_zone_info)) {
			$data['name'] = $service_zone_info['service_zone_name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['code'])) {
			$data['code'] = $this->request->post['code'];
		} elseif (!empty($service_zone_info)) {
			$data['code'] = $service_zone_info['service_zone_code'];
		} else {
			$data['code'] = '';
		}

		if (isset($this->request->post['city_id'])) {
			$data['city_id'] = $this->request->post['city_id'];
		} elseif (!empty($service_zone_info)) {
			$data['city_id'] = $service_zone_info['city_id'];
		} else {
			$data['city_id'] = 0;
		}

		$this->load->model('localisation/city');
		$data['cities'] = $this->model_localisation_city->getCities();

		if (isset($this->request->post['admin_name'])) {
			$data['admin_name'] = $this->request->post['admin_name'];
		} elseif (!empty($service_zone_info)) {
			$data['admin_name'] = $service_zone_info['admin_name'];
		} else {
			$data['admin_name'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($service_zone_info)) {
			$data['telephone'] = $service_zone_info['telephone'];
		} else {
			$data['telephone'] = '';
		}
		
		if (isset($this->request->post['openid'])) {
			$data['openid'] = $this->request->post['openid'];
		} elseif (!empty($service_zone_info)) {
			$data['openid'] = $service_zone_info['openid'];
		} else {
			$data['openid'] = '';
		}
		
		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} elseif (!empty($service_zone_info)) {
			$data['description'] = $service_zone_info['description'];
		} else {
			$data['description'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($service_zone_info)) {
			$data['status'] = $service_zone_info['status'];
		} else {
			$data['status'] = '1';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('localisation/service_zone_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/service_zone')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['code']) < 2) || (utf8_strlen($this->request->post['code']) > 10)) {
			$this->error['code'] = $this->language->get('error_code');
		}
		
		if ((utf8_strlen($this->request->post['admin_name']) < 2) || (utf8_strlen($this->request->post['admin_name']) > 32)) {
			$this->error['admin_name'] = $this->language->get('error_admin_name');
		}
		
		if ((utf8_strlen($this->request->post['telephone']) < 7) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}
		
		if (utf8_strlen($this->request->post['openid']) != 28) {
			$this->error['openid'] = $this->language->get('error_openid');
		}
		
		if (utf8_strlen($this->request->post['description']) == 0) {
			$this->error['description'] = $this->language->get('error_description');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/service_zone')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('sale/customer');
		$this->load->model('localisation/delivery_area');

		foreach ($this->request->post['selected'] as $service_zone_id) {

			$address_total = $this->model_sale_customer->getTotalAddressesByServiceZoneID($service_zone_id);

			if ($address_total) {
				$this->error['warning'] = sprintf($this->language->get('error_address'), $address_total);
			}

			$delivery_area_total = $this->model_localisation_delivery_area->getTotalDeliveryAreaByServiceZone($service_zone_id);

			if ($delivery_area_total) {
				$this->error['warning'] = sprintf($this->language->get('error_delivery_area'), $delivery_area_total);
			}
		}

		return !$this->error;
	}
	
	/* 
	 * ajax方式通过service_zone_id获取配送范围
	 */ 
	public function deliveryArea() {
		$json = array();
	
		$this->load->model('localisation/service_zone');
	
		$service_zone_info = $this->model_localisation_service_zone->getServiceZone($this->request->get['service_zone_id']);
	
		if ($service_zone_info) {
			$this->load->model('localisation/delivery_area');
	
			$json = array(
					'service_zone_id'      => $service_zone_info['service_zone_id'],
					'service_zone_name'    => $service_zone_info['service_zone_name'],
					'delivery_area'        => $this->model_localisation_delivery_area->getDeliveryAreasByServiceZone($this->request->get['service_zone_id']),
			);
		}
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}