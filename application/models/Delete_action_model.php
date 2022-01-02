<?php
	class Delete_action_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function del_action($table, $userUpdate, $datetimeUpdate, $fieldAllow, $fieldID) {
    		      if (uri_seg(1) !== ''       && uri_seg(2) !== '' && uri_seg(3) !== '' && uri_seg(4) === 'del' && uri_seg(5) !== '')
                $this->row_delete($table, uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), uri_seg(5), $userUpdate, $datetimeUpdate, $fieldAllow, $fieldID);

            else  if (uri_seg(4) === 'del'    && uri_seg(5) === '')
                redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
    	}

        public function del_custom($table, $userUpdate, $datetimeUpdate, $fieldAllow, $fieldID) {
                  if (uri_seg(1) !== '' && uri_seg(2) !== '' && uri_seg(3) === 'del' && uri_seg(4) !== '')
                $this->row_delete($table, uri_seg(1).'/'.uri_seg(2), uri_seg(4), $userUpdate, $datetimeUpdate, $fieldAllow, $fieldID);

            else  if (uri_seg(3) === 'del'    && uri_seg(4) === '')
                redirect(uri_seg(1).'/'.uri_seg(2), 'refresh');
        }

    	public function row_delete($table, $href, $fieldKey, $userUpdate, $datetimeUpdate, $fieldAllow, $fieldCondition) {
    		$this->common_model->update(
                $table,
                array(
                    $fieldAllow     => '3',
                    $userUpdate     => get_session('M_ID'),
                    $datetimeUpdate => date('Y-m-d H:i:s')
                ),
                array($fieldCondition => $fieldKey)
            );
            header('Location: '.base_url($href));
            exit();
    	}

    }
?>


