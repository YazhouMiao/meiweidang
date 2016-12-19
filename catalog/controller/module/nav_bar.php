<?php
/**
 * 作者: myzhou
 * 时间: 2015-8-17
 * 描述: 导航栏模块 controller
 */
class ControllerModuleNavBar extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->language('module/nav_bar');
		
		$data['text_category'] = $this->language->get('text_category');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_account'] = $this->language->get('text_account');
		
		// home
		$data['home'] = array();
		$data['home']['title'] = $this->language->get('text_home');
		$data['home']['link'] = $this->url->link('common/home', '', 'SSL');

		if(!isset($this->request->get['route']) || $this->request->get['route'] == 'common/home'){
			$data['home']['status'] = true;
		} else {
			$data['home']['status'] = false;
		}
		
		// category
		$data['category'] = array();
		$data['category']['title'] = $this->language->get('text_category');
		$data['category']['link'] = $this->url->link('common/category', '', 'SSL');

		if(isset($this->request->get['route']) && $this->request->get['route'] == 'common/category'){
			$data['category']['status'] = true;
		} else {
			$data['category']['status'] = false;
		}
		
		// cart
		$data['cart'] = array();
		$data['cart']['title'] = $this->language->get('text_cart');
		$data['cart']['link'] = $this->url->link('checkout/cart', '', 'SSL');
		
		if(isset($this->request->get['route']) && $this->request->get['route'] == 'checkout/cart'){
			$data['cart']['status'] = true;
		} else {
			$data['cart']['status'] = false;
		}
		
		$data['cart_count'] = $this->cart->countProducts();
		
		// account
		$data['account'] = array();
		$data['account']['title'] = $this->language->get('text_account');
		$data['account']['link'] = $this->url->link('account/account', '', 'SSL');
		
		if(isset($this->request->get['route']) && $this->request->get['route'] == 'account/account'){
			$data['account']['status'] = true;
		} else {
			$data['account']['status'] = false;
		}

		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/nav_bar.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/nav_bar.tpl', $data);
		} else {
			return $this->load->view('default/template/module/nav_bar.tpl', $data);
		}
	}
}