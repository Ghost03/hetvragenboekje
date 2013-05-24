<?php

class SearchController extends AppController {

	public function getresultsAction()
    {   
        // Get 10 more search results for questions
        
		if (!isset($_GET['from'])) exit;
		if (!isset($_GET['to'])) exit;

		$db = Zend_Registry::get('db');

        $from = (int) $_GET['from'];
		$to = (int) $_GET['to'];
        $s = $_GET['s'];
		$total = (int) 10;

		$q = $db->prepare('SELECT * FROM questions WHERE name LIKE :search ORDER BY date_created LIMIT :start, :total');
        $q->bindValue(':search', '%' . $s . '%', PDO::PARAM_STR);
        $q->bindValue(':start', $from, PDO::PARAM_INT);
        $q->bindValue(':total', $total, PDO::PARAM_INT);
        $q->execute();
        $questions = $q->fetchAll(PDO::FETCH_ASSOC);

		$arr = array();

		foreach($questions as $k => $question):
            
            $q = $db->prepare('SELECT * categories WHERE id = :id');
            $q->bindValue(':id', $question['category_id']);
            $category = $q->fetch(PDO::FETCH_ASSOC);

            $arr[$k]['category'] = $category['name'];
            $arr[$k]['category-url'] = $category['url'];
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
            $sbind = '%' . $search . '%';

        	$results = $db->fetchAll('SELECT * FROM questions WHERE name LIKE ? ORDER BY date_created LIMIT 10', '%' . $search . '%');
            $q = $db->prepare('SELECT * FROM questions WHERE name LIKE :search');
            $q->bindValue(":search", $sbind, PDO::PARAM_STR);
            $q->execute();
            $total = $q->rowCount();

        	// Views
        	$this->view->search = $search;
        	$this->view->results = $results;
            $this->view->total = $total;

        endif;

    }
    
}

?>
