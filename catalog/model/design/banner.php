<?php
class ModelDesignBanner extends Model {
	public function getBanner($banner_id) {
		// myzhou 2015/8/28 add service_zone_id IN (0,session['service_zone_id'])
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image bi LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE bi.banner_id = '" . (int)$banner_id . "' AND bi.service_zone_id IN ('0', '" . (int)$this->session->data['service_zone_id'] . "') AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");

		return $query->rows;
	}
}