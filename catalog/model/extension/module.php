<?php
class ModelExtensionModule extends Model {
	public function getModule($module_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE module_id = '" . (int)$module_id . "'");
		
		if ($query->row) {
			return unserialize($query->row['setting']);
		} else {
			return array();	
		}
	}	
	
	// add start 2014/12/17
	/*
	 * 根据模块名称仅获取一个模块信息
	 */
	public function getModuleByName($name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE name = '".$name."' limit 1");
	
		if ($query->row) {
			return unserialize($query->row['setting']);
		} else {
			return array();	
		}
	}
	// end 2014/12/17	
}