<?php
/*
 *二维码生成模块 后台controller
 *myzhou 2015/2/5
 *
*/

class ControllerModuleQrcode extends Controller {			   
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/qrcode');

		$this->document->setTitle = $this->language->get('heading_title');
		
		$this->load->model('extension/module');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('qrcode', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}	

			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_level_L'] = $this->language->get('text_level_L');
		$data['text_level_M'] = $this->language->get('text_level_M');
		$data['text_level_Q'] = $this->language->get('text_level_Q');
		$data['text_level_H'] = $this->language->get('text_level_H');
	
		$data['entry_size'] = $this->language->get('entry_size');
		$data['entry_level'] = $this->language->get('entry_level');
		$data['entry_margin'] = $this->language->get('entry_margin');
		$data['entry_logo'] = $this->language->get('entry_logo');
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		// error message
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} 
		
		if (isset($this->error['size'])) {
			$data['error_size'] = $this->error['image_size'];
		}
		
		if (isset($this->error['number'])) {
			$data['error_number'] = $this->error['number'];
		}
		
		if (isset($this->error['min_size'])) {
			$data['error_min_size'] = $this->error['min_size'];
		}
		
        $data['breadcrumbs'] = array();
   		
   		$data['breadcrumbs'][] = array(
       		'href'      => HTTPS_SERVER .'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
   		);

   		$data['breadcrumbs'][] = array(
       		'href'      => HTTPS_SERVER .'index.php?route=extension/module&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_module'),
   		);
		
   		$data['breadcrumbs'][] = array(
       		'href'      => HTTPS_SERVER .'index.php?route=module/qrcode&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
   		);
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/qrcode', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/qrcode', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['qrcode_size'])) {
			$data['qrcode_size'] = $this->request->post['qrcode_size'];
		} elseif (!empty($module_info)) {
			$data['qrcode_size'] = $module_info['qrcode_size'];
		} else {
			$data['qrcode_size'] = 100;
		}
						
		if (isset($this->request->post['qrcode_logo'])) {
			$data['qrcode_logo'] = $this->request->post['qrcode_logo'];
		} elseif (!empty($module_info)) {
			$data['qrcode_logo'] = $module_info['qrcode_logo'];
		} else {
			$data['qrcode_logo'] = false;
		}	
		
		$this->load->model("tool/image");
		
		if (isset($this->request->post['qrcode_logo']) && is_file(DIR_IMAGE . $this->request->post['qrcode_logo'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['qrcode_logo'], 100, 100);
		} elseif (isset($module_info['qrcode_logo']) && is_file(DIR_IMAGE . $module_info['qrcode_logo'])) {
			$data['thumb'] = $this->model_tool_image->resize($module_info['qrcode_logo'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['qrcode_margin'])) {
			$data['qrcode_margin'] = $this->request->post['qrcode_margin'];
		} elseif (!empty($module_info)) {
			$data['qrcode_margin'] = $module_info['qrcode_margin'];
		} else {
			$data['qrcode_margin'] = 2;
		}	
			
		if (isset($this->request->post['level'])) {
			$data['qrcode_level'] = $this->request->post['qrcode_level'];
		} elseif (!empty($module_info)) {
			$data['qrcode_level'] = $module_info['qrcode_level'];
		} else {
			$data['qrcode_level'] = 'H';
		}		
		
		if (isset($this->request->post['status'])) {
			$data['qrcode_status'] = $this->request->post['qrcode_status'];
		} elseif (!empty($module_info)) {
			$data['qrcode_status'] = $module_info['qrcode_status'];
		} else {
			$data['qrcode_status'] = '';
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/qrcode.tpl', $data));
	}
	
	private function validate() {
		// 修改权限判断
		if (!$this->user->hasPermission('modify', 'module/qrcode')) {
			$this->error['warning'] = $this->language->get('error_permission');
			return false;
		}
		
		foreach($this->request->post['qrcode_module'] as $module){
		
			//标题不为空
			if (utf8_strlen(trim($module['title'])) < 1) {
				$this->error['title'] = $this->language->get('error_title');
			}
			
			//二维码大小
			$image_size = trim($module['image_size']);
			if (utf8_strlen($image_size) < 1) {
				$this->error['image_size'] = $this->language->get('error_image_size');
			}else if(!preg_match('/^[1-9][0-9]*$/', $image_size)){
				$this->error['number'] = $this->language->get('error_number');
			}
			else if($image_size < 33){
				$this->error['min_size'] = $this->language->get('error_min_size');
			}
		}
		
		return !$this->error;
	}

}
?>