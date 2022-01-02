<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Control_cart extends MX_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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
                'delete_action_model',
                'fill_dropdown_model',
                'product_type_model',
                'crud_level_model',
                'order_status_model',
            )
        );

        $this->permission_model->getOnceWebMain();
        $this->statistic_view_model->getBackLogMain();
        $this->product_type_model->productTypeDailyUpdate();
    }

    public function index() {
        redirect('cart/control_cart/order_management', 'refresh');
    }

    public function number_format_OD_Price($value, $row) {
        return '<span style="display:block;text-align:right">'.number_format($value, 2).'</span>';
    }

    public function number_format_OD_Amount($value, $row) {
        return '<span style="display:block;text-align:right">'.number_format($value).'</span>';
    }

    // public function order_status_changed() {
    //     $data = array(
    //         'OD_UserUpdate'     => get_session('M_ID'),
    //         'OD_DateTimeUpdate' => date('Y-m-d H:i:s'),
    //         'OD_Allow'          => $this->input->post('OD_Allow')
    //     );
    //     $this->db->where('OD_ID',   $this->input->post('OD_ID'));
    //     $this->db->update('order',  $data);

    //     if ($this->input->post('OD_Allow') == '7') {
    //         $OD_ID = $this->input->post('OD_ID');
    //         $OD_Limit = $this->db->query(" SELECT `ODL_ID` FROM `order_list` ")->num_rows();
    //         $order_list = $this->common_model->custom_query(
    //             "   SELECT `P_ID` FROM `order_list`
    //                 WHERE `OD_ID` = $OD_ID AND `ODL_Allow` = '1'
    //                 ORDER BY `ODL_DateTimeUpdate` DESC
    //                 LIMIT $OD_Limit "
    //         );
    //         if (count($order_list) > 0) {
    //             foreach ($order_list as $key => $value) {
    //                 $P_ID = $value['P_ID'];
    //                 $order_amount = $this->common_model->custom_query(
    //                     "   SELECT SUM(`ODL_Amount`) AS `ODL_Amount` FROM `order_list`
    //                         WHERE `OD_ID` = $OD_ID AND `P_ID` = $P_ID AND `ODL_Allow` = '1'
    //                         ORDER BY `ODL_DateTimeUpdate` DESC
    //                         LIMIT 1 "
    //                 );
    //                 if (count($order_amount) > 0) {
    //                     $rows_amount = rowArray($order_amount);
    //                     $product_stock = $this->common_model->custom_query(
    //                         "   SELECT `PS_Amount`, `PS_FullSumPrice` FROM `product_stock`
    //                             WHERE `P_ID` = $P_ID AND `PS_Allow` = '1'
    //                             ORDER BY `PS_DateTimeUpdate` DESC
    //                             LIMIT 1 "
    //                     );
    //                     if (count($product_stock) > 0) {
    //                         $rows_stock         = rowArray($product_stock);
    //                         $PS_Amount          = $rows_stock['PS_Amount'] - $rows_amount['ODL_Amount'];
    //                         $PS_Amount_Log      = $rows_amount['ODL_Amount'];
    //                         $PS_FullSumPrice    = $rows_stock['PS_FullSumPrice'];
    //                         $data_stock = array(
    //                             'P_ID'                  => $P_ID,
    //                             'PS_Amount'             => $PS_Amount,
    //                             'PS_Amount_Log'         => $PS_Amount_Log,
    //                             'PS_Price'              => $PS_FullSumPrice,
    //                             'PS_Price_Log'          => 0,
    //                             'PS_SumPrice'           => $PS_FullSumPrice,
    //                             'PS_SumPrice_Log'       => 0,
    //                             'PS_FullSumPrice'       => $PS_FullSumPrice,
    //                             'PS_FullSumPrice_Log'   => 0,
    //                             'PS_Price_Type'         => '3',
    //                             'PS_Amount_Type'        => '2',
    //                             'PS_UserUpdate'         => get_session('M_ID'),
    //                             'PS_DateTimeUpdate'     => date('Y-m-d H:i:s'),
    //                             'PS_Allow'              => '1'
    //                         );
    //                         $this->common_model->insert('product_stock', $data_stock);
    //                         $this->db->query(" UPDATE `product_stock` SET `PS_Allow` = '3' WHERE `P_ID` = '$P_ID' ");
    //                         $this->db->query(" UPDATE `product_stock` SET `PS_Allow` = '1' WHERE `P_ID` = '$P_ID' ORDER BY `PS_ID` DESC LIMIT 1 ");
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     if ($this->input->post('OD_Allow') == '5' || $this->input->post('OD_Allow') == '7') {
    //         $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $this->input->post('OD_ID')));
    //         $edata = array(
    //             'OD_Allow'          => $order['OD_Allow'],
    //             'OD_FullSumPrice'   => $order['OD_FullSumPrice'],
    //             'OD_EmsCode'        => $order['OD_EmsCode']
    //         );
    //         $this->send_confirm_order_or_tracking_code($edata, $this->input->post('OD_ID'));
    //     }
    // }

    public function send_confirm_order_or_tracking_code($post_array, $primary_key) {
        $webconfig      = rowArray($this->common_model->getTable('webconfig'));
        $order          = rowArray($this->common_model->get_where_custom('order',           'OD_ID', $primary_key));
        $order_address  = rowArray($this->common_model->get_where_custom('order_address',   'OD_ID', $primary_key));
        $order_transfer = rowArray($this->common_model->custom_query(" SELECT * FROM order_transfer LEFT JOIN bank ON order_transfer.B_ID = bank.B_ID WHERE OD_ID = '$primary_key' "));

        $config['useragent']    = $webconfig['WD_Name'];
        $config['mailtype']     = 'html';
        $this->email->initialize($config);
        $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
        $this->email->to($order_address['OD_Email']);

        if ($post_array['OD_Allow'] === '5') {
            if ($order['OD_Code'] != '' && $order_transfer['B_Name'] != '' && $order_transfer['OT_Payment'] != '' && $order_transfer['OT_DateTimeUpdate'] != '' && $order_transfer['OT_FullSumPrice'] != '') {
                $OT_Payment = array('1' => 'โอนเงินผ่านธนาคาร', '2' => 'ชำระเงินผ่านบัตรเครดิต', '3' => 'ชำระผ่านเคาน์เตอร์เซอร์วิส', '4' => 'อื่นๆ');
                $data = array(
                    'OD_ID'                 => $order['OD_ID'],
                    'OD_Code'               => $order['OD_Code'],
                    'B_Name'                => $order_transfer['B_Name'],
                    'OT_Payment'            => $OT_Payment[$order_transfer['OT_Payment']],
                    'OT_DateTimeUpdate'     => $order_transfer['OT_DateTimeUpdate'],
                    'OT_FullSumPrice'       => $order_transfer['OT_FullSumPrice'],
                    'OD_Allow'              => 'โอนเงินแล้ว',
                    'document_type'         => 'html'
                );
                $this->email->subject('ยืนยันการโอนเงินไปยัง '.$webconfig['WD_Name']);
                $this->email->message($this->load->view('web_template1/email/transfer_success', $data, true));
                $this->email->send();
            }
        }
        if ($post_array['OD_Allow'] === '7') {
            if ($order['OD_Code'] != '' && $post_array['OD_EmsCode'] != '') {
                $data = array(
                    'OD_ID'                 => $order['OD_ID'],
                    'OD_Code'               => $order['OD_Code'],
                    'OD_EmsCode'            => $post_array['OD_EmsCode'],
                    'OD_Allow'              => 'ส่งสินค้าแล้ว',
                    'document_type'         => 'html'
                );
                $this->email->subject('หมายเลขสิ่งของฝากส่งทางไปรษณีย์ การสั่งซื้อสินค้าจาก '.$webconfig['WD_Name']);
                $this->email->message($this->load->view('web_template1/email/order_code', $data, true));
                $this->email->send();
            }
        }
    }

    public function ems_code_changed() {
        $query = rowArray($this->common_model->get_where_custom('order', 'OD_ID', get_inpost('OD_ID')));
        if (count($query) > 0) {
            $OD_ID = get_inpost('OD_ID');
            $data = array(
                'OD_EmsCode'        => get_inpost('OD_EmsCode'),
                'OD_UserUpdate'     => get_session('M_ID'),
                'OD_DateTimeUpdate' => date('Y-m-d H:i:s'),
            );
            $this->common_model->update('order', $data, " OD_ID = '$OD_ID' ");
        }
    }

    // public function order_status($fieldKey) {
    //     $data = array('OD_ID' => $fieldKey);
    //     $this->load->view('back-end/order_status_dialog', $data);
    // }

    public function none_FullSumPrice($value, $row) {
        return number_format(0, 2, '.', '');
    }

    public function number_format_OD_FullSumPrice($value, $row) {
        if ($value != '')
            return number_format($value, 2, '.', '');
        else
            return number_format(0, 2, '.', '');
    }

    public function number_format_OT_FullSumPrice($value, $row) {
        $OT_FullSumPrice = rowArray($this->common_model->get_where_custom('order_transfer', 'OD_ID', $row->OD_ID));
        if (count($OT_FullSumPrice) > 0)
            return number_format($OT_FullSumPrice['OT_FullSumPrice'], 2, '.', '');
        else
            return number_format(0, 2, '.', '');
    }

    public function date_format_OD_DateTimeAdd($value, $row) {
        return date('d/m/Y', strtotime($value));
    }

    public function date_format_OT_DateTimeAdd($value, $row) {
        $OT_DateTimeAdd = rowArray($this->common_model->get_where_custom('order_transfer', 'OD_ID', $row->OD_ID));
        return date('d/m/Y', strtotime($OT_DateTimeAdd['OT_DateTimeAdd']));
    }

    public function editor_OD_EmsCode($value, $row) {
        if (uri_seg(3) != 'order_history_cancel') {
            if ($value != '')
                return '<a href="#" class="" onclick="inputGenerate(this, '.'`'.$value.'`'.', '.$row->OD_ID.');"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>&#160;'.$value;
            else
                return '<a href="#" class="" onclick="inputGenerate(this, '.'`'.$value.'`'.', '.$row->OD_ID.');"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>&#160;<a href="#" class="" onclick="inputGenerate(this, '.'`'.$value.'`'.', '.$row->OD_ID.');" style="color:red;font-weight:bold;font-size:17px">ป้อนข้อมูล</a>';
        }
        else {
            if ($value != '')
                return $value;
        }
    }

    public function orderTransfered() {
        if (get_inpost('OD_Allow') != '' && get_inpost('OD_ID') != '') {
            $data = array(
                'OD_UserUpdate'     => get_session('M_ID'),
                'OD_DateTimeUpdate' => date('Y-m-d H:i:s'),
                'OD_Allow'          => get_inpost('OD_Allow')
            );
            $this->common_model->update('order', $data, " OD_ID = ".get_inpost('OD_ID'));
            if (get_inpost('OD_Allow') == '5' || get_inpost('OD_Allow') == '7') {
                $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', get_inpost('OD_ID')));
                $edata = array(
                    'OD_Allow'          => $order['OD_Allow'],
                    'OD_FullSumPrice'   => $order['OD_FullSumPrice'],
                    'OD_EmsCode'        => $order['OD_EmsCode']
                );
                $this->send_confirm_order_or_tracking_code($edata, get_inpost('OD_ID'));
            }
        }
        if (get_inpost('OD_URL') != '')
            redirect(get_inpost('OD_URL'), 'refresh');
        else
            redirect('cart/control_cart/order_doing_unannounce', 'refresh');
    }

    public function orderTrasported() {
        if (get_inpost('OD_Allow') != '' && get_inpost('OD_ID') != '') {
            $data = array(
                'OD_UserUpdate'     => get_session('M_ID'),
                'OD_DateTimeUpdate' => date('Y-m-d H:i:s'),
                'OD_Allow'          => get_inpost('OD_Allow')
            );
            $this->common_model->update('order', $data, " OD_ID = ".get_inpost('OD_ID'));
            if (get_inpost('OD_Allow') == '5' || get_inpost('OD_Allow') == '7') {
                $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', get_inpost('OD_ID')));
                $edata = array(
                    'OD_Allow'          => $order['OD_Allow'],
                    'OD_FullSumPrice'   => $order['OD_FullSumPrice'],
                    'OD_EmsCode'        => $order['OD_EmsCode']
                );
                $this->send_confirm_order_or_tracking_code($edata, get_inpost('OD_ID'));
            }
        }
        if (get_inpost('OD_URL') != '')
            redirect(get_inpost('OD_URL'), 'refresh');
        else
            redirect('cart/control_cart/order_history_success', 'refresh');
    }

    public function editor_OD_Allow($value, $row) {
        $OD_Allow   = $this->order_status_model->getOnceWebMain();
        $formID     = 'orderStateChange'.$row->OD_ID;
        if ($value == '4')
            return
                '<form id="orderStateChange'.$row->OD_ID.'" method="post" accept-charset="utf-8" action="'.base_url('cart/control_cart/orderTransfered').'">
                    <input type="hidden" name="OD_ID" value="'.$row->OD_ID.'">
                    <input type="hidden" name="OD_Allow" value="5">
                    <input type="hidden" name="OD_URL" value="'.current_url().'">
                    <a href="#" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" onclick="document.getElementById('."'$formID'".').submit();">
                        <span class="ui-button-text a-little-help a-little-help-1"><i class="fa fa-share"></i> แจ้งชำระแล้ว</span>
                    </a>
                </form>';
        else if ($value == '5')
            return
                '<form id="orderStateChange'.$row->OD_ID.'" method="post" accept-charset="utf-8" action="'.base_url('cart/control_cart/orderTransfered').'">
                    <input type="hidden" name="OD_ID" value="'.$row->OD_ID.'">
                    <input type="hidden" name="OD_Allow" value="6">
                    <input type="hidden" name="OD_URL" value="'.current_url().'">
                    <a href="#" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" onclick="document.getElementById('."'$formID'".').submit();">
                        <span class="ui-button-text a-little-help a-little-help-2"><i class="fa fa-exchange"></i> จัดส่งแล้ว</span>
                    </a>
                </form>';
        if ($value == '6' || $value == '7')
            return '<i class="fa fa-exchange a-little-help-text-1"></i>&#160;<span class="a-little-help-text-1">จัดส่งแล้ว</span>';
        else if ($value == '2' || $value == '3')
            return '<i class="fa fa-lock a-little-help-text-2"></i>&#160;<span class="a-little-help-text-2">'.$OD_Allow[$value].'</span>';
        // $OD_Allow = $this->order_status_model->getOnceWebMain();
        // return '<a href="#" class="" onclick="dropdownGenerate(this, '.$value.', '.$row->OD_ID.');"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'"></a>&#160;'.$OD_Allow[$value];
    }

    public function order_history_success() {
        $this->crud_level_model->crudStateEnabled(/*add*/false,/*view*/true,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('order', 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Allow', 'OD_ID');
        $this->viewer_action_model->vie_action('order', 'OD_ID', 'OD_Allow', 'back-end/order_detail', 'ประวัติการซื้อ / ขาย', array('รายการที่จัดส่งแล้ว', 'รายละเอียดรายการที่จัดส่งแล้ว', 'ข้อมูลติดต่อ และที่อยู่ในการจัดส่ง'));
        // $this->viewer_action_model->vie_action('order', 'OD_ID', 'OD_Allow', 'back-end/order_detail', 'ใบสั่งซื้อ', array('ข้อมูลการซื้อขาย / สั่งซื้อ', 'รายละเอียดการซื้อขาย / สั่งซื้อ', 'ข้อมูลติดต่อ และที่อยู่ในการจัดส่ง'));

        $title = 'ประวัติการซื้อ / ขาย';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('order');
        $crud->set_theme('datatables');
        $crud->where("order.OD_Allow = ", "7");

        $crud->display_as('OD_Code',            'รหัสใบสั่งซื้อ');
        $crud->display_as('M_ID',               'ลูกค้า');
        $crud->display_as('OD_Name',            'ชื่อ-นามสกุล');
        $crud->display_as('OD_SumPrice',        'ราคารวม');
        $crud->display_as('OD_FullSumPrice',    'เงินที่ต้องชำระ');
        $crud->display_as('OT_FullSumPrice',    'เงินที่แจ้ง');
        $crud->display_as('OT_DateTimeAdd',     'วันที่แจ้ง');
        $crud->display_as('OD_DateTimeAdd',     'วันที่สั่งซื้อ');
        $crud->display_as('OD_EmsCode',         'รหัส EMS');
        $crud->display_as('OD_Allow',           'สถานะ');

        $crud->columns('OD_Code', 'OD_DateTimeAdd', 'OD_Name', 'OD_FullSumPrice', 'OT_FullSumPrice', 'OD_EmsCode', 'OT_DateTimeAdd');
        $crud->callback_column('OD_FullSumPrice',   array($this, 'number_format_OD_FullSumPrice'));
        $crud->callback_column('OT_FullSumPrice',   array($this, 'number_format_OT_FullSumPrice'));
        $crud->callback_column('OD_DateTimeAdd',    array($this, 'date_format_OD_DateTimeAdd'));
        $crud->callback_column('OT_DateTimeAdd',    array($this, 'date_format_OT_DateTimeAdd'));
        // $crud->callback_column('OD_EmsCode',        array($this, 'editor_OD_EmsCode'));
        // $crud->callback_column('OD_Allow',          array($this, 'editor_OD_Allow'));

        // $crud->edit_fields('OD_Code', 'OD_Code', 'OD_Code', 'OD_Code', 'OD_Code', 'OD_Code', 'OD_Code');

        $crud->set_rules('OD_Allow', 'สถานะ', 'required');
        $crud->required_fields('OD_Allow');
        $crud->set_relation('M_ID', 'member', 'M_flName');
        $crud->edit_fields('OD_Code', 'M_ID', 'OD_SumPrice', 'OD_FullSumPrice', 'OD_EmsCode', 'OD_Allow');
        if ($crud->getState() == 'edit') {
            $crud->field_type('OD_Code',            'readonly');
            $crud->field_type('M_ID',               'readonly');
            $crud->field_type('OD_SumPrice',        'readonly');
            $crud->field_type('OD_FullSumPrice',    'readonly');
            $crud->field_type('OD_EmsCode',         'readonly');
            $crud->field_type('OD_UserUpdate',      'hidden',   get_session('M_ID'));
            $crud->field_type('OD_DateTimeUpdate',  'hidden',   date("Y-m-d H:i:s"));
            $crud->field_type('OD_Allow',           'dropdown', $this->order_status_model->getOnceWebMain());
        }

        $crud->add_action('ข้อมูล', base_url('assets/admin/images/tools/magnifier.png'), 'cart/control_cart/order_history_success/view');
        $crud->add_action('ยกเลิก', base_url('assets/admin/images/tools/delete-icon.png'), 'cart/control_cart/order_history_success/del', 'del-row');

        $crud->unset_add();
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

    public function order_history_cancel() {
        $this->crud_level_model->crudStateEnabled(/*add*/false,/*view*/false,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('order', 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Allow', 'OD_ID');
        $this->viewer_action_model->vie_action('order', 'OD_ID', 'OD_Allow', 'back-end/order_detail', 'ประวัติการซื้อ / ขาย', array('รายการที่ยกเลิก/ระงับ', 'รายละเอียดรายการที่ยกเลิก/ระงับ', 'ข้อมูลติดต่อ และที่อยู่ในการจัดส่ง'));
        // $this->viewer_action_model->vie_action('order', 'OD_ID', 'OD_Allow', 'back-end/order_detail', 'ใบสั่งซื้อ', array('ข้อมูลการซื้อขาย / สั่งซื้อ', 'รายละเอียดการซื้อขาย / สั่งซื้อ', 'ข้อมูลติดต่อ และที่อยู่ในการจัดส่ง'));

        $title = 'ประวัติการซื้อ / ขาย';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('order');
        $crud->set_theme('datatables');
        $crud->or_where("order.OD_Allow = ", "2");
        $crud->or_where("order.OD_Allow = ", "3");

        $crud->display_as('OD_Code',            'รหัสใบสั่งซื้อ');
        $crud->display_as('M_ID',               'ลูกค้า');
        $crud->display_as('OD_Name',            'ชื่อ-นามสกุล');
        $crud->display_as('OD_SumPrice',        'ราคารวม');
        $crud->display_as('OD_FullSumPrice',    'เงินที่ต้องชำระ');
        $crud->display_as('OT_FullSumPrice',    'เงินที่แจ้ง');
        $crud->display_as('OT_DateTimeAdd',     'วันที่แจ้ง');
        $crud->display_as('OD_DateTimeAdd',     'วันที่สั่งซื้อ');
        $crud->display_as('OD_EmsCode',         'รหัส EMS');
        $crud->display_as('OD_Allow',           'สถานะ');

        $crud->columns('OD_Code', 'OD_DateTimeAdd', 'OD_Name', 'OD_FullSumPrice', 'OT_FullSumPrice', 'OD_EmsCode', 'OT_DateTimeAdd');
        $crud->callback_column('OD_FullSumPrice',   array($this, 'number_format_OD_FullSumPrice'));
        $crud->callback_column('OT_FullSumPrice',   array($this, 'number_format_OT_FullSumPrice'));
        $crud->callback_column('OD_DateTimeAdd',    array($this, 'date_format_OD_DateTimeAdd'));
        $crud->callback_column('OT_DateTimeAdd',    array($this, 'date_format_OT_DateTimeAdd'));
        // $crud->callback_column('OD_EmsCode',        array($this, 'editor_OD_EmsCode'));
        // $crud->callback_column('OD_Allow',          array($this, 'editor_OD_Allow'));

        $crud->set_rules('OD_Allow', 'สถานะ', 'required');
        $crud->required_fields('OD_Allow');
        $crud->set_relation('M_ID', 'member', 'M_flName');
        $crud->edit_fields('OD_Code', 'M_ID', 'OD_SumPrice', 'OD_FullSumPrice', 'OD_EmsCode', 'OD_Allow');
        if ($crud->getState() == 'edit') {
            $crud->field_type('OD_Code',            'readonly');
            $crud->field_type('M_ID',               'readonly');
            $crud->field_type('OD_SumPrice',        'readonly');
            $crud->field_type('OD_FullSumPrice',    'readonly');
            $crud->field_type('OD_EmsCode',         'readonly');
            $crud->field_type('OD_UserUpdate',      'hidden',   get_session('M_ID'));
            $crud->field_type('OD_DateTimeUpdate',  'hidden',   date("Y-m-d H:i:s"));
            $crud->field_type('OD_Allow',           'dropdown', $this->order_status_model->getOnceWebMain());
        }

        // $crud->add_action('ข้อมูล', base_url('assets/admin/images/tools/magnifier.png'), 'cart/control_cart/order_history_cancel/view');
        $crud->add_action('ยกเลิก', base_url('assets/admin/images/tools/delete-icon.png'), 'cart/control_cart/order_history_cancel/del', 'del-row');

        $crud->unset_add();
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

    public function send_email_to_confirm_order_after_update($post_array, $primary_key) {
        $webconfig      = rowArray($this->common_model->getTable('webconfig'));
        $order          = rowArray($this->common_model->get_where_custom('order',           'OD_ID', $primary_key));
        $order_address  = rowArray($this->common_model->get_where_custom('order_address',   'OD_ID', $primary_key));
        $order_transfer = rowArray($this->common_model->custom_query(" SELECT * FROM order_transfer LEFT JOIN bank ON order_transfer.B_ID = bank.B_ID WHERE OD_ID = '$primary_key' "));

        $config['useragent']    = $webconfig['WD_Name'];
        $config['mailtype']     = 'html';
        $this->email->initialize($config);
        $this->email->from($webconfig['WD_Email'], $webconfig['WD_Name']);
        $this->email->to($order_address['OD_Email']);

        if ($post_array['OD_Allow'] === '5') {
            $OT_Payment = array('1' => 'โอนเงินผ่านธนาคาร', '2' => 'ชำระเงินผ่านบัตรเครดิต', '3' => 'ชำระผ่านเคาน์เตอร์เซอร์วิส', '4' => 'อื่นๆ');
            $data = array(
                'OD_ID'                 => $order['OD_ID'],
                'OD_Code'               => $order['OD_Code'],
                'B_Name'                => $order_transfer['B_Name'],
                'OT_Payment'            => $OT_Payment[$order_transfer['OT_Payment']],
                'OT_DateTimeUpdate'     => $order_transfer['OT_DateTimeUpdate'],
                'OT_FullSumPrice'       => $order_transfer['OT_FullSumPrice'],
                'OD_Allow'              => 'โอนเงินแล้ว',
                'document_type'         => 'html'
            );
            $this->email->subject('ยืนยันการโอนเงินไปยัง '.$webconfig['WD_Name']);
            $this->email->message($this->load->view('web_template1/email/transfer_success', $data, true));
            $this->email->send();
        }
        if ($post_array['OD_Allow'] === '7') {
            $data = array(
                'OD_ID'                 => $order['OD_ID'],
                'OD_Code'               => $order['OD_Code'],
                'OD_EmsCode'            => $post_array['OD_EmsCode'],
                'OD_Allow'              => 'ส่งสินค้าแล้ว',
                'document_type'         => 'html'
            );
            $this->email->subject('หมายเลขสิ่งของฝากส่งทางไปรษณีย์ การสั่งซื้อสินค้าจาก '.$webconfig['WD_Name']);
            $this->email->message($this->load->view('web_template1/email/order_code', $data, true));
            $this->email->send();
        }
        return true;
    }

    public function order_doing_unannounce() {
        $this->crud_level_model->crudStateEnabled(/*add*/false,/*view*/true,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('order', 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Allow', 'OD_ID');
        $this->viewer_action_model->vie_action('order', 'OD_ID', 'OD_Allow', 'back-end/order_detail', 'รายการที่ดำเนินการอยู่', array('รายการที่ยังไม่ได้แจ้งชำระ', 'รายละเอียดรายการที่ยังไม่ได้แจ้งชำระ', 'ข้อมูลติดต่อ และที่อยู่ในการจัดส่ง'));

        $title = 'รายการที่ดำเนินการอยู่';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('order');
        $crud->set_theme('datatables');
        $crud->or_where("order.OD_Allow = ", "1");
        $crud->or_where("order.OD_Allow = ", "4");

        $crud->display_as('OD_Code',            'รหัสใบสั่งซื้อ');
        $crud->display_as('M_ID',               'ลูกค้า');
        $crud->display_as('OD_Name',            'ชื่อ-นามสกุล');
        $crud->display_as('OD_SumPrice',        'ราคารวม');
        $crud->display_as('OD_FullSumPrice',    'เงินที่ต้องชำระ');
        $crud->display_as('OT_FullSumPrice',    'เงินที่แจ้ง');
        $crud->display_as('OT_DateTimeAdd',     'วันที่แจ้ง');
        $crud->display_as('OD_DateTimeAdd',     'วันที่สั่งซื้อ');
        $crud->display_as('OD_EmsCode',         'รหัส EMS');
        $crud->display_as('OD_Allow',           'สถานะ');

        $crud->columns('OD_Code', 'OD_DateTimeAdd', 'OD_Name', 'OD_FullSumPrice', 'OT_FullSumPrice', 'OD_EmsCode', 'OD_Allow');
        $crud->callback_column('OD_FullSumPrice',   array($this, 'number_format_OD_FullSumPrice'));
        $crud->callback_column('OT_FullSumPrice',   array($this, 'none_FullSumPrice'));
        $crud->callback_column('OD_DateTimeAdd',    array($this, 'date_format_OD_DateTimeAdd'));
        $crud->callback_column('OD_EmsCode',        array($this, 'editor_OD_EmsCode'));
        $crud->callback_column('OD_Allow',          array($this, 'editor_OD_Allow'));
        $crud->callback_after_update(array($this,   'send_email_to_confirm_order_after_update'));

        $crud->set_rules('OD_FullSumPrice', 'เงินที่ต้องชำระ', 'numeric|required');
        $crud->set_rules('OD_Allow',        'สถานะ', 'required');
        $crud->required_fields('OD_FullSumPrice', 'OD_Allow');
        $crud->set_relation('M_ID', 'member', 'M_flName');
        $crud->edit_fields('OD_Code', 'M_ID', 'OD_SumPrice', 'OD_FullSumPrice', 'OD_EmsCode', 'OD_Allow');
        if ($crud->getState() == 'edit') {
            $crud->field_type('OD_Code',            'readonly');
            $crud->field_type('OD_UserUpdate',      'hidden',   get_session('M_ID'));
            $crud->field_type('OD_DateTimeUpdate',  'hidden',   date("Y-m-d H:i:s"));
            $crud->field_type('OD_Allow',           'dropdown', $this->order_status_model->getOnceWebMain());
        }

        $crud->add_action('ข้อมูล', base_url('assets/admin/images/tools/magnifier.png'), 'cart/control_cart/order_doing_unannounce/view');
        $crud->add_action('ยกเลิก', base_url('assets/admin/images/tools/delete-icon.png'), 'cart/control_cart/order_doing_unannounce/del', 'del-row');

        $crud->unset_add();
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

    public function order_doing_announced() {
        $this->crud_level_model->crudStateEnabled(/*add*/false,/*view*/true,/*edit*/true,/*del*/true,/*export*/true,/*print*/true);
        $this->delete_action_model->del_action('order', 'OD_UserUpdate', 'OD_DateTimeUpdate', 'OD_Allow', 'OD_ID');
        $this->viewer_action_model->vie_action('order', 'OD_ID', 'OD_Allow', 'back-end/order_detail', 'รายการที่ดำเนินการอยู่', array('รายการที่แจ้งชำระแล้ว', 'รายละเอียดรายการที่แจ้งชำระแล้ว', 'ข้อมูลติดต่อ และที่อยู่ในการจัดส่ง'));

        $title = 'รายการที่ดำเนินการอยู่';
        $crud = new grocery_CRUD();
        $crud->set_language('thai');
        $crud->set_subject($title);
        $crud->set_table('order');
        $crud->set_theme('datatables');
        $crud->or_where("order.OD_Allow = ", "5");
        $crud->or_where("order.OD_Allow = ", "6");

        $crud->display_as('OD_Code',            'รหัสใบสั่งซื้อ');
        $crud->display_as('M_ID',               'ลูกค้า');
        $crud->display_as('OD_Name',            'ชื่อ-นามสกุล');
        $crud->display_as('OD_SumPrice',        'ราคารวม');
        $crud->display_as('OD_FullSumPrice',    'เงินที่ต้องชำระ');
        $crud->display_as('OT_FullSumPrice',    'เงินที่แจ้ง');
        $crud->display_as('OT_DateTimeAdd',     'วันที่แจ้ง');
        $crud->display_as('OD_DateTimeAdd',     'วันที่สั่งซื้อ');
        $crud->display_as('OD_EmsCode',         'รหัส EMS');
        $crud->display_as('OD_Allow',           'สถานะ');

        $crud->columns('OD_Code', 'OT_DateTimeAdd', 'OD_Name', 'OD_FullSumPrice', 'OT_FullSumPrice', 'OD_EmsCode', 'OD_Allow');
        $crud->callback_column('OD_FullSumPrice',   array($this, 'number_format_OD_FullSumPrice'));
        $crud->callback_column('OT_FullSumPrice',   array($this, 'number_format_OT_FullSumPrice'));
        $crud->callback_column('OD_DateTimeAdd',    array($this, 'date_format_OD_DateTimeAdd'));
        $crud->callback_column('OT_DateTimeAdd',    array($this, 'date_format_OT_DateTimeAdd'));
        $crud->callback_column('OD_EmsCode',        array($this, 'editor_OD_EmsCode'));
        $crud->callback_column('OD_Allow',          array($this, 'editor_OD_Allow'));
        $crud->callback_after_update(array($this,   'send_email_to_confirm_order_after_update'));

        $crud->set_rules('OD_FullSumPrice', 'เงินที่ต้องชำระ', 'numeric|required');
        $crud->set_rules('OD_Allow',        'สถานะ', 'required');
        $crud->required_fields('OD_FullSumPrice', 'OD_Allow');
        $crud->set_relation('M_ID', 'member', 'M_flName');
        $crud->edit_fields('OD_Code', 'M_ID', 'OD_SumPrice', 'OD_FullSumPrice', 'OD_EmsCode', 'OD_Allow');
        if ($crud->getState() == 'edit') {
            $crud->field_type('OD_Code',            'readonly');
            $crud->field_type('OD_UserUpdate',      'hidden',   get_session('M_ID'));
            $crud->field_type('OD_DateTimeUpdate',  'hidden',   date("Y-m-d H:i:s"));
            $crud->field_type('OD_Allow',           'dropdown', $this->order_status_model->getOnceWebMain());
        }

        $crud->add_action('ข้อมูล', base_url('assets/admin/images/tools/magnifier.png'), 'cart/control_cart/order_doing_announced/view');
        $crud->add_action('ยกเลิก', base_url('assets/admin/images/tools/delete-icon.png'), 'cart/control_cart/order_doing_announced/del', 'del-row');

        $crud->unset_add();
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

    public function _example_output($output = null, $title = null) {
        $data = array(
            'content_view'  => $output,
            'title'         => $title
        );
        $this->template->load('index_page', $data);
    }

}