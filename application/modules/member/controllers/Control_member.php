<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Control_member extends MX_Controller {

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
		redirect('member/control_member/member_management', 'refresh');
	}

    public function member_before_insert_datas($post_array, $primary_key) {
        // redirect('member/control_member/member_management', 'refresh');
        $post_array['M_Password'] = $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

    public function member_before_update_password($post_array, $primary_key) {
        // redirect('member/control_member/member_management', 'refresh');
        $row = $this->common_model->get_where_custom_field('member', 'M_ID', $primary_key, 'M_Password');
        if ($post_array['M_Password'] == $row['M_Password'])
            $post_array['M_Password'] =  $row['M_Password'];
        else
            $post_array['M_Password'] =  $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

	public function member_management() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/true,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('member', 'M_Update', 'M_KeyUpdate', 'M_Allow', 'M_ID');
        $this->viewer_action_model->vie_action('member', 'M_ID', 'M_Allow', 'back-end/member_detail', 'ผู้เข้าใช้งานระบบ', array('รายละเอียดผู้เข้าใช้งานระบบ'));

        $title = 'ผู้เข้าใช้งานระบบ';
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

        $crud->required_fields('M_Username', 'M_Password', 'M_flName', 'M_Email');
        // $crud->required_fields('M_flName', 'M_MTel', 'M_Email', 'M_hrNumber', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code');

        // $crud->columns('M_Img', 'M_flName', 'M_MTel', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code');
        $crud->columns('M_Img', 'M_flName', 'M_MTel', 'M_Email');

        $crud->add_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_npID', 'M_HTel', 'M_MTel', 'M_Fax', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow', 'M_UserAdd', 'M_Regis', 'M_Update', 'M_KeyUpdate');
        $crud->edit_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_npID', 'M_HTel', 'M_MTel', 'M_Fax', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow', 'M_Update', 'M_KeyUpdate');
        // $crud->edit_fields('M_Img', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_npID', 'M_HTel', 'M_MTel', 'M_Fax', 'M_Email', 'M_hrNumber', 'M_VilBuild', 'M_VilNo', 'M_LaneRoad', 'M_Street', 'District_ID', 'Amphur_ID', 'Province_ID', 'Zipcode_Code', 'M_Allow', 'M_Update', 'M_KeyUpdate');

        $crud->set_rules('M_Email', 'อีเมล', 'required|valid_email');

        $crud->field_type('M_Password', 'password');
        $crud->field_type('M_TName',    'dropdown', array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ'));
        $crud->field_type('M_Sex',      'dropdown', array('M' => 'ชาย', 'F' => 'หญิง'));
        $crud->field_type('M_Allow',    'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        // $dts = $this->fill_dropdown_model->getOnceWebMain('districts',    'District_ID',  'District_Name');
        // $aps = $this->fill_dropdown_model->getOnceWebMain('amphures',     'Amphur_ID',    'Amphur_Name');
        // $pvs = $this->fill_dropdown_model->getOnceWebMain('provinces',    'Province_ID',  'Province_Name');
        $zcs = $this->fill_dropdown_model->getOnceWebMain('zipcodes',     'Zipcode_Code', 'Zipcode_Code');

        // $crud->field_type('District_ID',    'dropdown', $dts);
        // $crud->field_type('Amphur_ID',      'dropdown', $aps);
        // $crud->field_type('Province_ID',    'dropdown', $pvs);
        $crud->field_type('Zipcode_Code',   'dropdown', $zcs);

        if ($crud->getState() == 'add') {
            $crud->field_type('M_Allow',        'hidden', '1');
            $crud->field_type('M_UserAdd',      'hidden', get_session('M_ID'));
            $crud->field_type('M_Regis',        'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('M_Update',       'hidden', get_session('M_ID'));
            $crud->field_type('M_KeyUpdate',    'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('M_Update',       'hidden', get_session('M_ID'));
            $crud->field_type('M_KeyUpdate',    'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'print' || $crud->getState() == 'export') $crud->unset_columns('M_Img');

        $crud->set_field_upload('M_Img', 'assets/uploads/profile_img');

        $crud->callback_edit_field('M_Password', array($this, 'decrypt_M_Password_callback'));
        $crud->callback_before_insert(array($this,  'member_before_insert_datas'));
        $crud->callback_before_update(array($this,  'member_before_update_password'));

        $crud->add_action('รายละเอียด '.$title, base_url('assets/admin/images/tools/magnifier.png'), 'member/control_member/member_management/view');
        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'member/control_member/member_management/del', 'del-row');

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

    public function admin_before_insert_datas($post_array, $primary_key) {
        $post_array['M_Password'] = $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

    public function admin_before_update_password($post_array, $primary_key) {
        $row = $this->common_model->get_where_custom_field('admin', 'M_ID', $primary_key, 'M_Password');
        if ($post_array['M_Password'] == $row['M_Password'])
            $post_array['M_Password'] =  $row['M_Password'];
        else
            $post_array['M_Password'] =  $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

    public function admin_management() {
        $this->crud_level_model->crudStateEnabled(/*add*/true,/*view*/true,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('admin', 'M_UserUpdate', 'M_DateTimeUpdate', 'M_Allow', 'M_ID');
        $this->viewer_action_model->vie_action('admin', 'M_ID', 'M_Allow', 'back-end/admin_detail', 'ผู้ดูแลระบบ', array('รายละเอียดผู้ดูแลระบบ'));

        $title = 'ผู้ดูแลระบบ';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('admin');
        $crud->where("admin.M_Allow != ", "3");

        $crud->display_as('M_ID',               'ไอดี');
        $crud->display_as('M_Img',              'รูปประจำตัว');
        $crud->display_as('M_Username',         'ชื่อผู้ใช้งาน');
        $crud->display_as('M_Password',         'รหัสผ่าน');
        $crud->display_as('M_TName',            'คำนำหน้าชื่อ');
        $crud->display_as('M_flName',           'ชื่อ-นามสกุล');
        $crud->display_as('M_ucName',           'Name & Lastname');
        $crud->display_as('M_Sex',              'เพศ');
        $crud->display_as('M_Birthdate',        'วันเดือนปีเกิด');
        $crud->display_as('M_npID',             'เลขประจำตัวประชาชน');
        $crud->display_as('M_Tel',              'โทรศัพท์');
        $crud->display_as('M_Email',            'อีเมล');
        $crud->display_as('M_Address',          'ที่อยู่');
        $crud->display_as('M_Type',             'ประเภทผู้ใช้งาน');
        $crud->display_as('M_Allow',            'สถานะ');
        $crud->display_as('M_UserAdd',          'ผู้เพิ่มข้อมูล');
        $crud->display_as('M_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('M_DateTimeUpdate',   'วันเวลาที่อัพเดท');
        $crud->display_as('M_UserUpdate',       'ผู้อัพเดท');

        $crud->columns('M_Img', 'M_flName', 'M_Tel', 'M_Email', 'M_Type');

        $crud->add_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_Birthdate', 'M_npID', 'M_Tel', 'M_Email', 'M_Address', 'M_Type', 'M_Allow', 'M_UserAdd', 'M_DateTimeAdd', 'M_DateTimeUpdate', 'M_UserUpdate');
        $crud->edit_fields('M_Img', 'M_Username', 'M_Password', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_Birthdate', 'M_npID', 'M_Tel', 'M_Email', 'M_Address', 'M_Type', 'M_Allow', 'M_DateTimeUpdate', 'M_UserUpdate');

        $crud->field_type('M_TName',    'dropdown', array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ'));
        $crud->field_type('M_Sex',      'dropdown', array('M' => 'ชาย', 'F' => 'หญิง'));
        $crud->field_type('M_Type',     'dropdown', array('1' => 'ผู้ดูแลระบบ', '2' => 'บัญชี', '3' => 'คลังสินค้า', '4' => 'พนักงานส่งของ'));
        $crud->field_type('M_Allow',    'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->required_fields('M_Username', 'M_Password', 'M_Email', 'M_Type', 'M_Allow');
            $crud->set_rules('M_Email', 'อีเมล', 'required|valid_email|is_unique[admin.M_Email]');
            $crud->field_type('M_Allow',            'hidden', '1');
            $crud->field_type('M_UserAdd',          'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeAdd',      'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('M_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->required_fields('M_Password', 'M_Email', 'M_Type', 'M_Allow');
            $crud->set_rules('M_Email', 'อีเมล', 'required|valid_email');
            $crud->field_type('M_Username',         'readonly');
            $crud->field_type('M_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'print' || $crud->getState() == 'export') $crud->unset_columns('M_Img');

        $crud->set_field_upload('M_Img', 'assets/uploads/profile_img');

        $crud->callback_edit_field('M_Password', array($this, 'decrypt_M_Password_callback'));
        $crud->callback_before_insert(array($this,  'admin_before_insert_datas'));
        $crud->callback_before_update(array($this,  'admin_before_update_password'));

        $crud->add_action('รายละเอียด '.$title, base_url('assets/admin/images/tools/magnifier.png'), 'member/control_member/admin_management/view');
        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'member/control_member/admin_management/del', 'del-row');

        // $crud->unset_add();
        // $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        // $crud->unset_export();
        // $crud->unset_list();
        // $crud->unset_print();
        $crud->unset_read();
        $crud->unset_texteditor(array('M_Address'));

        $output = $crud->render();
        if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
    }

    public function _callback_M_Type($value, $primary_key) {
        $M_Type = array('1' => 'ผู้ดูแลระบบ', '2' => 'บัญชี', '3' => 'คลังสินค้า', '4' => 'พนักงานส่งของ');
        return '<div id="field-M_Type" class="readonly_label">'.$M_Type[$value].'</div>';
    }

    public function profile_management() {
        $this->crud_level_model->crudStateEnabled(/*add*/false,/*view*/false,/*edit*/true,/*del*/false,/*export*/false,/*print*/false);
        if (uri_seg(4) == 'edit') $this->uri->set_segment(5, get_session('M_ID'));

        $title = 'ข้อมูลส่วนตัว';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('admin');
        $crud->where("admin.M_Allow != ", "3");

        $crud->display_as('M_ID',               'ไอดี');
        $crud->display_as('M_Img',              'รูปประจำตัว');
        $crud->display_as('M_Username',         'ชื่อผู้ใช้งาน');
        $crud->display_as('M_TName',            'คำนำหน้าชื่อ');
        $crud->display_as('M_flName',           'ชื่อ-นามสกุล');
        $crud->display_as('M_ucName',           'Name & Lastname');
        $crud->display_as('M_Sex',              'เพศ');
        $crud->display_as('M_Birthdate',        'วันเดือนปีเกิด');
        $crud->display_as('M_npID',             'เลขประจำตัวประชาชน');
        $crud->display_as('M_Tel',              'โทรศัพท์');
        $crud->display_as('M_Email',            'อีเมล');
        $crud->display_as('M_Address',          'ที่อยู่');
        $crud->display_as('M_Type',             'ประเภทผู้ใช้งาน');
        $crud->display_as('M_Allow',            'สถานะ');
        $crud->display_as('M_UserAdd',          'ผู้เพิ่มข้อมูล');
        $crud->display_as('M_DateTimeAdd',      'วันเวลาที่เพิ่ม');
        $crud->display_as('M_DateTimeUpdate',   'วันเวลาที่อัพเดท');
        $crud->display_as('M_UserUpdate',       'ผู้อัพเดท');

        $crud->edit_fields('M_Img', 'M_Username', 'M_TName', 'M_flName', 'M_ucName', 'M_Sex', 'M_Birthdate', 'M_npID', 'M_Tel', 'M_Email', 'M_Address', 'M_Type', 'M_Allow', 'M_DateTimeUpdate', 'M_UserUpdate');

        $crud->set_rules('M_Email', 'อีเมล', 'required|valid_email');

        $crud->field_type('M_Username', 'readonly');
        $crud->field_type('M_Type',     'readonly');
        $crud->field_type('M_TName',    'dropdown', array('1' => 'นาง', '2' => 'นางสาว', '3' => 'นาย', '4' => 'ไม่ระบุ'));
        $crud->field_type('M_Sex',      'dropdown', array('M' => 'ชาย', 'F' => 'หญิง'));
        $crud->field_type('M_Allow',    'dropdown', array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'edit') {
            $crud->field_type('M_Allow',            'hidden', '1');
            $crud->field_type('M_UserUpdate',       'hidden', get_session('M_ID'));
            $crud->field_type('M_DateTimeUpdate',   'hidden', date("Y-m-d H:i:s"));
        }

        $crud->set_field_upload('M_Img', 'assets/uploads/profile_img');

        $crud->callback_edit_field('M_Type', array($this, '_callback_M_Type'));

        $crud->unset_add();
        $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        $crud->unset_export();
        $crud->unset_list();
        $crud->unset_print();
        $crud->unset_read();
        // $crud->unset_texteditor(array());

        $crud->unset_texteditor('M_Address');

        try {
            $output = $crud->render();
            if (uri_seg(4) !== 'view') $this->_example_output($output, $title);
        }
        catch (Exception $e) {
            if ($e->getCode() == 14)
                redirect('member/control_member/profile_management/edit');
            else
                show_error($e->getMessage());
        }
    }

    public function password_management() {
        $data = array(
            'table'         => 'admin',
            'field_key'     => 'M_ID',
            'field_id'      => get_session('M_ID'),
            'field_allow'   => 'M_Allow',
            'content_view'  => 'back-end/password_management',
            'title'         => 'ข้อมูลการเข้าสู่ระบบ'
        );
        $this->template->load('index_page', $data);
    }

    public function password_changed() {
        $this->form_validation->set_rules('M_Passcurr', 'รหัสผ่าน (ปัจจุบัน)', 'trim|required');
        $this->form_validation->set_rules('M_Password', 'รหัสผ่าน (ใหม่)', 'trim|required|matches[M_Passconf]|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('M_Passconf', 'ยืนยันรหัสผ่าน (ใหม่)', 'trim|required');
        $rows = rowArray($this->common_model->get_where_custom('admin', 'M_ID', $this->input->post('M_ID')));
        $data = array(
            'table'         => 'admin',
            'field_key'     => 'M_ID',
            'field_id'      => get_session('M_ID'),
            'field_allow'   => 'M_Allow',
            'content_view'  => 'back-end/password_management',
            'title'         => 'ข้อมูลการเข้าสู่ระบบ'
        );
        if ($this->form_validation->run() === true) {
            if ($this->input->post('M_Passcurr') === $this->encrypt->decode($rows['M_Password'])) {
                $data['validation_success'] = 'success';
                $admin_data = array(
                    'M_Password'        => $this->encrypt->encode($this->input->post('M_Password')),
                    'M_DateTimeUpdate'  => date('Y-m-d H:i:s'),
                    'M_UserUpdate'      => get_session('M_ID')
                );
                $this->common_model->update('admin', $admin_data, 'M_ID = '.$this->input->post('M_ID'));
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

    public function _example_output($output = null, $title = null) {
        $data = array(
            'content_view'  => $output,
            'title'         => $title
        );
        $this->template->load('index_page', $data);
    }

    public function encrypt_M_Password_callback($post_array, $primary_key = null) {
        $post_array['M_Password'] = $this->encrypt->encode($post_array['M_Password']);
        return $post_array;
    }

    public function decrypt_M_Password_callback($value) {
        $decrypted_password = $this->encrypt->decode($value);
        return "<input type='password' class='form-control' name='M_Password' value='$decrypted_password'>";
    }

}