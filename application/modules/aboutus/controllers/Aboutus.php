<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends MX_Controller {

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
				'statistic_view_model',
				'product_type_model',
				'serialized_model',
				'breadcrumb_model',
			)
		);

		$this->statistic_view_model->getOnceWebMain();
		$this->product_type_model->productTypeDailyUpdate();
	}

	public function index() {
		$title 			= 'เกี่ยวกับเรา';
		$content_view 	= 'front-end/aboutus';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb' 	=> $breadcrumb,
		);
        $this->template->load('index_page', $data);
	}

	public function terms() {
		$title 			= 'ข้อตกลงและเงื่อนไข';
		$content_view 	= 'front-end/terms';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb' 	=> $breadcrumb,
		);
        $this->template->load('index_page', $data);
	}

	public function privacy() {
		$title 			= 'นโยบายความเป็นส่วนตัว';
		$content_view 	= 'front-end/privacy';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb' 	=> $breadcrumb,
		);
        $this->template->load('index_page', $data);
	}

	public function storelist() {
		$title 			= 'รายชื่อร้านค้า';
		$content_view 	= 'front-end/storelist';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb' 	=> $breadcrumb,
		);
        $this->template->load('index_page', $data);
	}

}