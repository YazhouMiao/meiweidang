<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-9
 * 描述: 添加独立的商品分类显示功能
 */
class ControllerCommonCategory extends Controller {
    public function index() {
    	$this->load->language('common/category');
    	
    	$this->document->setTitle($this->language->get('heading_title'));

        // 取得分类信息
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            if ($category['status']) {
            	// Level 2
            	$children_data = array();
            	
            	$children = $this->model_catalog_category->getCategories($category['category_id']);
            	
            	foreach ($children as $child) {
            		$filter_data = array(
            			'filter_category_id'  => $child['category_id'],
            			'filter_sub_category' => true
            		);
            	
            		$children_data[] = array(
            			'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
            			'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
            		);
            	}

                // Level 1
                if ($category['image']) {
                    $image = $this->model_tool_image->resize($category['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
                }
                
                $data['categories'][] = array(
                    'name'     => $category['name'],
                    'image'    => $image,
                	'children' => $children_data,
                    'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
            }
        }
        
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/category.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/category.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/common/category.tpl', $data));
        }
    }
}