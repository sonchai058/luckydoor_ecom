<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Control_bank extends MX_Controller {

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
                'delete_action_model',
                'product_type_model',
                'crud_level_model',
            )
        );

        $this->permission_model->getOnceWebMain();
        $this->statistic_view_model->getBackLogMain();
        $this->product_type_model->productTypeDailyUpdate();
	}

	public function index() {
		redirect('bank/control_bank/bank_management', 'refresh');
	}

	public function bank_management() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/false,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('bank', 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow', 'B_ID');

        $title = 'ธนาคาร';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('bank');
        $crud->where("bank.B_Allow != ", "3");
        $crud->order_by("B_Order", "asc");

        $crud->display_as('B_ID',               'ไอดี');
        $crud->display_as('B_Code',             'รหัสธนาคาร');
        $crud->display_as('B_Name',             'ชื่อธนาคาร');
        $crud->display_as('B_Order',            'ลำดับที่');
        $crud->display_as('B_UserAdd',          'ผู้เพิ่ม');
        $crud->display_as('B_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('B_UserUpdate',       'ผู้อัพเดท');
        $crud->display_as('B_DateTimeUpdate',   'วันเวลาที่อัพเดท');
        $crud->display_as('B_Allow',            'สถานะ');

        $crud->required_fields('B_Name', 'B_Order', 'B_Allow');

        $crud->columns('B_Order', 'B_Code', 'B_Name');

        $crud->add_fields('B_Code', 'B_Name', 'B_Order', 'B_UserAdd', 'B_DateTimeAdd', 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow');
        $crud->edit_fields('B_Code', 'B_Name', 'B_Order', 'B_UserUpdate', 'B_DateTimeUpdate', 'B_Allow');

        $crud->field_type('B_Allow', 'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('B_Allow',            'hidden', '1');
            $crud->field_type('B_UserAdd',          'hidden', get_session('M_ID'));
            $crud->field_type('B_DateTimeAdd',      'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('B_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('B_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('B_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('B_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'bank/control_bank/bank_management/del', 'del-row');

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
        $this->_example_output($output, $title);
    }

    public function _example_output($output = null, $title = null) {
        $data = array(
            'content_view'  => $output,
            'title'         => $title
        );
        $this->template->load('index_page', $data);
    }

}
