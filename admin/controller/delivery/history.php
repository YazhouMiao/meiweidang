<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-11
 * 描述: 配送历史记录查询相关的controller
 */
class ControllerDeliveryHistory extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('delivery/history');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('delivery/history');

		$this->getList();
	}

	/*
	 * 查看单个订单的历史记录
	 */
	public function single(){
		$this->load->language('delivery/history');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('delivery/history');
		
		$url = '';
		
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_delivery_name'])) {
			$url .= '&filter_delivery_name=' . urlencode(html_entity_decode($this->request->get['filter_delivery_name'], ENT_QUOTES, 'UTF-8'));
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
		
		if(isset($this->request->get['order_id'])){
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('delivery/history', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['delivery_histories'] = array();
		
		$results = $this->model_delivery_history->getDeliveryHistoriesByOrderId($order_id);
		
		if($results){
			foreach ($results as $result) {
				if(0 == $result['status']){
					$status = $this->language->get('text_status_0');
				} elseif (1 == $result['status']){
					$status = $this->language->get('text_status_1');
				} elseif (2 == $result['status']){
					$status = $this->language->get('text_status_2');
				} elseif (3 == $result['status']){
					$status = $this->language->get('text_status_3');
				}
		
				$data['delivery_histories'][] = array(
					'add_time'       => $result['add_time'],
					'status'         => $status,
					'delivery_name'  => $result['delivery_name'],
					'delivery_telephone'  => $result['delivery_telephone'],
				);
			}
		} else {
			$data['delivery_histories'] = array();
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list']     = $this->language->get('text_list');
		$data['text_success']  = $this->language->get('text_success');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_order_list'] = sprintf($this->language->get('text_order_list'), $order_id);
		
		// Column
		$data['column_order_id']           = $this->language->get('column_order_id');
		$data['column_delivery_name']      = $this->language->get('column_delivery_name');;
		$data['column_delivery_telephone'] = $this->language->get('column_delivery_telephone');;
		$data['column_status']             = $this->language->get('column_status');
		$data['column_add_time']           = $this->language->get('column_add_time');
		
		// Button
		$data['button_back'] = $this->language->get('button_back');
		
		$data['token'] = $this->session->data['token'];
		
		$url = '';
		
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_delivery_name'])) {
			$url .= '&filter_delivery_name=' . urlencode(html_entity_decode($this->request->get['filter_delivery_name'], ENT_QUOTES, 'UTF-8'));
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

		$data['back'] = $this->url->link('delivery/history', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('delivery/history_single.tpl', $data));
		
	}

	protected function getList() {
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}
		
		if (isset($this->request->get['filter_delivery_name'])) {
			$filter_delivery_name = $this->request->get['filter_delivery_name'];
		} else {
			$filter_delivery_name = null;
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
			$sort = 'dh.order_id';
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

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_delivery_name'])) {
			$url .= '&filter_delivery_name=' . urlencode(html_entity_decode($this->request->get['filter_delivery_name'], ENT_QUOTES, 'UTF-8'));
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
				'href' => $this->url->link('delivery/history', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['delivery_histories'] = array();

		$filter_data = array(
			'filter_order_id'          => $filter_order_id,
			'filter_delivery_name'     => $filter_delivery_name,
			'filter_city_id'           => $filter_city_id,
			'filter_service_zone_id'   => $filter_service_zone_id,
			'filter_delivery_area_id'  => $filter_delivery_area_id,
			'filter_start_time'        => $filter_start_time,
			'filter_end_time'          => $filter_end_time,
			'filter_status'            => $filter_status,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$delivery_history_total = $this->model_delivery_history->getTotalDeliveryHistories($filter_data);

		$results = $this->model_delivery_history->getDeliveryHistories($filter_data);

		if($results){
			foreach ($results as $result) {
				if(0 == $result['status']){
					$status = $this->language->get('text_status_0');
				} elseif (1 == $result['status']){
					$status = $this->language->get('text_status_1');
				} elseif (2 == $result['status']){
					$status = $this->language->get('text_status_2');
				} elseif (3 == $result['status']){
					$status = $this->language->get('text_status_3');
				}

				$data['delivery_histories'][] = array(
					'order_id'       => $result['order_id'],
					'city'           => $result['city'],
					'service_zone'   => $result['service_zone'],
					'delivery_area'  => $result['delivery_area'],
					'address'        => $result['address'],
					'company'        => $result['company'],
					'add_time'       => $result['add_time'],
					'delivery_name'  => $result['delivery_name'],
					'delivery_telephone'  => $result['delivery_telephone'],
					'shipping_name'  => $result['shipping_name'],
					'shipping_telephone'  => $result['shipping_telephone'],
					'status'         => $status,
					'view'           => $this->url->link('delivery/history/single', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
				);
			}
		} else {
			$data['delivery_histories'] = array();
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list']     = $this->language->get('text_list');
		$data['text_success']  = $this->language->get('text_success');
		$data['text_none']     = $this->language->get('text_none');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_status_0'] = $this->language->get('text_status_0');
		$data['text_status_1'] = $this->language->get('text_status_1');
		$data['text_status_2'] = $this->language->get('text_status_2');
		$data['text_status_3'] = $this->language->get('text_status_3');

		// Column
		$data['column_order_id']           = $this->language->get('column_order_id');
		$data['column_delivery_name']      = $this->language->get('column_delivery_name');;
		$data['column_delivery_telephone'] = $this->language->get('column_delivery_telephone');;
		$data['column_shipping_name']      = $this->language->get('column_shipping_name');
		$data['column_shipping_telephone'] = $this->language->get('column_shipping_telephone');
		$data['column_address']            = $this->language->get('column_address');
		$data['column_status']             = $this->language->get('column_status');
		$data['column_add_time']           = $this->language->get('column_add_time');
		$data['column_city']               = $this->language->get('column_city');
		$data['column_view']               = $this->language->get('column_view');
		
		// Entry
		$data['entry_city']            = $this->language->get('entry_city');
		$data['entry_service_zone']    = $this->language->get('entry_service_zone');
		$data['entry_delivery_area']   = $this->language->get('entry_delivery_area');
		$data['entry_delivery_name']   = $this->language->get('entry_delivery_name');
		$data['entry_status']          = $this->language->get('entry_status');
		$data['entry_start_time']      = $this->language->get('entry_start_time');
		$data['entry_end_time']        = $this->language->get('entry_end_time');
		$data['entry_order_id']        = $this->language->get('entry_order_id');

		// Button
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_view']  = $this->language->get('button_view');

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

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_delivery_name'])) {
			$url .= '&filter_delivery_name=' . urlencode(html_entity_decode($this->request->get['filter_delivery_name'], ENT_QUOTES, 'UTF-8'));
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

		if (isset($this->request->get['filter_start_time'])) {
			$url .= '&filter_start_time=' . $this->request->get['filter_start_time'];
		}

		if (isset($this->request->get['filter_end_time'])) {
			$url .= '&filter_end_time=' . $this->request->get['filter_end_time'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order_id'] = $this->url->link('delivery/history', 'token=' . $this->session->data['token'] . '&sort=dh.order_id' . $url, 'SSL');
		$data['sort_delivery_name'] = $this->url->link('delivery/history', 'token=' . $this->session->data['token'] . '&sort=ds.delivery_staff_name' . $url, 'SSL');
		$data['sort_add_time'] = $this->url->link('delivery/history', 'token=' . $this->session->data['token'] . '&sort=dh.add_time' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('delivery/history', 'token=' . $this->session->data['token'] . '&sort=dh.status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_delivery_name'])) {
			$url .= '&filter_delivery_name=' . urlencode(html_entity_decode($this->request->get['filter_delivery_name'], ENT_QUOTES, 'UTF-8'));
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

		$pagination = new Pagination();
		$pagination->total = $delivery_history_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('delivery/history', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($delivery_history_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($delivery_history_total - $this->config->get('config_limit_admin'))) ? $delivery_history_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $delivery_history_total, ceil($delivery_history_total / $this->config->get('config_limit_admin')));

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_delivery_name'] = $filter_delivery_name;
		$data['filter_city_id'] = $filter_city_id;
		$data['filter_service_zone_id'] = $filter_service_zone_id;
		$data['filter_delivery_area_id'] = $filter_delivery_area_id;
		$data['filter_status'] = $filter_status;
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

		$this->response->setOutput($this->load->view('delivery/history_list.tpl', $data));
	}
}
