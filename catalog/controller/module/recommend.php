<?php
/**
 * 作者: myzhou
 * 时间: 2015-9-5
 * 描述: 综合推荐模块 controller
 */
class ControllerModuleRecommend extends Controller {
	public function index($setting) {
		$this->load->language('module/recommend');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_fen'] = $this->language->get('text_fen');
		$data['text_old_price'] = $this->language->get('text_old_price');
		$data['text_tag_latest']        = $this->language->get('text_tag_latest');
		$data['text_tag_best_seller']   = $this->language->get('text_tag_best_seller');
		$data['text_tag_special']       = $this->language->get('text_tag_special');
		$data['text_tag_best_review']   = $this->language->get('text_tag_best_review');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		// latest products
		$latest_results = $this->model_catalog_product->getLatestProductsByInterval($setting['latest_interval_day'], $setting['latest_limit'], true);

		// best seller products
		$best_seller_results = $this->model_catalog_product->getBestSellerProductsByInterval($setting['best_seller_interval_day'], $setting['best_seller_limit'], true);

		// special products
		$special_results = $this->model_catalog_product->getProductSpecialsDiff($setting['special_limit'], true);
		
		// best review products
		$best_review_results = $this->model_catalog_product->getBestReviewProducts($setting['review_score_limit'], $setting['best_review_limit'], true);

		// tags
		$data['tags'] = array();
		
		foreach($latest_results as $latest) {
			$data['tags'][$latest['product_id']][] = 'latest';
		}
		
		foreach($best_seller_results as $best_seller) {
			$data['tags'][$best_seller['product_id']][] = 'best_seller';
		}
		
		foreach($special_results as $special) {
			$data['tags'][$special['product_id']][] = 'special';
		}
		
		foreach($best_review_results as $best_review) {
			$data['tags'][$best_review['product_id']][] = 'best_review';
		}

		// add array
		$results = $latest_results + $best_seller_results + $special_results + $best_review_results;
		
		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_review_status') && in_array('best_review', $data['tags'][$result['product_id']])) {
					$rating = number_format($result['rating'], 1);
				} else {
					$rating = false;
				}
				
				// sales
				if(isset($best_seller_results[$result['product_id']])){
					if($setting['best_seller_interval_day'] == '7') {
						$sales = sprintf($this->language->get('text_sales_one_week'), $best_seller_results[$result['product_id']]['sales']);
					}
					if($setting['best_seller_interval_day'] == '14') {
						$sales = sprintf($this->language->get('text_sales_two_week'), $best_seller_results[$result['product_id']]['sales']);
					}
					if($setting['best_seller_interval_day'] == '30') {
						$sales = sprintf($this->language->get('text_sales_one_month'), $best_seller_results[$result['product_id']]['sales']);
					}
				} else {
					$sales = false;
				}
				
				// latest
				if(in_array('latest', $data['tags'][$result['product_id']])){
					$end_date = strtotime(date("Y-m-d"));
					$start_date = strtotime($result['date_available']);
					$days = round(($end_date - $start_date)/(60 * 60 * 24));
					if($days){
						$text_days = sprintf($this->language->get('text_latest_days'), $days);
					} else {
						$text_days = $this->language->get('text_latest_today');
					}
				} else {
					$text_days = false;
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					'thumb'       => $image,
					'name'        => $result['name'],
					'title'       => $result['title'],
					'price'       => $price,
					'special'     => $special,
					'rating'      => $rating,
					'sales'       => $sales,
					'latest'      => $text_days,
					'tags'        => $data['tags'][$result['product_id']]
				);
			}
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/recommend.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/recommend.tpl', $data);
		} else {
			return $this->load->view('default/template/module/recommend.tpl', $data);
		}
	}
}