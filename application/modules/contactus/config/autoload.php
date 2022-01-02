<?php  
   
    $autoload = array(
        'helper'    => array('url', 'form', 'general', 'file', 'html', 'asset'),
        'libraries' => array('session', 'encrypt', 'cart', 'grocery_CRUD', 'form_validation', 'email'),
        'model' 	=> array('admin_model', 'common_model', 'useful_model', 'webinfo_model', 'files_model')
    );

?>