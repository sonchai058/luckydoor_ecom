<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MX_Controller {

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
				'fill_dropdown_model',
				'serialized_model',
				'crud_level_model',
				'order_status_model',
				'breadcrumb_model',
			)
		);

		$this->statistic_view_model->getOnceWebMain();
		$this->product_type_model->productTypeDailyUpdate();
		
	}

	public function index() {
		redirect('member/history', 'refresh');
	}

	public function login() {
		$title 			= 'เข้าสู่ระบบ';
		$content_view 	= 'front-end/login';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		if (get_session('C_ID') != '')
			redirect('main', 'refresh');
		else {
	        if (get_inpost('loggedin')) {
	        	$this->form_validation->set_rules('user_id', 	'ชื่อผู้ใช้งาน',	'trim|required');
				$this->form_validation->set_rules('user_pass', 	'รหัสผ่าน', 		'trim|required');
				$this->form_validation->set_message('required',	'กรุณากรอก %s');
				if ($this->form_validation->run() !== false) {
		        	$row = rowArray($this->admin_model->getLoginEncrypt(get_inpost('user_id'), get_inpost('user_pass')));
					if (isset($row['M_ID'])) {
						if ($row['M_Allow'] !== '3') {
							$M_TName_arr = array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ');
							set_session('C_ID', $row['M_ID']);
							set_session('C_Username', $row['M_Username']);
							set_session('C_flName', $M_TName_arr[$row['M_TName']].$row['M_flName']);
							if ($row['M_Img'] !== '') set_session('C_Img', $row['M_Img']); else set_session('C_Img', 'no_img.jpg');
						}
						else
							print("<script language='javascript'>alert('!!! บัญชีของท่านถูกระงับ กรุณาติดต่อทีมงาน');</script>");
					}
					else
						print("<script language='javascript'>alert('!!! ไม่พบบัญชีผู้ใช้งาน หรือข้อมูลไม่ถูกต้อง กรุณาเข้าสู่ระบบอีกครั้ง');</script>");
				}
				else
					print("<script language='javascript'>alert('!!! เข้าสู่ระบบล้มเหลว กรุณาตรวจสอบข้อมูลอีกครั้ง');</script>");
	        	redirect(get_inpost('current_url'), 'refresh');
	        }
	        else {
	        	$data = array(
					'content_view' 	=> $content_view,
					'title'			=> $title,
					'breadcrumb'    => $breadcrumb,
				);
		        $this->template->load('index_page', $data);
	        }

	    }
	}

	public function logout() {
		// $this->session->sess_destroy();
		$this->session->unset_userdata('C_ID');
		$this->session->unset_userdata('C_Username');
		$this->session->unset_userdata('C_flName');
		$this->session->unset_userdata('C_Img');
		redirect(get_inpost('current_url'), 'refresh');
	}

	public function register() {
		$title 			= 'สมัครใช้งาน';
		$content_view 	= 'front-end/register';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		if (get_session('C_ID') != '')
			redirect('member/login', 'refresh');
		else {
			$data = array(
				'content_view' 	=> $content_view,
				'title'			=> $title,
				'breadcrumb'    => $breadcrumb,
			);
		    if (get_inpost('registered')) {
		    	$this->form_validation->set_rules('username', 		'ชื่อผู้ใช้งาน',	'trim|required|min_length[5]|max_length[12]|is_unique[member.M_Username]|alpha');
				$this->form_validation->set_rules('email', 			'อีเมล', 			'trim|required|valid_email|is_unique[member.M_Email]');
				$this->form_validation->set_rules('password', 		'รหัสผ่าน', 		'trim|required|matches[passconf]|min_length[5]|max_length[12]|alpha_numeric');
				$this->form_validation->set_rules('passconf', 		'ยืนยันรหัสผ่าน',	'trim|required|alpha_numeric');
				$this->form_validation->set_rules('fullname', 		'ชื่อ-นามสกุล',	'trim|required');
				$this->form_validation->set_message('required', 	'%s เป็นข้อมูลที่จำเป็น');
				$this->form_validation->set_message('min_length', 	'%s ต้องมีอย่างน้อย %d ตัวอักษร');
				$this->form_validation->set_message('max_length', 	'%s ต้องไม่เกิน %d ตัวอักษร');
				$this->form_validation->set_message('valid_email', 	'%s จะต้องมีรูปแบบที่ถูกต้อง');
				$this->form_validation->set_message('matches', 		'%s ไม่ตรงกับข้อมูลยืนยันรหัสผ่าน');
				$this->form_validation->set_message('is_unique', 	'%s มีในระบบแล้ว');
				$this->form_validation->set_message('alpha', 		'%s ต้องเป็นอักษรภาษาอังกฤษ');
				if ($this->form_validation->run() !== false) {
					$register_data = array(
						'M_flName' 		=> get_inpost('fullname'),
						'M_Email' 		=> get_inpost('email'),
						'M_Username' 	=> get_inpost('username'),
						'M_Password'	=> $this->encrypt->encode(get_inpost('password')),
						'M_Allow' 		=> '1',
						'M_Regis' 		=> date('Y-m-d H:i:s'),
						'M_KeyUpdate'	=> date('Y-m-d H:i:s'),
					);
					$this->common_model->insert('member', $register_data);
					$member = rowArray($this->common_model->get_where_custom_and('member', array('M_Username' => get_inpost('username'), 'M_Allow' => '1')));
					if (count($member) > 0) {
						$update_data = array(
							'M_UserAdd' 	=> $member['M_ID'],
							'M_Update'		=> $member['M_ID'],
						);
						$this->common_model->update('member', $update_data, 'M_ID = '.$member['M_ID']);
					}
					$this->registerverifysend(get_inpost('email'), get_inpost('username'), get_inpost('password'));
					redirect('main', 'refresh');
				}
				else
					print("<script language='javascript'>alert('!!! สมัครใช้งานล้มเหลว กรุณาตรวจสอบข้อมูลก่อนสมัครใช้งาน');</script>");
		    }
		    $this->template->load('index_page', $data);
		}
	}

	public function registerverifysend($M_Email = null, $M_Username = null, $M_Password = null) {
		if (get_session('C_ID') != '')
			redirect('member/login', 'refresh');
		else {
			$site = $this->webinfo_model->getOnceWebMain();
			$config['useragent']	= $site['WD_Name'];
	        $config['mailtype']     = 'html';
	        $this->email->initialize($config);
	        $this->email->from($site['WD_Email'], $site['WD_Name']);
	        $this->email->to($M_Email);
	        $this->email->subject('ยืนยันการลงทะเบียนกับ '.$site['WD_Name']);
	        $this->email->message('Username: '.$M_Username.'<br>Password: '.$M_Password.'<br>Login <a href="'.base_url('member/login').'" target="_blank">click here</a>');
	        @$this->email->send();
	        // echo $this->email->print_debugger();
	        print("<script language='javascript'>alert('สมัครใช้งานเรียบร้อยแล้ว กรุณาตรวจสอบอีเมลของท่าน');</script>");
		}
	}

	public function forgotpassword() {
		$title 			= 'ลืมรหัสผ่าน';
		$content_view 	= 'front-end/forgotpassword';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		if (get_session('C_ID') != '')
			redirect('main', 'refresh');
		else {
			$data = array(
				'content_view' 	=> $content_view,
				'title'			=> $title,
				'breadcrumb'    => $breadcrumb,
			);
			if (get_inpost('forgotten')) {
				$this->form_validation->set_rules('username', 	'ชื่อผู้ใช้งาน',	'trim|required');
				$this->form_validation->set_rules('email',		'อีเมล', 			'trim|required');
				$this->form_validation->set_message('required',	'กรุณากรอก %s');
				if ($this->form_validation->run() !== false) {
					$M_Username = get_inpost('username');
					$M_Email = get_inpost('email');
		        	$rows = rowArray($this->common_model->custom_query(" SELECT * FROM member WHERE M_Username = '$M_Username' AND M_Email = '$M_Email' "));
					if (count($rows) > 0) {
						$this->passwordsend($M_Email, $M_Username, $this->encrypt->decode($rows['M_Password']));
						redirect('main', 'refresh');
					}
					else
						print("<script language='javascript'>alert('!!! ชื่อผู้ใช้งานหรืออีเมล์ไม่ถูกต้อง กรุณาส่งข้อมูลอีกครั้ง');</script>");
				}
				else
					print("<script language='javascript'>alert('!!! ส่งข้อมูล้มเหลว กรุณาตรวจสอบข้อมูลอีกครั้ง');</script>");
			}
			$this->template->load('index_page', $data);
		}
	}

	public function passwordsend($M_Email = null, $M_Username = null, $M_Password = null) {
		if (get_session('C_ID') != '')
			redirect('member/login', 'refresh');
		else {
			$site = $this->webinfo_model->getOnceWebMain();
			$config['useragent']	= $site['WD_Name'];
	        $config['mailtype']     = 'html';
	        $this->email->initialize($config);
	        $this->email->from($site['WD_Email'], $site['WD_Name']);
	        $this->email->to($M_Email);
	        $this->email->subject('รหัสผ่านเข้าใช้งานเว็บไซต์ '.$site['WD_Name']);
	        $this->email->message('Username: '.$M_Username.'<br>Password: '.$M_Password.'<br>Login <a href="'.base_url('member/login').'" target="_blank">click here</a>');
	        @$this->email->send();
	        // echo $this->email->print_debugger();
	        print("<script language='javascript'>alert('ส่งข้อมูลผู้ใช้งานเรียบร้อยแล้ว กรุณาตรวจสอบอีเมลของท่าน');</script>");
		}
	}

	public function get_member() {
		return rowArray($this->common_model->get_where_custom('member', 'M_ID', get_session('C_ID')));
	}

	public function history() {
		$title 			= 'ติดตามสถานะคำสั่งซื้อ';
		$content_view 	= 'front-end/history';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$this->permission_model->getMemberLevel();

		$M_ID = get_session('C_ID');
		$order_data = $this->common_model->custom_query(
			" 	SELECT * FROM `order`
				WHERE `M_ID` = '$M_ID'
				AND `OD_Allow` IN ('1','4','5','6','7')
				ORDER BY `OD_DateTimeUpdate` DESC, `OD_Allow` DESC "
		);
		$order_allow = $this->order_status_model->getOnceWebMain();
		if (count($order_data) > 0) {
			$order_status = array();
			foreach ($order_data as $key => $value) {
				array_push($order_status, $order_allow[$value['OD_Allow']]);
			}
		}
		else {
			$order_data 	= array();
			$order_status 	= array();
		}

		$data = array(
			'content_view' 			=> $content_view,
			'title'					=> $title,
			'breadcrumb'    		=> $breadcrumb,
			'order_data'			=> $order_data,
			'order_status'			=> $order_status,
			'member_data'			=> $this->get_member(),
		);
        $this->template->load('index_page', $data);
	}

	public function record() {
		$title 			= 'ประวัติการซื้อ/สั่งซื้อ';
		$content_view 	= 'front-end/history';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$this->permission_model->getMemberLevel();

		$M_ID = get_session('C_ID');
		$order_history = $this->common_model->custom_query(
			" 	SELECT * FROM `order`
				WHERE `M_ID` = '$M_ID'
				AND `OD_Allow` IN ('2','3','7')
				ORDER BY `OD_DateTimeUpdate` DESC, `OD_Allow` DESC "
		);
		$order_allow = $this->order_status_model->getOnceWebMain();
		if (count($order_history) > 0) {
			$order_status_history = array();
			foreach ($order_history as $key => $value) {
				array_push($order_status_history, $order_allow[$value['OD_Allow']]);
			}
		}
		else {
			$order_history 			= array();
			$order_status_history 	= array();
		}

		$data = array(
			'content_view' 			=> $content_view,
			'title'					=> $title,
			'breadcrumb'    		=> $breadcrumb,
			'order_history'			=> $order_history,
			'order_status_history' 	=> $order_status_history,
			'member_data'			=> $this->get_member(),
		);
        $this->template->load('index_page', $data);
	}

	public function historydetail($OD_ID = null) {
		$title 			= 'รายละเอียดติดตามสถานะคำสั่งซื้อ';
		$content_view 	= 'front-end/historydetail';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$this->permission_model->getMemberLevel();

		$M_ID = get_session('C_ID');
		$order = $this->common_model->custom_query(
			" 	SELECT * FROM `order`
				WHERE `OD_ID` = '$OD_ID'
				AND `M_ID` = '$M_ID'
				ORDER BY `OD_DateTimeUpdate` DESC,
				`OD_Allow` DESC "
		);
		$order_list = $this->common_model->custom_query(
			" 	SELECT * FROM `order_list`
				LEFT JOIN `product`
				ON `order_list`.`P_ID` = `product`.`P_ID`
				WHERE `OD_ID` = '$OD_ID' "
		);
		$order_address = $this->common_model->custom_query(
			" SELECT * FROM `order_address` WHERE `OD_ID` = '$OD_ID' "
		);
		$order_allow = $this->order_status_model->getOnceWebMain();
		if (count($order) > 0) {
			$order_data		= rowArray($order);
			$order_status 	= $order_allow[$order_data['OD_Allow']];
			if (count($order_list) <= 0) $order_list = array();
		}
		else {
			$order_data 	= array();
			$order_status 	= '';
		}
		if (count($order_address) > 0) $address_data = rowArray($order_address); else $address_data = array();

		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb'    => $breadcrumb,
			'order_data'	=> $order_data,
			'order_list'	=> $order_list,
			'address_data'	=> $address_data,
			'order_status'	=> $order_status,
			'member_data'	=> $this->get_member(),
		);
        $this->template->load('index_page', $data);
	}

	public function transfer($OD_ID = null) {
		$title 			= 'แจ้งโอนเงิน';
		$content_view 	= 'front-end/transfer';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$this->permission_model->getMemberLevel();

		$M_ID = get_session('C_ID');
		$order = $this->common_model->custom_query(
			" SELECT * FROM `order` WHERE `OD_ID` = '$OD_ID' AND `M_ID` = '$M_ID' "
		);
		if (count($order) > 0) {
			$order_data = rowArray($order);
			if ($order_data['OD_Allow'] === '6' || $order_data['OD_Allow'] === '7' || $order_data['OD_Allow'] === '8') {
				// echo "<script>alert('แจ้งโอนเงินเรียบร้อยแล้ว');</script>";
				redirect('member', 'refresh');
			}
		}
		else {
			$order_data = array();
			redirect('member', 'refresh');
		}

		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb'    => $breadcrumb,
			'order_data'    => $order_data,
			'member_data'	=> $this->get_member(),
		);
		if (get_inpost('transfered')) {
			$C_ID = get_session('C_ID');
			$this->form_validation->set_rules('B_ID', 			'ธนาคาร', 				'trim|required');
			$this->form_validation->set_rules('OT_DateTimeAdd', 'วันเวลาที่ทำรายการ', 		'trim|required');
			$this->form_validation->set_rules('OT_Price', 		'จำนวนเงิน', 				'trim|required|numeric');
			$this->form_validation->set_message('required', 	'%s เป็นข้อมูลที่จำเป็น');
			$this->form_validation->set_message('numeric', 		'%s ต้องเป็นตัวเลข');
			if ($this->form_validation->run() !== false) {
				$transfer_data = array(
					'OD_ID' 			=> $OD_ID,
					'B_ID' 				=> get_inpost('B_ID'),
					'OT_Payment' 		=> get_inpost('OT_Payment'),
					'OT_Descript' 		=> trim(get_inpost('OT_Descript')),
					'OT_Price' 			=> get_inpost('OT_Price'),
					'OT_SumPrice' 		=> get_inpost('OT_Price'),
					'OT_FullSumPrice' 	=> get_inpost('OT_Price'),
					'OT_UserAdd' 		=> get_session('C_ID'),
					'OT_DateTimeAdd' 	=> get_inpost('OT_DateTimeAdd'),
					'OT_UserUpdate' 	=> get_session('C_ID'),
					'OT_DateTimeUpdate' => get_inpost('OT_DateTimeAdd'),
					'OT_Allow' 			=> '1',
				);
				$config['upload_path'] 		= './assets/uploads/user_uploads_img/';
				$config['allowed_types'] 	= 'gif|jpg|jpeg|png';
				$config['max_size']			= '100';
				$config['max_width']  		= '1024';
				$config['max_height']  		= '768';
				$config['encrypt_name']  	= true;
				$config['remove_spaces']  	= true;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('OT_ImgAttach'))
					$data['upload_error'] 			= $this->upload->display_errors();
				else {
					$data['upload_data'] 			= $this->upload->data();
					$transfer_data['OT_ImgAttach']	= $data['upload_data']['file_name'];
					$this->common_model->insert('order_transfer', $transfer_data);
					$this->common_model->update('order', array('OD_Allow' => '5', 'OD_UserUpdate' => '0', 'OD_DateTimeUpdate' => date('Y-m-d H:i:s')), " `OD_ID` = '$OD_ID' ");
					$this->orderTransferSendEmail($OD_ID);
					// print("<script language='javascript'>alert('แจ้งโอนเงินเรียบร้อยแล้ว');</script>");
					redirect('member', 'refresh');
				}
			}
			else print("<script language='javascript'>alert('!!! แจ้งโอนเงินล้มเหลว กรุณาตรวจสอบข้อมูล');</script>");
		}
		$this->template->load('index_page', $data);
	}

	public function transfercustom($OD_ID = null) {
		if (get_session('C_ID') != '') redirect('member', 'refresh');

		$title 			= 'แจ้งโอนเงิน';
		$content_view 	= 'front-end/transfercustom';

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
		if (get_inpost('transferchecked')) {
			$OD_Code = get_inpost('OD_Code');
			$order = $this->common_model->custom_query(
				" SELECT * FROM `order` WHERE `OD_Code` = '$OD_Code' "
			);
			if (count($order) > 0) {
				$order_data = rowArray($order);
				if ($order_data['OD_Allow'] === '6' || $order_data['OD_Allow'] === '7' || $order_data['OD_Allow'] === '8')
					$data['search_error'] = 'ใบสั่งซื้อ '.$OD_Code.' ได้แจ้งโอนเงินไปแล้ว';
				else
					$data['order_data'] = $order_data;
			}
			else {
				$order_data = array();
				$data['search_error'] = 'ไม่พบเลขที่ใบสั่งซื้อ';
			}
		}
		else if (get_inpost('transfered') && $OD_ID != '') {
			$this->form_validation->set_rules('B_ID', 			'ธนาคาร', 				'trim|required');
			$this->form_validation->set_rules('OT_DateTimeAdd', 'วันเวลาที่ทำรายการ', 		'trim|required');
			$this->form_validation->set_rules('OT_Price', 		'จำนวนเงิน', 				'trim|required|numeric');
			$this->form_validation->set_message('required', 	'%s เป็นข้อมูลที่จำเป็น');
			$this->form_validation->set_message('numeric', 		'%s ต้องเป็นตัวเลข');
			if ($this->form_validation->run() !== false) {
				$transfer_data = array(
					'OD_ID' 			=> $OD_ID,
					'B_ID' 				=> get_inpost('B_ID'),
					'OT_Payment' 		=> get_inpost('OT_Payment'),
					'OT_Descript' 		=> trim(get_inpost('OT_Descript')),
					'OT_Price' 			=> get_inpost('OT_Price'),
					'OT_SumPrice' 		=> get_inpost('OT_Price'),
					'OT_FullSumPrice' 	=> get_inpost('OT_Price'),
					'OT_UserAdd' 		=> '0',
					'OT_DateTimeAdd' 	=> get_inpost('OT_DateTimeAdd'),
					'OT_UserUpdate' 	=> '0',
					'OT_DateTimeUpdate' => get_inpost('OT_DateTimeAdd'),
					'OT_Allow' 			=> '1',
				);
				$config['upload_path'] 		= './assets/uploads/user_uploads_img/';
				$config['allowed_types'] 	= 'gif|jpg|jpeg|png';
				$config['max_size']			= '100';
				$config['max_width']  		= '1024';
				$config['max_height']  		= '768';
				$config['encrypt_name']  	= true;
				$config['remove_spaces']  	= true;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('OT_ImgAttach'))
					$data['upload_error'] 			= $this->upload->display_errors();
				else {
					$data['upload_data'] 			= $this->upload->data();
					$transfer_data['OT_ImgAttach']	= $data['upload_data']['file_name'];
					$this->common_model->insert('order_transfer', $transfer_data);
					$this->common_model->update('order', array('OD_Allow' => '5', 'OD_UserUpdate' => get_session('C_ID'), 'OD_DateTimeUpdate' => date('Y-m-d H:i:s')), " `OD_ID` = '$OD_ID' ");
					$this->orderTransferSendEmail($OD_ID);
					// print("<script language='javascript'>alert('แจ้งโอนเงินเรียบร้อยแล้ว');</script>");
					redirect('main', 'refresh');
				}
			}
			else print("<script language='javascript'>alert('!!! แจ้งโอนเงินล้มเหลว กรุณาตรวจสอบข้อมูล');</script>");
		}
		$this->template->load('index_page', $data);
	}

	public function orderTransferSendEmail($OD_ID = null) {
    	$sites = $this->webinfo_model->getOnceWebMain();
        $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $OD_ID));
    	$order_address = rowArray($this->common_model->get_where_custom('order_address', 'OD_ID', $OD_ID));
    	$admin_level = '2,4';
        $roots_email = $this->common_model->custom_query(" SELECT M_Email FROM admin WHERE M_Type = '1' ");
        $roots_email_list = array();
        array_push($roots_email_list, $order_address['OD_Email']);
		foreach ($roots_email as $email_roots) {
			array_push($roots_email_list, $email_roots['M_Email']);
		}
		$admin_email = $this->common_model->custom_query(" SELECT M_Email FROM admin WHERE M_Type IN ($admin_level) ");
        $admin_email_list = array();
		foreach ($admin_email as $email_admin) {
			array_push($admin_email_list, $email_admin['M_Email']);
		}
        $query = rowArray($this->common_model->custom_query(
        	" 	SELECT * FROM `order_transfer`
        		LEFT JOIN `order` 	ON `order_transfer`.`OD_ID` = `order`.`OD_ID`
        		LEFT JOIN `bank` 	ON `order_transfer`.`B_ID` 	= `bank`.`B_ID`
        		WHERE `order_transfer`.`OD_ID` = '$OD_ID' "
        ));
        $data = array(
            'OD_ID'             => $query['OD_ID'],
            'OD_Code'           => $query['OD_Code'],
            'B_Name'            => $query['B_Name'],
            'OT_Payment'        => $query['OT_Payment'],
            'OT_DateTimeUpdate' => $query['OT_DateTimeUpdate'],
            'OT_FullSumPrice'   => $query['OT_FullSumPrice'],
            'document_type'     => 'html',
        );
		$config['useragent']    = $sites['WD_Name'];
        $config['mailtype']     = 'html';
        $this->email->initialize($config);
        $this->email->from($sites['WD_Email'], $sites['WD_Name']);
        $this->email->to($roots_email_list);
        $this->email->cc($admin_email_list);
        $this->email->subject('แจ้งการโอนเงิน '.$sites['WD_Name']);
        $this->email->message($this->load->view('web_template1/email/order_transfer', $data, true));
        @$this->email->send();
        // echo $this->email->print_debugger();
    }

	public function wishlist() {
		$title 			= 'รายการสินค้าที่ชอบ';
		$content_view 	= 'front-end/wishlist';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$this->permission_model->getMemberLevel();

		$M_ID = get_session('C_ID');
		$product_query = $this->common_model->custom_query(
			" 	SELECT * FROM `wishlist`
				LEFT JOIN `product`
				ON `wishlist`.`P_ID` = `product`.`P_ID`
				WHERE `wishlist`.`M_ID` = '$M_ID'
				AND `W_Allow` != '3' "
		);
		if (count($product_query) > 0) $product = $product_query; else $product = array();

		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb'    => $breadcrumb,
			'member_data'	=> $this->get_member(),
			'product_query'	=> $product,
		);
        $this->template->load('index_page', $data);
	}

	public function account() {
		$title 			= 'ข้อมูลส่วนตัว';
		$content_view 	= 'front-end/account';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$this->permission_model->getMemberLevel();
		$data = array(
			'content_view' 	=> $content_view,
			'title'			=> $title,
			'breadcrumb'    => $breadcrumb,
			'member_data'	=> $this->get_member(),
		);
		if (get_inpost('accounted')) {
			$password_update = true;
			$C_ID = get_session('C_ID');
			$this->form_validation->set_rules('M_flName', 		'ชื่อ-นามสกุล', 			'trim|required');
			$this->form_validation->set_rules('M_MTel', 		'โทรศัพท์มือถือ', 			'trim|required');
			$this->form_validation->set_rules('M_Email', 		'อีเมล', 					'trim|required|valid_email');
			$this->form_validation->set_rules('M_hrNumber', 	'เลขที่/ห้อง', 			'trim|required');
			$this->form_validation->set_rules('M_VilNo', 		'หมู่ที่', 				'trim|numeric');
			$this->form_validation->set_rules('Amphur_ID',      'เขต/อำเภอ', 				'trim|required');
            $this->form_validation->set_rules('District_ID',    'แขวง/ตำบล', 			'trim|required');
            $this->form_validation->set_rules('Province_ID',    'จังหวัด', 				'trim|required');
            $this->form_validation->set_rules('Zipcode_Code',   'รหัสไปรษณีย์', 			'trim|required|numeric|max_length[5]');
            if (get_inpost('M_Passcurr') != '' || get_inpost('M_Password') != '' || get_inpost('M_Passconf') != '') {
	            $this->form_validation->set_rules('M_Passcurr',	'รหัสผ่านปัจจุบัน', 		'trim|required');
	        	$this->form_validation->set_rules('M_Password', 'รหัสผ่านใหม่', 			'trim|required|matches[M_Passconf]|min_length[5]|max_length[12]|alpha_numeric');
	        	$this->form_validation->set_rules('M_Passconf', 'ยืนยันรหัสผ่านใหม่', 		'trim|required');
	        	$M_Password = rowArray($this->common_model->custom_query(
					" SELECT `M_Password` FROM `member` WHERE `M_ID` = '$C_ID' "
				));
				if (count($M_Password) > 0) {
					if ($this->encrypt->decode($M_Password['M_Password']) != get_inpost('M_Passcurr'))
						$password_update = false;
				}
				else $password_update = false;
	        }
			$this->form_validation->set_message('required', 	'%s เป็นข้อมูลที่จำเป็น');
			$this->form_validation->set_message('min_length', 	'%s ต้องมีอย่างน้อย %d ตัวอักษร');
			$this->form_validation->set_message('max_length', 	'%s ต้องไม่เกิน %d ตัวอักษร');
			$this->form_validation->set_message('valid_email', 	'%s จะต้องมีรูปแบบที่ถูกต้อง');
			$this->form_validation->set_message('matches', 		'%s ไม่ตรงกับข้อมูลยืนยันรหัสผ่าน');
			$this->form_validation->set_message('numeric', 		'%s ต้องเป็นตัวเลข');
			if ($this->form_validation->run() !== false && $password_update === true) {
				$M_Email = get_inpost('M_Email');
				$query = rowArray($this->common_model->custom_query(
					" 	SELECT `M_Email` FROM `member`
						WHERE `M_ID` != '$C_ID'
						AND `M_Email` = '$M_Email' 	"
				));
				$update_data = array(
					'M_TName' 		=> get_inpost('M_TName'),
					'M_flName' 		=> get_inpost('M_flName'),
					'M_ucName' 		=> get_inpost('M_ucName'),
					'M_Sex' 		=> get_inpost('M_Sex'),
					'M_npID' 		=> get_inpost('M_npID'),
					'M_HTel' 		=> get_inpost('M_HTel'),
					'M_MTel' 		=> get_inpost('M_MTel'),
					'M_Fax' 		=> get_inpost('M_Fax'),
					'M_Email' 		=> get_inpost('M_Email'),
					'M_hrNumber' 	=> get_inpost('M_hrNumber'),
					'M_VilBuild' 	=> get_inpost('M_VilBuild'),
					'M_VilNo' 		=> get_inpost('M_VilNo'),
					'M_LaneRoad' 	=> get_inpost('M_LaneRoad'),
					'M_Street' 		=> get_inpost('M_Street'),
					'Amphur_ID' 	=> get_inpost('Amphur_ID'),
					'District_ID' 	=> get_inpost('District_ID'),
					'Province_ID' 	=> get_inpost('Province_ID'),
					'Zipcode_Code'	=> get_inpost('Zipcode_Code'),
				);
				if (!empty($_FILES['M_Img']['name'])) {
					$config['upload_path'] 		= './assets/uploads/profile_img/';
					$config['allowed_types'] 	= 'gif|jpg|jpeg|png';
					$config['max_size']			= '100';
					$config['max_width']  		= '1024';
					$config['max_height']  		= '768';
					$config['encrypt_name']  	= true;
					$config['remove_spaces']  	= true;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('M_Img'))
						$data['upload_error'] 	= $this->upload->display_errors();
					else {
						$data['upload_data'] 	= $this->upload->data();
						$update_data['M_Img']	= $data['upload_data']['file_name'];
					}
				}
				if (count($query) <= 0) {
					$update_data['M_Email'] = get_inpost('M_Email');
					if ((get_inpost('M_Passcurr') != '' || get_inpost('M_Password') != '' || get_inpost('M_Passconf') != '') && $password_update === true)
						$update_data['M_Password'] = $this->encrypt->encode(get_inpost('M_Password'));
					$this->common_model->update('member', $update_data, 'M_ID = '.get_session('C_ID'));
					// print("<script language='javascript'>alert('อัพเดทข้อมูลเรียบร้อยแล้ว');</script>");
					redirect('member/account', 'refresh');
				}
				else $this->session->set_flashdata('M_Email_Error', 'อีเมล '.get_inpost('M_Email').' มีผู้ใช้งานแล้ว');
			}
			else {
				print("<script language='javascript'>alert('!!! อัพเดทข้อมูลล้มเหลว กรุณาตรวจสอบข้อมูล');</script>");
				if ($password_update === false) $this->session->set_flashdata('M_Password_Error', 'รหัสผ่านปัจจุบันของท่านไม่ถูกต้อง กรุณาตรวจสอบ');
			}
		}
        $this->template->load('index_page', $data);
	}

	public function profile_management() {
        $title = 'ข้อมูลส่วนตัว';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

        $this->crud_level_model->crudStateEnabled(/*add*/false,/*view*/false,/*edit*/true,/*del*/false,/**/false,/**/false);
        if (uri_seg(3) == 'edit') $this->uri->set_segment(4, get_session('C_ID'));

        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('member');
        $crud->where("member.M_Allow != ", "3");

        $crud->set_relation('District_ID',  'districts',    'District_Name');
        $crud->set_relation('Amphur_ID',    'amphures',     'Amphur_Name');
        $crud->set_relation('Province_ID',  'provinces',    'Province_Name');

        $crud->display_as('M_ID',           'ไอดี');
        $crud->display_as('M_Img',          'รูปประจำตัว');
        $crud->display_as('M_Username',     'ชื่อผู้ใช้งาน');
        $crud->display_as('M_Password',     'รหัสผ่าน');
        $crud->display_as('M_TName',        'คำนำหน้าชื่อ');
        $crud->display_as('M_flName',       'ชื่อ-นามสกุล');
        $crud->display_as('M_ucName',       'Name & Lastname');
        $crud->display_as('M_Sex',          'เพศ');
        $crud->display_as('M_npID',         'เลขประจำตัวประชาชน');
        $crud->display_as('M_HTel',         'โทรศัพท์บ้าน');
        $crud->display_as('M_MTel',         'โทรศัพท์มือถือ');
        $crud->display_as('M_Fax',          'โทรสาร');
        $crud->display_as('M_Email',        'อีเมล');
        $crud->display_as('M_hrNumber',     'เลขที่/ห้อง');
        $crud->display_as('M_VilBuild',     'หมู่บ้าน/อาคาร/คอนโด');
        $crud->display_as('M_VilNo',        'หมู่ที่');
        $crud->display_as('M_LaneRoad',     'ตรอก/ซอย');
        $crud->display_as('M_Street',       'ถนน');
        $crud->display_as('Amphur_ID',      'อำเภอ/เขต');
        $crud->display_as('District_ID',    'ตำบล/แขวง');
        $crud->display_as('Province_ID',    'จังหวัด');
        $crud->display_as('Zipcode_Code',   'รหัสไปรษณีย์');
        $crud->display_as('M_Allow',        'สถานะ');
        $crud->display_as('M_UserAdd',      'ผู้เพิ่มข้อมูล');
        $crud->display_as('M_Regis',        'วันเวลาที่เพิ่ม/สมัคร');
        $crud->display_as('M_Update',       'ผู้อัพเดท');
        $crud->display_as('M_KeyUpdate',    'วันเวลาที่อัพเดท');

        $crud->required_fields('M_flName', 'M_MTel', 'M_Email');

        $crud->edit_fields('M_Img', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_npID', 'M_HTel', 'M_MTel', 'M_Fax', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow', 'M_Update', 'M_KeyUpdate');

        $crud->set_rules('M_Email', 'อีเมล', 'required|valid_email');

        $crud->field_type('M_Username', 'readonly');
        $crud->field_type('M_TName',    'dropdown', array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ'));
        $crud->field_type('M_Sex',      'dropdown', array('M' => 'ชาย', 'F' => 'หญิง'));
        $crud->field_type('M_Allow',    'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'edit') {
            $crud->field_type('M_Allow',		'hidden', '1');
            $crud->field_type('M_Update',       'hidden', get_session('C_ID'));
            $crud->field_type('M_KeyUpdate',	'hidden', date("Y-m-d H:i:s"));
        }

        $crud->set_field_upload('M_Img', 'assets/uploads/profile_img');

        $crud->unset_add();
        $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        $crud->unset_export();
        $crud->unset_list();
        $crud->unset_print();
        $crud->unset_read();
        // $crud->unset_texteditor(array());

        try {
            $output = $crud->render();
            $this->_example_output($output, $title);
        }
        catch (Exception $e) {
            if ($e->getCode() == 14)
                redirect('member/profile_management/edit');
            else
                show_error($e->getMessage());
        }
    }

	public function password_changed() {
		$title 			= 'ข้อมูลการเข้าสู่ระบบ';
		$content_view 	= 'front-end/password_management';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

		$this->permission_model->getMemberLevel();
		$this->form_validation->set_rules('M_Passcurr', 'รหัสผ่าน (ปัจจุบัน)', 	'trim|required');
        $this->form_validation->set_rules('M_Password', 'รหัสผ่าน (ใหม่)', 		'trim|required|matches[M_Passconf]|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('M_Passconf', 'ยืนยันรหัสผ่าน (ใหม่)', 	'trim|required');
        $rows = rowArray($this->common_model->get_where_custom('member', 'M_ID', $this->input->post('M_ID')));
        $data = array(
            'table'         => 'member',
            'field_key'     => 'M_ID',
            'field_id'      => get_session('C_ID'),
            'field_allow'   => 'M_Allow',
            'content_view'  => $content_view,
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
        );
        if ($this->form_validation->run() === true) {
            if ($this->input->post('M_Passcurr') === $this->encrypt->decode($rows['M_Password'])) {
                $data['validation_success'] = 'success';
                $member_data = array(
                    'M_Password'	=> $this->encrypt->encode($this->input->post('M_Password')),
                    'M_KeyUpdate'	=> date('Y-m-d H:i:s'),
                    'M_Update'      => get_session('C_ID')
                );
                $this->common_model->update('member', $member_data, 'M_ID = '.$this->input->post('M_ID'));
            }
            else
                $data['validation_error'] = 'error';
        }
        else {
            if ($this->input->post('M_Passcurr') !== $this->encrypt->decode($rows['M_Password']))
                $data['validation_error'] = 'error';
        }
        $this->template->load('index_page', $data);
	}

	public function password_management() {
        $title 			= 'ข้อมูลการเข้าสู่ระบบ';
		$content_view 	= 'front-end/password_management';

		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

        $data = array(
            'table'         => 'member',
            'field_key'     => 'M_ID',
            'field_id'      => get_session('C_ID'),
            'field_allow'   => 'M_Allow',
            'content_view'  => $content_view,
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
        );
        $this->template->load('index_page', $data);
    }

	public function _example_output($output = null, $title = null) {
		$navi_props = 	array(
			'path' 	=> 	array(),
			'name' 	=> 	array(),
		);
		$breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

        $data = array(
            'content_view'  => $output,
            'title'         => $title,
            'breadcrumb'    => $breadcrumb,
        );
        $this->template->load('index_page', $data);
    }

}