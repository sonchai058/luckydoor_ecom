<?php
	class Permission_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function getOnceWebMain() {
    		if (get_session('M_ID') == '')
    			redirect('control/login', 'refresh');
            else {
                $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
                if (count($row) <= 0)
    				redirect('control/login', 'refresh');
                else {
                    //                  Root,           Accountant,     Stock,          Messenger
                    // $product    = array('1' => '1',     '2' => '0',     '3' => '1',     '4' => '0');
                    // $cart       = array('1' => '1',     '2' => '1',     '3' => '0',     '4' => '1');
                    // $bank       = array('1' => '1',     '2' => '0',     '3' => '0',     '4' => '0');
                    // $member     = array('1' => '1',     '2' => '0',     '3' => '0',     '4' => '0');
                    // $statistic  = array('1' => '1',     '2' => '1',     '3' => '0',     '4' => '0');
                    // $webconfig  = array('1' => '1',     '2' => '0',     '3' => '0',     '4' => '0');
                    $product    = array('1' => '1',     '2' => '1',     '3' => '1',     '4' => '0');
                    $cart       = array('1' => '1',     '2' => '1',     '3' => '0',     '4' => '1');
                    $bank       = array('1' => '1',     '2' => '0',     '3' => '0',     '4' => '0');
                    $member     = array('1' => '1',     '2' => '0',     '3' => '0',     '4' => '0');
                    $statistic  = array('1' => '1',     '2' => '1',     '3' => '0',     '4' => '0');
                    $webconfig  = array('1' => '1',     '2' => '0',     '3' => '0',     '4' => '0');
                    //                  Root,           Accountant,     Stock,          Messenger
                    if (uri_seg(2)      == 'control_product')    {
                        if ($product[get_session('M_Type')]   == '0')
                            redirect('control', 'refresh');
                    }
                    else if (uri_seg(2) == 'control_cart')       {
                        if ($cart[get_session('M_Type')]      == '0')
                            redirect('control', 'refresh');
                        /**/
                        else {
                            if (uri_seg(3) == 'order_management') {
                                if (get_session('M_Type') == '3')
                                    redirect('control', 'refresh');
                            }
                        }
                        /**/
                    }
                    else if (uri_seg(2) == 'control_bank')       {
                        if ($bank[get_session('M_Type')]      == '0')
                            redirect('control', 'refresh');
                    }
                    else if (uri_seg(2) == 'control_member')     {
                        if ($member[get_session('M_Type')]    == '0')
                            redirect('control', 'refresh');
                    }
                    else if (uri_seg(2) == 'control_statistic')  {
                        if ($statistic[get_session('M_Type')] == '0')
                            redirect('control', 'refresh');
                    }
                    else if (uri_seg(1) == 'webconfig')          {
                        if ($webconfig[get_session('M_Type')] == '0')
                            redirect('control', 'refresh');
                    }
                }
            }
        }

        public function getMemberLevel() {
            if (get_session('C_ID') == '') {
                if (uri_seg(1) !== 'member') echo "<script>alert('!!! กรุณาเข้าสู่ระบบ');</script>";
                redirect('main', 'refresh');
            }
            else {
                $row = $this->common_model->get_where_custom('member', 'M_Username', $this->db->escape_str(get_session('C_Username')));
                if (count($row) <= 0)
                    redirect('main', 'refresh');
            }
        }

    }
?>