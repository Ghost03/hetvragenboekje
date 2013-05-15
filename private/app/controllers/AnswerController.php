<?php

class AnswerController extends CrudController {

    public function preDispatch() 
    {   
        parent::preDispatch();

        $this->_relation = 'thumbsup';
    }

    public function thumbsupAction()
    {
       // Get question id, answer id and user id

       if (!isset($_GET['q'])) exit;
       if (!isset($_GET['a'])) exit;
       if (!isset($_GET['u'])) exit;

       // Includes
       $db = Zend_Registry::get('db');
     	
       $answer_id = $_GET['a'];
       $question_id = $_GET['q'];
       $user_id = $_GET['u'];

       $user = $db->fetchRow('SELECT * FROM users WHERE id = ?', $user_id);

       if (!isset($_SESSION['user']) || $_SESSION['user'] != $user['name']) exit;

       $q = $db->prepare('INSERT INTO thumbs (user_id, answer_id, question_id) VALUES (:user_id, :answer_id, :question_id)');
       $q->bindValue(':user_id', $user_id, PDO::PARAM_INT);
       $q->bindValue(':answer_id', $answer_id, PDO::PARAM_INT);
       $q->bindValue(':question_id', $question_id, PDO::PARAM_INT);
       $q->execute();
    }
    
}
?>
