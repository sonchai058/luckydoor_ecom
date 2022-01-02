<?php
	class Statistic_view_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

	    public function getOnceWebMain() {
	        if (!isset($_SESSION['visited'])) {
				$visit_data = array(
					'S_IP' 			=> $this->admin_model->kh_getUserIP(),
					'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
					'S_Type' 		=> '1',
					'ID' 			=> 0,
				);
				$this->common_model->insert('statistics', $visit_data);
				set_session('visited', 'visited');
			}
	    }

	    public function getBackLogMain() {
	        if (!isset($_SESSION['backlog']) && get_session('M_ID') != '') {
				$visit_data = array(
					'S_IP' 			=> $this->admin_model->kh_getUserIP(),
					'S_UserAgent' 	=> $this->admin_model->get_http_user_agent(),
					'S_Type' 		=> '2',
					'ID' 			=> get_session('M_ID'),
				);
				$this->common_model->insert('statistics', $visit_data);
				set_session('backlog', 'backlog');
			}
	    }

	}
?>