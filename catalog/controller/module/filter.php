<?php
class ControllerModuleFilter extends Controller {
	public function index() {
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$category_id = end($parts);

		$this->load->model('catalog/category');

		$category_info = $this->model_catalog_category->getCategory($category_id);

		if ($category_info) {
			$this->load->language('module/filter');

			$data['heading_title'] = $this->language->get('heading_title');

			$data['button_filter'] = $this->language->get('button_filter');
			
			$data['text_all'] = $this->language->get('text_all');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['action'] = str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url));

			if (isset($this->request->get['filter'])) {
				$data['filter_category'] = array_unique(explode(',', $this->request->get['filter']));
			} else {
				$data['filter_category'] = array();
			}

			$this->load->model('catalog/product');

			$data['filter_groups'] = array();

			$filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);

			if ($filter_groups) {
				foreach ($filter_groups as $filter_group) {
					$childen_data = array();

					foreach ($filter_group['filter'] as $filter) {
						$filter_data = array(
							'filter_category_id' => $category_id,
							'filter_filter'      => $filter['filter_id']
						);

						// myzhou 2015/8/9 修改filter
						$filter_array = $data['filter_category'];
						$key = array_search($filter['filter_id'], $filter_array);
						if($key === false){
							array_push($filter_array,$filter['filter_id']);
						} else {
							unset($filter_array[$key]);
						}
						$filter_str = implode(',', $filter_array);
						$href = empty($filter_str) ? $data['action'] : $data['action'] . '&filter='. $filter_str;
						
						$childen_data[] = array(
							'filter_id' => $filter['filter_id'],
							'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
							'href'      => $href
						);
					}
					
					// myzhou 2015/8/10 修改filter_group
					$childen_filters = array();
					$group_filters = array();
					$selected = false;
					
					foreach($childen_data as $childen_filter){
						array_push($childen_filters, $childen_filter['filter_id']);
					}
	
					foreach($data['filter_category'] as $filter){
						if(in_array($filter, $childen_filters)){
							$selected = true;
						} else {
							array_push($group_filters, $filter);
						}
					}
					$filter_str = implode(',', $group_filters);
					$group_href = empty($filter_str) ? $data['action'] : $data['action'] . '&filter='. $filter_str;
					$first_childen = array(
						'filter_id' => 0,
						'name'      => $data['text_all'],
						'href'      => $group_href
					);
					// 插到数组的开头
					array_unshift($childen_data, $first_childen);

					$data['filter_groups'][] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $childen_data,
						'selected'        => $selected
					);
				}

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filter.tpl')) {
					return $this->load->view($this->config->get('config_template') . '/template/module/filter.tpl', $data);
				} else {
					return $this->load->view('default/template/module/filter.tpl', $data);
				}
			}
		}
	}
}