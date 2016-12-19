<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-22
 * 描述: 微信用户登录 controller
 */
class ControllerWeixinWxlogin extends Controller {
	public function index($openid) {
		$this->load->model('weixin/wx_customer');
	
		if ($this->customer->isLogged()) {
			return;
		}
		// 微信用户自动登录
		if ($this->customer->weixin_login($openid)) {
			unset($this->session->data['guest']);

			// Default Shipping Address
			$this->load->model('account/address');
	
			if (($this->config->get('config_tax_customer') == 'payment') || ($this->config->get('config_tax_customer') == 'shipping')) {
				$this->session->data['payment_address']  = $this->model_account_address->getAddress($this->customer->getAddressId());
				$this->session->data['shipping_address'] = $this->session->data['payment_address'];
			}
	
			// Add to activity log
			$this->load->model('account/activity');
	
			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName()
			);
	
			$this->model_account_activity->addActivity('login', $activity_data);
		}
	}
}