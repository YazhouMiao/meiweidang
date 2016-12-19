<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-11
 * 描述: 配送安排相关的controller
 */
class ControllerDeliverySchedule extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('delivery/schedule');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/schedule');

		$this->getList();
	}

	public function add() {
		$this->load->language('delivery/schedule');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/schedule');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_delivery_schedule->addDeliverySchedule($this->request->post);

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
	
			if (isset($this->request->get['filter_delivery_area_id'])) {
				$url .= '&filter_delivery_area_id=' . $this->request->get['filter_delivery_area_id'];
			}
	
			if (isset($this->request->get['filter_start_date'])) {
				$url .= '&filter_start_date=' . $this->request->get['filter_start_date'];
			}
			
			if (isset($this->request->get['filter_end_date'])) {
				$url .= '&filter_end_date=' . $this->request->get['filter_end_date'];
			}
	
			if (isset($this->request->get['filter_start_time'])) {
				$url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
			}
			
			if (isset($this->request->get['filter_end_time'])) {
				$url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('delivery/schedule');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/schedule');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_delivery_schedule->editDeliverySchedule($this->request->get['delivery_schedule_id'], $this->request->post);

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
	
			if (isset($this->request->get['filter_delivery_area_id'])) {
				$url .= '&filter_delivery_area_id=' . $this->request->get['filter_delivery_area_id'];
			}
	
			if (isset($this->request->get['filter_start_date'])) {
				$url .= '&filter_start_date=' . $this->request->get['filter_start_date'];
			}
			
			if (isset($this->request->get['filter_end_date'])) {
				$url .= '&filter_end_date=' . $this->request->get['filter_end_date'];
			}
	
			if (isset($this->request->get['filter_start_time'])) {
				$url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
			}
			
			if (isset($this->request->get['filter_end_time'])) {
				$url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('delivery/schedule');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/schedule');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $delivery_schedule_id) {
				$this->model_delivery_schedule->deleteDeliverySchedule($delivery_schedule_id);
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
	
			if (isset($this->request->get['filter_delivery_area_id'])) {
				$url .= '&filter_delivery_area_id=' . $this->request->get['filter_delivery_area_id'];
			}
	
			if (isset($this->request->get['filter_start_date'])) {
				$url .= '&filter_start_date=' . $this->request->get['filter_start_date'];
			}
			
			if (isset($this->request->get['filter_end_date'])) {
				$url .= '&filter_end_date=' . $this->request->get['filter_end_date'];
			}
	
			if (isset($this->request->get['filter_start_time'])) {
				$url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
			}
			
			if (isset($this->request->get['filter_end_time'])) {
				$url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
		
		if (isset($this->request->get['filter_delivery_area_id'])) {
			$filter_delivery_area_id = $this->request->get['filter_delivery_area_id'];
		} else {
			$filter_delivery_area_id = null;
		}

		if (isset($this->request->get['filter_start_date'])) {
			$filter_start_date = $this->request->get['filter_start_date'];
		} else {
			$filter_start_date = null;
		}
		
		if (isset($this->request->get['filter_end_date'])) {
			$filter_end_date = $this->request->get['filter_end_date'];
		} else {
			$filter_end_date = null;
		}
		
		if (isset($this->request->get['filter_start_time'])) {
			$filter_start_time = $this->request->get['filter_start_time'];
		} else {
			$filter_start_time = null;
		}
		
		if (isset($this->request->get['filter_end_time'])) {
			$filter_end_time = $this->request->get['filter_end_time'];
		} else {
			$filter_end_time = null;
		}
		
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
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
			$url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
		}

		if (isset($this->request->get['filter_service_zone_id'])) {
			$url .= '&filter_service_zone_id=' . $this->request->get['filter_service_zone_id'];
		}

		if (isset($this->request->get['filter_delivery_area_id'])) {
			$url .= '&filter_delivery_area_id=' . $this->request->get['filter_delivery_area_id'];
		}

		if (isset($this->request->get['filter_start_date'])) {
			$url .= '&filter_start_date=' . $this->request->get['filter_start_date'];
		}
		
		if (isset($this->request->get['filter_end_date'])) {
			$url .= '&filter_end_date=' . $this->request->get['filter_end_date'];
		}

		if (isset($this->request->get['filter_start_time'])) {
			$url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}
		
		if (isset($this->request->get['filter_end_time'])) {
			$url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
				'href' => $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('delivery/schedule/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('delivery/schedule/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['delivery_schedules'] = array();

		$filter_data = array(
				'filter_name'              => $filter_name,
				'filter_city_id'           => $filter_city_id,
				'filter_service_zone_id'   => $filter_service_zone_id,
				'filter_delivery_area_id'  => $filter_delivery_area_id,
				'filter_start_date'        => $filter_start_date,
				'filter_end_date'          => $filter_end_date,
				'filter_start_time'        => $filter_start_time,
				'filter_end_time'          => $filter_end_time,
				'filter_status'            => $filter_status,
				'sort'                     => $sort,
				'order'                    => $order,
				'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit'                    => $this->config->get('config_limit_admin')
		);

		$delivery_schedule_total = $this->model_delivery_schedule->getTotalDeliverySchedules($filter_data);

		$results = $this->model_delivery_schedule->getDeliverySchedules($filter_data);

		if($results){
			foreach ($results as $result) {
				$data['delivery_schedules'][] = array(
						'delivery_schedule_id'    => $result['delivery_schedule_id'],
						'name' => $result['name'],
						'city'           => $result['city'],
						'service_zone'   => $result['service_zone'],
						'delivery_area'  => $result['delivery_area'],
						'telephone'      => $result['telephone'],
						'start_date'     => $result['start_date'],
						'end_date'       => $result['end_date'],
						'start_time'     => $result['start_time'],
						'end_time'       => $result['end_time'],
						'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
						'edit'    => $this->url->link('delivery/schedule/edit', 'token=' . $this->session->data['token'] . '&delivery_schedule_id=' . $result['delivery_schedule_id'] . $url, 'SSL')
				);
			}
		} else {
			$data['delivery_schedules'] = array();
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
		$data['column_delivery_area'] = $this->language->get('column_delivery_area');
		$data['column_telephone'] = $this->language->get('column_telephone');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_start_date'] = $this->language->get('column_start_date');
		$data['column_end_date'] = $this->language->get('column_end_date');
		$data['column_start_time'] = $this->language->get('column_start_time');
		$data['column_end_time'] = $this->language->get('column_end_time');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_service_zone'] = $this->language->get('entry_service_zone');
		$data['entry_delivery_area'] = $this->language->get('entry_delivery_area');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_start_date'] = $this->language->get('entry_start_date');
		$data['entry_end_date'] = $this->language->get('entry_end_date');
		$data['entry_start_time'] = $this->language->get('entry_start_time');
		$data['entry_end_time'] = $this->language->get('entry_end_time');

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
		
		if (isset($this->request->get['filter_delivery_area_id'])) {
			$url .= '&filter_delivery_area_id=' . $this->request->get['filter_delivery_area_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_start_date'])) {
			$url .= '&filter_start_date=' . $this->request->get['filter_start_date'];
		}
		
		if (isset($this->request->get['filter_end_date'])) {
			$url .= '&filter_end_date=' . $this->request->get['filter_end_date'];
		}
		
		if (isset($this->request->get['filter_start_time'])) {
			$url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}
		
		if (isset($this->request->get['filter_end_time'])) {
			$url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . '&sort=ds.delivery_staff_name' . $url, 'SSL');
		$data['sort_delivery_area'] = $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . '&sort=da.delivery_area_name' . $url, 'SSL');
		$data['sort_start_date'] = $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . '&sort=dsc.start_date' . $url, 'SSL');
		$data['sort_end_date'] = $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . '&sort=dsc.end_date' . $url, 'SSL');
		$data['sort_start_time'] = $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . '&sort=dsc.start_time' . $url, 'SSL');
		$data['sort_end_time'] = $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . '&sort=dsc.end_time' . $url, 'SSL');
		
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

		if (isset($this->request->get['filter_delivery_area_id'])) {
			$url .= '&filter_delivery_area_id=' . $this->request->get['filter_delivery_area_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_start_date'])) {
			$url .= '&filter_start_date=' . $this->request->get['filter_start_date'];
		}
		
		if (isset($this->request->get['filter_end_date'])) {
			$url .= '&filter_end_date=' . $this->request->get['filter_end_date'];
		}
		
		if (isset($this->request->get['filter_start_time'])) {
			$url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}
		
		if (isset($this->request->get['filter_end_time'])) {
			$url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $delivery_schedule_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($delivery_schedule_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($delivery_schedule_total - $this->config->get('config_limit_admin'))) ? $delivery_schedule_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $delivery_schedule_total, ceil($delivery_schedule_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_city_id'] = $filter_city_id;
		$data['filter_service_zone_id'] = $filter_service_zone_id;
		$data['filter_delivery_area_id'] = $filter_delivery_area_id;
		$data['filter_status'] = $filter_status;
		$data['filter_start_date'] = $filter_start_date;
		$data['filter_end_date'] = $filter_end_date;
		$data['filter_start_time'] = $filter_start_time;
		$data['filter_end_time'] = $filter_end_time;

		$this->load->model('localisation/city');
		$this->load->model('localisation/service_zone');
		$this->load->model('localisation/delivery_area');

		$data['cities'] = $this->model_localisation_city->getCities();

		if($filter_city_id != null) {
			$data['service_zones'] = $this->model_localisation_service_zone->getServiceZonesByCity($filter_city_id);
		} else {
			$data['service_zones'] = array();
		}
		
		if($filter_service_zone_id != null) {
			$data['delivery_areas'] = $this->model_localisation_delivery_area->getDeliveryAreasByServiceZone($filter_service_zone_id);
		} else {
			$data['delivery_areas'] = array();
		}

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('delivery/schedule_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['delivery_schedule_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_service_zone'] = $this->language->get('entry_service_zone');
		$data['entry_delivery_area'] = $this->language->get('entry_delivery_area');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_start_date'] = $this->language->get('entry_start_date');
		$data['entry_end_date'] = $this->language->get('entry_end_date');
		$data['entry_start_time'] = $this->language->get('entry_start_time');
		$data['entry_end_time'] = $this->language->get('entry_end_time');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['delivery_schedule_id'])) {
			$data['delivery_schedule_id'] = $this->request->get['delivery_schedule_id'];
		} else {
			$data['delivery_schedule_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['delivery_area'])) {
			$data['error_delivery_area'] = $this->error['delivery_area'];
		} else {
			$data['error_delivery_area'] = '';
		}

		if (isset($this->error['delivery_staff'])) {
			$data['error_delivery_staff'] = $this->error['delivery_staff'];
		} else {
			$data['error_delivery_staff'] = '';
		}

		if (isset($this->error['start_date'])) {
			$data['error_start_date'] = $this->error['start_date'];
		} else {
			$data['error_start_date'] = '';
		}
		
		if (isset($this->error['end_date'])) {
			$data['error_end_date'] = $this->error['end_date'];
		} else {
			$data['error_end_date'] = '';
		}
		
		if (isset($this->error['start_end_date'])) {
			$data['error_start_end_date'] = $this->error['start_end_date'];
		} else {
			$data['error_start_end_date'] = '';
		}

		if (isset($this->error['start_time'])) {
			$data['error_start_time'] = $this->error['start_time'];
		} else {
			$data['error_start_time'] = '';
		}
		
		if (isset($this->error['end_time'])) {
			$data['error_end_time'] = $this->error['end_time'];
		} else {
			$data['error_end_time'] = '';
		}
		
		if (isset($this->error['start_end_time'])) {
			$data['error_start_end_time'] = $this->error['start_end_time'];
		} else {
			$data['error_start_end_time'] = '';
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

		if (isset($this->request->get['filter_delivery_area_id'])) {
			$url .= '&filter_delivery_area_id=' . $this->request->get['filter_delivery_area_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_start_date'])) {
			$url .= '&filter_start_date=' . $this->request->get['filter_start_date'];
		}
		
		if (isset($this->request->get['filter_end_date'])) {
			$url .= '&filter_end_date=' . $this->request->get['filter_end_date'];
		}
		
		if (isset($this->request->get['filter_start_time'])) {
			$url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}
		
		if (isset($this->request->get['filter_end_time'])) {
			$url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
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
				'href' => $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['delivery_schedule_id'])) {
			$data['action'] = $this->url->link('delivery/schedule/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('delivery/schedule/edit', 'token=' . $this->session->data['token'] . '&delivery_schedule_id=' . $this->request->get['delivery_schedule_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('delivery/schedule', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['delivery_schedule_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$delivery_schedule_info = $this->model_delivery_schedule->getDeliverySchedule($this->request->get['delivery_schedule_id']);
		}

		if (isset($this->request->post['delivery_area_id'])) {
			$data['delivery_area_id'] = $this->request->post['delivery_area_id'];
		} elseif (!empty($delivery_schedule_info)) {
			$data['delivery_area_id'] = $delivery_schedule_info['delivery_area_id'];
		} else {
			$data['delivery_area_id'] = 0;
		}

		if(!empty($data['delivery_area_id'])){
			// service_zone
			$this->load->model('localisation/delivery_area');
			$delivery_area_query = $this->model_localisation_delivery_area->getDeliveryArea($data['delivery_area_id']);
			$data['service_zone_id'] = $delivery_area_query['service_zone_id'];
			// city
			$this->load->model('localisation/service_zone');
			$service_zone_query = $this->model_localisation_service_zone->getServiceZone($data['service_zone_id']);
			$data['city_id'] = $service_zone_query['city_id'];
		} else {
			$data['service_zone_id'] = 0;
			$data['city_id'] = 0;
		}

		$this->load->model('localisation/city');
		$data['cities'] = $this->model_localisation_city->getCities();

		if(!empty($data['city_id'])){
			$data['service_zones'] = $this->model_localisation_service_zone->getServiceZonesByCity($data['city_id']);
		} else {
			$data['service_zones'] = array();
		}
		
		if(!empty($data['service_zone_id'])){
			$data['delivery_areas'] = $this->model_localisation_delivery_area->getDeliveryAreasByServiceZone($data['service_zone_id']);
		} else {
			$data['delivery_areas'] = array();
		}

		if (isset($this->request->post['delivery_staff_id'])) {
			$data['delivery_staff_id'] = $this->request->post['delivery_staff_id'];
		} elseif (!empty($delivery_schedule_info)) {
			$data['delivery_staff_id'] = $delivery_schedule_info['delivery_staff_id'];
		} else {
			$data['delivery_staff_id'] = '';
		}

		
		if(!empty($data['service_zone_id'])){
			$this->load->model('delivery/staff');
			$data['delivery_staffs'] = $this->model_delivery_staff->getDeliveryStaffsByServiceZoneId($data['service_zone_id']);
		} else {
			$data['delivery_staffs'] = array();
		}
		
		if (isset($this->request->post['start_date'])) {
			$data['start_date'] = $this->request->post['start_date'];
		} elseif (!empty($delivery_schedule_info)) {
			$data['start_date'] = $delivery_schedule_info['start_date'];
		} else {
			$data['start_date'] = '';
		}
		
		if (isset($this->request->post['end_date'])) {
			$data['end_date'] = $this->request->post['end_date'];
		} elseif (!empty($delivery_schedule_info)) {
			$data['end_date'] = $delivery_schedule_info['end_date'];
		} else {
			$data['end_date'] = '';
		}
		
		if (isset($this->request->post['start_time'])) {
			$data['start_time'] = $this->request->post['start_time'];
		} elseif (!empty($delivery_schedule_info)) {
			$data['start_time'] = $delivery_schedule_info['start_time'];
		} else {
			$data['start_time'] = '';
		}
		
		if (isset($this->request->post['end_time'])) {
			$data['end_time'] = $this->request->post['end_time'];
		} elseif (!empty($delivery_schedule_info)) {
			$data['end_time'] = $delivery_schedule_info['end_time'];
		} else {
			$data['end_time'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($delivery_schedule_info)) {
			$data['status'] = $delivery_schedule_info['status'];
		} else {
			$data['status'] = true;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('delivery/schedule_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'delivery/schedule')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['delivery_area_id']) == 0) {
			$this->error['delivery_area'] = $this->language->get('error_delivery_area');
		}
		
		if (utf8_strlen($this->request->post['delivery_staff_id']) == 0) {
			$this->error['delivery_staff'] = $this->language->get('error_delivery_staff');
		}

		if (utf8_strlen($this->request->post['start_date']) == 0) {
			$this->error['start_date'] = $this->language->get('error_start_date');
		}
		
		if (utf8_strlen($this->request->post['end_date']) == 0) {
			$this->error['end_date'] = $this->language->get('error_end_date');
		}
		
		if($this->request->post['end_date'] < $this->request->post['start_date']){
			$this->error['start_end_date'] = $this->language->get('error_start_end_date');
		}

		if (utf8_strlen($this->request->post['start_time']) == 0) {
			$this->error['start_time'] = $this->language->get('error_start_time');
		}
		
		if (utf8_strlen($this->request->post['end_time']) == 0) {
			$this->error['end_time'] = $this->language->get('error_end_time');
		}
		
		if($this->request->post['end_time'] <= $this->request->post['start_time']){
			$this->error['start_end_time'] = $this->language->get('error_start_end_time');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'delivery/schedule')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('delivery/schedule');

		foreach ($this->request->post['selected'] as $delivery_schedule_id) {
			$schedule = $this->model_delivery_schedule->getDeliverySchedule($delivery_schedule_id);
				
			if($schedule){
				$curDate = date('Y-m-d');
				// 正在使用的计划不能删除
				if($schedule['start_date'] <= $curDate && $schedule['end_date'] >= $curDate && $schedule['status']){
					$this->error['warning'] = $this->language->get('error_delivery_schedule');
				}
			}
		}

		return !$this->error;
	}
}
