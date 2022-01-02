<?php
	class Callback_column_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function product_PS_Price($value, $row) {
            $prices = $this->common_model->custom_query(" SELECT * FROM `product_stock` WHERE `P_ID` = '$row->P_ID' ORDER BY `PS_ID` DESC LIMIT 1 ");
            if (count($prices) > 0) {
                $price = rowArray($prices);
                return number_format($price['PS_FullSumPrice'], 2, '.', ',').' <a style="display:inline-block" href="product_stock/price/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้า"></a>';
            }
            else
                return number_format(0, 2, '.', ',').' <a style="display:inline-block" href="product_stock/price/'.$row->P_ID.'" class="various fancybox.ajax crud-action" title="แก้ไขราคาสินค้า"><img src="'.base_url('assets/admin/images/tools/edit-icon.png').'" alt="แก้ไขราคาสินค้า"></a>';
        }

    }
?>