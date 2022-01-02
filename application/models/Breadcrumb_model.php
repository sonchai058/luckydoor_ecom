<?php
	class Breadcrumb_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function breadcrumb($path = array(), $name = array(), $title = null) {
    		$breadcrumb = array(
                'index_url' => array( 
                    'path'  => base_url('main'), 
                    'name'  => 'หน้าหลัก', 
                ), 
                'lists_url' => array( 
                    'path'  => $path, 
                    'name'  => $name, 
                ), 
                'currt_url' => array( 
                    'path'  => '', 
                    'name'  => $title, 
                ), 
            );
            return $breadcrumb;
        }

    }
?>