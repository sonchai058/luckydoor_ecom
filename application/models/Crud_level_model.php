<?php
	class Crud_level_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function crudStateEnabled($c, $r, $u, $d, $e, $p) {
            if (uri_seg(4)) {
                $states = array('unknown', 'list', 'add', 'edit', 'insert', 'update', 'ajax_list', 'ajax_list_info', 'insert_validation', 'update_validation', 'upload_file', 'ajax_relation', 'ajax_relation_n_n', 'success', 'export', 'print', 'view', 'del');
                if (in_array(uri_seg(4), $states)) {
                    if (uri_seg(4) === 'add' || uri_seg(4) === 'view' || uri_seg(4) === 'edit' || uri_seg(4) === 'del' || uri_seg(4) === 'export' || uri_seg(4) === 'print') {
                        if (uri_seg(4) === 'add'    && $c === false) redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
                        if (uri_seg(4) === 'view'   && $r === false) redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
                        if (uri_seg(4) === 'edit'   && $u === false) redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
                        if (uri_seg(4) === 'del'    && $d === false) redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
                        if (uri_seg(4) === 'export' && $e === false) redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
                        if (uri_seg(4) === 'print'  && $p === false) redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
                    }
                }
                else redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
            }
        }

    }
?>


