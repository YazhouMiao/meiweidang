<?php
/**
 * 作者: myzhou
 * 时间: 2015-7-14
 * 描述: 购物车页面展示订单总额 controller
 */
class ControllerCheckoutTotals extends Controller {
	
	public function index() {
		// Totals
		$this->load->model('extension/extension');
		
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		
		// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array();
		
			$results = $this->model_extension_extension->getExtensions('total');
		
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
		
			array_multisort($sort_order, SORT_ASC, $results);
		
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}
		
			$sort_order = array();
		
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
		
			array_multisort($sort_order, SORT_ASC, $total_data);
		}
		
		$data['totals'] = array();
		
		foreach ($total_data as $total) {
			$data['totals'][] = array(
					'code'  => $total['code'],
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/totals.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/checkout/totals.tpl', $data);
		} else {
			return $this->load->view('default/template/checkout/totals.tpl', $data);
		}
	}
}