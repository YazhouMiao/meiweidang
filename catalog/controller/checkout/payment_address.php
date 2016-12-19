<?php
class ControllerCheckoutPaymentAddress extends Controller {
	public function index() {
		$this->load->language('checkout/checkout');

		$data['text_address_existing'] = $this->language->get('text_address_existing');
		$data['text_address_new'] = $this->language->get('text_address_new');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_other_address'] = $this->language->get('text_other_address');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		// myzhou 添加telephone/delivery
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_delivery_area'] = $this->language->get('entry_delivery_area');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		// 默认地址id
		if (isset($this->session->data['payment_address']['address_id'])) {
			$data['address_id'] = $this->session->data['payment_address']['address_id'];
		} else {
			$data['address_id'] = $this->customer->getAddressId();
		}

		$this->load->model('account/address');

		// 该服务区中的所有地址
		$data['addresses'] = $this->model_account_address->getAddresses(true);
		
		// myzhou 2015/7/9 获取已存地址
		$data['other_addresses'] = array();
		if(!empty($data['addresses'])){
			// 默认地址
			if(isset($data['addresses'][$data['address_id']])) {
				$data['default_address'] = $data['addresses'][$data['address_id']];
			} else {
				// 取不到就默认第一个
				$data['default_address'] = reset($data['addresses']);
			}
			// 其他地址
			$data['other_addresses'] = $data['addresses'];
			unset($data['other_addresses'][$data['default_address']['address_id']]);
		}
		
		// Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		if (isset($this->session->data['payment_address']['custom_field'])) {
			$data['payment_address_custom_field'] = $this->session->data['payment_address']['custom_field'];
		} else {
			$data['payment_address_custom_field'] = array();
		}

		// 获取新地址的默认值：姓名、电话、配送范围
		$data['firstname'] = $this->customer->getFirstName();
		$data['telephone'] = $this->customer->getTelephone();
		
		$this->load->model('localisation/delivery_area');
		$data['delivery_areas'] = $this->model_localisation_delivery_area->getDeliveryAreasByServiceZone($this->session->data['service_zone_id']);

		
		// 配送方式
		if (isset($this->session->data['payment_address'])) {
			// Shipping Methods
			$method_data = array();
		
			$this->load->model('extension/extension');
		
			$results = $this->model_extension_extension->getExtensions('shipping');
		
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);
		
					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($this->session->data['payment_address']);
		
					if ($quote) {
						$method_data[$result['code']] = array(
							'title'      => $quote['title'],
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}
		
			$sort_order = array();
		
			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
		
			array_multisort($sort_order, SORT_ASC, $method_data);
		
			$this->session->data['shipping_methods'] = $method_data;
		}
		
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		
		if (empty($this->session->data['shipping_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['shipping_methods'])) {
			$data['shipping_methods'] = $this->session->data['shipping_methods'];
		} else {
			$data['shipping_methods'] = array();
		}
		
		if (isset($this->session->data['shipping_method']['code'])) {
			$data['code'] = $this->session->data['shipping_method']['code'];
		} else {
			$data['code'] = '';
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment_address.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/payment_address.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/payment_address.tpl', $data));
		}
	}

	public function save() {
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate if customer is logged in.
		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}

		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
		
		if (!isset($this->request->post['shipping_method'])) {
			$json['error']['warning'] = $this->language->get('error_shipping');
		} else {
			$shipping = explode('.', $this->request->post['shipping_method']);
		
			if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
				$json['error']['warning'] = $this->language->get('error_shipping');
			}
		}
		
		if (!$json) {
			if (isset($this->request->post['payment_address']) && $this->request->post['payment_address'] == 'existing') {
				$this->load->model('account/address');

				if (empty($this->request->post['address_id'])) {
					$json['error']['warning'] = $this->language->get('error_address');
				} elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses(true)))) {
					$json['error']['warning'] = $this->language->get('error_address');
				}

				if (!$json) {
					// Default Payment Address
					$this->load->model('account/address');

					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->request->post['address_id']);

					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
					
					// myzhou 2015/5/16 账单地址和配送地址合并
					$this->session->data['shipping_address'] = $this->session->data['payment_address'];
					
					// shipping method
					$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
				}
			} else {
				if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
					$json['error']['firstname'] = $this->language->get('error_firstname');
				}
                // myzhou 2015/5/15 添加telephone验证
				if ((utf8_strlen($this->request->post['telephone']) < 8) || (utf8_strlen($this->request->post['telephone']) > 32)) {
					$json['error']['telephone'] = $this->language->get('error_telephone');
				}
				
				if ((utf8_strlen(trim($this->request->post['address_1'])) < 1) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
					$json['error']['address_1'] = $this->language->get('error_address_1');
				}
                
				// Custom field validation
				$this->load->model('account/custom_field');

				$custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

				foreach ($custom_fields as $custom_field) {
					if (($custom_field['location'] == 'address') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
						$json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
					}
				}

				// 添加新地址的参数
				$params['firstname'] = $this->request->post['firstname'];
				$params['lastname']  = '';
				$params['telephone'] = $this->request->post['telephone'];
				$params['address_1'] = $this->request->post['address_1'];
				$params['address_2'] = '';
				$params['postcode']  = '';
				$params['city']      = $this->session->data['city'];
				$params['zone_id']   = 0;
				$params['country_id'] = 0;
				$params['service_zone_id']  = $this->session->data['service_zone_id'];
				
				if (!$json) {
					// Default Payment Address
					$this->load->model('account/address');

					$address_id = $this->model_account_address->addAddress($params);

					$this->session->data['payment_address'] = $this->model_account_address->getAddress($address_id);

					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);

					// myzhou 2015/5/16 账单地址和配送地址合并
					$this->session->data['shipping_address'] = $this->session->data['payment_address'];
					
					// shipping method
					$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];

					$this->load->model('account/activity');

					$activity_data = array(
						'customer_id' => $this->customer->getId(),
						'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
					);

					$this->model_account_activity->addActivity('address_add', $activity_data);
				}
			}
		}
		
		// myzhou 2015/7/20 加载payment_method页面
		if (!$json) {
			$json['payment_method_html'] = $this->load->controller('checkout/payment_method');	
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}