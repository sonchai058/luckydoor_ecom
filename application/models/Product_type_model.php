<?php
	class Product_type_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function productTypeDailyUpdate() {



      //       $userUpdate     = get_session('M_ID');
      //       $todayDateTime  = date('Y-m-d H:i:s');
    		// $sevenDatePast  = date('Y-m-d H:i:s', strtotime('-7 days'));
      //       $sevenDateNext  = date('Y-m-d H:i:s', strtotime('+7 days'));






            // Add new to product
            // $query = $this->common_model->custom_query(
            //     "   SELECT * FROM `product`
            //         WHERE   `P_DateTimeAdd` >= '$sevenDatePast'
            //         AND     `P_DateTimeAdd` <= '$todayDateTime'     "
            // );
            // if (count($query) > 0) {
            //     foreach ($query as $key => $value) {
            //         if (strpos($value['PT_ID'], '1') === false) {
            //             $P_ID = $value['P_ID'];
            //             if ($value['PT_ID'] == '')
            //                 $PT_ID = '1';
            //             else
            //                 $PT_ID = '1,'.$value['PT_ID'];
            //             $this->db->query(
            //                 "   UPDATE `product` SET
            //                     `PT_ID`             = '$PT_ID',
            //                     `P_UserUpdate`      = '$userUpdate',
            //                     `P_DateTimeUpdate`  = '$todayDateTime'
            //                     WHERE `P_ID` = $P_ID    "
            //             );
            //         }
            //     }
            // }



            // Remove new from product
            // $query = $this->common_model->custom_query(
            //     "   SELECT * FROM `product`
            //         WHERE `P_DateTimeAdd` < '$sevenDatePast'    "
            // );
            // if (count($query) > 0) {
            //     foreach ($query as $key => $value) {
            //         if (strpos($value['PT_ID'], '1') !== false) {
            //             $P_ID = $value['P_ID'];
            //             if ($value['PT_ID'] == '1')
            //                 $PT_ID = '';
            //             else if (strpos($value['PT_ID'], '1,') !== false)
            //                 $PT_ID = str_replace('1,', '', $value['PT_ID']);
            //             else if (strpos($value['PT_ID'], ',1') !== false)
            //                 $PT_ID = str_replace(',1', '', $value['PT_ID']);
            //             $this->db->query(
            //                 "   UPDATE `product` SET
            //                     `PT_ID`             = '$PT_ID',
            //                     `P_UserUpdate`      = '$userUpdate',
            //                     `P_DateTimeUpdate`  = '$todayDateTime'
            //                     WHERE `P_ID` = $P_ID    "
            //             );
            //         }
            //     }
            // }






            // Don't show when promotion was expired
            // $query = $this->common_model->custom_query(
            //     "   SELECT * FROM `product`
            //         LEFT JOIN `product_price`
            //         ON `product`.`P_ID` = `product_price`.`P_ID`
            //         WHERE   `PP_Special` = '1'
            //         AND     `PP_StartDate`  < '$todayDateTime'
            //         AND     `PP_EndDate`    < '$todayDateTime'     "
            // );
            // if (count($query) > 0) {
            //     foreach ($query as $key => $value) {
            //         $PP_ID = $value['PP_ID'];
            //         $this->db->query(
            //             "   UPDATE `product_price` SET
            //                 `PP_Special`        = '2',
            //                 `PP_UserUpdate`     = '$userUpdate',
            //                 `PP_DateTimeUpdate` = '$todayDateTime'
            //                 WHERE `PP_ID` = $PP_ID    "
            //         );
            //     }
            // }



            // Remove promotion from product
            // $query = $this->common_model->custom_query(
            //     "   SELECT * FROM `product`
            //         LEFT JOIN `product_price`
            //         ON `product`.`P_ID` = `product_price`.`P_ID`
            //         WHERE `PP_Special` = '2'    "
            // );
            // if (count($query) > 0) {
            //     foreach ($query as $key => $value) {
            //         if (strpos($value['PT_ID'], '2') !== false) {
            //             $P_ID = $value['P_ID'];
            //             if ($value['PT_ID'] == '2')
            //                 $PT_ID = '';
            //             else if (strpos($value['PT_ID'], '2,') !== false)
            //                 $PT_ID = str_replace('2,', '', $value['PT_ID']);
            //             else if (strpos($value['PT_ID'], ',2') !== false)
            //                 $PT_ID = str_replace(',2', '', $value['PT_ID']);
            //             $this->db->query(
            //                 "   UPDATE `product` SET
            //                     `PT_ID`             = '$PT_ID',
            //                     `P_UserUpdate`      = '$userUpdate',
            //                     `P_DateTimeUpdate`  = '$todayDateTime'
            //                     WHERE `P_ID` = $P_ID    "
            //             );
            //         }
            //     }
            // }



        }

    }
?>