<?php
/**
 * 作者: myzhou
 * 时间: 2015-7-21
 * 描述: 微信公众号支付
 */
class ModelPaymentWxpayJsapi extends Model {
	public function getMethod($address) {
		$this->load->language('payment/wxpay_native');

		if ($this->config->get('wxpay_jsapi_status') && $this->weixin->getWxVersion()) {
			$status = TRUE;
		} else {
			$status = FALSE;
		}

		$method_data = array();

		$this->load->model('tool/image');
		if ($status) {
			// 微信支付logo
			if ($this->config->get('wxpay_jsapi_logo') && is_file(DIR_IMAGE . $this->config->get('wxpay_jsapi_logo'))) {
				$logo = $this->model_tool_image->resize($this->config->get('wxpay_jsapi_logo'), 50, 50);
			} else {
				$logo = $this->model_tool_image->resize('no_image.png', 150, 50);
			}

			$method_data = array(
				'code'       => 'wxpay_jsapi',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'logo'       => $logo,
				'sort_order' => $this->config->get('wxpay_jsapi_sort_order')
			);
		}

		return $method_data;
	}
}