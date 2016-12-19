<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-4
 * 描述: 配送人员相关的DB处理类 model
 */
class ModelDeliveryStaff extends Model {
	public function getDeliveryStaff($delivery_staff_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_staff WHERE delivery_staff_id = '" . (int)$delivery_staff_id . "'");

		return $query->row;
	}

	public function getDeliveryStaffByOpenid($openid) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_staff WHERE openid = '" . $openid . "'");
	
		return $query->row;
	}
}