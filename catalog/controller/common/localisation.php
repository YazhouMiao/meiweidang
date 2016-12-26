<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-31
 * 描述: 获取用户位置信息。移动端采用浏览器定位,PC端采用IP定位 controller
 */
class ControllerCommonLocalisation extends Controller {
	/*
	 * 设置session['session_id']
	 */
    public function index(){
    	$this->load->model('localisation/service_zone');

    	if(!isset($this->request->get['route']) || !is_int(strpos($this->request->get['route'],'common/localisation'))){
	    	if(!isset($this->session->data['service_zone_id'])){
	    		// 1.客户端cookie
	    		if(isset($this->request->cookie['sz_id'])){
	    			$service_zone_id = $this->request->cookie['sz_id'];

	    			$result = $this->model_localisation_service_zone->getServiceZone($service_zone_id);
	    			if($result){
	    				// session
	    				$this->session->data['service_zone_id'] = $service_zone_id;
	    			}
	    		// 2.已经登录且有地址
	    		} else if($this->customer->isLogged() && $this->customer->getAddressId()){
	    			$result = $this->model_localisation_service_zone->getServiceZoneByAddressId($this->customer->getAddressId());
	    			if($result){
	    				// session
	    				$this->session->data['service_zone_id'] = $result['service_zone_id'];
	    				// set cookie
	    				setcookie('sz_id', $result['service_zone_id'], time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
	    			}
		    	}
	    	}
    	}
	}
	
	/**
	 * 选择服务区页面
	 */
	public function locate(){
		$this->load->language('common/localisation');
		$this->load->model('localisation/city');
		$this->load->model('localisation/service_zone');
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_located_city'] = $this->language->get('text_located_city');
		$data['text_on_service_city'] = $this->language->get('text_on_service_city');
		$data['text_service_zone'] = $this->language->get('text_service_zone');
		$data['text_city_status'] = $this->language->get('text_off_service');
		$data['text_no_service_zone'] = $this->language->get('text_no_service_zone');
		$data['text_tip'] = $this->language->get('text_tip');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['button_select'] = $this->language->get('button_select');
		
		$this->document->setTitle($this->config->get('config_meta_title'));
		
		$data['set_url'] = $this->url->link('common/localisation/set');
		
		// 百度地图
		$this->document->addScript('http://api.map.baidu.com/api?v=2.0&ak=i9y2FLYOcYpKQohQLOWVAiDS');

		if(!isset($this->session->data['service_zone_id'])) {
			// 默认城市/服务区
			$city_id = $this->config->get('config_default_city_id');
			$city_query = $this->model_localisation_city->getCity($city_id);
				
			$data['city'] = array(
				'id' => $city_query['city_id'],
				'name' => $city_query['city_name']
			);
			
			$service_zone_query = $this->model_localisation_service_zone->getServiceZone($city_query['service_zone_id']);

			// default service_zone
			$data['service_zone'] = array(
				'id'   => $service_zone_query['service_zone_id'],
				'name' => $service_zone_query['service_zone_name']
			);
		} else {
			// service_zone_id
			$service_zone_id = $this->session->data['service_zone_id'];
			
			// service_zone
			$service_zone = $this->model_localisation_service_zone->getServiceZone($service_zone_id);
			if(!empty($service_zone)){
				$data['service_zone'] = array(
						'id'   => $service_zone['service_zone_id'],
						'name' => $service_zone['service_zone_name'],
				);
					
				// city
				$city = $this->model_localisation_city->getCity($service_zone['city_id']);
				$data['city'] = array(
						'id'   => $city['city_id'],
						'name' => $city['city_name']
				);
			} else {
				// 默认城市/服务区
				$city_id = $this->config->get('config_default_city_id');
				$city_query = $this->model_localisation_city->getCity($city_id);
				
				$data['city'] = array(
						'id' => $city_query['city_id'],
						'name' => $city_query['city_name']
				);
					
				$service_zone_query = $this->model_localisation_service_zone->getServiceZone($city_query['service_zone_id']);
				
				// default service_zone
				$data['service_zone'] = array(
						'id'   => $service_zone_query['service_zone_id'],
						'name' => $service_zone_query['service_zone_name']
				);
			}
		}
		
		// cities
		$data['cities'] = array();
		$cities = $this->model_localisation_city->getCities();
		foreach($cities as $result){
			$data['cities'][] = array(
				'id'   => $result['city_id'],
				'name' => $result['city_name'],
				'code' => $result['code']
			);
		}

		// service_zones
    	$data['service_zones'] = array();
    	$service_zones = $this->model_localisation_service_zone->getServiceZonesByCity($data['city']['id']);
    	foreach($service_zones as $result){
    		$data['service_zones'][] = array(
    			'id'   => $result['service_zone_id'],
    			'name' => $result['service_zone_name'],
    			'code' => $result['service_zone_code'],
    			'description' => $result['description']
    		);
    	}
    	
    	$data['header'] = $this->load->controller('common/header');
    	$data['footer'] = $this->load->controller('common/footer');
    	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/localisation.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/localisation.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/localisation.tpl', $data));
		}
	}
	
