<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MX_Controller {

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
                'fill_dropdown_model',
                'serialized_model',
                'breadcrumb_model',
			)
		);

		$this->statistic_view_model->getOnceWebMain();
		$this->product_type_model->productTypeDailyUpdate();
	}

    public function grand_quantity() {
        $grand_quantity = 0;
        if ($this->cart->contents()) {
            foreach ($this->cart->contents() as $value) {
                $grand_quantity += $value['qty'];
            }
        }
        return $grand_quantity;
    }

    public function grand_subtotal() {
        $grand_subtotal = 0;
        if ($this->cart->contents()) {
            foreach ($this->cart->contents() as $value) {
                $grand_subtotal += $value['subtotal'];
            }
        }
        return $grand_subtotal;
    }

    public function grand_weight() {
        $grand_weight = 0;
        if ($this->cart->contents()) {
            foreach ($this->cart->contents() as $value) {
                $grand_weight += $value['options']['weight'] * $value['qty'];
            }
        }
        return $grand_weight;
    }

    public function grand_wprice() {
        // $grand_wprice = rowArray($this->common_model->custom_query(
        //     "   SELECT * FROM `product_weight`
        //         WHERE `PW_Weight` >= '{$this->grand_weight()}'
        //         ORDER BY `PW_ID` ASC LIMIT 1    "
        // ));
        // if (count($grand_wprice) > 0)
        //     return $grand_wprice['PW_FullSumPrice'];
        // else if (count($grand_wprice) <= 0) {
        //     $grand_wprice = rowArray($this->common_model->custom_query(
        //         " SELECT * FROM `product_weight` ORDER BY `PW_ID` DESC LIMIT 1 "
        //     ));
        //     if (count($grand_wprice) > 0) {
        //         if ($this->grand_weight() > $grand_wprice['PW_Weight'])
        //             return $grand_wprice['PW_FullSumPrice'];
        //         else return 0;
        //     }
        //     else return 0;
        // }
        // else return 0;
        
        if (get_session('Zipcode_Code') != '' && get_session('Amphur_ID') != '') {
            $Amphur_ID = get_session('Amphur_ID');
            $Zipcode_Code = get_session('Zipcode_Code');
        }
        else {
            $Amphur_ID = '1';
            $Zipcode_Code = '10200';
        }
        $grand_wprice = rowArray($this->common_model->custom_query(
            "   SELECT * FROM `shipping_charges`
                WHERE `Zipcode_Code` = '$Zipcode_Code' AND `Amphur_ID` = '$Amphur_ID'
                ORDER BY `SC_ID` ASC LIMIT 1    "
        ));
        if (count($grand_wprice) > 0)
            return (($grand_wprice['SC_Price'] / 20) * $this->grand_weight());
        else if (count($grand_wprice) <= 0) {
            $grand_wprice = rowArray($this->common_model->custom_query(
                " SELECT * FROM `product_weight` ORDER BY `PW_ID` DESC LIMIT 1 "
            ));
            if (count($grand_wprice) > 0) {
                if ($this->grand_weight() > $grand_wprice['PW_Weight'])
                    return $grand_wprice['PW_FullSumPrice'];
                else return 0;
            }
            else return 0;
        }
        else return 0;
    }

	public function index() {
        $title        = 'รายละเอียดการสั่งซื้อ';
        $content_view = 'front-end/basket';

        $navi_props =   array(
            'path'  =>  array(),
            'name'  =>  array(),
        );
        $breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

        $data = array(
			'content_view'   => $content_view,
			'title'          => $title,
            'breadcrumb'     => $breadcrumb,
            'grand_quantity' => $this->grand_quantity(),
            'grand_subtotal' => $this->grand_subtotal(),
            'grand_weight'   => $this->grand_weight(),
            'grand_wprice'   => $this->grand_wprice(),
		);
        $this->template->load('index_page', $data);
	}

    public function shipping_charges() {

    }

	public function address() {
        if ($this->cart->contents()) {
    		$title        = 'ที่อยู่ในการจัดส่ง';
            $content_view = 'front-end/address';

            $navi_props =   array(
                'path'  =>  array(base_url('cart')),
                'name'  =>  array('รายละเอียดการสั่งซื้อ'),
            );
            $breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

            $data = array(
                'content_view'   => $content_view,
                'title'          => $title,
                'breadcrumb'     => $breadcrumb,
                'grand_quantity' => $this->grand_quantity(),
                'grand_subtotal' => $this->grand_subtotal(),
                'grand_weight'   => $this->grand_weight(),
                'grand_wprice'   => $this->grand_wprice(),
            );
            $this->template->load('index_page', $data);
        }
        else redirect('cart', 'refresh');
	}

    public function review() {
        if ($this->cart->contents()) {

            $title        = 'การสั่งซื้อ';
            $content_view = 'front-end/review';

            $navi_props =   array(
                'path'  =>  array(base_url('cart'), base_url('cart/address')),
                'name'  =>  array('รายละเอียดการสั่งซื้อ', 'ที่อยู่ในการจัดส่ง'),
            );
            $breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

            $data = array(
                'content_view'   => $content_view,
                'title'          => $title,
                'breadcrumb'     => $breadcrumb,
                'grand_quantity' => $this->grand_quantity(),
                'grand_subtotal' => $this->grand_subtotal(),
                'grand_weight'   => $this->grand_weight(),
                'grand_wprice'   => $this->grand_wprice(),
            );
            // dieArray($data);
            $this->template->load('index_page', $data);
        }
        else redirect('cart', 'refresh');
    }

	public function payment() {
        if ($this->cart->contents()) {
    		$title        = 'การชำระเงิน';
            $content_view = 'front-end/payment';

            $navi_props =   array(
                'path'  =>  array(base_url('cart'), base_url('cart/address'), base_url('cart/review')),
                'name'  =>  array('รายละเอียดการสั่งซื้อ', 'ที่อยู่ในการจัดส่ง', 'การสั่งซื้อ'),
            );
            $breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

            $data = array(
                'content_view'   => $content_view,
                'title'          => $title,
                'breadcrumb'     => $breadcrumb,
                'grand_quantity' => $this->grand_quantity(),
                'grand_subtotal' => $this->grand_subtotal(),
                'grand_weight'   => $this->grand_weight(),
                'grand_wprice'   => $this->grand_wprice(),
            );
            $this->template->load('index_page', $data);
        }
        else redirect('cart', 'refresh');
	}

    public function addToCart($P_ID = null, $P_Color = null) {
        $qty_buffer = 0;
        $product = rowArray($this->common_model->custom_query(
            " SELECT * FROM `product` WHERE `P_ID` = $P_ID AND `P_Allow` != '3' "
        ));
        if ($this->cart->contents()) {
            foreach ($this->cart->contents() as $value) {
                if ($value['id'] === $product['P_ID'])
                    $qty_buffer = $value['qty'];
            }
        }
        if (count($product) > 0) {
            $promotion_price = rowArray($this->common_model->custom_query(
                "   SELECT * FROM `product_price`
                    WHERE `P_ID` = $P_ID AND `PP_Special` = '1' AND `PP_Allow` != '3' AND (NOW() BETWEEN PP_StartDate AND PP_EndDate )
                    ORDER BY PP_ID DESC LIMIT 1     "
            ));
            $stock_price = rowArray($this->common_model->custom_query(
                "   SELECT * FROM `product_stock`
                    WHERE `P_ID` = $P_ID AND `PS_Allow` != '3'
                    ORDER BY PS_ID DESC LIMIT 1     "
            ));
            if (count($promotion_price)     > 0 && $promotion_price['PP_Price'] != 0)
                $price = number_format($promotion_price['PP_Price'], 2, '.', '');
            else if (count($stock_price)    > 0 && $stock_price['PS_Price']     != 0)
                $price = number_format($stock_price['PS_Price'], 2, '.', '');
            else
                $price = number_format(0, 2, '.', '');
            if (count($stock_price) > 0 && $stock_price['PS_Amount'] != 0 && $stock_price['PS_Amount'] >= (1 + $qty_buffer)) {
                $options        =  array(
                    'code'      => $product['P_IDCode'],
                    'weight'    => $product['P_Weight'],
                    'color'     => $P_Color,
                    'imgs'      => $product['P_Img'],
                );
                $data           =  array(
                    'id'        => $P_ID,
                    'name'      => $product['P_Name'],
                    'price'     => $price,
                    'qty'       => 1,
                    'options'   => $options
                );
                $this->cart->insert($data);

                // echo '<script>alert("เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว");</script>';
                redirect('cart', 'refresh');
            }
            else {
                if (count($stock_price) <= 0 || $stock_price['PS_Amount'] == 0)
                    echo '<script>alert("สินค้าหมด");</script>';
                else if ((1 + $qty_buffer) > $stock_price['PS_Amount'])
                    echo '<script>alert("สินค้ามีจำนวนไม่พอ กรุณาทำรายการใหม่");</script>';
                else
                    echo '<script>alert("สินค้าหมด");</script>';
            }
        }
        redirect('product', 'refresh');
    }

    public function cartOrderAdded() {
        $P_ID = get_inpost('id');
        $promotion_price = rowArray($this->common_model->custom_query(
            "   SELECT * FROM `product_price`
                WHERE `P_ID` = $P_ID AND `PP_Special` = '1' AND `PP_Allow` != '3' AND (NOW() BETWEEN PP_StartDate AND PP_EndDate )
                ORDER BY PP_ID DESC LIMIT 1     "
        ));
        $stock_price = rowArray($this->common_model->custom_query(
            "   SELECT * FROM `product_stock`
                WHERE `P_ID` = $P_ID AND `PS_Allow` != '3'
                ORDER BY PS_ID DESC LIMIT 1     "
        ));
        if (count($promotion_price)     > 0 && $promotion_price['PP_Price'] != 0)
            $price = number_format($promotion_price['PP_Price'], 2, '.', '');
        else if (count($stock_price)    > 0 && $stock_price['PS_Price']     != 0)
            $price = number_format($stock_price['PS_Price'], 2, '.', '');
        else
            $price = number_format(0, 2, '.', '');
        if (count($stock_price) > 0 && $stock_price['PS_Amount'] != 0 && $stock_price['PS_Amount'] >= get_inpost('qty')) {
            $options        =  array(
                'code'      => get_inpost('code'),
                'weight'    => get_inpost('weight'),
                'color'     => get_inpost('color'),
                'imgs'      => get_inpost('imgs'),
            );
            $data           =  array(
                'id'        => get_inpost('id'),
                'name'      => get_inpost('name'),
                'price'     => $price,
                'qty'       => get_inpost('qty'),
                'options'   => $options
            );
            $this->cart->insert($data);

            // echo '<script>alert("เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว");</script>';
            redirect('cart', 'refresh');
        }
        else {
            if (count($stock_price) <= 0 || $stock_price['PS_Amount'] == 0)
                echo '<script>alert("สินค้าหมด");</script>';
            else if (get_inpost('qty') > $stock_price['PS_Amount'])
                echo '<script>alert("สินค้ามีจำนวนไม่พอ กรุณาทำรายการใหม่");</script>';
            else
                echo '<script>alert("สินค้าหมด");</script>';
        }
    }

    public function cartOrderUpdate() {
        if ($this->cart->contents()) {
            $cart_info = $_POST['cart'];
            foreach($cart_info as $key => $cart) {
                if ($cart['qty'] <= $cart['stock']) {
                    $options        =  array(
                        'code'      => $cart['options']['code'],
                        'weight'    => $cart['options']['weight'],
                        'color'     => $cart['options']['color'],
                        'imgs'      => $cart['options']['imgs'],
                    );
                    $data = array(
                        'rowid'     => $cart['rowid'],
                        'price'     => $cart['price'],
                        'amount'    => $cart['price'] * $cart['qty'],
                        'qty'       => $cart['qty'],
                        'options'   => $options,
                    );
                    $this->cart->update($data);
                }
                else echo '<script>alert("สั่งซื้อ '.$cart['name'].' ได้ไม่เกิน '.$cart['stock'].'");</script>';
            }
            redirect('cart', 'refresh');
        }
        else redirect('product', 'refresh');
    }

    public function cartOrderRemove($rowid = null, $P_ID = null) {
        if ($this->cart->contents()) {
            if ($rowid === "all") {
                $this->cart->destroy();
                $this->session->unset_userdata('delivery_index');
                $this->session->unset_userdata('delivery_price');
                $this->session->unset_userdata('delivery_types');
                $this->session->unset_userdata('OD_Name');
                $this->session->unset_userdata('OD_Tel');
                $this->session->unset_userdata('OD_Email');
                $this->session->unset_userdata('OD_hrNumber');
                $this->session->unset_userdata('OD_VilBuild');
                $this->session->unset_userdata('OD_VilNo');
                $this->session->unset_userdata('OD_LaneRoad');
                $this->session->unset_userdata('OD_Street');
                $this->session->unset_userdata('Amphur_ID');
                $this->session->unset_userdata('District_ID');
                $this->session->unset_userdata('Province_ID');
                $this->session->unset_userdata('Zipcode_Code');
                $this->session->unset_userdata('account_address');
                $this->session->unset_userdata('packing_fee');
                redirect('product', 'refresh');
            }
            else {
                $data = array(
                    'rowid' => $rowid,
                    'qty'   => 0
                );
                $this->cart->update($data);
                if ($this->cart->contents())
                    redirect('cart', 'refresh');
                else
                    redirect('product', 'refresh');
            }
        }
        else redirect('product', 'refresh');
    }

    public function getAddress() {
        $address = rowArray($this->common_model->get_where_custom('member', 'M_ID', get_session('C_ID')));
        if (count($address) > 0)
            echo json_encode($address);
        else {
            $address = array();
            echo json_encode($address);
        }
    }

    public function cartOrderAddress() {
        if ($this->cart->contents()) {
            $address_items = array(
                'delivery_index'    => '',
                // 'delivery_price'    => '',
                'delivery_types'    => '',
                'OD_Name'           => '',
                'OD_Tel'            => '',
                'OD_Email'          => '',
                'OD_hrNumber'       => '',
                'OD_VilBuild'       => '',
                'OD_VilNo'          => '',
                'OD_LaneRoad'       => '',
                'OD_Street'         => '',
                'Amphur_ID'         => '',
                'District_ID'       => '',
                'Province_ID'       => '',
                'Zipcode_Code'      => '',
                'account_address'   => '',
                // 'packing_fee'       => '',
            );
            $this->session->unset_userdata($address_items);
            if (get_inpost('account_address') == 'checked') {
                if (get_session('C_ID') != '')
                    $address_items['account_address'] = 'checked';
                else
                    $address_items['account_address'] = '';
                $address_items['delivery_index']    = get_inpost('delivery_index');
                // $address_items['delivery_price']    = get_inpost('delivery_price');
                $address_items['delivery_types']    = get_inpost('delivery_types');
                // $address_items['packing_fee']       = get_inpost('packing_fee');
                $this->session->set_userdata($address_items);

                redirect('cart/review', 'refresh');
            }
            else {
                $this->form_validation->set_rules('OD_Name',        'ชื่อ-นามสกุล', 'trim|required');
                $this->form_validation->set_rules('OD_Tel',         'โทรศัพท์', 'trim|required');
                $this->form_validation->set_rules('OD_Email',       'อีเมล', 'trim|required|valid_email');
                $this->form_validation->set_rules('OD_hrNumber',    'เลขที่/ห้อง', 'trim|required');
                $this->form_validation->set_rules('OD_VilNo',       'หมู่ที่', 'trim|numeric');
                $this->form_validation->set_rules('Amphur_ID',      'เขต/อำเภอ', 'trim|required');
                $this->form_validation->set_rules('District_ID',    'แขวง/ตำบล', 'trim|required');
                $this->form_validation->set_rules('Province_ID',    'จังหวัด', 'trim|required');
                $this->form_validation->set_rules('Zipcode_Code',   'รหัสไปรษณีย์', 'trim|required|numeric|max_length[5]');
                $this->form_validation->set_message('required',     '%s เป็นข้อมูลที่จำเป็น');
                $this->form_validation->set_message('max_length',   '%s ต้องไม่เกิน %d ตัวอักษร');
                $this->form_validation->set_message('valid_email',  '%s จะต้องมีรูปแบบที่ถูกต้อง');
                $this->form_validation->set_message('numeric',      '%s จะต้องเป็นตัวเลขเท่านั้น');
                if ($this->form_validation->run() !== false) {
                    $address_items = array(
                        'OD_Name'           => get_inpost('OD_Name'),
                        'OD_Tel'            => get_inpost('OD_Tel'),
                        'OD_Email'          => get_inpost('OD_Email'),
                        'OD_hrNumber'       => get_inpost('OD_hrNumber'),
                        'OD_VilBuild'       => get_inpost('OD_VilBuild'),
                        'OD_VilNo'          => get_inpost('OD_VilNo'),
                        'OD_LaneRoad'       => get_inpost('OD_LaneRoad'),
                        'OD_Street'         => get_inpost('OD_Street'),
                        'Amphur_ID'         => get_inpost('Amphur_ID'),
                        'District_ID'       => get_inpost('District_ID'),
                        'Province_ID'       => get_inpost('Province_ID'),
                        'Zipcode_Code'      => get_inpost('Zipcode_Code'),
                    );
                    $address_items['delivery_index']    = get_inpost('delivery_index');
                    // $address_items['delivery_price']    = get_inpost('delivery_price');
                    $address_items['delivery_types']    = get_inpost('delivery_types');
                    // $address_items['packing_fee']       = get_inpost('packing_fee');
                    $address_items['account_address']   = '';
                    $this->session->set_userdata($address_items);

                    redirect('cart/review', 'refresh');
                    die();
                }
                else {
                    // print("<script language='javascript'>alert('!!! ข้อมูลที่อยู่ผิดพลาด กรุณาตรวจสอบข้อมูลอีกครั้ง');</script>");
                    $this->address();
                }
            }
        }
        else redirect('product', 'refresh');
    }

	public function cartOrderSaved() {
        if ($this->cart->contents()) {
            $order_state    = true;
            $order_total    = 0;
            $order_msg      = '';
            foreach ($this->cart->contents() as $key => $value) {
                $P_ID       = $value['id'];
                $ODL_Amount = $value['qty'];
                $row = rowArray($this->common_model->custom_query(" SELECT `PS_Amount` FROM `product_stock` WHERE `P_ID` = '$P_ID' AND `PS_Allow` = '1' "));
                if (count($row) > 0) {
                    if ($ODL_Amount > $row['PS_Amount']) {
                        $order_state    = false;
                        $P_Name         = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P_ID));
                        $order_msg      = 'ขออภัยสินค้า '.$P_Name['P_Name'].' ขณะนี้มีจำนวนไม่พอ กรุณาทำรายการใหม่อีกครั้ง';
                        break;
                    }
                    else {
                        $order_state  = true;
                        $promotion_price = rowArray($this->common_model->custom_query(
                            "   SELECT * FROM `product_price`
                                WHERE `P_ID` = $P_ID AND `PP_Special` = '1' AND `PP_Allow` != '3' AND (NOW() BETWEEN PP_StartDate AND PP_EndDate )
                                ORDER BY PP_ID DESC LIMIT 1     "
                        ));
                        $stock_price = rowArray($this->common_model->custom_query(
                            "   SELECT * FROM `product_stock`
                                WHERE `P_ID` = $P_ID AND `PS_Allow` != '3'
                                ORDER BY PS_ID DESC LIMIT 1     "
                        ));
                        if (count($promotion_price)     > 0 && $promotion_price['PP_Price'] != 0)
                            $price = number_format($promotion_price['PP_Price'], 2, '.', '');
                        else if (count($stock_price)    > 0 && $stock_price['PS_Price']     != 0)
                            $price = number_format($stock_price['PS_Price'], 2, '.', '');
                        else
                            $price = number_format(0, 2, '.', '');
                        $order_total += ($value['qty'] * $price);
                        // $order_total += $value['subtotal'];
                    }
                }
                else {
                    $order_state    = false;
                    $P_Name         = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P_ID));
                    $order_msg      = 'ขออภัยสินค้า '.$P_Name['P_Name'].' หมด กรุณาทำรายการใหม่อีกครั้ง';
                    break;
                }
            }

            if ($order_state === true) {
                $data = array(
                    'OD_SumPrice'       => number_format($order_total, 2, '.', ''),
                    // 'OD_FullSumPrice'   => number_format($order_total + get_session('delivery_price'), 2, '.', ''),
                    // 'OD_FullSumPrice'   => number_format($order_total + get_session('packing_fee'), 2, '.', ''),
                    'OD_FullSumPrice'   => number_format($order_total + $this->grand_wprice(), 2, '.', ''),
                    'OD_DateTimeAdd'    => date("Y-m-d H:i:s"),
                    'OD_DateTimeUpdate' => date("Y-m-d H:i:s"),
                    'OD_Status'         => '2',
                    'OD_Allow'          => '4',
                );
                if (get_session('C_ID') != '') {
                    $data['M_ID']           = get_session('C_ID');
                    $data['OD_UserAdd']     = get_session('C_ID');
                    $data['OD_UserUpdate']  = get_session('C_ID');
                }
                else {
                    $data['M_ID']           = 0;
                    $data['OD_UserAdd']     = 0;
                    $data['OD_UserUpdate']  = 0;
                }
                $this->common_model->insert('order', $data);

                $OD_ID = rowArray($this->common_model->custom_query(" SELECT * FROM `order` ORDER BY `OD_ID` DESC LIMIT 1 "));
                if (count($OD_ID) > 0) {
                    $OD_Code    = array('OD_Code' => 'PO'.str_pad($OD_ID['OD_ID'], 6, "0", STR_PAD_LEFT));
                    $OD_Cond    = "OD_ID = '".$OD_ID['OD_ID']."'";
                    $this->common_model->update('order', $OD_Code, $OD_Cond);
                    if (get_session('account_address') == 'checked') {
                        $member = rowArray($this->common_model->get_where_custom('member', 'M_ID', get_session('C_ID')));
                        if (count($member) > 0) {
                            $address = array(
                                'OD_Name'           => $member['M_flName'],
                                'OD_Email'          => $member['M_Email'],
                                'OD_hrNumber'       => $member['M_hrNumber'],
                                'OD_VilBuild'       => $member['M_VilBuild'],
                                'OD_VilNo'          => $member['M_VilNo'],
                                'OD_LaneRoad'       => $member['M_LaneRoad'],
                                'OD_Street'         => $member['M_Street'],
                                'Amphur_ID'         => $member['Amphur_ID'],
                                'District_ID'       => $member['District_ID'],
                                'Province_ID'       => $member['Province_ID'],
                                'Zipcode_Code'      => $member['Zipcode_Code'],
                            );
                                    if ($member['M_MTel'] != '')    $address['OD_Tel'] = $member['M_MTel'];
                            else    if ($member['M_HTel'] != '')    $address['OD_Tel'] = $member['M_HTel'];
                            else                                    $address['OD_Tel'] = '';
                        }
                    }
                    else {
                        $address = array(
                            'OD_Name'           => get_session('OD_Name'),
                            'OD_Tel'            => get_session('OD_Tel'),
                            'OD_Email'          => get_session('OD_Email'),
                            'OD_hrNumber'       => get_session('OD_hrNumber'),
                            'OD_VilBuild'       => get_session('OD_VilBuild'),
                            'OD_VilNo'          => get_session('OD_VilNo'),
                            'OD_LaneRoad'       => get_session('OD_LaneRoad'),
                            'OD_Street'         => get_session('OD_Street'),
                            'Amphur_ID'         => get_session('Amphur_ID'),
                            'District_ID'       => get_session('District_ID'),
                            'Province_ID'       => get_session('Province_ID'),
                            'Zipcode_Code'      => get_session('Zipcode_Code'),
                        );
                    }
                    $address['OD_ID']               = $OD_ID['OD_ID'];
                    $address['OD_DateTimeAdd']      = date("Y-m-d H:i:s");
                    $address['OD_DateTimeUpdate']   = date("Y-m-d H:i:s");
                    $address['OD_Allow']            = '1';
                    if (get_session('delivery_types')   != '')  $address['OD_Descript']  = trim('ส่งแบบ '.get_session('delivery_types')).' ';
                    // if (get_session('delivery_price')   != '')   $address['OD_Descript'] .= trim('(฿'.number_format(get_session('delivery_price'), 2, '.', ',').')');
                    // if (get_session('packing_fee')       > 0)   $address['OD_Descript'] .= trim(', (บรรจุพิเศษ)');
                    else $address['OD_Descript']  = '';
                    if (get_session('C_ID') != '') {
                        $address['OD_UserAdd']     = get_session('C_ID');
                        $address['OD_UserUpdate']  = get_session('C_ID');
                    }
                    else {
                        $address['OD_UserAdd']     = 0;
                        $address['OD_UserUpdate']  = 0;
                    }
                    $this->common_model->insert('order_address', $address);

                    $lists = array();
                    foreach ($this->cart->contents() as $key => $value) {
                        $P_IDCode = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P_ID));
                        $promotion_price = rowArray($this->common_model->custom_query(
                            "   SELECT * FROM `product_price`
                                WHERE `P_ID` = $P_ID AND `PP_Special` = '1' AND `PP_Allow` != '3' AND (NOW() BETWEEN PP_StartDate AND PP_EndDate )
                                ORDER BY PP_ID DESC LIMIT 1     "
                        ));
                        $stock_price = rowArray($this->common_model->custom_query(
                            "   SELECT * FROM `product_stock`
                                WHERE `P_ID` = $P_ID AND `PS_Allow` != '3'
                                ORDER BY PS_ID DESC LIMIT 1     "
                        ));
                        if (count($promotion_price)     > 0 && $promotion_price['PP_Price'] != 0)
                            $price = number_format($promotion_price['PP_Price'], 2, '.', '');
                        else if (count($stock_price)    > 0 && $stock_price['PS_Price']     != 0)
                            $price = number_format($stock_price['PS_Price'], 2, '.', '');
                        else
                            $price = number_format(0, 2, '.', '');
                        $ODL_Descript = $P_IDCode['P_IDCode'];
                        if ($value['options']['color'] != '') $ODL_Descript .= '.'.$value['options']['color'];
                        $datas = array(
                            'OD_ID'                 => $OD_ID['OD_ID'],
                            'P_ID'                  => $value['id'],
                            'ODL_Amount'            => $value['qty'],
                            'ODL_Price'             => $price,
                            'ODL_SumPrice'          => ($value['qty'] * $price),
                            'ODL_FullSumPrice'      => ($value['qty'] * $price),
                            'ODL_Descript'          => $ODL_Descript,
                            'ODL_DateTimeAdd'       => date("Y-m-d H:i:s"),
                            'ODL_DateTimeUpdate'    => date("Y-m-d H:i:s"),
                            'ODL_Allow'             => '1'
                        );
                        if (get_session('C_ID') != '') {
                            $datas['ODL_UserAdd']     = get_session('C_ID');
                            $datas['ODL_UserUpdate']  = get_session('C_ID');
                        }
                        else {
                            $datas['ODL_UserAdd']     = 0;
                            $datas['ODL_UserUpdate']  = 0;
                        }
                        array_push($lists, $datas);
                    }
                    $this->common_model->insert_batch('order_list', $lists);

                    // $this->cart->destroy();
                    // $this->session->unset_userdata('delivery_index');
                    // $this->session->unset_userdata('delivery_price');
                    // $this->session->unset_userdata('delivery_types');
                    // $this->session->unset_userdata('OD_Name');
                    // $this->session->unset_userdata('OD_Tel');
                    // $this->session->unset_userdata('OD_Email');
                    // $this->session->unset_userdata('OD_hrNumber');
                    // $this->session->unset_userdata('OD_VilBuild');
                    // $this->session->unset_userdata('OD_VilNo');
                    // $this->session->unset_userdata('OD_LaneRoad');
                    // $this->session->unset_userdata('OD_Street');
                    // $this->session->unset_userdata('Amphur_ID');
                    // $this->session->unset_userdata('District_ID');
                    // $this->session->unset_userdata('Province_ID');
                    // $this->session->unset_userdata('Zipcode_Code');
                    // $this->session->unset_userdata('account_address');
                    // $this->session->unset_userdata('packing_fee');
                    // $this->cartResultToEmail($OD_ID['OD_ID']);
                    // $order_msg = 'บันทึกใบสั่งซื้อเรียบร้อยแล้ว';
                    // echo "<script>alert('".$order_msg."');</script>";
                    // die("-..-");

                    redirect('cart/cartResult/'.$OD_ID['OD_ID'], 'refresh');
                    // $this->cartResult($OD_ID['OD_ID']);
                }
            }
            else redirect('cart', 'refresh');
        }
        else redirect('product', 'refresh');
	}

    public function cartResult($OD_ID = null){

            $title        = 'การสั่งซื้อเสร็จสิ้น';
            $content_view = 'front-end/result';

            $navi_props =   array(
                'path'  =>  array(base_url('cart'), base_url('cart/address'), base_url('cart/review')),
                'name'  =>  array('รายละเอียดการสั่งซื้อ', 'ที่อยู่ในการจัดส่ง', 'การสั่งซื้อ'),
            );
            $breadcrumb = $this->breadcrumb_model->breadcrumb($navi_props['path'], $navi_props['name'], $title);

            
            

        $sites = $this->webinfo_model->getOnceWebMain();
        $order_address = rowArray($this->common_model->get_where_custom('order_address', 'OD_ID', $OD_ID));

        $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $OD_ID));
        $order_data = array(
            'OD_ID'             => $OD_ID,
            'OD_Code'           => $order['OD_Code'],
            'OD_Allow'          => 'รอโอนเงิน',
            'OD_SumPrice'       => $order['OD_SumPrice'],
            'OD_FullSumPrice'   => $order['OD_FullSumPrice'],
        );
        $order_list  = $this->common_model->custom_query(
            " SELECT * FROM `order_list` LEFT JOIN `product` ON `order_list`.`P_ID` = `product`.`P_ID` WHERE `OD_ID` = '$OD_ID' "
        );
        $order_list_data = array();
        foreach ($order_list as $list_order) {
            array_push($order_list_data, $list_order);
        }
        $district   = rowArray($this->common_model->get_where_custom('districts', 'District_ID',  $order_address['District_ID']));
        $amphur     = rowArray($this->common_model->get_where_custom('amphures',  'Amphur_ID',    $order_address['Amphur_ID']));
        $province   = rowArray($this->common_model->get_where_custom('provinces', 'Province_ID',  $order_address['Province_ID']));
        if ($order_address['OD_hrNumber']   != '') $OD_Address  = 'เลขที่/ห้อง '.$order_address['OD_hrNumber'];
        if ($order_address['OD_VilBuild']   != '') $OD_Address .= ' หมู่บ้าน/อาคาร/คอนโด '.$order_address['OD_VilBuild'];
        if ($order_address['OD_VilNo']      != '') $OD_Address .= ' หมู่ที่ '.$order_address['OD_VilNo'];
        if ($order_address['OD_LaneRoad']   != '') $OD_Address .= ' ตรอก/ซอย '.$order_address['OD_LaneRoad'];
        if ($order_address['OD_Street']     != '') $OD_Address .= ' ถนน'.$order_address['OD_Street'];
        if ($order_address['Province_ID']   != 1) {
            $OD_Address .= ' ตำบล'.$district['District_Name'];
            $OD_Address .= ' อำเภอ'.$amphur['Amphur_Name'];
            $OD_Address .= ' จังหวัด'.$province['Province_Name'];
        }
        if ($order_address['Zipcode_Code']  != '') $OD_Address .= ' รหัสไปรษณีย์ '.$order_address['Zipcode_Code'];
        $order_address_data = array(
            'OD_Name'       => $order_address['OD_Name'],
            'OD_Tel'        => $order_address['OD_Tel'],
            'OD_Address'    => $OD_Address,
        );

        $data = array(
            'order'         => $order_data,
            'order_list'    => $order_list_data,
            'order_address' => $order_address_data,
            'document_type' => 'html',
            'content_view'   => $content_view,
            'title'          => $title,
            'breadcrumb'     => $breadcrumb,
            'grand_quantity' => $this->grand_quantity(),
            'grand_subtotal' => $this->grand_subtotal(),
            'grand_weight'   => $this->grand_weight(),
            'grand_wprice'   => $this->grand_wprice(),
        );
        $this->cart->destroy();
        $this->session->unset_userdata('delivery_index');
        $this->session->unset_userdata('delivery_price');
        $this->session->unset_userdata('delivery_types');
        $this->session->unset_userdata('OD_Name');
        $this->session->unset_userdata('OD_Tel');
        $this->session->unset_userdata('OD_Email');
        $this->session->unset_userdata('OD_hrNumber');
        $this->session->unset_userdata('OD_VilBuild');
        $this->session->unset_userdata('OD_VilNo');
        $this->session->unset_userdata('OD_LaneRoad');
        $this->session->unset_userdata('OD_Street');
        $this->session->unset_userdata('Amphur_ID');
        $this->session->unset_userdata('District_ID');
        $this->session->unset_userdata('Province_ID');
        $this->session->unset_userdata('Zipcode_Code');
        $this->session->unset_userdata('account_address');
        $this->session->unset_userdata('packing_fee');
        $this->cartResultToEmail($OD_ID);

        $this->template->load('index_page', $data);
    }

    public function orderTransferSubmit() {
        $OD_ID  = $this->input->post('OD_ID');
        $day    = substr(str_replace('/', '-', $this->input->post('OT_DateAdd')), 0, 2);
        $month  = substr(str_replace('/', '-', $this->input->post('OT_DateAdd')), 3, 2);
        $year   = substr(str_replace('/', '-', $this->input->post('OT_DateAdd')), 6, 10);
        $year   = $year - 543;
        $OT_DateTime = date('Y-m-d H:i:s', strtotime($year.'-'.$month.'-'.$day.' '.$this->input->post('OT_HourAdd').':'.$this->input->post('OT_MinuteAdd').':00'));
        $data = array(
            'OD_ID'             => $this->input->post('OD_ID'),
            'B_ID'              => $this->input->post('B_ID'),
            'OT_Payment'        => $this->input->post('OT_Payment'),
            'OT_Descript'       => $this->input->post('OT_Descript'),
            'OT_Price'          => $this->input->post('OT_Price'),
            'OT_SumPrice'       => $this->input->post('OT_Price'),
            'OT_FullSumPrice'   => $this->input->post('OT_Price'),
            'OT_ImgAttach'      => $this->input->post('OT_ImgAttach'),
            'OT_UserAdd'        => get_session('C_ID'),
            'OT_DateTimeAdd'    => $OT_DateTime,
            'OT_UserUpdate'     => get_session('C_ID'),
            'OT_DateTimeUpdate' => $OT_DateTime,
            'OT_Allow'          => '1',
        );
        $this->common_model->insert('order_transfer', $data);
        $this->db->query(" UPDATE `order_transfer` SET `OT_Allow` = '3' WHERE `OD_ID` = '$OD_ID' ");
        $this->db->query(" UPDATE `order_transfer` SET `OT_Allow` = '1' WHERE `OD_ID` = '$OD_ID' ORDER BY `OT_ID` DESC LIMIT 1 ");
        $this->orderTransferSendEmail($this->input->post('OD_ID'));
        redirect('cart/order_transfer_form', 'refresh');
    }

    public function cartResultToEmail($OD_ID = null) {
        $sites = $this->webinfo_model->getOnceWebMain();
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
        $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $OD_ID));
        $order_data = array(
            'OD_ID'             => $OD_ID,
            'OD_Code'           => $order['OD_Code'],
            'OD_Allow'          => 'รอโอนเงิน',
            'OD_SumPrice'       => $order['OD_SumPrice'],
            'OD_FullSumPrice'   => $order['OD_FullSumPrice'],
        );
        $order_list  = $this->common_model->custom_query(
            " SELECT * FROM `order_list` LEFT JOIN `product` ON `order_list`.`P_ID` = `product`.`P_ID` WHERE `OD_ID` = '$OD_ID' "
        );
        $order_list_data = array();
        foreach ($order_list as $list_order) {
            array_push($order_list_data, $list_order);
        }
        $district   = rowArray($this->common_model->get_where_custom('districts', 'District_ID',  $order_address['District_ID']));
        $amphur     = rowArray($this->common_model->get_where_custom('amphures',  'Amphur_ID',    $order_address['Amphur_ID']));
        $province   = rowArray($this->common_model->get_where_custom('provinces', 'Province_ID',  $order_address['Province_ID']));
        if ($order_address['OD_hrNumber']   != '') $OD_Address  = 'เลขที่/ห้อง '.$order_address['OD_hrNumber'];
        if ($order_address['OD_VilBuild']   != '') $OD_Address .= ' หมู่บ้าน/อาคาร/คอนโด '.$order_address['OD_VilBuild'];
        if ($order_address['OD_VilNo']      != '') $OD_Address .= ' หมู่ที่ '.$order_address['OD_VilNo'];
        if ($order_address['OD_LaneRoad']   != '') $OD_Address .= ' ตรอก/ซอย '.$order_address['OD_LaneRoad'];
        if ($order_address['OD_Street']     != '') $OD_Address .= ' ถนน'.$order_address['OD_Street'];
        if ($order_address['Province_ID']   != 1) {
            $OD_Address .= ' ตำบล'.$district['District_Name'];
            $OD_Address .= ' อำเภอ'.$amphur['Amphur_Name'];
            $OD_Address .= ' จังหวัด'.$province['Province_Name'];
        }
        if ($order_address['Zipcode_Code']  != '') $OD_Address .= ' รหัสไปรษณีย์ '.$order_address['Zipcode_Code'];
        $order_address_data = array(
            'OD_Name'       => $order_address['OD_Name'],
            'OD_Tel'        => $order_address['OD_Tel'],
            'OD_Address'    => $OD_Address,
        );
        $data = array(
            'order'         => $order_data,
            'order_list'    => $order_list_data,
            'order_address' => $order_address_data,
            'document_type' => 'html',
        );
        $config['useragent']    = $sites['WD_Name'];
        $config['mailtype']     = 'html';
        $this->email->initialize($config);
        $this->email->from($sites['WD_Email'], $sites['WD_Name']);
        $this->email->to($roots_email_list);
        $this->email->cc($admin_email_list);
        $this->email->subject('การสั่งซื้อสินค้ากับ '.$sites['WD_Name']);
        $this->email->message($this->load->view('web_template1/email/order', $data, true));
        @$this->email->send();
        // echo $this->email->print_debugger();
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
			array_push($admin_email_list, $email_admin);
		}
        $query = rowArray($this->common_model->custom_query(" SELECT * FROM `order_transfer` LEFT JOIN `order` ON `order_transfer`.`OD_ID` = `order`.`OD_ID` WHERE `order_transfer`.`OD_ID` = '$OD_ID' "));
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

    public function searchOrderCode() {
        $rows = $this->common_model->get_where_custom('order', 'OD_Code', $this->db->escape_str($this->input->post('OD_Code')));
        if (count($rows) > 0) {
            $row = rowArray($rows);
            echo $row['OD_ID'];
        }
    }

    public function orderprint($key_id = null) {
        $OD_ID = $this->encrypt->decode($key_id);
        $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $OD_ID));
        $order_data = array(
            'OD_ID'             => $OD_ID,
            'OD_Code'           => $order['OD_Code'],
            'OD_Allow'          => 'รอโอนเงิน',
            'OD_SumPrice'       => $order['OD_SumPrice'],
            'OD_FullSumPrice'   => $order['OD_FullSumPrice'],
        );
        $order_list  = $this->common_model->custom_query(
            " SELECT * FROM `order_list` LEFT JOIN `product` ON `order_list`.`P_ID` = `product`.`P_ID` WHERE `OD_ID` = '$OD_ID' "
        );
        $order_list_data = array();
        foreach ($order_list as $list_order) {
            array_push($order_list_data, $list_order);
        }
        $district           = rowArray($this->common_model->get_where_custom('districts',       'District_ID',  $order_address['District_ID']));
        $amphur             = rowArray($this->common_model->get_where_custom('amphures',        'Amphur_ID',    $order_address['Amphur_ID']));
        $province           = rowArray($this->common_model->get_where_custom('provinces',       'Province_ID',  $order_address['Province_ID']));
        if ($order_address['OD_hrNumber']   != '') $OD_Address  = 'เลขที่/ห้อง '.$order_address['OD_hrNumber'];
        if ($order_address['OD_VilBuild']   != '') $OD_Address .= ' หมู่บ้าน/อาคาร/คอนโด '.$order_address['OD_VilBuild'];
        if ($order_address['OD_VilNo']      != '') $OD_Address .= ' หมู่ที่ '.$order_address['OD_VilNo'];
        if ($order_address['OD_LaneRoad']   != '') $OD_Address .= ' ตรอก/ซอย '.$order_address['OD_LaneRoad'];
        if ($order_address['OD_Street']     != '') $OD_Address .= ' ถนน'.$order_address['OD_Street'];
        if ($order_address['Province_ID']   != 1) {
            $OD_Address .= ' ตำบล'.$district['District_Name'];
            $OD_Address .= ' อำเภอ'.$amphur['Amphur_Name'];
            $OD_Address .= ' จังหวัด'.$province['Province_Name'];
        }
        if ($order_address['Zipcode_Code']  != '') $OD_Address .= ' รหัสไปรษณีย์ '.$order_address['Zipcode_Code'];
        $order_address_data = array(
            'OD_Name'       => $order_address['OD_Name'],
            'OD_Tel'        => $order_address['OD_Tel'],
            'OD_Address'    => $OD_Address,
        );
        $data = array(
            'order'         => $order_data,
            'order_list'    => $order_list_data,
            'order_address' => $order_address_data,
            'document_type' => 'pdf',
        );
        $pdfFilePath = 'order_'.$order['OD_Code'].'.pdf';
        $html = $this->load->view('web_template1/email/order', $data, true);
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

    public function orderconfirmprint($key_id = null) {
        $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $key_id));
        $data = array(
            'OD_Code'               => $order['OD_Code'],
            'OD_FullSumPrice'       => $order['OD_FullSumPrice'],
            'OD_DateTimeAdd'        => $order['OD_DateTimeAdd'],
            'OD_Allow'              => 'ยืนยันแล้ว',
            'document_type'         => 'pdf',
        );
        $pdfFilePath = 'confirm_order_'.$order['OD_Code'].'.pdf';
        $html = $this->load->view('web_template1/email/order_confirm', $data, true);
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

    public function ordertransferprint($key_id = null) {
        $query = rowArray($this->common_model->custom_query(
            "   SELECT * FROM `order_transfer`
                LEFT JOIN `order`   ON `order_transfer`.`OD_ID` = `order`.`OD_ID`
                LEFT JOIN `bank`    ON `order_transfer`.`B_ID`  = `bank`.`B_ID`
                WHERE `order_transfer`.`OD_ID` = '$key_id' "
        ));
        $data = array(
            'OD_Code'           => $query['OD_Code'],
            'B_Name'            => $query['B_Name'],
            'OT_Payment'        => $query['OT_Payment'],
            'OT_DateTimeUpdate' => $query['OT_DateTimeUpdate'],
            'OT_FullSumPrice'   => $query['OT_FullSumPrice'],
            'document_type'     => 'pdf',
        );
        $pdfFilePath = 'transfer_order_'.$order['OD_Code'].'.pdf';
        $html = $this->load->view('web_template1/email/order_transfer', $data, true);
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

    public function transfersuccessprint($key_id = null) {
        $query = rowArray($this->common_model->custom_query(" SELECT * FROM `order_transfer` LEFT JOIN `order` ON `order_transfer`.`OD_ID` = `order`.`OD_ID` WHERE `order_transfer`.`OD_ID` = '$key_id' "));
        $data = array(
            'OD_Code'           => $query['OD_Code'],
            'B_Name'            => $query['B_Name'],
            'OT_Payment'        => $query['OT_Payment'],
            'OT_DateTimeUpdate' => $query['OT_DateTimeUpdate'],
            'OT_FullSumPrice'   => $query['OT_FullSumPrice'],
            'document_type'     => 'pdf',
        );
        $pdfFilePath = 'success_order_'.$order['OD_Code'].'.pdf';
        $html = $this->load->view('web_template1/email/transfer_success', $data, true);
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

    public function transferfailedprint($key_id = null) {
        $query = rowArray($this->common_model->custom_query(" SELECT * FROM `order_transfer` LEFT JOIN `order` ON `order_transfer`.`OD_ID` = `order`.`OD_ID` WHERE `order_transfer`.`OD_ID` = '$key_id' "));
        $data = array(
            'OD_Code'           => $query['OD_Code'],
            'B_Name'            => $query['B_Name'],
            'OT_Payment'        => $query['OT_Payment'],
            'OT_DateTimeUpdate' => $query['OT_DateTimeUpdate'],
            'OT_FullSumPrice'   => $query['OT_FullSumPrice'],
            'document_type'     => 'pdf',
        );
        $pdfFilePath = 'failed_order_'.$order['OD_Code'].'.pdf';
        $html = $this->load->view('web_template1/email/transfer_failed', $data, true);
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

    public function ordercodeprint($key_id = null) {
        $query = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $OD_ID));
        $data = array(
            'OD_Code'           => $query['OD_Code'],
            'OD_EmsCode'        => $query['OD_EmsCode'],
            'document_type'     => 'pdf',
        );
        $pdfFilePath = 'emscode_order_'.$order['OD_Code'].'.pdf';
        $html = $this->load->view('web_template1/email/order_code', $data, true);
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