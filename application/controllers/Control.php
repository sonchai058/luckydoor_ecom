<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url', 'form', 'general', 'file', 'html', 'asset', 'email'));
		$this->load->library(array('session', 'encrypt', 'cart', 'grocery_CRUD', 'form_validation', 'email'));
		$this->load->model(array('admin_model', 'common_model', 'useful_model', 'webinfo_model', 'files_model'));

		$this->load->library(
			'template',
			array(
				'name' 		=> 'admin_template1',
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
				'viewer_action_model',
				'product_type_model',
			)
		);

		$this->product_type_model->productTypeDailyUpdate();
		
	}

	public function index($mode = '1') {
		$this->permission_model->getOnceWebMain();
		$this->statistic_view_model->getBackLogMain();

        $between = " WHERE OD_Allow IN ('6','7') ";

        if (get_inpost('bt_submit1') != null) {
            $date_start = dateChange(get_inpost('date-start'), 2);
            $date_end   = dateChange(get_inpost('date-end'), 2);
            $between    = " WHERE DATE(`OD_DateTimeUpdate`) >= '".$date_start."' AND DATE(`OD_DateTimeUpdate`) <= '".$date_end."' AND OD_Allow IN ('6','7') ";
        }

        $data['get_date']   = $this->db->query(" SELECT DISTINCT DATE(`OD_DateTimeUpdate`) AS `Date`, DATE(`OD_DateTimeAdd`) AS `DateAdd`, `OD_Code`, `M_flName` FROM `order` LEFT JOIN `admin` ON `order`.`OD_UserUpdate` = `admin`.`M_ID` {$between} ORDER BY `OD_DateTimeUpdate` ASC ")->result_array();
        $data['total']      = 0;
        $data['price'][0]   = 0;

        foreach ($data['get_date'] as $i => $row) {
            $data['get_date'][$i]['count'] = $this->db->where('DATE(OD_DateTimeUpdate)', $row['Date'])->from('order')->count_all_results();
            $query  = $this->db->select_sum('OD_FullSumPrice');
            $query  = $this->db->where('DATE(OD_DateTimeUpdate)', $row['Date']);
            $query  = $this->db->get('order');
            $result = $query->result();
            $data['total'] += $result[0]->OD_FullSumPrice;
            $data['price'][$i] = $result[0]->OD_FullSumPrice;
        }

        $data['date_start']     = get_inpost('date-start')!=''?get_inpost('date-start'):'';
        $data['date_end']       = get_inpost('date-end')!=''?get_inpost('date-end'):'';
        $data['mode']           = $mode;
        $data['content_view']   = "statistic/back-end/total_sales";
        $data['title']          = "ยอดการขาย";

        if ($this->input->post('bt_submit2')) {
            $data['content_view']   = "statistic/back-end/print_sales";
            $data['table']          = "order";
            $data['field_allow']    = "OD_Allow";
            $this->print_sales($data);
        }
        else
            $this->template->load('index_page', $data);
	}

	public function total_amounts($mode = '1') {

        $between = " WHERE `OD_Allow` IN ('6','7') ";

        if (get_inpost('bt_submit1') != null || get_inpost('bt_submit2') != null) {
            $date_start = dateChange(get_inpost('date-start'), 2);
            $date_end   = dateChange(get_inpost('date-end'), 2);
            $between    = " WHERE DATE(`ODL_DateTimeUpdate`) >= '".$date_start."' AND DATE(`ODL_DateTimeUpdate`) <= '".$date_end."' AND `OD_Allow` IN ('6','7') ";
        }

        $products = $this->db->query(
            "   SELECT DISTINCT `product`.`P_ID`, `P_Name`, `P_IDCode`
                FROM `product`
                LEFT JOIN `order_list`  ON `product`.`P_ID`     = `order_list`.`P_ID`
                LEFT JOIN `order`       ON `order_list`.`OD_ID` = `order`.`OD_ID`
                {$between}   "
        );

        if ($products->num_rows() > 0) {
            foreach ($products->result() as $row) {
                $summary = $this->db->query(
                    "   SELECT `P_Name`, `P_IDCode`,
                        SUM(`ODL_Amount`)       AS `ODL_Amount`,
                        SUM(`ODL_FullSumPrice`) AS `ODL_FullSumPrice`
                        FROM `order_list`
                        LEFT JOIN `product` ON `order_list`.`P_ID`  = `product`.`P_ID`
                        LEFT JOIN `order`   ON `order_list`.`OD_ID` = `order`.`OD_ID`
                        WHERE `product`.`P_ID` = '$row->P_ID'   "
                );
                $data['summary'][] = $summary->result();
            }
        }
        else
            $data['summary'] = array();

        $data['get_date'] = $this->db->query(
            "   SELECT DISTINCT
                DATE(`ODL_DateTimeUpdate`)  AS `Date`,
                DATE(`ODL_DateTimeAdd`)     AS `DateAdd`
                FROM `order_list`
                LEFT JOIN `order` ON `order_list`.`OD_ID` = `order`.`OD_ID`
                {$between}
                ORDER BY `ODL_DateTimeUpdate` ASC   "
        )->result_array();

        foreach ($data['get_date'] as $i => $row) {
            $data['get_date'][$i]['count'] = $this->db->where('DATE(ODL_DateTimeUpdate)', $row['Date'])->from('order_list')->count_all_results();
        }

        $data['date_start']     = get_inpost('date-start')!=''?get_inpost('date-start'):'';
        $data['date_end']       = get_inpost('date-end')!=''?get_inpost('date-end'):'';
        $data['mode']           = $mode;
        $data['content_view']   = "statistic/back-end/total_amounts";
        $data['title']          = "สินค้าที่ขายได้";

        if ($this->input->post('bt_submit2')) {
            $data['content_view']   = "statistic/back-end/print_amounts";
            $this->print_amounts($data);
        }
        else
            $this->template->load('index_page', $data);
    }

	public function print_sales($data = array()) {
        $pdfFilePath = $data['title'].'.pdf';
        $html = $this->load->view($data['content_view'], $data, true);
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $pdf = new mPDF('tha', 'A4', '14');
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        $pdf->SetDisplayMode('fullpage');
        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $pdf->WriteHTML(file_get_contents(base_url('assets/admin/css/print.css')), 1);
        $pdf->WriteHTML($html, 2);
        $pdf->Output($pdfFilePath, 'I');
    }

    public function print_amounts($data = array()) {
        $pdfFilePath = $data['title'].'.pdf';
        $html = $this->load->view($data['content_view'], $data, true);
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $pdf = new mPDF('tha', 'A4', '14');
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        $pdf->SetDisplayMode('fullpage');
        $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
        $pdf->WriteHTML(file_get_contents(base_url('assets/admin/css/print.css')), 1);
        $pdf->WriteHTML($html, 2);
        $pdf->Output($pdfFilePath, 'I');
    }

	public function login() {
		if (get_session('M_ID') != '') redirect('control', 'refresh');
		else {
			$data = array(
				'title' 	=> 'ลงชื่อเข้าใช้',
				'captcha'	=> $this->admin_model->createCaptcha()
			);
			$this->template->load('login', $data);
		}
	}

	public function admin_access() {
		if (get_session('M_ID') != '') redirect('control', 'refresh');
		else {
			$row = rowArray($this->admin_model->getLoginEncryptAdmin(get_inpost('user_id'), get_inpost('user_pass')));
			if (isset($row['M_ID']) && $this->admin_model->ConfirmCaptcha()) {
				if ($row['M_Allow'] !== '3') {
					set_session('M_ID', 		$row['M_ID']);
					set_session('M_Username', 	$row['M_Username']);
					$M_TName_arr = array(
						'1' => 'นาง',
						'2' => 'นางสาว',
						'3' => 'นาย',
						'4' => 'ไม่ระบุ'
					);
					set_session('M_flName', $M_TName_arr[$row['M_TName']].$row['M_flName']);
					if ($row['M_Img'] !== '')
						set_session('M_Img', $row['M_Img']);
					else
						set_session('M_Img', 'no_img.jpg');
					set_session('M_Type', $row['M_Type']);
				}
				else
					print("<script language='javascript'>alert('Please Contact Support!');</script>");
			}
			else
				print("<script language='javascript'>alert('Login Failed!');</script>");
			redirect('control/login', 'refresh');
		}
	}

	public function forgot_password() {
		$data = array('title' => 'ลืมรหัสผ่าน');
		$this->template->load('forgot_password', $data);
	}

	public function password_sending() {
		$webconfig = rowArray($this->common_model->getTable('webconfig'));
		if ($this->input->post('email') == '')
			redirect('control/forgot_password', 'refresh');
		else {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			if ($this->form_validation->run() === false) {
				echo "<script language='javascript'>alert('The email address is not valid or in the wrong format!'); history.back(); </script>";
				exit();
			}
			else {
				$admin = rowArray($this->common_model->get_where_custom_and('admin', array('M_Email' => $this->input->post('email'), 'M_Allow' => '1')));
				if (count($admin) > 0) {
					if (isset($admin['M_Email'])) {
						$config['useragent']	= $webconfig['WD_Name'];
				        $config['mailtype']     = 'html';
				        $this->email->initialize($config);
				        $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
				        $this->email->to($this->input->post('email'));
				        $this->email->subject('อีเมลตอบกลับจาก '.$webconfig['WD_Name']);
				        $this->email->message('Username: '.$admin['M_Username'].'<br>Password: '.$this->encrypt->decode($admin['M_Password']).'<br>Login here: <a href="'.base_url('control/login').'" target="_blank">'.base_url('control/login').'</a>');
				        @$this->email->send();
				        print("<script language='javascript'>alert('Send completed. Please check your email inbox.');</script>");
				    }
				    else
				    	print("<script language='javascript'>alert('Please check your email!'); history.back();</script>");
				}
				else
					print("<script language='javascript'>alert('No email in the system Or User is Blocked. Please contact your system administrator!'); history.back();</script>");
			}
			redirect('control/login', 'refresh');
		}
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('control/login', 'refresh');
	}

}