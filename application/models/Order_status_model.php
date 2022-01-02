<?php
	class Order_status_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

	    public function getOnceWebMain() {
	        return array(
	        	'1' => 'ปกติ'		,
	        	'2' => 'ระงับ'		,
	        	'3' => 'ยกเลิก'		,
	        	'4' => 'รอโอนเงิน'		,
	        	'5' => 'โอนเงินแล้ว'	,
	        	'6' => 'รอส่งสินค้า'	,
	        	'7' => 'ส่งสินค้าแล้ว'	,
	        );
	    }

	}
?>