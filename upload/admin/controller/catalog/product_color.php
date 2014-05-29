<?php 
class ControllerCatalogProductColor extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->language->load('catalog/product_color');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/product_color');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->language->load('catalog/product_color');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('catalog/product_color');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_product_color->addColor($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
				
			$this->redirect($this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->language->load('catalog/product_color');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/product_color');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$this->model_catalog_product_color->editColor($this->request->get['code'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->language->load('catalog/product_color');

    	$this->document->setTitle('Colores');
		
		$this->load->model('catalog/product_color');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $code) {

				$this->model_catalog_product_color->deleteColor($code);
	  		}

			$this->session->data['success'] = $this->language->get('text_success')."__";
			
			$url = '';
			
			$this->redirect($this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			$sort = 'c.name';
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
			'href'      => $this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] 	= $this->url->link('catalog/product_color/insert', 	'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] 	= $this->url->link('catalog/product_color/copy', 	'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] 	= $this->url->link('catalog/product_color/delete', 	'token=' . $this->session->data['token'] . $url, 'SSL');
    	
    	$this->load->model('catalog/manufacturer');

    	$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(array());
		$this->data['products'] = array();

		$data = array(
			'filter_code'	  		 => $filter_code,
			'filter_name'	  		 => $filter_name, 
			'filter_manufacturer_id' => $filter_manufacturer_id,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);

		$this->load->model('tool/image');

		$colores_data 	= $this->model_catalog_product_color->getColores($data);
		$total_color 	= $this->model_catalog_product_color->getColoresTotal($data);
		
		$url = '';
		$this->data['colores'] = array();
		foreach ($colores_data as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/product_color/update', 'token=' . $this->session->data['token'] . '&code=' . $result['code'] . $url, 'SSL')
			);
			$image = $this->model_tool_image->resize($result['image'], 40, 40);
			
			if(!$image){
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
		 	$this->data['colores'][] = array(
				'code' 				=> $result['code'],
				'name' 				=> $result['name'],
				'image' 			=> $image,
				'manufacturer_id' 	=> $result['manufacturer_id'],
				'manufacturer_name' => $result['manufacturer_name'],
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

		$this->data['sort_code'] 			= $this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . '&sort=c.code' . $url, 'SSL');
		$this->data['sort_name'] 			= $this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . '&sort=c.name' . $url, 'SSL');
		$this->data['sort_manufacturer_id'] = $this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . '&sort=c.manufacturer_id' . $url, 'SSL');

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
		$pagination->url = $this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] 				= $filter_name;
		$this->data['filter_code'] 				= $filter_code;
		$this->data['filter_manufacturer_id'] 	= $filter_manufacturer_id;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/product_color_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	protected function getForm() {
    	
    	$this->data['heading_title'] = $this->language->get('heading_title');

 		if (!empty($this->error['code'])) {
			$this->data['error_warning'] = "* ". implode("<br/> * ", $this->error);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['manufacturer_id'])) {
			$this->data['error_manufacturer'] = $this->error['manufacturer_id'];
		} else {
			$this->data['error_manufacturer'] = '';
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
       		'text'      => 'Colores',
			'href'      => $this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->load->model('catalog/manufacturer');

    	$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(array());

		if (!isset($this->request->get['code'])) {
			$this->data['action'] = $this->url->link('catalog/product_color/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/product_color/update', 'token=' . $this->session->data['token'] . '&code=' . $this->request->get['code'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/product_color', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$color_info = array();
		if (isset($this->request->get['code']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$color_info = $this->model_catalog_product_color->getColor($this->request->get['code']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->post['code'])) {
      		$this->data['code'] = $this->request->post['code'];
    	} elseif (!empty($color_info)) {
			$this->data['code'] = $color_info['code'];
		} else {
      		$this->data['code'] = '';
    	}		

    	if (isset($this->request->post['name'])) {
      		$this->data['name'] = $this->request->post['name'];
    	} elseif (!empty($color_info)) {
			$this->data['name'] = $color_info['name'];
		} else {
      		$this->data['name'] = '';
    	}	


    	if (isset($this->request->post['manufacturer_id'])) {
      		$this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
    	} elseif (!empty($color_info)) {
			$this->data['manufacturer_id'] = $color_info['manufacturer_id'];
		} else {
      		$this->data['manufacturer_id'] = '';
    	}		

    	if (isset($this->request->post['image'])) {
      		$this->data['image'] = $this->request->post['image'];
    	} elseif (!empty($color_info)) {
			$this->data['image'] = $color_info['image'];
		} else {
      		$this->data['image'] = '';
    	}		

		$this->load->model('tool/image');
    	$this->data['thumb'] = $this->model_tool_image->resize($this->data['image'],100,100);

    	if (isset($this->request->post['manufacturer_id'])) {
      		$this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
    	} elseif (!empty($color_info)) {
			$this->data['manufacturer_id'] = $color_info['manufacturer_id'];
		} else {
      		$this->data['manufacturer_id'] = '11';
    	}		
										
		$this->template = 'catalog/product_color_form.tpl';
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

    	if ((utf8_strlen($this->request->post['code']) < 1) || (utf8_strlen($this->request->post['code']) > 64)) {
      		$this->error['code'] = 'Codigo requerido';
    	}

    	if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 64)) {
      		$this->error['name'] = 'Nombre requerido';
    	}

    	if (  $this->request->post['manufacturer_id'] < 1) {
      		$this->error['manufacturer_id'] = 'Marca Requerida';
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
			$this->load->model('catalog/product_color');
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
			
			$results = $this->model_catalog_product_color->getColores($data);
			foreach ($results as $result) {
				$option_data = array();
				
				$json[] = array(
					'code' 				=> $result['code'],
					'name' 				=> strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'image' 			=> $result['image'],
					'manufacturer_id' 	=> $result['manufacturer_id'],
					'manufacturer_name' => $result['manufacturer_name'],
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function cambiarEstado(){

		$this->load->model('catalog/product_color');
		$this->model_catalog_product->cambiarEstado($this->request->get['product_id']);
		return;
	}
}
?>