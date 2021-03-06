<?php
/**
 * 作者: myzhou
 * 时间: 2015-7-11
 * 描述: TODO
 */
class ModelPaymentWxpayNative extends Model {
	public function getMethod($address) {
		$this->load->language('payment/wxpay_native');

		if ($this->config->get('wxpay_native_status') && !$this->request->isMobile()) {
			$status = TRUE;
		} else {
			$status = FALSE;
		}

		$method_data = array();

		$this->load->model('tool/image');
		if ($status) {
			// 支付宝logo
			if ($this->config->get('wxpay_native_logo') && is_file(DIR_IMAGE . $this->config->get('wxpay_native_logo'))) {
				$logo = $this->model_tool_image->resize($this->config->get('wxpay_native_logo'), 150, 50);
			} else {
				$logo = $this->model_tool_image->resize('no_image.png', 150, 50);
			}

			$method_data = array(
					'code'       => 'wxpay_native',
					'title'      => $this->language->get('text_title'),
					'terms'      => '',
					'logo'       => $logo,
					'sort_order' => $this->config->get('wxpay_native_sort_order')
			);
		}

		return $method_data;
	}
}