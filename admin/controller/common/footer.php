<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['text_footer'] = sprintf($this->language->get('text_footer'), $this->config->get('config_name'), date('Y', time()));
		$data['text_icp'] = $this->language->get('text_icp');

		return $this->load->view('common/footer.tpl', $data);
	}
}