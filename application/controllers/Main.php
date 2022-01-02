<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url', 'form', 'general', 'file', 'html', 'asset'));
		$this->load->library(array('session', 'encrypt', 'cart', 'grocery_CRUD', 'form_validation', 'email'));
		$this->load->model(array('admin_model', 'common_model', 'useful_model', 'webinfo_model', 'files_model'));

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
				'serialized_model'
			)
		);

		$this->statistic_view_model->getOnceWebMain();
		$this->product_type_model->productTypeDailyUpdate();
	}

	public function index() {
		// $feature_items = $this->common_model->custom_query(
		// 	" 	SELECT * FROM `product` LEFT JOIN `category`
		// 		ON `product`.`C_ID` = `category`.`C_ID`
		// 		WHERE `PT_ID` IN ('1','2','3')
		// 		ORDER BY `P_ID` DESC LIMIT 4 	"
		// );
		$feature_items = $this->common_model->custom_query(
			" 	SELECT * FROM `product` LEFT JOIN `category`
				ON `product`.`C_ID` = `category`.`C_ID`
				WHERE `PT_ID` IN ('1') AND `P_Allow` != '3'
				ORDER BY `P_ID` DESC LIMIT 4 	"
		);
		if (count($feature_items) <= 0) $feature_items = array();
		$data = array(
			'title' 		=> 'หน้าหลัก',
			'content_view'	=> 'content/main',
			'feature_items' => $feature_items,
		);
		$this->template->load('index_page', $data);
	}

	public function locations() {
		if (get_inpost('fieldKey') == 'District_ID') {
			$fieldID = rowArray($this->common_model->get_where_custom('districts', get_inpost('fieldKey'), get_inpost('fieldID')));
			$row = $this->common_model->get_where_custom(get_inpost('fieldTable'), 'District_Code', $fieldID['District_Code']);
		}
		else
			$row = $this->common_model->get_where_custom(get_inpost('fieldTable'), get_inpost('fieldKey'), get_inpost('fieldID'));
        if (count($row) <= 0)
            // echo json_encode(array('' => ''));
            echo json_encode('');
        else {
        	if (get_inpost('fieldEle') === 'input') {
        		foreach ($row as $key => $value) {
	                $custom_texts = trim($value[get_inpost('fieldName')]);
	            }
	            echo json_encode($custom_texts);
	        }
        	else {
	            $custom_array = array();
	            foreach ($row as $key => $value) {
	                $custom_array[$value[get_inpost('fieldValue')]] = trim($value[get_inpost('fieldName')]);
	            }
	            echo json_encode($custom_array);
	        }
        }
	}

	public function address() {
		$site = $this->webinfo_model->getOnceWebMain();
		if ($site['WD_Address'] !== '' && $this->serialized_model->is_serialized($site['WD_Address']) === true) {
        	$site['WD_Address'] = unserialize(preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $site['WD_Address']));
			$site['WD_Address'] = implode(',', $site['WD_Address']);
			$site['WD_Address'] = strip_tags($site['WD_Address']);
			$site['WD_Address'] = explode(',', $site['WD_Address']);
		}
		echo json_encode($site['WD_Address']);
	}

	public function tel() {
		$site = $this->webinfo_model->getOnceWebMain();
		if ($site['WD_Tel'] !== '' && $this->serialized_model->is_serialized($site['WD_Tel']) === true) {
        	$site['WD_Tel'] = unserialize(preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $site['WD_Tel']));
			$site['WD_Tel'] = implode(',', $site['WD_Tel']);
			$site['WD_Tel'] = strip_tags($site['WD_Tel']);
			$site['WD_Tel'] = explode(',', $site['WD_Tel']);
		}
		echo json_encode($site['WD_Tel']);
	}

	public function fax() {
		$site = $this->webinfo_model->getOnceWebMain();
		if ($site['WD_Fax'] !== '' && $this->serialized_model->is_serialized($site['WD_Fax']) === true) {
        	$site['WD_Fax'] = unserialize(preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $site['WD_Fax']));
			$site['WD_Fax'] = implode(',', $site['WD_Fax']);
			$site['WD_Fax'] = strip_tags($site['WD_Fax']);
			$site['WD_Fax'] = explode(',', $site['WD_Fax']);
		}
		echo json_encode($site['WD_Fax']);
	}

}