<?php
class ControllerCheckoutGuest extends Controller {
	public function index() {
		$this->load->language('checkout/checkout');

		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_your_details'] = $this->language->get('text_your_details');
		$data['text_your_account'] = $this->language->get('text_your_account');
		$data['text_your_address'] = $this->language->get('text_your_address');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_select_delivery_area'] = $this->language->get('text_select_delivery_area');
		$data['text_placeholder_name']      = $this->language->get('text_placeholder_name');
		$data['text_placeholder_telephone'] = $this->language->get('text_placeholder_telephone');
		$data['text_placeholder_company']   = $this->language->get('text_placeholder_company');
		$data['text_placeholder_address']   = $this->language->get('text_placeholder_address');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_delivery_area'] = $this->language->get('entry_delivery_area');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		$data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$this->load->model('account/customer_group');

			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$data['customer_groups'][] = $customer_group;
				}
			}
		}

		if (isset($this->session->data['guest']['customer_group_id'])) {
			$data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
		} else {
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}

		if (isset($this->session->data['guest']['firstname'])) {
			$data['firstname'] = $this->session->data['guest']['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->session->data['guest']['lastname'])) {
			$data['lastname'] = $this->session->data['guest']['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->session->data['guest']['email'])) {
			$data['email'] = $this->session->data['guest']['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->session->data['guest']['telephone'])) {
			$data['telephone'] = $this->session->data['guest']['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->session->data['guest']['fax'])) {
			$data['fax'] = $this->session->data['guest']['fax'];
		} else {
			$data['fax'] = '';
		}

		if (isset($this->session->data['payment_address']['company'])) {
			$data['company'] = $this->session->data['payment_address']['company'];
		} else {
			$data['company'] = '';
		}

		if (isset($this->session->data['payment_address']['address_1'])) {
			$data['address_1'] = $this->session->data['payment_address']['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->session->data['payment_address']['address_2'])) {
			$data['address_2'] = $this->session->data['payment_address']['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->session->data['payment_address']['postcode'])) {
			$data['postcode'] = $this->session->data['payment_address']['postcode'];
		} elseif (isset($this->session->data['shipping_address']['postcode'])) {
			$data['postcode'] = $this->session->data['shipping_address']['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->session->data['payment_address']['city'])) {
			$data['city'] = $this->session->data['payment_address']['city'];
		} else {
			$data['city'] = '';
		}
		
		// myzhou 2015/7/18 添加delivery_areas
		$this->load->model('localisation/delivery_area');
		$data['delivery_areas'] = $this->model_localisation_delivery_area->getDeliveryAreasByServiceZone($this->session->data['service_zone_id']);
        // end

		// Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields();

		if (isset($this->session->data['guest']['custom_field'])) {
			if (isset($this->session->data['guest']['custom_field'])) {
				$guest_custom_field = $this->session->data['guest']['custom_field'];
			} else {
				$guest_custom_field = array();
			}
			
			if (isset($this->session->data['payment_address']['custom_field'])) {
				$address_custom_field = $this->session->data['payment_address']['custom_field'];
			} else {
				$address_custom_field = array();
			}
						
			$data['guest_custom_field'] = $guest_custom_field + $address_custom_field;
		} else {
			$data['guest_custom_field'] = array();
		}

		$data['shipping_required'] = $this->cart->hasShipping();

		if (isset($this->session->data['guest']['shipping_address'])) {
			$data['shipping_address'] = $this->session->data['guest']['shipping_address'];
		} else {
			$data['shipping_address'] = true;
		}
		
		// 配送方式
		if ($data['shipping_required']) {
			// Shipping Methods
			$method_data = array();
		
			$this->load->model('extension/extension');
		
			$results = $this->model_extension_extension->getExtensions('shipping');
		
			$shipping_address = array();
			// TODO:临时使用,当配送方式完善之后可删除
			$shipping_address['country_id'] = 0;
			$shipping_address['zone_id'] = 0;

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);
		
					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);
		
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

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/guest.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/guest.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/guest.tpl', $data));
		}
	}

	public function save() {
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate if customer is logged in.
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Check if guest checkout is available.
		if (!$this->config->get('config_checkout_guest') || $this->config->get('config_customer_price') || $this->cart->hasDownload()) {
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
			if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}
			
			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
				$json['error']['telephone'] = $this->language->get('error_telephone');
			}
			
			if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
				$json['error']['address_1'] = $this->language->get('error_address_1');
			}
			
			// Customer Group
			if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
				$customer_group_id = $this->request->post['customer_group_id'];
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}

			// Custom field validation
			$this->load->model('account/custom_field');

			$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
					$json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
				}
			}
		}

		if (!$json) {
			$this->session->data['account'] = 'guest';
            // 联系人信息
			$this->session->data['guest']['customer_group_id'] = $customer_group_id;
			$this->session->data['guest']['firstname'] = $this->request->post['firstname'];
			// myzhou 2015/5/15 lastname/email/fax赋空值
			$this->session->data['guest']['lastname'] = '';
			$this->session->data['guest']['email'] = '';
			$this->session->data['guest']['fax'] = '';

			if (isset($this->request->post['custom_field']['account'])) {
				$this->session->data['guest']['custom_field'] = $this->request->post['custom_field']['account'];
			} else {
				$this->session->data['guest']['custom_field'] = array();
			}
            // 联系地址
			$this->session->data['payment_address']['telephone'] = $this->request->post['telephone'];
			$this->session->data['payment_address']['firstname'] = $this->request->post['firstname'];
			$this->session->data['payment_address']['company'] = '';
			$this->session->data['payment_address']['address_1'] = $this->request->post['address_1'];
			// myzhou 2015/5/15 lastname/address_2/postcode/city/country_id/zone_id/country/iso_code_2/iso_code_3/address_format赋空值
			$this->session->data['payment_address']['lastname'] = '';
			$this->session->data['payment_address']['address_2'] = '';
			$this->session->data['payment_address']['postcode'] = '';
			$this->session->data['payment_address']['city'] = '';
			$this->session->data['payment_address']['country_id'] = 0;
			$this->session->data['payment_address']['zone_id'] = 0;
			$this->session->data['payment_address']['country'] = '';
			$this->session->data['payment_address']['iso_code_2'] = '';
			$this->session->data['payment_address']['iso_code_3'] = '';
			$this->session->data['payment_address']['address_format'] = '';
			$this->session->data['payment_address']['service_zone_id'] = $this->session->data['service_zone_id'];
			$this->load->model('localisation/service_zone');
			$result = $this->model_localisation_service_zone->getServiceZone($this->session->data['service_zone_id']);
			$this->session->data['payment_address']['service_zone_name'] = $result['service_zone_name'];
			$this->session->data['payment_address']['delivery_area_id'] = 0;
			$this->session->data['payment_address']['delivery_area_name'] = '';

			if (isset($this->request->post['custom_field']['address'])) {
				$this->session->data['payment_address']['custom_field'] = $this->request->post['custom_field']['address'];
			} else {
				$this->session->data['payment_address']['custom_field'] = array();
			}

			$this->session->data['payment_address']['zone'] = '';
			$this->session->data['payment_address']['zone_code'] = '';

			// myzhou 2015/5/15 默认账单地址和配送地址相同
			$this->session->data['shipping_address'] = $this->session->data['payment_address'];

			// shipping method
			$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
					
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			
			// myzhou 2015/7/20 加载payment_method页面
			$json['payment_method_html'] = $this->load->controller('checkout/payment_method');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}