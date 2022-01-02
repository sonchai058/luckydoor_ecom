<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus extends MX_Controller {

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
		$title 			= 'ติดต่อเรา';
		$content_view 	= 'front-end/contactus';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb'    => $breadcrumb,
		);
		if (get_inpost('contacted')) {
			$this->form_validation->set_rules('name', 			'ชื่อ-นามสกุล', 	'trim|required');
			$this->form_validation->set_rules('email', 			'อีเมล', 			'trim|required|valid_email');
			$this->form_validation->set_rules('subject', 		'หัวข้อ', 		'trim|required');
			$this->form_validation->set_rules('message', 		'ข้อความ', 		'trim|required');
			$this->form_validation->set_message('required',		'%s เป็นข้อมูลที่จำเป็น');
			$this->form_validation->set_message('valid_email', 	'%s จะต้องมีรูปแบบที่ถูกต้อง');
			if ($this->form_validation->run() !== false) {
				$this->contactsend(get_inpost('name'), get_inpost('email'), get_inpost('subject'), get_inpost('message'));
				redirect('contactus', 'refresh');
			}
			else
				print("<script language='javascript'>alert('!!! ส่งข้อความล้มเหลว กรุณาตรวจสอบข้อมูลอีกครั้ง');</script>");
		}
        $this->template->load('index_page', $data);
	}

	public function contactsend($name = null, $email = null, $subject = null, $message = null) {
		$sites = $this->webinfo_model->getOnceWebMain();
		$roots_email = $this->common_model->custom_query(" SELECT M_Email FROM admin WHERE M_Type = '1' ");
        $email_lists = array();
        foreach ($roots_email as $key => $email_roots) {
        	array_push($email_lists, $email_roots['M_Email']);
        }
		$config['useragent']    = $sites['WD_Name'];
        $config['mailtype']     = 'html';
        $this->email->initialize($config);
        $this->email->from($email, $name);
        $this->email->to($sites['WD_Email']);
        $this->email->cc($email_lists);
        $this->email->subject($subject);
        $this->email->message($message);
        @$this->email->send();
        // echo $this->email->print_debugger();
		print("<script language='javascript'>alert('ส่งข้อความเรียบร้อยแล้ว');</script>");
	}

}