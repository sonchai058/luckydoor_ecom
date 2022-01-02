<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webconfig extends MX_Controller {

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
                'product_type_model',
                'serialized_model',
                'crud_level_model',
                'delete_action_model',
            )
        );

        $this->permission_model->getOnceWebMain();
        $this->statistic_view_model->getBackLogMain();
        $this->product_type_model->productTypeDailyUpdate();
	}

	public function index() {
        $site = $this->webinfo_model->getOnceWebMain();
        $states = array('unknown', 'list', 'edit', 'update', 'ajax_list', 'ajax_list_info', 'update_validation', 'upload_file', 'ajax_relation', 'ajax_relation_n_n', 'success');
        if (!in_array(uri_seg(3), $states)) redirect('webconfig/index/edit', 'refresh');
        if (uri_seg(3) == 'edit') $this->uri->set_segment(4, $site['WD_ID']);

        $title = 'ข้อมูลระบบ';
		$crud = new grocery_CRUD();
		$crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('webconfig');

        $crud->display_as('WD_ID',              'ไอดี');
        $crud->display_as('WD_Logo',            'โลโก้');
        $crud->display_as('WD_Icon',            'ไอคอน');
        $crud->display_as('WD_BGcolor',         'โค๊ดสี พื้นหลัง');
        $crud->display_as('WD_Themcolor',       'รูปแบบสี');
        $crud->display_as('WD_Background',      'รูปพื้นหลัง');
        $crud->display_as('WD_Name',            'ชื่อเว็บไซต์');
        $crud->display_as('WD_EnName',          'ชื่อเว็บไซต์ (อังกฤษ)');
        $crud->display_as('WD_Address',         'ที่อยู่<br><span class="flexigrid-suggest-custom">ถ้ามีมากกว่า 1 ที่อยู่ ให้คั่นด้วยเครื่องหมาย (,)</span>');
        $crud->display_as('WD_Email',           'อีเมล');
        $crud->display_as('WD_Tel',             'เบอร์โทรศัพท์<br><span class="flexigrid-suggest-custom">ถ้ามีมากกว่า 1 เบอร์โทรศัพท์ ให้คั่นด้วยเครื่องหมาย (,)</span>');
        $crud->display_as('WD_Fax',             'แฟกซ์<br><span class="flexigrid-suggest-custom">ถ้ามีมากกว่า 1 เบอร์แฟกซ์ ให้คั่นด้วยเครื่องหมาย (,)</span>');
        $crud->display_as('WD_Title',           'ไตเติ้ล/เรื่องย่อ');
        $crud->display_as('WD_Descrip',         'รายละเอัยดเว็บไซต์');
        $crud->display_as('WD_Keyword',         'คีย์เวิร์ด');
        $crud->display_as('WD_Gglink',          'Google+ link<br><span class="flexigrid-suggest-custom">ควรมี https:// หรือ http://</span>');
        $crud->display_as('WD_Twlink',          'Twitter link<br><span class="flexigrid-suggest-custom">ควรมี https:// หรือ http://</span>');
        $crud->display_as('WD_Inlink',          'Linkedin link<br><span class="flexigrid-suggest-custom">ควรมี https:// หรือ http://</span>');
        $crud->display_as('WD_FbLink',          'Facebook link<br><span class="flexigrid-suggest-custom">ควรมี https:// หรือ http://</span>');
        $crud->display_as('WD_BG_BlockMain1',   'ภาพพื้นหลังบล็อกข่าวประกาศหน้าหลัก 1015x612');
        $crud->display_as('WD_BG_BlockMain2',   'ภาพพื้นหลังบล็อกกิจกรรมหน้าหลัก 983x574');
        $crud->display_as('WD_BG_BlockMain3',   'ภาพพื้นหลังบล็อกข้อมูลสถิติหน้าหลัก 1013x587');
        $crud->display_as('WD_BG_Footer',       'ภาพพื้นหลังบล็อกข้อมูลสถิติหน้าหลัก 1918x784');
        $crud->display_as('WD_BG_BlockSub',     'ภาพพื้นหลังบล็อกอ่านข่าวหน้าย่อย 1032x629');
        $crud->display_as('WD_Latitude',        'พิกัด (Latitude)<br><span class="flexigrid-suggest-custom">ถ้ามีมากกว่า 1 ให้คั่นด้วยเครื่องหมาย (,)</span>');
        $crud->display_as('WD_Longjitude',      'พิกัด (Longitude)<br><span class="flexigrid-suggest-custom">ถ้ามีมากกว่า 1 ให้คั่นด้วยเครื่องหมาย (,)</span>');
        $crud->display_as('WD_ImgMap',          'รูปหมุดในแผนที่');
        $crud->display_as('WD_SlideConfig',     'ค่า config ภาพสไลด์(ฆerialize)');
        $crud->display_as('WD_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('WD_DatetimeUpdate',  'วันเวลาที่อัพเดท');

        // $crud->required_fields('WD_Name', 'WD_Address', 'WD_Email', 'WD_Tel');

        $crud->columns('WD_ID', 'WD_Logo', 'WD_Icon', 'WD_BGcolor', 'WD_Themcolor', 'WD_Background', 'WD_Name', 'WD_EnName', 'WD_Address', 'WD_Email', 'WD_Tel', 'WD_Fax', 'WD_Title', 'WD_Descrip', 'WD_Keyword', 'WD_Gglink', 'WD_Twlink', 'WD_Inlink', 'WD_FbLink', 'WD_BG_BlockMain1', 'WD_BG_BlockMain2', 'WD_BG_BlockMain3', 'WD_BG_Footer', 'WD_BG_BlockSub', 'WD_Latitude', 'WD_Longjitude', 'WD_ImgMap', 'WD_SlideConfig', 'WD_UserUpdate', 'WD_DatetimeUpdate');

        $crud->edit_fields('WD_Logo', 'WD_Icon', 'WD_Name', 'WD_EnName', 'WD_Address', 'WD_Email', 'WD_Tel', 'WD_Fax', 'WD_Title', 'WD_Descrip', 'WD_Keyword', 'WD_Gglink', 'WD_Twlink', 'WD_Inlink', 'WD_FbLink', 'WD_Latitude', 'WD_Longjitude', 'WD_ImgMap', 'WD_UserUpdate', 'WD_DatetimeUpdate');

        // $crud->set_rules('WD_Email', 'E-Email', 'required|valid_email');

        $crud->field_type('WD_UserUpdate',      'hidden', get_session('M_ID'));
        $crud->field_type('WD_DatetimeUpdate',  'hidden', date("Y-m-d H:i:s"));

        $crud->set_field_upload('WD_Logo',      'assets/images/webconfig');
        $crud->set_field_upload('WD_Icon',      'assets/images/webconfig');
        $crud->set_field_upload('WD_ImgMap',    'assets/images/webconfig');

        $crud->callback_edit_field('WD_Address',    array($this, 'unserialize_address_callback'));
        $crud->callback_edit_field('WD_Tel',        array($this, 'unserialize_tel_callback'));
        $crud->callback_edit_field('WD_Fax',        array($this, 'unserialize_fax_callback'));
        $crud->callback_before_update(array($this, 'serialize_datas_callback'));

        $crud->unset_add();
        $crud->unset_back_to_list();
        $crud->unset_delete();
        // $crud->unset_edit();
        $crud->unset_export();
        $crud->unset_list();
        $crud->unset_print();
        $crud->unset_read();
        $crud->unset_texteditor(array('WD_Address', 'WD_Tel', 'WD_Fax', 'WD_Title', 'WD_Descrip', 'WD_Keyword', 'WD_Gglink', 'WD_Twlink', 'WD_Inlink', 'WD_FbLink'));

        try {
            $output = $crud->render();
            $this->_example_output($output, $title);
        }
        catch (Exception $e) {
            if ($e->getCode() == 14)
                redirect('webconfig/index/edit');
            else
                show_error($e->getMessage());
        }
	}

    public function unserialize_address_callback($value, $primary_key) {
        if ($value !== '' && $this->serialized_model->is_serialized($value) === true) {
            $WD_Buffers = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $value);
            $WD_Buffers = unserialize($WD_Buffers);
            $value = implode(",", $WD_Buffers);
            $value = strip_tags($value);
        }
        return '<textarea id="field-WD_Address" name="WD_Address">'.$value.'</textarea>';
    }

    public function unserialize_tel_callback($value, $primary_key) {
        if ($value !== '' && $this->serialized_model->is_serialized($value) === true) {
            $WD_Buffers = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $value);
            $WD_Buffers = unserialize($WD_Buffers);
            $value = implode(",", $WD_Buffers);
            $value = strip_tags($value);
        }
        return '<textarea id="field-WD_Tel" name="WD_Tel">'.$value.'</textarea>';
    }

    public function unserialize_fax_callback($value, $primary_key) {
        if ($value !== '' && $this->serialized_model->is_serialized($value) === true) {
            $WD_Buffers = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $value);
            $WD_Buffers = unserialize($WD_Buffers);
            $value = implode(",", $WD_Buffers);
            $value = strip_tags($value);
        }
        return '<textarea id="field-WD_Fax" name="WD_Fax">'.$value.'</textarea>';
    }

    public function serialize_datas_callback($post_array, $primary_key) {
        $array_post = $post_array['WD_Address'];
        $array_post = nl2br($array_post);
        if (strpos($array_post, ",") !== false) {
            $WD_Buffers = explode(",", $array_post);
            $post_array['WD_Address'] = serialize($WD_Buffers);
        }
        $array_post = $post_array['WD_Tel'];
        $array_post = nl2br($array_post);
        if (strpos($array_post, ",") !== false) {
            $WD_Buffers = explode(",", $array_post);
            $post_array['WD_Tel'] = serialize($WD_Buffers);
        }
        $array_post = $post_array['WD_Fax'];
        $array_post = nl2br($array_post);
        if (strpos($array_post, ",") !== false) {
            $WD_Buffers = explode(",", $array_post);
            $post_array['WD_Fax'] = serialize($WD_Buffers);
        }
        return $post_array;
    }

    public function image_slider_manage() {
        $states = array('unknown', 'list', 'add', 'edit', 'insert', 'update', 'ajax_list', 'ajax_list_info', 'insert_validation', 'update_validation', 'upload_file', 'ajax_relation', 'ajax_relation_n_n', 'success', 'view', 'del');
        if (uri_seg(3) && !in_array(uri_seg(3), $states)) redirect('webconfig/image_slider_manage', 'refresh');
        $this->delete_action_model->del_custom('image_slider', 'IS_UserUpdate', 'IS_DateTimeUpdate', 'IS_Allow', 'IS_ID');

        $title = 'รูปภาพสไลด์';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('image_slider');
        $crud->where("image_slider.IS_Allow != ", "3");
        $crud->order_by("IS_Order", "asc");

        $crud->display_as('IS_ID',              'ไอดี');
        $crud->display_as('IS_Img',             'รูปภาพ<br><span class="flexigrid-suggest-custom">ทุกภาพควรมีขนาดเท่ากัน</span>');
        $crud->display_as('IS_Name',            'ชื่อรูปภาพ');
        $crud->display_as('IS_Order',           'ลำดับที่');
        $crud->display_as('IS_UserAdd',         'ผู้เพิ่ม');
        $crud->display_as('IS_DateTimeAdd',     'วันเวลาที่เพิ่ม');
        $crud->display_as('IS_UserUpdate',      'ผู้อัพเดท');
        $crud->display_as('IS_DateTimeUpdate',  'วันเวลาที่อัพเดท');
        $crud->display_as('IS_Allow',           'สถานะ');

        $crud->required_fields('IS_Name', 'IS_Img', 'IS_Order', 'IS_Allow');

        $crud->columns('IS_Order', 'IS_Img', 'IS_Name');

        $crud->add_fields('IS_Img', 'IS_Name', 'IS_Order', 'IS_UserAdd', 'IS_DateTimeAdd', 'IS_UserUpdate', 'IS_DateTimeUpdate', 'IS_Allow');
        $crud->edit_fields('IS_Img', 'IS_Name', 'IS_Order', 'IS_UserUpdate', 'IS_DateTimeUpdate', 'IS_Allow');

        $crud->field_type('IS_Allow', 'dropdown', array('1' => 'เผยแพร่', '2' => 'ไม่เผยแพร่', '3' => 'ลบ / บล็อค'));

        if ($crud->getState() == 'add') {
            $crud->field_type('IS_Allow',           'hidden', '1');
            $crud->field_type('IS_UserAdd',         'hidden', get_session('M_ID'));
            $crud->field_type('IS_DateTimeAdd',     'hidden', date("Y-m-d H:i:s"));
            $crud->field_type('IS_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('IS_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'edit') {
            $crud->field_type('IS_UserUpdate',      'hidden', get_session('M_ID'));
            $crud->field_type('IS_DateTimeUpdate',  'hidden', date("Y-m-d H:i:s"));
        }
        if ($crud->getState() == 'print' || $crud->getState() == 'export') $crud->unset_columns('IS_Img');

        $crud->set_field_upload('IS_Img', 'assets/images/slide');

        $crud->add_action('ลบ '.$title, base_url('assets/admin/images/tools/delete-icon.png'), 'webconfig/image_slider_manage/del', 'del-row');

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

	public function _example_output($output = null, $title = null) {
        $data = array(
            'content_view'  => $output,
            'title'         => $title
        );
        $this->template->load('index_page', $data);
    }

}