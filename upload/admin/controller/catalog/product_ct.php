<?php
class ControllerCatalogProductCt extends Controller {
	private $error = array();  

	public function index() {
		$this->language->load('catalog/product_ct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product_ct');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/product_ct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product_ct');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product_ct->addOption($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/product_ct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product_ct');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product_ct->editOption($this->request->get['option_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/product_ct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product_ct');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $option_id) {
				$this->model_catalog_product_ct->deleteOption($option_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('catalog/product_ct/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/product_ct/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['options'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$option_total = $this->model_catalog_product_ct->getTotalOptions();

		$results = $this->model_catalog_product_ct->getOptions($data);
		
		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/product_ct/update', 'token=' . $this->session->data['token'] . '&option_id=' . $result['option_id'] . $url, 'SSL')
			);

			$this->data['options'][] = array(
				'option_id'  => $result['option_id'],
				'name'       => $result['name'],
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['option_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');	

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . '&sort=od.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . '&sort=o.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $option_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/product_ct_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_choose'] = $this->language->get('text_choose');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_radio'] = $this->language->get('text_radio');
		$this->data['text_checkbox'] = $this->language->get('text_checkbox');
		$this->data['text_image'] = $this->language->get('text_image');
		$this->data['text_input'] = $this->language->get('text_input');
		$this->data['text_text'] = $this->language->get('text_text');
		$this->data['text_textarea'] = $this->language->get('text_textarea');
		$this->data['text_file'] = $this->language->get('text_file');
		$this->data['text_date'] = $this->language->get('text_date');
		$this->data['text_datetime'] = $this->language->get('text_datetime');
		$this->data['text_time'] = $this->language->get('text_time');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_option_value'] = $this->language->get('entry_option_value');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_option_value'] = $this->language->get('button_add_option_value');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}	

