<?php
	class Viewer_action_model extends CI_Model {

        function __construct() {
            parent::__construct();
        }

        public function vie_action($table, $fieldKey, $fieldAllow, $content_view, $title, $titles) {
            if (uri_seg(5) != '') {
                        if (uri_seg(1)  !== ''      && uri_seg(2) !== ''        && uri_seg(3) !== '' && uri_seg(4) === 'view'   && uri_seg(5) !== '')
                    $this->row_viewer($table, $fieldKey, uri_seg(5), $fieldAllow, $content_view, $title, $titles);

                else    if (uri_seg(1)  !== ''      && uri_seg(2) !== ''        && uri_seg(3) !== '' && uri_seg(4) === 'print'  && uri_seg(5) !== '')
                    $this->row_prints($table, $fieldKey, uri_seg(5), $fieldAllow, $content_view, $title, $titles);

                else    if ((uri_seg(4) === 'view'  || uri_seg(4) === 'print')  && uri_seg(5) === '')
                    redirect(uri_seg(1).'/'.uri_seg(2).'/'.uri_seg(3), 'refresh');
            }
    	}

    	public function row_viewer($table, $fieldKey, $fieldID, $fieldAllow, $content_view, $title, $titles) {
    		$data = array(
                'content_view'  => $content_view,
                'title'         => $title,
                'titles'        => $titles,
                'table'         => $table,
                'field_key'     => $fieldKey,
                'field_id'      => $fieldID,
                'field_allow'   => $fieldAllow,
            );
            $this->template->load('index_page', $data);
    	}

        public function row_prints($table, $fieldKey, $fieldID, $fieldAllow, $content_view, $title, $titles) {
            $data = array(
                'content_view'  => $content_view,
                'title'         => $title,
                'titles'        => $titles,
                'table'         => $table,
                'field_key'     => $fieldKey,
                'field_id'      => $fieldID,
                'field_allow'   => $fieldAllow,
            );
            $pdfFilePath = $title.'.pdf';
            $html = $this->load->view($content_view, $data, true);
            include_once APPPATH.'/third_party/mpdf/mpdf.php';
            $pdf = new mPDF('tha', 'A4', '14');
            $pdf->autoScriptToLang = true;
            $pdf->autoLangToFont = true;
            $pdf->SetDisplayMode('fullpage');
            $pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822));
            $pdf->WriteHTML(file_get_contents(base_url('assets/admin/css/print.css')), 1);
            $pdf->WriteHTML($html, 2);
            $pdf->Output($pdfFilePath, 'I');
        }

    }
?>