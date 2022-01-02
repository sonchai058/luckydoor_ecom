<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Control_product extends MX_Controller {

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
                'delete_action_model',
                'fill_dropdown_model',
                'product_type_model',
                'crud_level_model',
            )
		);

        $this->permission_model->getOnceWebMain();
        $this->statistic_view_model->getBackLogMain();
        $this->product_type_model->productTypeDailyUpdate();
	}

	public function index() {
		redirect('product/control_product/product_management', 'refresh');
	}

    public function stock_changed() {
        $stock_data = array(
            'P_ID'                  => $this->input->post('P_ID'),
            'PS_Price'              => $this->input->post('PS_Price'),
            'PS_Price_Log'          => $this->input->post('PS_Price_Log'),
            'PS_Amount'             => $this->input->post('PS_Amount'),
            'PS_Amount_Log'         => $this->input->post('PS_Amount_Log'),
            'PS_SumPrice'           => $this->input->post('PS_Price'),
            'PS_SumPrice_Log'       => $this->input->post('PS_Price_Log'),
            'PS_FullSumPrice'       => $this->input->post('PS_Price'),
            'PS_FullSumPrice_Log'   => $this->input->post('PS_Price_Log'),
            'PS_Price_Type'         => $this->input->post('PS_Price_Type'),
            'PS_Amount_Type'        => $this->input->post('PS_Amount_Type'),
            'PS_UserUpdate'         => get_session('M_ID'),
            'PS_DateTimeUpdate'     => date('Y-m-d H:i:s'),
            'PS_Allow'              => '1'
        );
        $P_ID = $this->input->post('P_ID');
        $this->common_model->insert('product_stock', $stock_data);
        $this->db->query(" UPDATE `product_stock` SET `PS_Allow` = '3' WHERE `P_ID` = '$P_ID' ");
        $this->db->query(" UPDATE `product_stock` SET `PS_Allow` = '1' WHERE `P_ID` = '$P_ID' ORDER BY `PS_ID` DESC LIMIT 1 ");
    }

    // public function promotion_changed() {
    //     $promotion_data = array(
    //         'P_ID'                  => $this->input->post('P_ID'),
    //         'PP_StartDate'          => $this->input->post('PP_StartDate'),
    //         'PP_EndDate'            => $this->input->post('PP_EndDate'),
    //         'PP_Special'            => $this->input->post('PP_Special'),
    //         'PP_Name'               => $this->input->post('PP_Name'),
    //         'PP_Title'              => $this->input->post('PP_Title'),
    //         'PP_Descript'           => $this->input->post('PP_Descript'),
    //         'PP_Remark'             => $this->input->post('PP_Remark'),
    //         'PP_Price'              => $this->input->post('PP_Price'),
    //         'PP_SumPrice'           => $this->input->post('PP_Price'),
    //         'PP_FullSumPrice'       => $this->input->post('PP_Price'),
    //         'PP_UserUpdate'         => get_session('M_ID'),
    //         'PP_DateTimeUpdate'     => date('Y-m-d H:i:s'),
    //         'PP_Allow'              => '1'
    //     );
    //     $this->common_model->insert('product_price', $promotion_data);
    // }

    public function product_stock() {
        $data = array(
            'P_ID'              => $this->db->escape_str(uri_seg(5)),
            'PS_Price_amount'   => $this->db->escape_str(uri_seg(4))
        );
        $this->load->view('back-end/stock_dialog', $data);
    }

    // public function product_promotion() {
    //     $data = array('P_ID' => $this->db->escape_str(uri_seg(4)));
    //     $this->load->view('back-end/promotion_dialog', $data);
    // }

	// public function _callback_PS_Price($value, $row) {
 //        $prices = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' ORDER BY PS_ID DESC LIMIT 1 ");
 //        if (count($prices) > 0) {
 //            $price = rowArray($prices);
 //            return number_format($price['PS_FullSumPrice'], 2, '.', '').'&#160;<a href="'.base_url('product/control_product/product_stock/price').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้า"></a>';
 //        }
 //        else
 //            return number_format(0, 0, '.', '').'&#160;<a href="'.base_url('product/control_product/product_stock/price').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้า"></a>';
 //    }

 //    public function _callback_PS_Amount($value, $row) {
 //        $amounts = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' AND PS_Allow = '1' ");
 //        if (count($amounts) > 0) {
 //            $amount = rowArray($amounts);
 //            return number_format($amount['PS_Amount'], 0, '.', '').'&#160;<a href="'.base_url('product/control_product/product_stock/amount').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขจำนวนสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขจำนวนสินค้า"></a>';
 //        }
 //        else
 //            return number_format(0, 0, '.', '').'&#160;<a href="'.base_url('product/control_product/product_stock/amount').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขจำนวนสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขจำนวนสินค้า"></a>';
 //    }

 //    public function _callback_PP_Price($value, $row) {
 //        $prices = $this->common_model->custom_query(" SELECT * FROM product_price WHERE P_ID = '$row->P_ID' ORDER BY PP_ID DESC LIMIT 1 ");
 //        if (count($prices) > 0) {
 //            $price = rowArray($prices);
 //            return number_format($price['PP_FullSumPrice'], 2, '.', '').'&#160;<a href="'.base_url('product/control_product/product_promotion').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้าโปรโมชั่น"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้าโปรโมชั่น"></a>';
 //        }
 //        else
 //            return number_format(0, 2, '.', '').'&#160;<a href="'.base_url('product/control_product/product_promotion').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้าโปรโมชั่น"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้าโปรโมชั่น"></a>';
 //    }

    public function _callback_PS_Price($value, $row) {
        $prices = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' ORDER BY PS_ID DESC LIMIT 1 ");
        if (count($prices) > 0) {
            $price = rowArray($prices);
            return number_format($price['PS_FullSumPrice'], 2, '.', '').'&#160;<a href="'.base_url('product/control_product/product_stock/price').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>';
        }
        else
            return number_format(0, 0, '.', '').'&#160;<a href="'.base_url('product/control_product/product_stock/price').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>';
    }

    public function _callback_PS_Amount($value, $row) {
        $amounts = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$row->P_ID' AND PS_Allow = '1' ");
        if (count($amounts) > 0) {
            $amount = rowArray($amounts);
            return number_format($amount['PS_Amount'], 0, '.', '').'&#160;<a href="'.base_url('product/control_product/product_stock/amount').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>';
        }
        else
            return number_format(0, 0, '.', '').'&#160;<a href="'.base_url('product/control_product/product_stock/amount').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>';
    }

    // public function _callback_PP_Price($value, $row) {
    //     $prices = $this->common_model->custom_query(" SELECT * FROM product_price WHERE P_ID = '$row->P_ID' ORDER BY PP_ID DESC LIMIT 1 ");
    //     if (count($prices) > 0) {
    //         $price = rowArray($prices);
    //         return number_format($price['PP_FullSumPrice'], 2, '.', '').'&#160;<a href="'.base_url('product/control_product/product_promotion').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>';
    //     }
    //     else
    //         return number_format(0, 2, '.', '').'&#160;<a href="'.base_url('product/control_product/product_promotion').'/'.$row->P_ID.'" class="various fancybox.ajax crud-action"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>';
    // }

    public function _callback_PP_Price($value, $row) {
        $prices = $this->common_model->custom_query(" SELECT * FROM product_price WHERE P_ID = '$row->P_ID' AND PP_Allow != '3' AND (NOW() BETWEEN PP_StartDate AND PP_EndDate )  ORDER BY PP_ID DESC LIMIT 1 ");
        if (count($prices) > 0) {
            $price = rowArray($prices);
            return number_format($price['PP_FullSumPrice'], 2, '.', '');
        }
        else
            return number_format(0, 2, '.', '');
    }

    public function sendNewProductToEmail($post_array, $primary_key) {
        $category = rowArray($this->common_model->get_where_custom('category', 'C_ID', $post_array['C_ID']));
        if (count($category) > 0) {
            $member_email = $this->common_model->custom_query(" SELECT `M_Email` FROM `member` WHERE `M_Allow` != '3' ");
            if (count($member_email) > 0) {
                $member_email_list = array();
                foreach ($member_email as $email_member) {
                    array_push($member_email_list, $email_member);
                }
                $data = array(
                    'P_ID'          => $primary_key,
                    'P_Img'         => $post_array['P_Img'],
                    'P_Name'        => $post_array['P_Name'],
                    'P_IDCode'      => $post_array['P_IDCode'],
                    'C_Name'        => $post_array['C_Name'],
                    'P_Title'       => $post_array['P_Title'],
                    'P_Detail'      => $post_array['P_Detail'],
                    'document_type' => 'html'
                );
                $sites = $this->webinfo_model->getOnceWebMain();
                $config['useragent'] = $sites['WD_Name'];
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from($sites['WD_Email'], $sites['WD_Name']);
                $this->email->to($member_email_list);
                $this->email->subject('สินค้ามาใหม่จาก '.$sites['WD_Name']);
                $this->email->message($this->load->view('web_template1/email/new_product', $data, true));
                $this->email->send();
            }
        }
        return true;
    }

    public function _callback_PT_ID($value, $row) {
        $pt_string = '';
        $pt_buffer = explode(',', $value);
        $pt_images = array('1' => 'new.png',    '2' => 'promotion.png', '3' => 'hot.png');
        $pt_pnames = array('1' => 'New Collection',        '2' => 'Products',     '3' => 'Hot Sale');
        foreach ($pt_buffer as $key => $pt_values) {
            if (array_key_exists($pt_values, $pt_images)) {
                $pt_string .= '<img src="'.base_url('assets/admin/images/'.$pt_images[$pt_values]).'" alt="" title="'.$pt_pnames[$pt_values].'"><br>'.$pt_pnames[$pt_values].'<br>';
            }
        }
        return $pt_string;
    }

	public function product_management() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/true,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
		$this->delete_action_model->del_action('product', 'P_UserUpdate', 'P_DateTimeUpdate', 'P_Allow', 'P_ID');
        $this->viewer_action_model->vie_action('product', 'P_ID', 'P_Allow', 'back-end/product_detail', 'สินค้า', array('รายละเอียดสินค้า', 'รายละเอียดโปรโมชั่น'));

        $title = 'สินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product');
        $crud->set_theme('datatables');
        $crud->where("product.P_Allow != ", "3");
        $crud->order_by("C_ID");

        $crud->set_relation('C_ID',		'category', 'C_Name');
        $crud->set_relation('PU_ID',	'product_unit', 'PU_Name');

        $crud->display_as('P_ID',           	'ไอดี');
        $crud->display_as('P_Img',          	'รูปภาพขนาดจริง');
        $crud->display_as('P_Name',     		'ชื่อสินค้า');
        $crud->display_as('P_IDCode',        	'รหัสสินค้า');
        $crud->display_as('C_ID',       		'หมวดหมู่หลัก');
        $crud->display_as('PT_ID',       		'ชนิด');
        $crud->display_as('PU_ID',          	'หน่วยนับ');
        $crud->display_as('P_Weight',           'น้ำหนัก (กก.)');
        $crud->display_as('P_Color',            'สีของสินค้า');
        $crud->display_as('P_Size',         	'ไซต์');
        $crud->display_as('P_Title',         	'ไตเติ้ล / เรื่องย่อ');
        $crud->display_as('P_Detail',         	'รายละเอียด');
        $crud->display_as('P_UserAdd',          'ผู้เพิ่ม');
        $crud->display_as('P_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('P_UserUpdate',     	'ผู้อัพเดท');
        $crud->display_as('P_DateTimeUpdate',	'วันเวลาที่อัพเดท');
        $crud->display_as('P_Allow',        	'สถานะ');
        $crud->display_as('PS_Price',        	'ราคา (ล่าสุด)');
        $crud->display_as('PS_Amount',        	'จำนวน');
        $crud->display_as('PP_Price',           'ราคา (โปรโมชั่น)');

        $crud->required_fields('P_Name', 'P_IDCode', 'C_ID', 'P_Weight', 'P_Allow');

        $crud->set_rules('P_Name',      'ชื่อสินค้า', 'required');
        $crud->set_rules('P_IDCode',    'รหัสสินค้า', 'required');
        $crud->set_rules('C_ID',        'หมวดหมู่หลัก', 'required');
        $crud->set_rules('P_Weight',    'น้ำหนัก (กก.)', 'required|numeric');

        $crud->columns('P_Img', 'P_IDCode', 'P_Name', 'PS_Price', 'PP_Price', 'PS_Amount', 'C_ID', 'PT_ID');
        // $crud->columns('P_Img', 'P_IDCode', 'P_Name', 'PS_Price', 'PS_Amount', 'C_ID', 'PT_ID');

        $crud->callback_column('PS_Price',  array($this, '_callback_PS_Price'));
        $crud->callback_column('PS_Amount', array($this, '_callback_PS_Amount'));
        $crud->callback_column('PP_Price',  array($this, '_callback_PP_Price'));
        $crud->callback_column('PT_ID',     array($this, '_callback_PT_ID'));
        // $crud->callback_after_insert(array($this, 'sendNewProductToEmail'));

        $crud->add_fields('P_Img', 'P_Name', 'P_IDCode', 'C_ID', 'P_Weight', 'P_Color', 'PT_ID', 'PU_ID', 'P_Size', 'P_Title', 'P_Detail', 'P_UserAdd', 'P_DateTimeAdd', 'P_UserUpdate', 'P_DateTimeUpdate', 'P_Allow');
        $crud->edit_fields('P_Img', 'P_Name', 'P_IDCode', 'C_ID', 'P_Weight', 'P_Color', 'PT_ID', 'PU_ID', 'P_Size', 'P_Title', 'P_Detail', 'P_UserUpdate', 'P_DateTimeUpdate', 'P_Allow');

        $crud->field_type('P_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));
        $crud->field_type('PT_ID', 'multiselect', $this->fill_dropdown_model->getOnceWebMain('product_type', 'PT_ID', 'PT_Name'));
        $crud->field_type('P_Color', 'multiselect', $this->fill_dropdown_model->getOnceWebMain('product_color', 'PC_ID', 'PC_Name'));

        if ($crud->getState() == 'add') {
            $crud->field_type('P_Allow',        	'hidden', '1');
            $crud->field_type('P_UserAdd',      	'hidden', get_session('M_ID'));
            $crud->field_type('P_DateTimeAdd',  	'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('P_UserUpdate',   	'hidden', get_session('M_ID'));
            $crud->field_type('P_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('P_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('P_DateTimeUpdate',	'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'print' || $crud->getState() == 'export') $crud->unset_columns('P_Img');

        $crud->set_field_upload('P_Img', 'assets/uploads/user_uploads_img');

        $crud->add_action('ข้อมูล', base_url('assets/admin/images/tools/magnifier.png'), 'product/control_product/product_management/view');
        $crud->add_action('ลบ', base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/product_management/del', 'del-row');

        // $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        // $crud->unset_export();
        // $crud->unset_list();
        // $crud->unset_print();
        $crud->unset_read();
        $crud->unset_texteditor(array('P_Title', 'P_Detail'));
        $crud->unset_read_fields('P_ThumbImg');

        $output = $crud->render();
        if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
	}

    // public function category_management() {
    //     $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/false,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
    //     $this->delete_action_model->del_action('category', 'C_UserUpdate', 'C_DateTimeUpdate', 'C_Allow', 'C_ID');

    //     $title = 'หมวดหมู่สินค้า';
    //     $crud = new grocery_CRUD();
    //     $crud->set_language('thai');
    //     $crud->set_subject($title);
    //     $crud->set_table('category');
    //     $crud->where("category.C_Allow != ", "3");
    //     $crud->order_by("C_Order", "asc");

    //     $crud->display_as('C_ID',               'ไอดี');
    //     $crud->display_as('C_Name',             'ชื่อหมวดหมู่');
    //     $crud->display_as('C_Descrip',          'คำอธิบาย / รายละเอียด');
    //     $crud->display_as('C_Order',            'ลำดับที่');
    //     $crud->display_as('C_UserAdd',          'ผู้เพิ่ม');
    //     $crud->display_as('C_DateTimeAdd',      'วันเวลาที่เพิ่ม');
    //     $crud->display_as('C_UserUpdate',       'ผู้อัพเดท');
    //     $crud->display_as('C_DateTimeUpdate',   'วันเวลาที่อัพเดท');
    //     $crud->display_as('C_Allow',            'สถานะ');

    //     $crud->required_fields('C_Name', 'C_Order', 'C_Allow');

    //     $crud->columns('C_Order', 'C_Name', 'C_Descrip');

    //     $crud->add_fields('C_Name', 'C_Order', 'C_Descrip', 'C_UserAdd', 'C_DateTimeAdd', 'C_UserUpdate', 'C_DateTimeUpdate', 'C_Allow');
    //     $crud->edit_fields('C_Name', 'C_Order', 'C_Descrip', 'C_UserUpdate', 'C_DateTimeUpdate', 'C_Allow');

    //     $crud->field_type('C_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

    //     if ($crud->getState() == 'add') {
    //         $crud->field_type('C_Allow',            'hidden', '1');
    //         $crud->field_type('C_UserAdd',          'hidden', get_session('M_ID'));
    //         $crud->field_type('C_DateTimeAdd',      'hidden', date("Y-m-d H:i:s"));
    //         $crud->field_type('C_UserUpdate',       'hidden', get_session('M_ID'));
    //         $crud->field_type('C_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
    //     }
    //     if ($crud->getState() == 'edit') {
    //         $crud->field_type('C_UserUpdate',       'hidden', get_session('M_ID'));
    //         $crud->field_type('C_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
    //     }

    //     $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/category_management/del', 'del-row');

    //     // $crud->unset_add();
    //     // $crud->unset_back_to_list();
    //     $crud->unset_delete();
    //     // $crud->unset_edit();
    //     // $crud->unset_export();
    //     // $crud->unset_list();
    //     // $crud->unset_print();
    //     $crud->unset_read();
    //     $crud->unset_texteditor(array('C_Descrip'));

    //     $output = $crud->render();
    //     if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    // }

    public function product_size_manage() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/false,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('product_size', 'PSI_UserUpdate', 'PSI_DateTimeUpdate', 'PSI_Allow', 'PSI_ID');

        $title = 'ขนาด / รูปทรงสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_size');
        $crud->where("product_size.PSI_Allow != ", "3");
        $crud->order_by("PSI_ID", "asc");

        $crud->display_as('PSI_ID',              'ไอดี');
        $crud->display_as('PSI_Name',            'ชื่อขนาด');
        $crud->display_as('PSI_Note',            'หมายเหตุ รูปทรง (เพิ่มเติม)');
        $crud->display_as('PSI_Order',           'ลำดับที่');
        $crud->display_as('PSI_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('PSI_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PSI_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PSI_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('PSI_Allow',           'สถานะ');

        $crud->required_fields('PSI_Name', 'PSI_Allow');

        $crud->columns('PSI_Name', 'PSI_Note');

        $crud->add_fields('PSI_Name', 'PSI_Note', 'PSI_UserAdd', 'PSI_DateTimeAdd', 'PSI_UserUpdate', 'PSI_DateTimeUpdate', 'PSI_Allow');
        $crud->edit_fields('PSI_Name', 'PSI_Note', 'PSI_UserUpdate', 'PSI_DateTimeUpdate', 'PSI_Allow');

        $crud->field_type('PSI_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('PSI_Allow',           'hidden', '1');
            $crud->field_type('PSI_UserAdd',         'hidden', get_session('M_ID'));
            $crud->field_type('PSI_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PSI_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PSI_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PSI_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PSI_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/product_size_manage/del', 'del-row');

        // $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        // $crud->unset_export();
        // $crud->unset_list();
        // $crud->unset_print();
        $crud->unset_read();
        // $crud->unset_texteditor(array());

        $output = $crud->render();
        if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    }

    // public function product_type_manage() {
    //     $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/false,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
    //     $this->delete_action_model->del_action('product_type', 'PT_UserUpdate', 'PT_DateTimeUpdate', 'PT_Allow', 'PT_ID');

    //     $title = 'ชนิดสินค้า';
    //     $crud = new grocery_CRUD();
    //     $crud->set_language('thai');
    //     $crud->set_subject($title);
    //     $crud->set_table('product_type');
    //     $crud->where("product_type.PT_Allow != ", "3");
    //     $crud->order_by("PT_ID", "asc");

    //     $crud->display_as('PT_ID',              'ไอดี');
    //     $crud->display_as('PT_Name',            'ชื่อชนิด');
    //     $crud->display_as('PT_Order',           'ลำดับที่');
    //     $crud->display_as('PT_UserAdd',         'ผู้เพิ่ม');
    //     $crud->display_as('PT_DateTimeAdd',     'วันเวลาที่เพิ่ม');
    //     $crud->display_as('PT_UserUpdate',      'ผู้อัพเดท');
    //     $crud->display_as('PT_DateTimeUpdate',  'วันเวลาที่อัพเดท');
    //     $crud->display_as('PT_Allow',           'สถานะ');

    //     $crud->required_fields('PT_Name', 'PT_Allow');

    //     $crud->columns('PT_Name');

    //     $crud->add_fields('PT_Name', 'PT_UserAdd', 'PT_DateTimeAdd', 'PT_UserUpdate', 'PT_DateTimeUpdate', 'PT_Allow');
    //     $crud->edit_fields('PT_Name', 'PT_UserUpdate', 'PT_DateTimeUpdate', 'PT_Allow');

    //     $crud->field_type('PT_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

    //     if ($crud->getState() == 'add') {
    //         $crud->field_type('PT_Allow',           'hidden', '1');
    //         $crud->field_type('PT_UserAdd',         'hidden', get_session('M_ID'));
    //         $crud->field_type('PT_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
    //         $crud->field_type('PT_UserUpdate',      'hidden', get_session('M_ID'));
    //         $crud->field_type('PT_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
    //     }
    //     if ($crud->getState() == 'edit') {
    //         $crud->field_type('PT_UserUpdate',      'hidden', get_session('M_ID'));
    //         $crud->field_type('PT_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
    //     }

    //     $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/product_type_manage/del', 'del-row');

    //     // $crud->unset_add();
    //     // $crud->unset_back_to_list();
    //     $crud->unset_delete();
    //     // $crud->unset_edit();
    //     // $crud->unset_export();
    //     // $crud->unset_list();
    //     // $crud->unset_print();
    //     $crud->unset_read();
    //     // $crud->unset_texteditor(array());

    //     $output = $crud->render();
    //     if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    // }

    // public function product_unit_manage() {
    //     $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/false,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
    //     $this->delete_action_model->del_action('product_unit', 'PU_UserUpdate', 'PU_DateTimeUpdate', 'PU_Allow', 'PU_ID');

    //     $title = 'หน่วยนับสินค้า';
    //     $crud = new grocery_CRUD();
    //     $crud->set_language('thai');
    //     $crud->set_subject($title);
    //     $crud->set_table('product_unit');
    //     $crud->where("product_unit.PU_Allow != ", "3");
    //     $crud->order_by("PU_ID", "asc");

    //     $crud->display_as('PU_ID',              'ไอดี');
    //     $crud->display_as('PU_Name',            'ชื่อหน่วยนับ');
    //     $crud->display_as('PU_Order',           'ลำดับที่');
    //     $crud->display_as('PU_UserAdd',         'ผู้เพิ่ม');
    //     $crud->display_as('PU_DateTimeAdd',     'วันเวลาที่เพิ่ม');
    //     $crud->display_as('PU_UserUpdate',      'ผู้อัพเดท');
    //     $crud->display_as('PU_DateTimeUpdate',  'วันเวลาที่อัพเดท');
    //     $crud->display_as('PU_Allow',           'สถานะ');

    //     $crud->required_fields('PU_Name', 'PU_Allow');

    //     $crud->columns('PU_Name');

    //     $crud->add_fields('PU_Name', 'PU_UserAdd', 'PU_DateTimeAdd', 'PU_UserUpdate', 'PU_DateTimeUpdate', 'PU_Allow');
    //     $crud->edit_fields('PU_Name', 'PU_UserUpdate', 'PU_DateTimeUpdate', 'PU_Allow');

    //     $crud->field_type('PU_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

    //     if ($crud->getState() == 'add') {
    //         $crud->field_type('PU_Allow',           'hidden', '1');
    //         $crud->field_type('PU_UserAdd',         'hidden', get_session('M_ID'));
    //         $crud->field_type('PU_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
    //         $crud->field_type('PU_UserUpdate',      'hidden', get_session('M_ID'));
    //         $crud->field_type('PU_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
    //     }
    //     if ($crud->getState() == 'edit') {
    //         $crud->field_type('PU_UserUpdate',      'hidden', get_session('M_ID'));
    //         $crud->field_type('PU_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
    //     }

    //     $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/product_unit_manage/del', 'del-row');

    //     // $crud->unset_add();
    //     // $crud->unset_back_to_list();
    //     $crud->unset_delete();
    //     // $crud->unset_edit();
    //     // $crud->unset_export();
    //     // $crud->unset_list();
    //     // $crud->unset_print();
    //     $crud->unset_read();
    //     // $crud->unset_texteditor(array());

    //     $output = $crud->render();
    //     if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    // }

    public function product_color_manage() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/false,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('product_color', 'PC_UserUpdate', 'PC_DateTimeUpdate', 'PC_Allow', 'PC_ID');

        $title = 'สีของสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_color');
        $crud->where("product_color.PC_Allow != ", "3");
        $crud->order_by("PC_ID", "asc");

        $crud->display_as('PC_ID',              'ไอดี');
        $crud->display_as('PC_Name',            'ชื่อสี');
        $crud->display_as('PC_Order',           'ลำดับที่');
        $crud->display_as('PC_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('PC_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PC_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PC_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('PC_Allow',           'สถานะ');

        $crud->required_fields('PC_Name', 'PC_Allow');

        $crud->columns('PC_Name');

        $crud->add_fields('PC_Name', 'PC_UserAdd', 'PC_DateTimeAdd', 'PC_UserUpdate', 'PC_DateTimeUpdate', 'PC_Allow');
        $crud->edit_fields('PC_Name', 'PC_UserUpdate', 'PC_DateTimeUpdate', 'PC_Allow');

        $crud->field_type('PC_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('PC_Allow',           'hidden', '1');
            $crud->field_type('PC_UserAdd',         'hidden', get_session('M_ID'));
            $crud->field_type('PC_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PC_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PC_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PC_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PC_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/product_color_manage/del', 'del-row');

        // $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        // $crud->unset_export();
        // $crud->unset_list();
        // $crud->unset_print();
        $crud->unset_read();
        // $crud->unset_texteditor(array());

        $output = $crud->render();
        if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    }

    public function weight_price_callback_insert($post_array) {
        if ($post_array['PW_SumPrice']      == '' || $post_array['PW_SumPrice']      == 0) $post_array['PW_SumPrice']       = $post_array['PW_Price'];
        if ($post_array['PW_FullSumPrice']  == '' || $post_array['PW_FullSumPrice']  == 0) $post_array['PW_FullSumPrice']   = $post_array['PW_Price'];
        return $post_array;
    }

    public function weight_price_callback_update($post_array, $primary_key) {
        if ($post_array['PW_SumPrice']      == '' || $post_array['PW_SumPrice']      == 0) $post_array['PW_SumPrice']       = $post_array['PW_Price'];
        if ($post_array['PW_FullSumPrice']  == '' || $post_array['PW_FullSumPrice']  == 0) $post_array['PW_FullSumPrice']   = $post_array['PW_Price'];
        return $post_array;
    }

    public function product_weight_manage() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/false,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('product_weight', 'PW_UserUpdate', 'PW_DateTimeUpdate', 'PW_Allow', 'PW_ID');

        $title = 'น้ำหนักของสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_weight');
        $crud->where("product_weight.PW_Allow != ", "3");
        $crud->order_by("PW_ID", "asc");

        $crud->display_as('PW_ID',              'ไอดี');
        $crud->display_as('PW_Weight',          'น้ำหนัก (กก.)');
        $crud->display_as('PW_Price',           'ราคาต่อหน่วย');
        $crud->display_as('PW_SumPrice',        'ราคารวม');
        $crud->display_as('PW_FullSumPrice',    'ราคารวมสุทธิ');
        $crud->display_as('PW_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('PW_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PW_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PW_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('PW_Allow',           'สถานะ');

        $crud->required_fields('PW_Weight', 'PW_Price', 'PW_Allow');

        $crud->set_rules('PW_Price',        'ราคาต่อหน่วย', 'numeric|required');
        $crud->set_rules('PW_SumPrice',     'ราคารวม', 'numeric');
        $crud->set_rules('PW_FullSumPrice', 'ราคารวมสุทธิ', 'numeric');

        $crud->columns('PW_Weight', 'PW_Price');
        $crud->callback_before_insert(array($this, 'weight_price_callback_insert'));
        $crud->callback_before_update(array($this, 'weight_price_callback_update'));

        $crud->add_fields('PW_Weight', 'PW_Price', 'PW_SumPrice', 'PW_FullSumPrice', 'PW_UserAdd', 'PW_DateTimeAdd', 'PW_UserUpdate', 'PW_DateTimeUpdate', 'PW_Allow');
        $crud->edit_fields('PW_Weight', 'PW_Price', 'PW_SumPrice', 'PW_FullSumPrice', 'PW_UserUpdate', 'PW_DateTimeUpdate', 'PW_Allow');

        $crud->field_type('PW_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('PW_Allow',           'hidden', '1');
            $crud->field_type('PW_UserAdd',         'hidden', get_session('M_ID'));
            $crud->field_type('PW_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PW_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PW_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PW_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PW_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/product_weight_manage/del', 'del-row');

        // $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        // $crud->unset_export();
        // $crud->unset_list();
        // $crud->unset_print();
        $crud->unset_read();
        // $crud->unset_texteditor(array());

        $output = $crud->render();
        if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    }

    public function product_gallery_manage() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/false,/*edit*/true,/*del*/true,/*export*/false,/*print*/false);
        $this->delete_action_model->del_action('product_gallery', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow', 'PG_ID');

        $title = 'แกลเลอรี่รูปสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_gallery');
        $crud->where("product_gallery.PG_Allow != ", "3");
        $crud->order_by("PG_Order", "asc");

        $crud->set_relation('P_ID', 'product', 'P_IDCode');

        $crud->display_as('PG_ID',              'ไอดี');
        $crud->display_as('PG_Name',            'ชื่อรูปภาพ');
        $crud->display_as('P_ID',               'ชื่อสินค้า');
        $crud->display_as('PG_Img',             'รูปภาพขนาดจริง');
        $crud->display_as('PG_ThumbImg',        'รูปภาพ Thumbnail');
        $crud->display_as('PG_Order',           'ลำดับที่');
        $crud->display_as('PG_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('PG_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('PG_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PG_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('PG_Allow',           'สถานะ');

        $crud->required_fields('PG_Name', 'P_ID', 'PG_Img', 'PG_Order', 'PG_Allow');

        // $crud->columns('PG_Order', 'PG_Img', 'PG_ThumbImg', 'P_ID', 'PG_Name');
        $crud->columns('PG_Order', 'PG_Img', 'P_ID', 'PG_Name');

        // $crud->add_fields('PG_Img', 'PG_ThumbImg', 'PG_Name', 'P_ID', 'PG_Order', 'PG_UserAdd', 'PG_DateTimeAdd', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow');
        $crud->add_fields('PG_Img', 'PG_Name', 'P_ID', 'PG_Order', 'PG_UserAdd', 'PG_DateTimeAdd', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow');
        // $crud->edit_fields('PG_Img', 'PG_ThumbImg', 'PG_Name', 'P_ID', 'PG_Order', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow');
        $crud->edit_fields('PG_Img', 'PG_Name', 'P_ID', 'PG_Order', 'PG_UserUpdate', 'PG_DateTimeUpdate', 'PG_Allow');

        $crud->field_type('PG_Allow',   'dropdown', array('1' => 'เผยแพร่', '2' => 'ไม่เผยแพร่', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('PG_Allow',           'hidden', '1');
            $crud->field_type('PG_UserAdd',         'hidden', get_session('M_ID'));
            $crud->field_type('PG_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('PG_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PG_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PG_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('PG_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'print' || $crud->getState() == 'export') {
            $crud->unset_columns('PG_Img');
            $crud->unset_columns('PG_ThumbImg');
        }

        $crud->set_field_upload('PG_Img',       'assets/uploads/user_uploads_img');
        // $crud->set_field_upload('PG_ThumbImg',  'assets/uploads/user_uploads_img');

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/product_gallery_manage/del', 'del-row');

        // $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        $crud->unset_export();
        // $crud->unset_list();
        $crud->unset_print();
        $crud->unset_read();
        // $crud->unset_texteditor(array());

        $output = $crud->render();
        if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    }

    public function promotion_insert_check_callback($post_array) {
        $str_concat     = "";
        $P_ID           = $post_array['P_ID'];
        $PP_StartDate   = dateChange($post_array['PP_StartDate'],   4);
        $PP_EndDate     = dateChange($post_array['PP_EndDate'],     4);
        $temp1  = rowArray($this->common_model->custom_query(" SELECT * FROM `product_price` WHERE ((`PP_StartDate` <= '$PP_StartDate'  AND `PP_EndDate`      >= '$PP_StartDate')   OR `PP_StartDate`  = '$PP_StartDate'    OR  `PP_EndDate`   = '$PP_StartDate')   AND `PP_Allow` != '3' AND `P_ID` = $P_ID $str_concat "));
        $temp2  = rowArray($this->common_model->custom_query(" SELECT * FROM `product_price` WHERE ((`PP_StartDate` <= '$PP_EndDate'    AND `PP_EndDate`      >= '$PP_EndDate')     OR `PP_StartDate`  = '$PP_EndDate'      OR  `PP_EndDate`   = '$PP_EndDate')     AND `PP_Allow` != '3' AND `P_ID` = $P_ID $str_concat "));
        $temp3  = rowArray($this->common_model->custom_query(" SELECT * FROM `product_price` WHERE ((`PP_StartDate` >= '$PP_StartDate'  AND `PP_StartDate`    <= '$PP_EndDate')     OR (`PP_EndDate`  >= '$PP_StartDate'    AND `PP_EndDate`  <= '$PP_EndDate'))    AND `PP_Allow` != '3' AND `P_ID` = $P_ID $str_concat "));
        if (count($temp1) > 0 || count($temp2) > 0 || count($temp3) > 0)
            return false;
        else {
            if ($post_array['PP_SumPrice']      == '' || $post_array['PP_SumPrice']      == 0) $post_array['PP_SumPrice']       = $post_array['PP_Price'];
            if ($post_array['PP_FullSumPrice']  == '' || $post_array['PP_FullSumPrice']  == 0) $post_array['PP_FullSumPrice']   = $post_array['PP_Price'];
            return $post_array;
        }
    }

    public function promotion_update_check_callback($post_array, $primary_key) {
        $str_concat     = " AND `PP_ID` != '".$primary_key."'";
        $P_ID           = $post_array['P_ID'];
        $PP_StartDate   = dateChange($post_array['PP_StartDate'],   4);
        $PP_EndDate     = dateChange($post_array['PP_EndDate'],     4);
        $temp1  = rowArray($this->common_model->custom_query(" SELECT * FROM `product_price` WHERE ((`PP_StartDate` <= '$PP_StartDate'  AND `PP_EndDate`      >= '$PP_StartDate')   OR `PP_StartDate`  = '$PP_StartDate'    OR  `PP_EndDate`   = '$PP_StartDate')   AND `PP_Allow` != '3' AND `P_ID` = $P_ID $str_concat "));
        $temp2  = rowArray($this->common_model->custom_query(" SELECT * FROM `product_price` WHERE ((`PP_StartDate` <= '$PP_EndDate'    AND `PP_EndDate`      >= '$PP_EndDate')     OR `PP_StartDate`  = '$PP_EndDate'      OR  `PP_EndDate`   = '$PP_EndDate')     AND `PP_Allow` != '3' AND `P_ID` = $P_ID $str_concat "));
        $temp3  = rowArray($this->common_model->custom_query(" SELECT * FROM `product_price` WHERE ((`PP_StartDate` >= '$PP_StartDate'  AND `PP_StartDate`    <= '$PP_EndDate')     OR (`PP_EndDate`  >= '$PP_StartDate'    AND `PP_EndDate`  <= '$PP_EndDate'))    AND `PP_Allow` != '3' AND `P_ID` = $P_ID $str_concat "));
        if (count($temp1) > 0 || count($temp2) > 0 || count($temp3) > 0)
            return false;
        else {
            if ($post_array['PP_SumPrice']      == '' || $post_array['PP_SumPrice']      == 0) $post_array['PP_SumPrice']       = $post_array['PP_Price'];
            if ($post_array['PP_FullSumPrice']  == '' || $post_array['PP_FullSumPrice']  == 0) $post_array['PP_FullSumPrice']   = $post_array['PP_Price'];
            return $post_array;
        }
    }

    public function product_promotion_manage() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/true,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('product_price', 'PP_UserUpdate', 'PP_DateTimeUpdate', 'PP_Allow', 'PP_ID');
        $this->viewer_action_model->vie_action('product_price', 'PP_ID', 'PP_Allow', 'back-end/promotion_detail', 'โปรโมชั่นสินค้า', array('รายละเอียดสินค้า', 'รายละเอียดโปรโมชั่น'));

        $title = 'โปรโมชั่นสินค้า';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('product_price');
        $crud->where("product_price.PP_Allow    != ", "3");
        $crud->order_by("PP_ID");

        $crud->set_relation('P_ID', 'product', 'P_IDCode');

        $crud->display_as('PP_ID',              'ไอดี');
        $crud->display_as('P_ID',               'ชื่อสินค้า');
        $crud->display_as('PP_StartDate',       'วันเวลาเริ่มต้น');
        $crud->display_as('PP_EndDate',         'วันเวลาสิ้นสุด');
        $crud->display_as('PP_Special',         'แสดง / ไม่แสดง');
        $crud->display_as('PP_Name',            'ชื่อโปรโมชั่น');
        $crud->display_as('PP_Title',           'คำอธิบายโปรโมชั่น');
        $crud->display_as('PP_Descript',        'รายละเอียดโปรโมชั่น');
        $crud->display_as('PP_Remark',          'หมายเหตุโปรโมชั่น');
        $crud->display_as('PP_Price',           'ราคาต่อหน่วย');
        $crud->display_as('PP_SumPrice',        'ราคารวม');
        $crud->display_as('PP_FullSumPrice',    'ราคาเต็มแบบไม่คิดส่วนลด');
        $crud->display_as('PP_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('PP_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('PP_Allow',           'สถานะ');

        $crud->required_fields('P_ID', 'PP_StartDate', 'PP_EndDate', 'PP_Special', 'PP_Price', 'PP_Allow');

        $crud->set_rules('PP_Price',        'ราคาต่อหน่วย', 'numeric|required');
        $crud->set_rules('PP_SumPrice',     'ราคารวม', 'numeric');
        $crud->set_rules('PP_FullSumPrice', 'ราคาเต็มแบบไม่คิดส่วนลด', 'numeric');
        $crud->set_lang_string('insert_error', 'เกิดเหตุขัดข้องระหว่างการเพิ่มข้อมูล หรือ สินค้านี้มีโปรโมชั่นในช่วงระยะเวลาดังกล่าวแล้ว');
        $crud->set_lang_string('update_error', 'เกิดเหตุขัดข้องในระหว่างการบันทึกข้อมูล หรือ สินค้านี้มีโปรโมชั่นในช่วงระยะเวลาดังกล่าวแล้ว');

        $crud->columns('P_ID', 'PP_Price', 'PP_SumPrice', 'PP_FullSumPrice', 'PP_StartDate', 'PP_EndDate', 'PP_Special');

        $crud->add_fields('P_ID', 'PP_StartDate', 'PP_EndDate', 'PP_Special', 'PP_Price', 'PP_SumPrice', 'PP_FullSumPrice', 'PP_Name', 'PP_Title', 'PP_Descript', 'PP_Remark', 'PP_UserUpdate', 'PP_DateTimeUpdate', 'PP_Allow');
        $crud->edit_fields('P_ID', 'PP_StartDate', 'PP_EndDate', 'PP_Special', 'PP_Price', 'PP_SumPrice', 'PP_FullSumPrice', 'PP_Name', 'PP_Title', 'PP_Descript', 'PP_Remark', 'PP_UserUpdate', 'PP_DateTimeUpdate', 'PP_Allow');

        $crud->field_type('PP_Special', 'dropdown', array('1' => 'แสดง', '2' => 'ไม่แสดง'));
        $crud->field_type('PP_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        $crud->callback_before_insert(array($this,  'promotion_insert_check_callback'));
        $crud->callback_before_update(array($this,  'promotion_update_check_callback'));

        if ($crud->getState() == 'add') {
            $crud->field_type('PP_Allow',            'hidden', '1');
            $crud->field_type('PP_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('PP_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('PP_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('PP_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('View', base_url('assets/admin/images/tools/magnifier.png'), 'product/control_product/product_promotion_manage/view');
        $crud->add_action('ลบ', base_url('assets/admin/images/tools/delete-icon.png'), 'product/control_product/product_promotion_manage/del', 'del-row');

        // $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        // $crud->unset_export();
        // $crud->unset_list();
        // $crud->unset_print();
        $crud->unset_read();
        $crud->unset_texteditor(array('PP_Title', 'PP_Descript', 'PP_Remark'));

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