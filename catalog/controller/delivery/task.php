<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-16
 * 描述: 配送人员查看当前任务相关的controller
 */
class ControllerDeliveryTask extends Controller {
	private $error = array();
	private $staff_info = array();

	public function index() {
		// 判断是不是配送人员
		if (!$this->validateLogin()) {
			$this->session->data['redirect'] = $this->url->link('delivery/task', '', 'SSL');
		
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->getList();
	}

	/*
	 * 查看单个订单的配送状况
	 */
	public function single(){
		$data['error'] = array();
		if (isset($this->error['delivery_staff'])) {
			$data['error']['delivery_staff'] = $this->error['delivery_staff'];
		} else {
			$data['error']['delivery_staff'] = '';
		}
		
		if (isset($this->error['order'])) {
			$data['error']['order'] = $this->error['order'];
		} else {
			$data['error']['order'] = '';
		}
		
		if (isset($this->error['permission'])) {
			$data['error']['permission'] = $this->error['permission'];
		} else {
			$data['error']['permission'] = '';
		}
		
		if (isset($this->error['status'])) {
			$data['error']['status'] = $this->error['status'];
		} else {
			$data['error']['status'] = '';
		}

		if(isset($this->request->get['order_id'])){
			$data['order_id'] = $this->request->get['order_id'];
		} else {
			$data['order_id'] = 0;
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		// 判断是不是配送人员
		if (!$this->validateLogin()) {
			$this->session->data['redirect'] = $this->url->link('delivery/task/single', 'order_id=' . $data['order_id'], 'SSL');
		
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$this->load->language('delivery/task');
		$data['heading_title'] = sprintf($this->language->get('heading_title'), $data['order_id']);

		// 订单信息
		$this->load->model('delivery/task');
		
		$order_info = $this->model_delivery_task->getOrder($data['order_id']);
		
		if ($order_info) {
			$this->document->setTitle($this->language->get('text_task_single'));
		
			// 配送信息
			$data['delivery_info'] = array();
			
			$data['delivery_status'] = $order_info['delivery_status'];
			if(0 == $data['delivery_status']){
				$status = $this->language->get('text_status_0');
			} elseif (1 == $data['delivery_status']){
				$status = $this->language->get('text_status_1');
			} elseif (2 == $data['delivery_status']){
				$status = $this->language->get('text_status_2');
			} elseif (3 == $data['delivery_status']){
				$status = $this->language->get('text_status_3');
			}
			$data['delivery_info'] = array(
				'add_time'            => $order_info['add_time'],
				'status'              => $status,
				'delivery_name'       => $order_info['delivery_name'],
				'delivery_telephone'  => $order_info['delivery_telephone'],
			);

			// 发票
			if ($order_info['invoice_no']) {
				$data['invoice'] = $this->language->get('text_invoice_yes');
			} else {
				$data['invoice'] = $this->language->get('text_invoice_no');
			}
		
			$data['date_added'] = $order_info['date_added'];
		
			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{customer_name}'. "\n" . '{company}' . "\n" . '{service_zone} , {delivery_area} , {address}';
			}
		
			$find = array(
				'{customer_name}',
				'{company}',
				'{service_zone}',
				'{delivery_area}',
				'{address}'
			);
		
			$replace = array(
				'customer_name'   => $order_info['customer_name'],
				'company'         => $order_info['company'],
				'service_zone'    => $order_info['service_zone'],
				'delivery_area'   => $order_info['delivery_area'],
				'address'         => $order_info['customer_address']
			);
		
			$data['customer_telephone'] = $order_info['customer_telephone'];
			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		
			if($order_info['payment_code'] == 'cod'){
				$data['payment_status'] = $this->language->get('text_paid');
			} else {
				$data['payment_status'] = $this->language->get('text_non_payment');
			}
		
			$data['shipping_method'] = $order_info['shipping_method'];
		
			// Products
			$this->load->model('catalog/product');
			$this->load->model('catalog/manufacturer');
		
			$data['products'] = array();
		
			$products = $this->model_delivery_task->getOrderProducts($data['order_id']);
		
			foreach ($products as $product) {
				$option_data = array();
		
				$options = $this->model_delivery_task->getOrderOptions($data['order_id'], $product['order_product_id']);
		
				foreach ($options as $option) {
					$value = $option['value'];

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}
				
				$manufacturer = $this->model_catalog_manufacturer->getManufacturerByProductId($product['product_id']);
				
				$product_info[] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'business_id' => $manufacturer['manufacturer_id'],
					'business_name' => $manufacturer['name'],
					'business_address'    => $manufacturer['address'],
					'business_telephone'  => $manufacturer['telephone']
				);
			}
			
			// 按business_id分组
			foreach($product_info as $k => $value){
				$data['products'][$value['business_id']][] = $value;
			}
			
			$data['comment'] = nl2br($order_info['comment']);

			// Totals
			$data['totals'] = array();
			
			$totals = $this->model_delivery_task->getOrderTotals($this->request->get['order_id']);
			
			foreach ($totals as $total) {
				$data['totals'][] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}
			
			// language
			// Text
			$data['text_order_detail']     = $this->language->get('text_order_detail');
			$data['text_invoice']          = $this->language->get('text_invoice');
			$data['text_telephone']        = $this->language->get('text_telephone');
			$data['text_delivery_status']  = $this->language->get('text_delivery_status');
			$data['text_date_added']       = $this->language->get('text_date_added');
			$data['text_payment_address']  = $this->language->get('text_payment_address');
			$data['text_shipping_method']  = $this->language->get('text_shipping_method');
			$data['text_payment_status']   = $this->language->get('text_payment_status');
			$data['text_products']         = $this->language->get('text_products');
			$data['text_total']            = $this->language->get('text_total');
			$data['text_comment']          = $this->language->get('text_comment');
			$data['text_empty']            = $this->language->get('text_empty');
			$data['text_error']            = $this->language->get('text_error');
			$data['text_action']           = $this->language->get('text_action');
			
			$data['text_delivery_name']      = $this->language->get('text_delivery_name');;
			$data['text_delivery_telephone'] = $this->language->get('text_delivery_telephone');;
			$data['text_add_time']           = $this->language->get('text_add_time');
			
			$data['text_products']         = $this->language->get('text_products');
			$data['text_business']         = $this->language->get('text_business');
			$data['text_business_name']    = $this->language->get('text_business_name');
			$data['text_business_address']     = $this->language->get('text_business_address');
			$data['text_business_telephone']   = $this->language->get('text_business_telephone');
			$data['text_product']        = $this->language->get('text_product');
			$data['text_name']           = $this->language->get('text_name');
			$data['text_model']          = $this->language->get('text_model');
			$data['text_quantity']       = $this->language->get('text_quantity');
			$data['text_price']          = $this->language->get('text_price');
			$data['text_unit']           = $this->language->get('text_unit');
			$data['text_total']          = $this->language->get('text_total');
			$data['text_comment']        = $this->language->get('text_comment');
			
			// Button
			$data['button_got']       = $this->language->get('button_got');
			$data['button_delivered'] = $this->language->get('button_delivered');
			$data['button_returned']  = $this->language->get('button_returned');
			$data['button_task_list'] = $this->language->get('button_task_list');
			
			$data['got']       = $this->url->link('delivery/task/addSingle', 'order_id='.$data['order_id'].'&status=1', 'SSL');
			$data['delivered'] = $this->url->link('delivery/task/addSingle', 'order_id='.$data['order_id'].'&status=2', 'SSL');
			$data['returned']  = $this->url->link('delivery/task/addSingle', 'order_id='.$data['order_id'].'&status=3', 'SSL');
			$data['task_list'] = $this->url->link('delivery/task', '', 'SSL');
			
			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wishlist.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/delivery/task_single.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/delivery/task_single.tpl', $data));
			}
		} else {
			$data['text_error'] = $this->language->get('text_error');
			
			$data['button_continue'] = $this->language->get('button_continue');
			
			$data['continue'] = $this->url->link('delivery/task', '', 'SSL');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function getList() {

		$this->load->language('delivery/task');
		
		$this->document->setTitle($this->language->get('list_title'));
		
		$this->load->model('delivery/task');

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = 0;
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

		$url = '';

		if (isset($filter_status)) {
			$url .= '&filter_status=' . $filter_status;
		}

		if (isset($sort)) {
			$url .= '&sort=' . $sort;
		}

		if (isset($order)) {
			$url .= '&order=' . $order;
		}


		$data['delivery_tasks'] = array();

		$filter_data = array(
			'filter_status'            => $filter_status,
			'sort'                     => $sort,
			'order'                    => $order,
			'delivery_staff_id'        => $this->staff_info['id']
		);

		$results = $this->model_delivery_task->getDeliveryTasks($filter_data);

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

				$data['delivery_tasks'][] = array(
					'order_id'       => $result['order_id'],
					'delivery_area'  => $result['delivery_area'],
					'address'        => $result['address'],
					'company'        => $result['company'],
					'date_added'       => date('m-d H:m',strtotime($result['date_added'])),
					'business_name'  => $result['business_name'],
					'product_name'   => $result['product_name'],
					'status'         => $status,
					'quantity'       => $result['quantity'],
					'link'           => $this->url->link('delivery/task/single', '&order_id=' . $result['order_id'] . $url, 'SSL')
				);
			}
		} else {
			$data['delivery_tasks'] = array();
		}

		$data['text_list']     = sprintf($this->language->get('text_list'), $this->staff_info['name']);
		$data['text_success']  = $this->language->get('text_success');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_status_0'] = $this->language->get('text_status_0');
		$data['text_status_1'] = $this->language->get('text_status_1');
		$data['text_status_2'] = $this->language->get('text_status_2');
		$data['text_status_3'] = $this->language->get('text_status_3');
		$data['text_confirm']   = $this->language->get('text_confirm');
		$data['text_no_selected'] = $this->language->get('text_no_selected');

		// Column
		$data['column_order_id']         = $this->language->get('column_order_id');
		$data['column_business_name']    = $this->language->get('column_business_name');
		$data['column_product_name']     = $this->language->get('column_product_name');
		$data['column_quantity']         = $this->language->get('column_quantity');
		$data['column_status']           = $this->language->get('column_status');
		$data['column_address']          = $this->language->get('column_address');
		$data['column_date_added']       = $this->language->get('column_date_added');

		// Entry
		$data['entry_status']          = $this->language->get('entry_status');

		// Button
		$data['button_filter'] = $this->language->get('button_filter');
		if($filter_status == 0){
			$data['button_action'] = $this->language->get('button_got');
		} else if($filter_status == 1){
			$data['button_action'] = $this->language->get('button_delivered');
		}
		
		$data['action'] = $this->url->link('delivery/task/addList', $url, 'SSL');

		$data['error'] = array();

		if (isset($this->error['order'])) {
			$data['error']['order'] = $this->error['order'];
		} else {
			$data['error']['order'] = '';
		}
		
		if (isset($this->error['status'])) {
			$data['error']['status'] = $this->error['status'];
		} else {
			$data['error']['status'] = '';
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

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		$data['sort_order_id'] = $this->url->link('delivery/task', '&sort=dh.order_id' . $url, 'SSL');
		$data['sort_business_name'] = $this->url->link('delivery/task', '&sort=ma.name' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('delivery/task', '&sort=o.date_added' . $url, 'SSL');
		$data['sort_quantity'] = $this->url->link('delivery/task', '&sort=op.quantity' . $url, 'SSL');

		$data['filter_status'] = $filter_status;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['footer'] = $this->load->controller('common/footer');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/delivery/task_list.tpl', $data));
		} else {
				$this->response->setOutput($this->load->view('default/template/delivery/task_list.tpl', $data));
		}
	}

	/*
	 * 在single页面添加单个订单的配送状态
	 */
	public function addSingle() {
		if(isset($this->request->get['order_id'])){
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}
		
		if(isset($this->request->get['status'])){
			$status = $this->request->get['status'];
		} else {
			$status = 0;
		}

		// 判断是不是配送人员
		if (!$this->validateLogin()) {
			$this->session->data['redirect'] = $this->url->link('delivery/task/single', 'order_id=' . $order_id, 'SSL');
		
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('delivery/task');

		if ($this->validateAddSingle($order_id, $status)) {
			$this->load->model('delivery/history');
			$this->load->model('delivery/task');
			
			$this->model_delivery_history->addDeliveryHistory($order_id, $this->staff_info['id'], $status);
			
			// 订单状态(配送状态和订单状态相差1)
			$order_status = $status + 1;
			$this->model_delivery_task->addOrderHistory($order_id, $order_status);
			
			$this->session->data['success'] = $this->language->get('text_success');
		} 
		
		$this->response->redirect($this->url->link('delivery/task/single', 'order_id='.$order_id, 'SSL'));
	}
	
	/*
	 * 在list页面添加多个订单的配送状态
	 */
	public function addList() {
		
		// 判断是不是配送人员
		if (!$this->validateLogin()) {
			$this->session->data['redirect'] = $this->url->link('delivery/task', '' , 'SSL');
		
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('delivery/task');
		
		$id_array = array();
		// 删除重复的order_id
		if (isset($this->request->post['selected']) && isset($this->request->get['filter_status'])){
			$status = $this->request->get['filter_status'];
			foreach ($this->request->post['selected'] as $order_id) {
				if(!in_array($order_id, $id_array)){
					array_push($id_array, $order_id);
				}
			}
		}
		
		if (!empty($id_array) && isset($status) && $this->validateAddList($id_array, $status)) {
			$this->load->model('delivery/history');
			$this->load->model('delivery/task');
			// 新配送状态
			$new_status = $status + 1;
			// 订单状态
			$order_status = $new_status + 1;

			foreach ($id_array as $order_id) {
				$this->model_delivery_history->addDeliveryHistory($order_id, $this->staff_info['id'], $new_status);
				$this->model_delivery_task->addOrderHistory($order_id, $order_status);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
				
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
				
			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'ASC';
			}
			
			$this->response->redirect($this->url->link('delivery/task', $url , 'SSL'));
		}

		$this->getList();
	}
	
	/*
	 * 验证是否可以添加新配送历史
	 * 满足以下条件,即可通过验证
	 * 1：订单与配送人员在同一个服务区
	 * 2：当前配送状态<=2(2:已验收/3:送回商家) && 小于$status
	 */
	protected function validateAddSingle($order_id, $status) {
		$this->load->model('delivery/task');
		
		$order_query = $this->model_delivery_task->getOrder($order_id);
		if(empty($order_query)){
			$this->error['order'] = $this->language->get('error_order');
			return !$this->error;
		} 

		if(($order_query['service_zone_id'] != $this->staff_info['service_zone_id'])){
			$this->error['permission'] = $this->language->get('error_delivery_staff');
			return !$this->error;
		}

		if(($order_query['delivery_status'] >= $status) || ($order_query['delivery_status'] >= 2)){
			$this->error['status'] = $this->language->get('error_status');
			return !$this->error;
		}
		
		return true;
	}
	
	/*
	 * @param $order_ids 被验证的order_id array
	 * @param $order_ids 对应的配送状态
	 * 验证选中的list是否都可以添加新配送历史
	* list中每个元素满足以下条件,即可通过验证
	* 1：订单与配送人员在同一个服务区
	* 2：当前配送状态<=2(2:已验收/3:送回商家) && 小于$status
	*/
	protected function validateAddList($order_ids = array(), $status) {
		$this->load->model('delivery/task');
		
		$error_order = array();
		$error_status = array();
		
		$new_status = $status + 1; 
		foreach ($order_ids as $order_id) {
			$order_query = $this->model_delivery_task->getOrder($order_id);
			if(empty($order_query)){
				array_push($error_order, $order_id);
			}
	
			if(($order_query['delivery_status'] >= $new_status) || ($order_query['delivery_status'] >= 2)){
				array_push($error_status, $order_id);
			}
		}
		
		if(!empty($error_order)){
			$list_str = implode(" , ", $error_order);
			$this->error['order'] = sprintf($this->language->get('error_list_order'), $list_str);
		}
		
		if(!empty($error_status)){
			$list_str = implode(" , ", $error_status);
			$this->error['status'] = sprintf($this->language->get('error_list_status'), $list_str);
		}
	
		return !$this->error;
	}
	
	/*
	 * 验证是否是可用配送人员
	* 满足以下条件,即可通过验证
	* 1：已经登录
	* 2：属于配送人员群组
	* 3：关注爱佰味公众号
	* 4：配送人员状态 = 1
	*/
	protected function validateLogin(){
		if (!$this->customer->isLogged() || $this->customer->getGroupId() != $this->config->get('config_deliverer_group_id')) {
			return false;
		} else {
			$this->load->model('weixin/wx_customer');
			$customer = $this->model_weixin_wx_customer->getWxCustomerByCustomerId($this->customer->getId());
			if(!isset($customer['openid'])){
				return false;
			} else {
				$this->load->model('delivery/staff');
				$staff = $this->model_delivery_staff->getDeliveryStaffByOpenid($customer['openid']);
				if(empty($staff) || !$staff['status']){
					return false;
				} else {
					// staff_info
					$this->staff_info['id'] = $staff['delivery_staff_id'];
					$this->staff_info['name'] = $staff['delivery_staff_name'];
					$this->staff_info['telephone'] = $staff['telephone'];
					$this->staff_info['openid'] = $staff['openid'];
					$this->staff_info['service_zone_id'] = $staff['service_zone_id'];
					return true;
				}
			}
		}
	}
}
	
