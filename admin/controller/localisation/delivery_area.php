<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-9
 * 描述: 配送区域管理相关 controller
 */
class ControllerLocalisationDeliveryArea extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('localisation/delivery_area');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/delivery_area');

		$this->getList();
	}

	public function add() {
		$this->load->language('localisation/delivery_area');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/delivery_area');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_delivery_area->addDeliveryArea($this->request->post);

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

			$this->response->redirect($this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('localisation/delivery_area');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/delivery_area');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_delivery_area->editDeliveryArea($this->request->get['delivery_area_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('localisation/delivery_area');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/delivery_area');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $delivery_area_id) {
				$this->model_localisation_delivery_area->deleteDeliveryArea($delivery_area_id);
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

			$this->response->redirect($this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
				'href' => $this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('localisation/delivery_area/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('localisation/delivery_area/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['delivery_areas'] = array();

		$filter_data = array(
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit' => $this->config->get('config_limit_admin')
		);

		$delivery_area_total = $this->model_localisation_delivery_area->getTotalDeliveryAreas();

		$results = $this->model_localisation_delivery_area->getDeliveryAreas($filter_data);

		foreach ($results as $result) {
			$data['delivery_areas'][] = array(
					'delivery_area_id' => $result['delivery_area_id'],
					'city'             => $result['city'],
					'service_zone'     => $result['service_zone'],
					'name'    => $result['delivery_area_name'],
					'edit'    => $this->url->link('localisation/delivery_area/edit', 'token=' . $this->session->data['token'] . '&delivery_area_id=' . $result['delivery_area_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_city'] = $this->language->get('column_city');
		$data['column_service_zone'] = $this->language->get('column_service_zone');
		$data['column_name'] = $this->language->get('column_name');
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

		$data['sort_city'] = $this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . '&sort=c.city_name' . $url, 'SSL');
		$data['sort_service_zone'] = $this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . '&sort=sz.service_zone_name' . $url, 'SSL');
		$data['sort_name'] = $this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . '&sort=da.delivery_area_name' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $delivery_area_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($delivery_area_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($delivery_area_total - $this->config->get('config_limit_admin'))) ? $delivery_area_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $delivery_area_total, ceil($delivery_area_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('localisation/delivery_area_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['delivery_area_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_select'] = $this->language->get('text_select');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_service_zone'] = $this->language->get('entry_service_zone');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['help_description'] = $this->language->get('help_description');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->error['service_zone'])) {
			$data['error_service_zone'] = $this->error['service_zone'];
		} else {
			$data['error_service_zone'] = '';
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
				'href' => $this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['delivery_area_id'])) {
			$data['action'] = $this->url->link('localisation/delivery_area/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('localisation/delivery_area/edit', 'token=' . $this->session->data['token'] . '&delivery_area_id=' . $this->request->get['delivery_area_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('localisation/delivery_area', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['delivery_area_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$delivery_area_info = $this->model_localisation_delivery_area->getDeliveryArea($this->request->get['delivery_area_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($delivery_area_info)) {
			$data['name'] = $delivery_area_info['delivery_area_name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['service_zone_id'])) {
			$data['service_zone_id'] = $this->request->post['service_zone_id'];
		} elseif (!empty($delivery_area_info)) {
			$data['service_zone_id'] = $delivery_area_info['service_zone_id'];
			
			// city
			$this->load->model('localisation/service_zone');
			$query = $this->model_localisation_service_zone->getServiceZone($data['service_zone_id']);
			$data['city_id'] = $query['city_id'];
		} else {
			$data['service_zone_id'] = 0;
			$data['city_id'] = 0;
		}

		$this->load->model('localisation/city');
		$data['cities'] = $this->model_localisation_city->getCities();
		
		if(!empty($data['city_id'])){
			$this->load->model('localisation/service_zone');
			$data['service_zones'] = $this->model_localisation_service_zone->getServiceZonesByCity($data['city_id']);
		} else {
			$data['service_zones'] = '';
		}

		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} elseif (!empty($delivery_area_info)) {
			$data['description'] = $delivery_area_info['description'];
		} else {
			$data['description'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($delivery_area_info)) {
			$data['status'] = $delivery_area_info['status'];
		} else {
			$data['status'] = '1';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('localisation/delivery_area_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/delivery_area')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (empty($this->request->post['service_zone_id'])) {
			$this->error['service_zone'] = $this->language->get('error_service_zone');
		}

		if (empty($this->request->post['description'])) {
			$this->error['description'] = $this->language->get('error_description');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/delivery_area')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('sale/customer');
		$this->load->model('localisation/delivery_area');

		foreach ($this->request->post['selected'] as $delivery_area_id) {

			$address_total = $this->model_sale_customer->getTotalAddressesByDeliveryAreaID($delivery_area_id);

			if ($address_total) {
				$this->error['warning'] = sprintf($this->language->get('error_address'), $address_total);
			}

			// TODO:检索delivery_history/delivery_schedule
		}

		return !$this->error;
	}
}