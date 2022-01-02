<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Control_statistic extends MX_Controller {

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
                'name'      => 'admin_template1',
				'setting'   => array('data_output' => '')
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
                'crud_level_model',
            )
        );

        $this->permission_model->getOnceWebMain();
        $this->statistic_view_model->getBackLogMain();
        $this->product_type_model->productTypeDailyUpdate();
	}

	public function index() {
		redirect('statistic/control_statistic/view_history', 'refresh');
	}

	public function view_history($mode = '1') {
        $between = '';

        if (get_inpost('bt_submit1') != null) {
            $date_start = dateChange(get_inpost('date-start'), 2);
            $date_end   = dateChange(get_inpost('date-end'), 2);
            $between    = " WHERE DATE(S_DateTime) >= '".$date_start."' AND DATE(S_DateTime) <= '".$date_end."' ";
        }

        $data['get_date']   = $this->db->query(" SELECT DISTINCT DATE(S_DateTime) AS Date FROM statistics {$between} ORDER BY S_DateTime ASC ")->result_array();
        $data['total']      = 0;

        foreach ($data['get_date'] as $i => $row) {
            $data['get_date'][$i]['count'] = $this->db->where('DATE(S_DateTime)', $row['Date'])->where('S_Type', $mode)->from('statistics')->count_all_results();
            $data['total'] += $data['get_date'][$i]['count'];
        }

        $data['date_start']     = get_inpost('date-start')!=''?get_inpost('date-start'):'';
        $data['date_end']       = get_inpost('date-end')!=''?get_inpost('date-end'):'';
        $data['mode']           = $mode;
        $data['content_view']   = "back-end/view_history";
        $data['title']          = "ประวัติการเข้าชม";

        $this->template->load('index_page', $data);
    }

    public function total_sales($mode = '1') {
        $between = " WHERE OD_Allow IN ('6','7') ";

        if (get_inpost('bt_submit1') != null || get_inpost('bt_submit2') != null) {
            $date_start = dateChange(get_inpost('date-start'), 2);
            $date_end   = dateChange(get_inpost('date-end'), 2);
            $between    = " WHERE DATE(`OD_DateTimeUpdate`) >= '".$date_start."' AND DATE(`OD_DateTimeUpdate`) <= '".$date_end."' AND OD_Allow IN ('6','7') ";
        }

        $data['get_date']   = $this->db->query(" SELECT DISTINCT DATE(`OD_DateTimeUpdate`) AS `Date`, DATE(`OD_DateTimeAdd`) AS `DateAdd`, `OD_Code`, `M_flName` FROM `order` LEFT JOIN `admin` ON `order`.`OD_UserUpdate` = `admin`.`M_ID` {$between} ORDER BY `OD_DateTimeUpdate` ASC ")->result_array();
        $data['total']      = 0;
        $data['price'][0]   = 0;
        // $data['sum']        = 0;
        // $data['amount'][0]  = 0;

        foreach ($data['get_date'] as $i => $row) {
            $data['get_date'][$i]['count'] = $this->db->where('DATE(OD_DateTimeUpdate)', $row['Date'])->from('order')->count_all_results();
            $query  = $this->db->select_sum('OD_FullSumPrice');
            $query  = $this->db->where('DATE(OD_DateTimeUpdate)', $row['Date']);
            $query  = $this->db->get('order');
            $result = $query->result();
            $data['total'] += $result[0]->OD_FullSumPrice;
            $data['price'][$i] = $result[0]->OD_FullSumPrice;
            // $query  = $this->db->select_sum('ODL_Amount');
            // $query  = $this->db->join('order_list', 'order.OD_ID = order_list.OD_ID');
            // $query  = $this->db->where('DATE(OD_DateTimeUpdate)', $row['Date']);
            // $query  = $this->db->get('order');
            // $result = $query->result();
            // $data['sum'] += $result[0]->ODL_Amount;
            // $data['amount'][$i] = $result[0]->ODL_Amount;
        }

        $data['date_start']     = get_inpost('date-start')!=''?get_inpost('date-start'):'';
        $data['date_end']       = get_inpost('date-end')!=''?get_inpost('date-end'):'';
        $data['mode']           = $mode;
        $data['content_view']   = "back-end/total_sales";
        $data['title']          = "ยอดการขาย";

        if ($this->input->post('bt_submit2')) {
            $data['content_view']   = "back-end/print_sales";
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
        $data['content_view']   = "back-end/total_amounts";
        $data['title']          = "สินค้าที่ขายได้";

        if ($this->input->post('bt_submit2')) {
            $data['content_view']   = "back-end/print_amounts";
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

    public function stock_report() {
        $this->crud_level_model->crudStateEnabled(/*add*/false,/*view*/true,/*edit*/false,/*del*/false,/*export*/true,/*print*/true);

        $title = 'รายงานสต็อกสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_stock');
        $crud->order_by('P_ID, PS_ID', 'desc');

        // $crud->set_relation('P_ID',             'product',  'P_Name');
        $crud->set_relation('PS_UserUpdate',    'admin',    'M_flName');

        $crud->display_as('PS_ID',                  'รหัสสต็อก');
        $crud->display_as('P_ID',                   'สินค้า');
        $crud->display_as('PS_Price',               'ราคาล่าสุด');
        $crud->display_as('PS_Price_Log',           'การเปลี่ยนราคาต่อหน่วย');
        $crud->display_as('PS_Amount',              'จำนวนคงเหลือ');
        $crud->display_as('PS_Amount_Log',          'การเปลี่ยนจำนวน');
        $crud->display_as('PS_SumPrice',            'ราคารวม');
        $crud->display_as('PS_SumPrice_Log',        'การเปลี่ยนราคารวม');
        // $crud->display_as('PS_FullSumPrice',        'ราคาเต็มแบบไม่คิดส่วนลด');
        $crud->display_as('PS_FullSumPrice',        'ราคาล่าสุด');
        // $crud->display_as('PS_FullSumPrice_Log',    'การเปลี่ยนราคาเต็มแบบไม่คิดส่วนลด');
        $crud->display_as('PS_FullSumPrice_Log',    'การเปลี่ยนราคา');
        $crud->display_as('PS_UserUpdate',          'ผู้อัพเดท');
        $crud->display_as('PS_DateTimeUpdate',      'วันเวลาที่อัพเดท');
        $crud->display_as('PS_Allow',               'สถานะ');

        $crud->columns('PS_DateTimeUpdate', 'P_ID', 'PS_Amount_Log', 'PS_Amount', 'PS_FullSumPrice_Log', 'PS_FullSumPrice');

        $crud->callback_column('P_ID',                  array($this, '_callback_P_ID'));
        $crud->callback_column('PS_Amount',             array($this, '_callback_PS_Amount'));
        $crud->callback_column('PS_Amount_Log',         array($this, '_callback_PS_Amount_Log'));
        $crud->callback_column('PS_FullSumPrice',       array($this, '_callback_PS_FullSumPrice'));
        $crud->callback_column('PS_FullSumPrice_Log',   array($this, '_callback_PS_FullSumPrice_Log'));

        $crud->field_type('PS_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        $crud->unset_edit();
        // $crud->unset_export();
        // $crud->unset_list();
        // $crud->unset_print();
        $crud->unset_read();
        // $crud->unset_texteditor(array());

        $output = $crud->render();
        if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    }

    public function _callback_P_ID($value, $row) {
        $product = rowArray($this->common_model->get_where_custom('product', 'P_ID', $value));
        return '<a href="'.base_url('statistic/control_statistic/stock_detail/view/'.$value).'">'.$product['P_IDCode'].'</a>';
    }

    public function _callback_PS_Amount($value, $row) {
        return number_format($value);
    }

    public function _callback_PS_Amount_Log($value, $row) {
        if ($value == 0)
            return number_format($value);
        else if ($row->PS_Amount_Type === '1')
            return '<span style="color:green;font-weight:bold">+ '.number_format($value).'</span> ';
        else if ($row->PS_Amount_Type === '2')
            return '<span style="color:red;font-weight:bold">- '.number_format($value).'</span> ';
        else if ($row->PS_Amount_Type === '3')
            return number_format($value);
        else
            return number_format($value);
    }

    public function _callback_PS_FullSumPrice($value, $row) {
        return number_format($value, 2, '.', ',');
    }

    public function _callback_PS_FullSumPrice_Log($value, $row) {
        if ($value == 0)
            return number_format($value, 2, '.', ',');
        else if ($row->PS_Price_Type === '1')
            return '<span style="color:green;font-weight:bold">+ '.number_format($value, 2, '.', ',').'</span> ';
        else if ($row->PS_Price_Type === '2')
            return '<span style="color:red;font-weight:bold">- '.number_format($value, 2, '.', ',').'</span> ';
        else if ($row->PS_Price_Type === '3')
            return number_format($value, 2, '.', ',');
        else
            return number_format($value, 2, '.', ',');
    }

    public function stock_detail($state = null, $P_ID = null) {
        $data = array(
            'content_view'  => 'back-end/stock_detail',
            'title'         => 'รายละเอียดรายงานสต็อกสินค้า',
            'P_ID'          => $P_ID
        );
        if (uri_seg(4) == 'view')
            $this->template->load('index_page', $data);
        else if (uri_seg(4) == 'print') {
            $pdfFilePath = 'รายละเอียดรายงานสต็อกสินค้า.pdf';
            $html = $this->load->view('back-end/stock_detail', $data, true);
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
    }

    public function user_history() {
        $this->crud_level_model->crudStateEnabled(/*add*/false,/*view*/false,/*edit*/false,/*del*/false,/*export*/true,/*print*/true);

        $title = 'ประวัติการใช้งาน';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('statistics');
        $crud->where('S_Type = ', '2');
        $crud->order_by('S_DateTime', 'desc');

        $crud->set_primary_key('S_DateTime', 'statistics');
        $crud->set_relation('ID', 'admin', 'M_flName');

        $crud->display_as('S_DateTime',     'วันเวลาที่เข้าใช้งาน');
        $crud->display_as('S_IP',           'หมายเลข IP');
        $crud->display_as('S_UserAgent',    'User Agent');
        $crud->display_as('ID',             'ผู้ใช้งาน');

        $crud->columns('S_DateTime', 'S_IP', 'ID');

        $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        $crud->unset_edit();
        // $crud->unset_export();
        // $crud->unset_list();
        // $crud->unset_print();
        $crud->unset_read();
        // $crud->unset_texteditor(array());

        $output = $crud->render();
        if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    }

    public function _example_output($output = null, $title = null) {
        $data = array(
            'content_view'  => $output,
            'title'         => $title
        );
        $this->template->load('index_page', $data);
    }

}
