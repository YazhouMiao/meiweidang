<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-11
 * 描述: 配送员管理相关的controller
 */
class ControllerDeliveryStaff extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('delivery/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/staff');

		$this->getList();
	}

	public function add() {
		$this->load->language('delivery/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/staff');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_delivery_staff->addDeliveryStaff($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

		
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_city_id'])) {
				$url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
			}

			if (isset($this->request->get['filter_service_zone_id'])) {
				$url .= '&filter_service_zone_id=' . $this->request->get['filter_service_zone_id'];
			}

			if (isset($this->request->get['filter_openid'])) {
				$url .= '&filter_openid=' . $this->request->get['filter_openid'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('delivery/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/staff');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_delivery_staff->editDeliveryStaff($this->request->get['delivery_staff_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_city_id'])) {
				$url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
			}

			if (isset($this->request->get['filter_service_zone_id'])) {
				$url .= '&filter_service_zone_id=' . $this->request->get['filter_service_zone_id'];
			}

			if (isset($this->request->get['filter_openid'])) {
				$url .= '&filter_openid=' . $this->request->get['filter_openid'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('delivery/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/staff');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $delivery_staff_id) {
				$this->model_delivery_staff->deleteDeliveryStaff($delivery_staff_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_city_id'])) {
				$url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
			}

			if (isset($this->request->get['filter_service_zone_id'])) {
				$url .= '&filter_service_zone_id=' . $this->request->get['filter_service_zone_id'];
			}

			if (isset($this->request->get['filter_openid'])) {
				$url .= '&filter_openid=' . $this->request->get['filter_openid'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_city_id'])) {
			$filter_city_id = $this->request->get['filter_city_id'];
		} else {
			$filter_city_id = null;
		}
		
		if (isset($this->request->get['filter_service_zone_id'])) {
			$filter_service_zone_id = $this->request->get['filter_service_zone_id'];
		} else {
			$filter_service_zone_id = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_openid'])) {
			$filter_openid = $this->request->get['filter_openid'];
		} else {
			$filter_openid = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_city_id'])) {
			$url .= '&filter_city_id=' . urlencode(html_entity_decode($this->request->get['filter_city_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_service_zone_id'])) {
			$url .= '&filter_service_zone_id=' . $this->request->get['filter_service_zone_id'];
		}

		if (isset($this->request->get['filter_openid'])) {
			$url .= '&filter_openid=' . $this->request->get['filter_openid'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

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
				'href' => $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('delivery/staff/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('delivery/staff/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['delivery_staffs'] = array();

		$filter_data = array(
			'filter_name'              => $filter_name,
			'filter_city_id'           => $filter_city_id,
			'filter_service_zone_id'   => $filter_service_zone_id,
			'filter_openid'            => $filter_openid,
			'filter_status'            => $filter_status,
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$delivery_staff_total = $this->model_delivery_staff->getTotalDeliveryStaffs($filter_data);

		$results = $this->model_delivery_staff->getDeliveryStaffs($filter_data);

		if($results){
			foreach ($results as $result) {
				$data['delivery_staffs'][] = array(
						'delivery_staff_id'    => $result['delivery_staff_id'],
						'name'           => $result['name'],
						'city'           => $result['city'],
						'service_zone'   => $result['service_zone'],
						'openid'         => $result['openid'],
						'telephone'      => $result['telephone'],
						'amount'         => $result['amount'],
						'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
						'add_time'       => $result['add_time'],
						'edit'    => $this->url->link('delivery/staff/edit', 'token=' . $this->session->data['token'] . '&delivery_staff_id=' . $result['delivery_staff_id'] . $url, 'SSL')
				);
			}
		} else {
			$data['delivery_staffs'] = array();
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_none'] = $this->language->get('text_none');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_city'] = $this->language->get('column_city');
		$data['column_service_zone'] = $this->language->get('column_service_zone');
		$data['column_openid'] = $this->language->get('column_openid');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_telephone'] = $this->language->get('column_telephone');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_service_zone'] = $this->language->get('entry_service_zone');
		$data['entry_openid'] = $this->language->get('entry_openid');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_city_id'])) {
			$url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
		}

		if (isset($this->request->get['filter_service_zone_id'])) {
			$url .= '&filter_service_zone_id=' . $this->request->get['filter_service_zone_id'];
		}

		if (isset($this->request->get['filter_openid'])) {
			$url .= '&filter_openid=' . $this->request->get['filter_openid'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . '&sort=ds.delivery_staff_name' . $url, 'SSL');
		$data['sort_openid'] = $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . '&sort=ds.openid' . $url, 'SSL');
		$data['sort_amount'] = $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . '&sort=ds.delivery_amount' . $url, 'SSL');
		$data['sort_service_zone'] = $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . '&sort=sz.service_zone_name' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . '&sort=ds.add_time' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_city_id'])) {
			$url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
		}

		if (isset($this->request->get['filter_service_zone_id'])) {
			$url .= '&filter_service_zone_id=' . $this->request->get['filter_service_zone_id'];
		}

		if (isset($this->request->get['filter_openid'])) {
			$url .= '&filter_openid=' . urlencode(html_entity_decode($this->request->get['filter_openid'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $delivery_staff_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($delivery_staff_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($delivery_staff_total - $this->config->get('config_limit_admin'))) ? $delivery_staff_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $delivery_staff_total, ceil($delivery_staff_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_city_id'] = $filter_city_id;
		$data['filter_service_zone_id'] = $filter_service_zone_id;
		$data['filter_openid'] = $filter_openid;
		$data['filter_status'] = $filter_status;
		$data['filter_date_added'] = $filter_date_added;

		$this->load->model('localisation/city');
		$this->load->model('localisation/service_zone');

		$data['cities'] = $this->model_localisation_city->getCities();

		if($filter_city_id != null) {
			$data['service_zones'] = $this->model_localisation_service_zone->getServiceZonesByCity($filter_city_id);
		} else {
			$data['service_zones'] = array();
		}

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('delivery/staff_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['delivery_staff_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_openid'] = $this->language->get('entry_openid');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_service_zone'] = $this->language->get('entry_service_zone');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_amount'] = $this->language->get('entry_amount');

		$data['help_description'] = $this->language->get('help_description');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['delivery_staff_id'])) {
			$data['delivery_staff_id'] = $this->request->get['delivery_staff_id'];
		} else {
			$data['delivery_staff_id'] = 0;
		}

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

		if (isset($this->error['openid'])) {
			$data['error_openid'] = $this->error['openid'];
		} else {
			$data['error_openid'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['amount'])) {
			$data['error_amount'] = $this->error['amount'];
		} else {
			$data['error_amount'] = '';
		}
		
		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_city_id'])) {
			$url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
		}

		if (isset($this->request->get['filter_service_zone_id'])) {
			$url .= '&filter_service_zone_id=' . $this->request->get['filter_service_zone_id'];
		}
		
		if (isset($this->request->get['filter_openid'])) {
			$url .= '&filter_openid=' . $this->request->get['filter_openid'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

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
				'href' => $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['delivery_staff_id'])) {
			$data['action'] = $this->url->link('delivery/staff/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('delivery/staff/edit', 'token=' . $this->session->data['token'] . '&delivery_staff_id=' . $this->request->get['delivery_staff_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('delivery/staff', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['delivery_staff_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$delivery_staff_info = $this->model_delivery_staff->getDeliveryStaff($this->request->get['delivery_staff_id']);
		}

		if (isset($this->request->post['service_zone_id'])) {
			$data['service_zone_id'] = $this->request->post['service_zone_id'];
		} elseif (!empty($delivery_staff_info)) {
			$data['service_zone_id'] = $delivery_staff_info['service_zone_id'];
		} else {
			$data['service_zone_id'] = 0;
		}
		
		// city
		if(!empty($data['service_zone_id'])){
			$this->load->model('localisation/service_zone');
			$query = $this->model_localisation_service_zone->getServiceZone($data['service_zone_id']);
			$data['city_id'] = $query['city_id'];
		} else {
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

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($delivery_staff_info)) {
			$data['name'] = $delivery_staff_info['delivery_staff_name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['openid'])) {
			$data['openid'] = $this->request->post['openid'];
		} elseif (!empty($delivery_staff_info)) {
			$data['openid'] = $delivery_staff_info['openid'];
		} else {
			$data['openid'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($delivery_staff_info)) {
			$data['telephone'] = $delivery_staff_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['amount'])) {
			$data['amount'] = $this->request->post['amount'];
		} elseif (!empty($delivery_staff_info)) {
			$data['amount'] = $delivery_staff_info['delivery_amount'];
		} else {
			$data['amount'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($delivery_staff_info)) {
			$data['status'] = $delivery_staff_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['description'])) {
			$data['description'] = $this->request->post['description'];
		} elseif (!empty($delivery_staff_info)) {
			$data['description'] = $delivery_staff_info['description'];
		} else {
			$data['description'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('delivery/staff_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'delivery/staff')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen(trim($this->request->post['name'])) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (utf8_strlen($this->request->post['service_zone_id']) == 0) {
			$this->error['service_zone'] = $this->language->get('error_service_zone');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 7) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}
		
		if (utf8_strlen($this->request->post['openid']) != 28) {
			$this->error['openid'] = $this->language->get('error_openid');
		}
		
		if ((utf8_strlen($this->request->post['amount'])) == 0 || (int)$this->request->post['amount'] <= 0) {
			$this->error['amount'] = $this->language->get('error_amount');
		}

		if (utf8_strlen($this->request->post['description']) < 8) {
			$this->error['description'] = $this->language->get('error_description');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'delivery/staff')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('delivery/schedule');
		
		foreach ($this->request->post['selected'] as $delivery_staff_id) {
			$delivery_schedule_total = $this->model_delivery_schedule->getTotalDeliverySchedulesByDeliveryStaffId($delivery_staff_id);
			
			if($delivery_schedule_total){
				$this->error['warning'] = sprintf($this->language->get('error_delivery_schedule'), $delivery_schedule_total);
			}
		}
		
		return !$this->error;
	}
	
	/*
	 * ajax方式通过service_zone_id取得staff
	 */
	public function getStaffsByServiceZone() {
		$json = array();
	
		$this->load->model('delivery/staff');
	
		$staffs = $this->model_delivery_staff->getDeliveryStaffsByServiceZoneId($this->request->get['service_zone_id']);
	
		if ($staffs) {
			foreach ($staffs as $staff) {
				$json['staffs'][] = array(
					'delivery_staff_id'      => $staff['delivery_staff_id'],
					'delivery_staff_name'    => $staff['delivery_staff_name'],
				);
			}
		}
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
