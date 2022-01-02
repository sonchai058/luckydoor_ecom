<?php
	class Fill_dropdown_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function getOnceWebMain($tableName, $fieldKey, $fieldName) {
            $row = $this->common_model->getTable($tableName);
            if (count($row) <= 0)
            	return array('' => '');
            else {
    	        $custom_array = array();
    	        foreach ($row as $key => $value) {
    	            $custom_array[$value[$fieldKey]] = $value[$fieldName];
    	        }
    	        return $custom_array;
    	    }
        }

        public function getOnceCustoms($tableName, $fieldKey, $fieldName, $fieldID, $fieldValue) {
            $row = $this->common_model->get_where_custom($tableName, $fieldID, $fieldValue);
            if (count($row) <= 0)
                return array('' => '');
            else {
                $custom_array = array();
                foreach ($row as $key => $value) {
                    $custom_array[$value[$fieldKey]] = $value[$fieldName];
                }
                return $custom_array;
            }
        }

    }
?>


