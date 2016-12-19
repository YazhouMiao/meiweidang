<?php 
class ModelPaymentAlipayDirect extends Model {
      public function getMethod($address) {
        $this->load->language('payment/alipay_direct');
        
        if ($this->config->get('alipay_direct_status') && !$this->request->isMobile()) {
            $status = TRUE;
        } else {
            $status = FALSE;
        }
        
        $method_data = array();
        
        $this->load->model('tool/image');
        if ($status) {
          // 支付宝logo
          if ($this->config->get('alipay_direct_logo') && is_file(DIR_IMAGE . $this->config->get('alipay_direct_logo'))) {
              $logo = $this->model_tool_image->resize($this->config->get('alipay_direct_logo'), 150, 50);
          } else {
              $logo = $this->model_tool_image->resize('no_image.png', 150, 50);
          }

          $method_data = array( 
            'code'       => 'alipay_direct',
            'title'      => $this->language->get('text_title'),
            'terms'      => '',
            'logo'       => $logo,
            'sort_order' => $this->config->get('alipay_direct_sort_order')
          );
        }
    
        return $method_data;
      }
}