<?php
class ModelPaymentCOD extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/cod');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('cod_total') > 0 && $this->config->get('cod_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('cod_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		$this->load->model('tool/image');
		if ($status) {
			// 货到付款logo
			if ($this->config->get('cod_logo') && is_file(DIR_IMAGE . $this->config->get('cod_logo'))) {
				$logo = $this->model_tool_image->resize($this->config->get('alipay_logo'), 50, 50);
			} else {
				$logo = $this->model_tool_image->resize('no_image.png', 50, 50);
			}
			
			$method_data = array(
				'code'       => 'cod',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'logo'       => $logo,
				'sort_order' => $this->config->get('cod_sort_order')
			);
		}

		return $method_data;
	}
}