<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-3
 * 描述: 配送计划的DB相关处理类  model
 * TODO: 考虑使用cache
 */
class ModelDeliverySchedule extends Model {
	public function getDeliveryStaffsByCurrentMoment($delivery_area_id) {
		// condition:start_date <= 当前日期  && end_date > 当前日期  && start_time <= 当前时间  && end_time > 当前时间
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_schedule WHERE delivery_area_id = '" . (int)$delivery_area_id . "' AND start_date <= curdate() AND end_date >= curdate() AND start_time <= curtime() AND end_time > curtime() AND status = '1'");

		return $query->rows;
	}

}