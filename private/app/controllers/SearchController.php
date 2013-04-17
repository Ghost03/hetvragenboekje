<?php

class SearchController extends AppController {

	public function getresultsAction()
    {   
		if (!isset($_GET['from'])) exit;
		if (!isset($_GET['to'])) exit;

		$db = Zend_Registry::get('db');

        $from = (int) $_GET['from'];
		$to = (int) $_GET['to'];
        $s = $_GET['s'];
		$diff = $from - $to;

		$q = $db->prepare('SELECT * FROM questions WHERE name LIKE :search LIMIT :start,:end');
        $q->bindValue(':search', '%' . $s . '%', PDO::PARAM_STR);
        $q->bindValue(':start', $from, PDO::PARAM_INT);
        $q->bindValue(':end', $to, PDO::PARAM_INT);
        $q->execute();
        $questions = $q->fetchAll(PDO::FETCH_ASSOC);

		$arr = array();

		foreach($questions as $k => $question):
			$arr[$k]['name'] = $question['name'];
            $arr[$k]['url'] = sanitize($question['name']);
        endforeach;

        header( "Content-type: text/json" );
        
		echo Zend_Json::encode($arr);	
        exit;
    }

    public function resultsAction()
    {   
    	// Includes
    	$db = Zend_Registry::get('db');    	
    	
        if(!empty( $_POST['s'] )):
    	
            $search = trim($_POST['s']);

        	$results = $db->fetchAll('SELECT * FROM questions WHERE name LIKE ? LIMIT 10', '%' . $search . '%');

        	// Views
        	$this->view->search = $search;
        	$this->view->results = $results;

        endif;

    }
    
}

?>
