<?php

class PageController extends AppController {

    public function homeAction()
    {   
        // Includes
        $db = Zend_Registry::get('db');
        /*require_once('dompdf/dompdf_config.inc.php');
        
        $pdf = new dompdf();
        $pdf->set_paper('a4', 'portrait');
        $pdf->load_html("<html><head></head><body><p>test</p></body></html>");*/

        
        // Queries
        $questions = $db->fetchAll('SELECT * FROM questions ORDER BY date_created DESC LIMIT 5');

        // Views
        $this->view->questions = $questions;
        //$this->view->pdf = $pdf;
    }
    
}

?>
