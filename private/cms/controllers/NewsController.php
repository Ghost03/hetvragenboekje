<?php

class NewsController extends Cms {

    public function listAction() 
    {
        $q = $this->_db->prepare('SELECT * FROM news');
        $q->execute();
        
        $this->view->items = $q->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function addAction() 
    {
        $this->editAction();

        $this->_helper->viewRenderer->setRender('edit');
    }

    public function editAction() {

        $this->_helper->layout()->noBox = true;

        $form = $this->view->form = new NewsForm($this->_getParam('id',false));
        $this->view->edit = $edit = $this->_request->getActionName() == 'edit';
        $news = $languages = array();
        
        if ($edit) {
            $news = $this->_get();
        }
        
        while ($_POST) {

            if (!$form->isValid($_POST)) break;
            
            $data['url'] = sanitize($data['title']);
            
            list($data) = $this->_filter($form->getValues());

            if ($edit)
                $this->_merge($news, $data);
            else {
                //$data['date_created'] = date('Y-m-d');
                $news = $this->_add($data);
            }

            $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        }

        if (!$_POST) {
            $form->populate(array_merge($news, $languages));
        }
    }

    public function activeAction() 
    {
        $db = Zend_Registry::get('db');
        
        $id = $this->_getParam('id',false);
        
        $check_active = $db->select()->from('news', array('id', 'active'))->where('id = '. $id .'');
        $stmt = $db->query($check_active);
        $check_active_result = $stmt->fetchAll();
        
        if($check_active_result[0]['active'] == 1)
        {
            $db->query("UPDATE  `news` SET  `active` =  '0' WHERE  `id` = $id;");   
        }
        else
        {
            $db->query("UPDATE  `news` SET  `active` =  '1' WHERE  `id` = $id;");
        }
        
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
    }
    
    public function deleteAction() {
        
        $q_delete = $this->_db->prepare('DELETE FROM news WHERE id = :id');
        $q_delete->bindValue(':id',$this->_getParam('id'));
        $q_delete->execute();
              
        $this->_delete();
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
    }

}