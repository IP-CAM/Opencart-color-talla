<?php 
class ControllerCatalogProductTalla extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->language->load('catalog/product_talla');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/product_talla');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->language->load('catalog/product_talla');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/product_talla');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_product_talla->add($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
				
			$this->redirect($this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->language->load('catalog/product_talla');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product_talla');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_product_talla->edit($this->request->get['talla_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->language->load('catalog/product_talla');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product_talla');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $code) {

				$this->model_catalog_product_talla->delete($code);
	  		}

			$this->session->data['success'] = $this->language->get('text_success')."__";
			
			$url = '';
			
			$this->redirect($this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	 
	
  	protected function getList() {	
		
		$this->data['token'] = $this->session->data['token'];

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


  		if (isset($this->request->get['filter_code'])) {
			$filter_code = $this->request->get['filter_code'];
		} else {
			$filter_code = null;
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
		} else {
			$filter_manufacturer_id = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 't.name';
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

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . urlencode(html_entity_decode($this->request->get['filter_code'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$url .= '&filter_manufacturer_id=' . urlencode(html_entity_decode($this->request->get['filter_manufacturer_id'], ENT_QUOTES, 'UTF-8'));
		}

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
			'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Colores',
			'href'      => $this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] 	= $this->url->link('catalog/product_talla/insert', 	'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] 	= $this->url->link('catalog/product_talla/copy', 	'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] 	= $this->url->link('catalog/product_talla/delete', 	'token=' . $this->session->data['token'] . $url, 'SSL');
    	
    	$this->load->model('catalog/manufacturer');

    	$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(array());
		$this->data['products'] = array();

		$data = array(
			'filter_talla_id'	  		=> $filter_code,
			'filter_name'	  		 	=> $filter_name, 
			'filter_manufacturer_id' 	=> $filter_manufacturer_id,
			'sort'            		 	=> $sort,
			'order'           		 	=> $order,
			'start'           		 	=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           		 	=> $this->config->get('config_admin_limit')
		);

		$this->load->model('tool/image');

		$tallas_data 	= $this->model_catalog_product_talla->getData($data);
		$total_color 	= $this->model_catalog_product_talla->getDataTotal($data);
		
		$url = '';
		$this->data['tallas'] = array();

		foreach ($tallas_data as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/product_talla/update', 'token=' . $this->session->data['token'] . '&talla_id=' . $result['talla_id'] . $url, 'SSL')
			);
			
		 	$this->data['tallas'][] = array(
				'talla_id'			=> $result['talla_id'],
				'name'				=> $result['name'],
				'sort_order'		=> $result['sort_order'],
				'equivalencia'		=> $result['equivalencia'],
				'type'				=> $result['type'],
				'store_id'			=> $result['store_id'],
				'action'     		=> $action,
			);
    	}
	
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . urlencode(html_entity_decode($this->request->get['filter_code'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_code'] 		= $this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . '&sort=t.talla_id' 	. $url, 'SSL');
		$this->data['sort_name'] 		= $this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . '&sort=t.name' 		. $url, 'SSL');
		$this->data['sort_sort_order'] 	= $this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . '&sort=t.sort_order' . $url, 'SSL');
		$this->data['sort_type'] 		= $this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . '&sort=t.type' 		. $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . urlencode(html_entity_decode($this->request->get['filter_code'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$url .= '&filter_manufacturer_id=' . urlencode(html_entity_decode($this->request->get['filter_manufacturer_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $total_color;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] 				= $filter_name;
		$this->data['filter_code'] 				= $filter_code;
		$this->data['filter_manufacturer_id'] 	= $filter_manufacturer_id;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/product_talla_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	protected function getForm() {
    	
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
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

		$url = '';

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => 'Form',
			'href'      => $this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->load->model('catalog/manufacturer');

    	$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(array());

		if (!isset($this->request->get['talla_id'])) {
			$this->data['action'] = $this->url->link('catalog/product_talla/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/product_talla/update', 'token=' . $this->session->data['token'] . '&talla_id=' . $this->request->get['talla_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/product_talla', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data_info = array();
		if (isset($this->request->get['talla_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$data_info = $this->model_catalog_product_talla->getInfo($this->request->get['talla_id']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->post['talla_id'])) {
      		$this->data['talla_id'] = $this->request->post['talla_id'];
    	} elseif (!empty($data_info)) {
			$this->data['talla_id'] = $data_info['talla_id'];
		} else {
      		$this->data['talla_id'] = '';
    	}		

    	if (isset($this->request->post['name'])) {
      		$this->data['name'] = $this->request->post['name'];
    	} elseif (!empty($data_info)) {
			$this->data['name'] = $data_info['name'];
		} else {
      		$this->data['name'] = '';
    	}	


    	if (isset($this->request->post['equivalencia'])) {
      		$this->data['equivalencia'] = $this->request->post['equivalencia'];
    	} elseif (!empty($data_info)) {
			$this->data['equivalencia'] = $data_info['equivalencia'];
		} else {
      		$this->data['equivalencia'] = '';
    	}

    	if (isset($this->request->post['type'])) {
      		$this->data['type'] = $this->request->post['type'];
    	} elseif (!empty($data_info)) {
			$this->data['type'] = $data_info['type'];
		} else {
      		$this->data['type'] = '';
    	}		

		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($data_info)) {
			$this->data['sort_order'] = $data_info['sort_order'];
		} else {
      		$this->data['sort_order'] = '';
    	}		

		$this->template = 'catalog/product_talla_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	protected function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((utf8_strlen($this->request->post['talla_id']) < 1) || (utf8_strlen($this->request->post['talla_id']) > 64)) {
      		$this->error['talla_id'] = 'Talla ID requerida';
    	}

    	if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 64)) {
      		$this->error['name'] = 'Nombre requerido';
    	}

    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}
	
  	protected function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
  	
  	protected function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'catalog/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
		
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_sku']) || isset($this->request->get['filter_category_id']) || isset($this->request->get['filter_product_id'])) {
			$this->load->model('catalog/product_talla');
			$this->load->model('catalog/option');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
			
			if (isset($this->request->get['filter_sku'])) {
				$filter_sku = $this->request->get['filter_sku'];
			} else {
				$filter_sku = '';
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['filter_product_id'])) {
				$filter_product_id = $this->request->get['filter_product_id'];
			} else {
				$filter_product_id = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit,
				'filter_sku'   => $filter_sku,
				'filter_product_id'    => $filter_product_id
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
				$option_data = array();
				
				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);	
		
				
				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);
					
					if ($option_info) {				
						if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
							$option_value_data = array();
							
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);
						
								if ($option_value_info) {
									$option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'name'                    => $option_value_info['name'],
										'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
										'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}
						
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $option_value_data,
								'required'          => $product_option['required']
							);	
						} else {
							$option_data[] = array(
								'product_option_id' => $product_option['product_option_id'],
								'option_id'         => $product_option['option_id'],
								'name'              => $option_info['name'],
								'type'              => $option_info['type'],
								'option_value'      => $product_option['option_value'],
								'required'          => $product_option['required']
							);				
						}
					}
				}
					
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price'],
					'sku'		 => $result['sku']
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}

}
?>