	/*
	 * ajax方式方式设置定位城市
	 */
	public function setCity(){
		$this->load->language('common/localisation');
		$this->load->model('localisation/city');
		$this->load->model('localisation/service_zone');
		
		$json = array();
		
		$json['text_located_city'] = $this->language->get('text_located_city');
		$json['text_off_service'] = $this->language->get('text_off_service');
		$json['text_on_service'] = $this->language->get('text_on_service');
		$json['city_status'] = false;
		$json['city'] = [];

		// 定位城市
		$json['located_city'] = $this->request->post['city_name'];
		$city_query = $this->model_localisation_city->getCityByName($json['located_city']);
		
		// 定位城市已开通服务
		if(!empty($city_query)){
			$json['city_status'] = true;
			$json['city']['id'] = $city_query['city_id'];
			$json['city']['name'] = $city_query['city_name'];
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	
	/*
	 * ajax方式设置服务区
	 */
	public function set(){
		$this->load->language('common/localisation');
		$this->load->model('localisation/city');
		$this->load->model('localisation/service_zone');
		
		$json = array();
		if(isset($this->request->post['service_zone_id'])){
			$service_zone = $this->model_localisation_service_zone->getServiceZone($this->request->post['service_zone_id']);
			
			if($service_zone){
				// session['service_zone_id']未设置  or 与之前设置的不同
				if(!isset($this->session->data['service_zone_id']) || ($this->session->data['service_zone_id'] != $service_zone['service_zone_id'])){
					// session
					$this->session->data['service_zone_id'] = $service_zone['service_zone_id'];
					// cookie
					setcookie('sz_id', $this->session->data['service_zone_id'], time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
				}
				
				// 默认上海
				$this->session->data['city'] = isset($this->request->post['city_id']) ? $this->request->post['city_id'] : 1000003;
				
				// 跳转到原始的请求页面
				if(isset($this->session->data['redirect'])) {
					$json['redirect'] = $this->session->data['redirect'];
					
					unset($this->session->data['redirect']);
				} else {
					$json['redirect'] = $this->url->link('common/home');
				}
				
			} else {
				$json['error'] = $this->language->get('text_error');
			}
		} else {
			$json['error'] = $this->language->get('text_error');
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/*
	 * ajax方式通过city_id取得service_zone
	*/
	public function getServiceZones() {
		$json = array();
	
		$this->load->model('localisation/service_zone');
		$this->load->model('localisation/city');
		
		$city = $this->model_localisation_city->getCity($this->request->post['city_id']);
		$json['default_service_zone_id'] = $city['service_zone_id'];
	
		$service_zones = $this->model_localisation_service_zone->getServiceZonesByCity($this->request->post['city_id']);
	
		if ($service_zones) {
			foreach ($service_zones as $service_zone) {
				$json['service_zones'][] = array(
					'id'      => $service_zone['service_zone_id'],
					'name'    => $service_zone['service_zone_name'],
					'code'    => $service_zone['service_zone_code'],
					'description' => $service_zone['description']
				);
			}
		}
	
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}