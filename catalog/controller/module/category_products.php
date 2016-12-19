<?php
/**
 * 作者: myzhou
 * 时间: 2015-9-13
 * 描述: 首页展示分类产品模块
 */
class ControllerModuleCategoryProducts extends Controller {
	public function index($setting) {
		$this->load->language('module/category_products');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');
		
		$data['text_no_review'] = $this->language->get('text_no_review');
		$data['text_more'] = $this->language->get('text_more');
		$data['text_all'] = $this->language->get('text_all');
		$data['text_fen'] = $this->language->get('text_fen');
		$data['text_unbuyable'] = $this->language->get('text_unbuyable');
		$data['horder_color'] = $this->language->get('horder_color');
		
		// 取得分类信息
		$data['categories'] = array();
		
		$category = $this->model_catalog_category->getCategory($setting['category_id']);
		
		if(!empty($setting['color'])){
			$data['color'] = $setting['color'];
		} else {
			// default color
			$data['color'] = '#999';
		}
		
		if (!empty($category) && $category['status']) {
			$category_id = $category['category_id'];

			$products = array();
			$filter_data = array();

			$filter_data['filter_category_id'] = $category_id;
			
			if(!empty($setting['limit'])){
				$filter_data['start'] = 0;
				$filter_data['limit'] = $setting['limit'];
			}

			if(!empty($setting['recommended'])){
				$filter_data['filter_recommended'] = 1;
			}

			$results = $this->model_catalog_product->getProducts($filter_data);

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

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				if(!is_null($result['buyable'])){
					if(empty($result['buyable'])){
						$sale_status = $this->language->get('text_bookable');
					} else {
						$sale_status = $this->language->get('text_on_sale');
					}
				} else {
					$sale_status = $this->language->get('text_off_sale');
				}

				$products[] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'title'       => $result['title'],
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'path=' . $category_id . '&product_id=' . $result['product_id']),
					'buyable'     => $result['buyable'],
					'sale_status' => $sale_status
				);
			}
			
			// children
			$children_data = array();
				
			$children = $this->model_catalog_category->getCategories($category['category_id']);
				
			foreach ($children as $child) {
				$children_data[] = array(
					'name'  => $child['name'],
					'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
				);
			}
			
			// parent
			$data['category'] = array(
				'name'     => $category['name'],
				'title'    => $setting['name'],
				'children' => $children_data,
				'products' => $products,
				'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category_products.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/category_products.tpl', $data);
		} else {
			return $this->load->view('default/template/module/category_products.tpl', $data);
		}
	}
}