		if (isset($this->error['option_value'])) {
			$this->data['error_option_value'] = $this->error['option_value'];
		} else {
			$this->data['error_option_value'] = array();
		}	

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['option_id'])) {
			$this->data['action'] = $this->url->link('catalog/product_ct/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else { 
			$this->data['action'] = $this->url->link('catalog/product_ct/update', 'token=' . $this->session->data['token'] . '&option_id=' . $this->request->get['option_id'] . $url, 'SSL');
		}

		$this->data['cancel'] 		= $this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['add_option'] 	= $this->url->link('catalog/product_ct/add_option', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		if (isset($this->request->get['option_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$option_info = $this->model_catalog_product_ct->getOption($this->request->get['option_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['option_description'])) {
			$this->data['option_description'] = $this->request->post['option_description'];
		} elseif (isset($this->request->get['option_id'])) {
			$this->data['option_description'] = $this->model_catalog_product_ct->getOptionDescriptions($this->request->get['option_id']);
		} else {
			$this->data['option_description'] = array();
		}	

		if (isset($this->request->post['type'])) {
			$this->data['type'] = $this->request->post['type'];
		} elseif (!empty($option_info)) {
			$this->data['type'] = $option_info['type'];
		} else {
			$this->data['type'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($option_info)) {
			$this->data['sort_order'] = $option_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

		if (isset($this->request->post['option_value'])) {
			$option_values = $this->request->post['option_value'];
		} elseif (isset($this->request->get['option_id'])) {
			$option_values = $this->model_catalog_product_ct->getOptionValueDescriptions($this->request->get['option_id']);
		} else {
			$option_values = array();
		}

		$this->load->model('tool/image');

		$this->data['option_values'] = array();

		foreach ($option_values as $option_value) {
			if ($option_value['image'] && file_exists(DIR_IMAGE . $option_value['image'])) {
				$image = $option_value['image'];
			} else {
				$image = 'no_image.jpg';
			}
			$url_ovid = '&ovid='.$option_value['option_value_id'];
			$this->data['option_values'][] = array(
				'option_value_id'          => $option_value['option_value_id'],
				'option_value_description' => $option_value['option_value_description'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($image, 50, 50),
				'sort_order'               => $option_value['sort_order'],
				'option_value_color_talla' => $option_value['option_value_color_talla'],
				'edit_option_href' 		   => $this->url->link('catalog/product_ct/edit_option', 'token=' . $this->session->data['token'] . $url. $url_ovid, 'SSL')
			);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 50, 50);

		$this->template = 'catalog/product_ct_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/product_ct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['option_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 128)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if (($this->request->post['type'] == 'select' || $this->request->post['type'] == 'radio' || $this->request->post['type'] == 'checkbox') && !isset($this->request->post['option_value'])) {
			$this->error['warning'] = $this->language->get('error_type');
		}

		// if (isset($this->request->post['option_value'])) {
		// 	foreach ($this->request->post['option_value'] as $option_value_id => $option_value) {
		// 		foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
		// 			if ((utf8_strlen($option_value_description['name']) < 1) || (utf8_strlen($option_value_description['name']) > 128)) {
		// 				$this->error['option_value'][$option_value_id][$language_id] = $this->language->get('error_option_value'); 
		// 			}					
		// 		}
		// 	}	
		// }

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}


	protected function validateOptionForm() {
		if (!$this->user->hasPermission('modify', 'catalog/product_ct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['option_value_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 128)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/product_ct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $option_id) {
			$product_total = $this->model_catalog_product->getTotalProductsByOptionId($option_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->language->load('catalog/product_ct');

			$this->load->model('catalog/product_ct');

			$this->load->model('tool/image');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$options = $this->model_catalog_product_ct->getOptions($data);

			foreach ($options as $option) {
				$option_value_data = array();

				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$option_values = $this->model_catalog_product_ct->getOptionValues($option['option_id']);

					foreach ($option_values as $option_value) {
						if ($option_value['image'] && file_exists(DIR_IMAGE . $option_value['image'])) {
							$image = $this->model_tool_image->resize($option_value['image'], 50, 50);
						} else {
							$image = '';
						}

						$option_value_data[] = array(
							'option_value_id' => $option_value['option_value_id'],
							'name'            => html_entity_decode($option_value['name'], ENT_QUOTES, 'UTF-8'),
							'image'           => $image					
						);
					}

					$sort_order = array();

					foreach ($option_value_data as $key => $value) {
						$sort_order[$key] = $value['name'];
					}

					array_multisort($sort_order, SORT_ASC, $option_value_data);					
				}

				$type = '';

				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$type = $this->language->get('text_choose');
				}

				if ($option['type'] == 'text' || $option['type'] == 'textarea') {
					$type = $this->language->get('text_input');
				}

				if ($option['type'] == 'file') {
					$type = $this->language->get('text_file');
				}

				if ($option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$type = $this->language->get('text_date');
				}

				$json[] = array(
					'option_id'    => $option['option_id'],
					'name'         => strip_tags(html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8')),
					'category'     => $type,
					'type'         => $option['type'],
					'option_value' => $option_value_data
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}

	public function add_option(){

		$this->language->load('catalog/product_ct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product_ct');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateOptionForm()) {
			$this->model_catalog_product_ct->addOptionValue($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/product_ct/update', 'token=' . $this->session->data['token'] . $url . '&option_id='.$this->request->post['option_id'], 'SSL'));
		}

		$this->option_form();
		
	}

	public function edit_option(){

		$this->language->load('catalog/product_ct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product_ct');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateOptionForm()) {
			$this->model_catalog_product_ct->editOptionValue($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('catalog/product_ct/update', 'token=' . $this->session->data['token'] . $url . '&option_id='.$this->request->post['option_id'], 'SSL'));
		}

		$this->option_form();
	}

	public function delete_option(){

		$this->language->load('catalog/product_ct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product_ct');

		$response = json_encode(array(
			'status' 	=> 'FAIL',
			'menssage' 	=> 'No se ha borrado la opción'
		));

		if (($this->request->server['REQUEST_METHOD'] == 'GET')) {
			if($this->model_catalog_product_ct->deleteOptionValue($this->request->get['option_value_id'])){
				$response = json_encode(array(
					'status' 	=> 'OK',
					'menssage' 	=> 'Se ha borrado la opción'
				));
			}

		}

		die($response);

	}


	public function option_form(){
		
		$this->load->model('tool/image');
		$this->load->model('catalog/product');
		$this->load->model('catalog/product_color');
		$this->load->model('catalog/product_talla');

		$this->data['heading_title'] = 'Nueva Opción de Compra';

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}	

		if (isset($this->error['option_value'])) {
			$this->data['error_option_value'] = $this->error['option_value'];
		} else {
			$this->data['error_option_value'] = array();
		}	

		$url = '';

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);


		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['ovid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$option_info = $this->model_catalog_product_ct->getOptionValueInfo($this->request->get['ovid']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['option_description'])) {
			$this->data['option_description'] = $this->request->post['option_description'];
		} elseif (isset($this->request->get['ovid'])) {
			$this->data['option_description'] = $this->model_catalog_product_ct->getOptionValueIdDescriptions($option_info['option_value_id']);
		} else {
			$this->data['option_description'] = array();
		}	

		$this->data['option_list'] = $this->model_catalog_product_ct->getOptions();

		if (isset($this->request->post['option_value_id'])) {
			$this->data['option_value_id'] = $this->request->post['option_value_id'];
		} elseif (!empty($option_info)) {
			$this->data['option_value_id'] = $option_info['option_value_id'];
		} else {
			$this->data['option_value_id'] = '';
		}

		if (isset($this->request->post['option_id'])) {
			$this->data['option_id'] = $this->request->post['option_id'];
		} elseif (!empty($option_info)) {
			$this->data['option_id'] = $option_info['option_id'];
		} else {
			$this->data['option_id'] = '';
		}
		

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($option_info)) {
			$this->data['image'] = $option_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($this->request->post['thumb'])) {
			$this->data['thumb'] = $this->request->post['thumb'];
		} elseif (!empty($option_info)) {
			$this->data['thumb'] = $this->model_tool_image->resize($option_info['image'],100,100);
		} else {
			$this->data['thumb'] = '';
		}


		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($option_info)) {
			$this->data['sort_order'] = $option_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		 

		if (isset($this->request->post['barcode'])) {
			$this->data['barcode'] = $this->request->post['barcode'];
		} elseif (!empty($option_info)) {
			$this->data['barcode'] = $option_info['barcode'];
		} else {
			$this->data['barcode'] = '';
		}
		

		if (isset($this->request->post['sku'])) {
			$this->data['sku'] = $this->request->post['sku'];
		} elseif (!empty($option_info)) {
			$this->data['sku'] = $option_info['sku'];
		} else {
			$this->data['sku'] = '';
		}


		if (isset($this->request->post['color_id'])) {
			$this->data['color_id'] = $this->request->post['color_id'];
			$this->data['color_name'] = $this->request->post['color_name'];
		} elseif (!empty($option_info)) {
			$this->data['color_id'] = $option_info['color_id'];
			$this->data['color_name'] = $this->model_catalog_product_color->getColor($option_info['color_id']);
		} else {
			$this->data['color_id'] = '';
			$this->data['color_name'] = '';
		}


		if (isset($this->request->post['talla_id'])) {
			$this->data['talla_id'] 	= $this->request->post['talla_id'];
			$this->data['talla_name'] 	= $this->request->post['talla_id'];
		} elseif (!empty($option_info)) {
			$this->data['talla_id'] 	= $option_info['talla_id'];
			$this->data['talla_name'] 	= $this->model_catalog_product_talla->getInfo($option_info['talla_id']);
		} else {
			$this->data['talla_id'] 	= '';
			$this->data['talla_name'] 	= '';
		}

		if (isset($this->request->post['product_id'])) {
			$this->data['product_id']   = $this->request->post['product_id'];
			$this->data['product_name'] = $this->request->post['product_name'];
		} elseif (!empty($option_info)) {
			$this->data['product_id'] 	= $option_info['product_id'];
			$this->data['product_name'] = $this->model_catalog_product->getProduct($option_info['product_id']);
		} else {
			$this->data['product_id'] = '';
			$this->data['product_name'] = '';
		}


		if (isset($this->request->post['option_value'])) {
			$option_values = $this->request->post['option_value'];
		} elseif (isset($this->request->get['option_id'])) {
			$option_values = $this->model_catalog_product_ct->getOptionValueDescriptions($this->request->get['option_id']);
		} else {
			$option_values = array();
		}

		$this->data['option_values'] = array();

		foreach ($option_values as $option_value) {
			if ($option_value['image'] && file_exists(DIR_IMAGE . $option_value['image'])) {
				$image = $option_value['image'];
			} else {
				$image = 'no_image.jpg';
			}
			$url_ovid = '&ovid='.$option_value['option_value_id'];
			$this->data['option_values'][] = array(
				'option_value_id'          => $option_value['option_value_id'],
				'option_value_description' => $option_value['option_value_description'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($image, 100, 100),
				'sort_order'               => $option_value['sort_order'],
				'option_value_color_talla' => $option_value['option_value_color_talla'],
				'edit_option_href' 		   => $this->url->link('catalog/product_ct/edit_option', 'token=' . $this->session->data['token'] . $url. $url_ovid, 'SSL')
			);
		}


		if (!isset($this->request->get['ovid'])) {
			$this->data['action'] = $this->url->link('catalog/product_ct/add_option', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else { 
			$this->data['action'] = $this->url->link('catalog/product_ct/edit_option', 'token=' . $this->session->data['token'] . $url, 'SSL');
		}

		$this->data['cancel'] 		= $this->url->link('catalog/product_ct', 'token=' . $this->session->data['token'] . $url , 'SSL');
		

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		$this->template = 'catalog/product_ct_form_option.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>