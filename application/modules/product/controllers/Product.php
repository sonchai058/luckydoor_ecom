<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct() {
		parent::__construct();
		$this->load->database();

		$this->load->library(
			'template',
			array(
				'name' 		=> 'web_template1',
				'setting' 	=> array('data_output' => '')
			)
		);

		$this->load->helper(
			array()
		);
		$this->load->libraries(
			array()
		);
		$this->load->model(
			array(
				'permission_model',
				'statistic_view_model',
				'product_type_model',
				'serialized_model',
				'breadcrumb_model',
			)
		);

		$this->statistic_view_model->getOnceWebMain();
		$this->product_type_model->productTypeDailyUpdate();
	}

	public function product_empty() {
		return 'ไม่มีสินค้าในประเภท/หมวดหมู่นี้';
	}

	public function index() {
		if (get_inpost('productsearch')) {
			$search_string = get_inpost('product_search_input');
			$product_query = $this->common_model->custom_query(
				" 	SELECT * FROM `product`
					LEFT JOIN `category`
					ON `product`.`C_ID` = `category`.`C_ID`
					WHERE `P_Allow` != '3'
					AND (`P_Name` LIKE '%$search_string%' OR `C_Name` LIKE '%$search_string%') 	"
			);
		}
		else {
			$product_query = $this->common_model->custom_query(
				" SELECT * FROM `product` WHERE `P_Allow` != '3' "
			);
		}
		if (count($product_query) > 0)
			$this->product($product_query);
		else
			// redirect('main', 'refresh');
			$this->product($product_query, $this->product_empty());
	}

	public function category($category = null) {
		$product_query = $this->common_model->custom_query(
			" SELECT * FROM `product` WHERE `P_Allow` != '3' AND `C_ID` = '$category' "
		);
		if (count($product_query) > 0)
			$this->product($product_query);
		else
			// redirect('product', 'refresh');
			$this->product($product_query, $this->product_empty());
	}

	public function type($type = null) {
		$product_query = $this->common_model->custom_query(
			" SELECT * FROM `product` WHERE `P_Allow` != '3' AND `PT_ID` LIKE '%$type%' "
		);
		if (count($product_query) > 0)
			$this->product($product_query);
		else
			// redirect('product', 'refresh');
			$this->product($product_query, $this->product_empty());
	}

	public function product($product_query = null, $product_empty = null) {
		$title 			= 'สินค้า';
		$content_view 	= 'front-end/product';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$category_query = $this->common_model->custom_query(
			" SELECT * FROM `category` WHERE `C_Allow` != '3' "
		);
		$type_query = $this->common_model->custom_query(
			" SELECT * FROM `product_type` WHERE `PT_Allow` != '3' "
		);
		// if (count($product_query) > 0) {
			if (count($product_query) 	< 0) $product_query 	= array();
			if (count($category_query) 	< 0) $category_query 	= array();
			if (count($type_query) 		< 0) $type_query 		= array();
			$data = array(
				'content_view' 		=> $content_view,
				'title'				=> $title,
				'product_query' 	=> $product_query,
				'category_query'	=> $category_query,
				'type_query'		=> $type_query,
				'breadcrumb' 		=> $breadcrumb,
				'product_empty'		=> $product_empty,
			);
	        $this->template->load('index_page', $data);
	    // }
	    // else
	    	// redirect('main', 'refresh');
	}

	public function color($P_ID = null) {
		$product = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P_ID));
		if (count($product) <= 0) $product = array();
		$data = array('P_ID' => $P_ID, 'product' => $product);
		$this->load->view('front-end/color', $data);
	}

	public function detail($P_ID = null) {
		if ($P_ID !== null) {
			$M_ID = get_session('C_ID');
			$product_detail_query = $this->common_model->custom_query(
				" 	SELECT * FROM `product`
					LEFT JOIN `category` 		ON `product`.`C_ID` 	= `category`.`C_ID`
					LEFT JOIN `product_size` 	ON `product`.`P_Size` 	= `product_size`.`PSI_ID`
					LEFT JOIN `product_unit` 	ON `product`.`PU_ID` 	= `product_unit`.`PU_ID`
					WHERE `product`.`P_ID` = '$P_ID'
					AND `product`.`P_Allow` != '3'
					LIMIT 1 	"
			);
			$product_price_query = $this->common_model->custom_query(
				" 	SELECT * FROM `product_price`
					WHERE `P_ID` 		 = '$P_ID'
					AND `PP_Special` 	 = '1'
					AND (NOW() BETWEEN PP_StartDate AND PP_EndDate )
					AND `PP_Allow`		!= '3'
					ORDER BY `PP_ID` DESC
					LIMIT 1 	"
			);
			$product_stock_query = $this->common_model->custom_query(
				" 	SELECT * FROM `product_stock`
					WHERE `P_ID` 	= '$P_ID'
					AND `PS_Allow` != '3'
					ORDER BY `PS_ID` DESC
					LIMIT 1 	"
			);
			$product_wlist_query = $this->common_model->custom_query(
				" 	SELECT * FROM `wishlist`
					WHERE `P_ID` 	 = '$P_ID'
					AND `M_ID` 		 = '$M_ID'
					AND `W_Allow` 	!= '3'
					ORDER BY `W_ID` DESC
					LIMIT 1 	"
			);
			if (count($product_detail_query) > 0) {
				$product_detail = rowArray($product_detail_query);

				if (count($product_price_query) > 0) $product_price = rowArray($product_price_query); else $product_price = array();
				if (count($product_stock_query) > 0) $product_stock = rowArray($product_stock_query); else $product_stock = array();
				if (count($product_wlist_query) > 0) $product_wlist = true; else $product_wlist = false;

				$title 			= $product_detail['P_IDCode'];
				$content_view 	= 'front-end/detail';

				$navi_props = 	array(
					'path' 	=> 	array(base_url('product'), base_url('product/category/'.$product_detail['C_ID'])),
					'name' 	=> 	array('สินค้า', $product_detail['C_Name']),
				);
				$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

				$data = array(
					'content_view' 		=> $content_view,
					'title'				=> $title,
					'product_detail'	=> $product_detail,
					'product_price'		=> $product_price,
					'product_stock'		=> $product_stock,
					'product_wlist'		=> $product_wlist,
					'breadcrumb'    	=> $breadcrumb,
				);
		        $this->template->load('index_page', $data);
		    }
		    else
		    	redirect('product', 'refresh');
	    }
	    else
	    	redirect('product', 'refresh');
	}

	public function wishlist($operator = null, $P_ID = null) {
		$this->permission_model->getMemberLevel();
		if ($P_ID !== null) {
			$C_ID = get_session('C_ID');
			$wishlist = rowArray($this->common_model->custom_query(
				" SELECT * FROM `wishlist` WHERE `P_ID` = '$P_ID' AND `M_ID` = '$C_ID' "
			));
			if ($operator === 'add') {
				$data = array(
					'P_ID' 				=> $P_ID,
					'M_ID' 				=> $C_ID,
					'W_UserAdd' 		=> $C_ID,
					'W_DateTimeAdd' 	=> date('Y-m-d H:i:s'),
					'W_UserUpdate' 		=> $C_ID,
					'W_DateTimeUpdate' 	=> date('Y-m-d H:i:s'),
					'W_Allow' 			=> '1',
				);
				$this->common_model->insert('wishlist', $data);
			}
			else if ($operator === 'del') {
				if (count($wishlist) > 0) {
					$data = array(
						'W_UserUpdate' 		=> $C_ID,
						'W_DateTimeUpdate' 	=> date('Y-m-d H:i:s'),
						'W_Allow' 			=> '3',
					);
					$this->common_model->update('wishlist', $data, 'P_ID = '.$P_ID.' AND M_ID = '.$C_ID);
				}
			}
			redirect('product/detail/'.$P_ID, 'refresh');
		}
	    else redirect('product', 'refresh');
	}

}