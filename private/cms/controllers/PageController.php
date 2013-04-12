<?php

class PageController extends Cms {

    public function listAction() 
    {
        while($_POST) {
            $ids = explode(',',$_POST['ids']);
            $i = 1;
            $db = Zend_Registry::get('db');
            $q = $db->prepare('UPDATE page SET position = :position WHERE id = :id LIMIT 1');
            foreach ($ids as $id) {
                $q->bindValue(':id', $id);
                $q->bindValue(':position', $i);
                $q->execute();
                $i++;
            }
            echo 'OK';
            exit;
        }
        
        $q = $this->_db->prepare('SELECT c.*, cl.name, cl.url 
                                  FROM page c 
                                  LEFT JOIN page_language cl ON cl.page_id = c.id 
                                  WHERE cl.language_id = :language_id
                                  ORDER BY c.page_id IS NULL ASC, c.page_id ASC, c.position ASC');
        $q->bindValue(':language_id',$this->language);
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

        $form = $this->view->form = new pageForm($this->_getParam('id',false));
        $this->view->edit = $edit = $this->_request->getActionName() == 'edit';
        $page = $languages = array();

        if ($edit) {
            $page = $this->_get();

            $languages = index_by_full($this->_list(array(
                'fields'     => array('language_id','*','(SELECT l.code FROM language l WHERE l.id = language_id) AS language_code'),
                'relation'   => 'page_language',
                'where'      => "page_id = {$page['id']}",
                'fetchMode'  => PDO::FETCH_ASSOC
            )),'language_code');
        }
        
        while ($_POST) {

            if (!$form->isValid($_POST)) break;

            list($data,$languages) = $this->_filter($form->getValues());

            if ($edit)
                $this->_merge($page, $data);
            else
                $page = $this->_add($data);
            
            $q_delete = $this->_db->prepare('DELETE FROM page_language WHERE page_id = :page_id');
            $q_delete->bindValue(':page_id',$page['id']);
            $q_delete->execute();
            
            $this->_relation = 'page_language';
            foreach($languages as $code => $data) {
                $data['language_id'] = $this->getLanguageId($code);
                $data['page_id'] = $page['id'];
                $data['url'] = sanitize($data['name']); // url
                
                $this->_primaryKey = "language_id = '{$data['language_id']}' AND page_id = {$page['id']}";

                $this->_add($data);
            }

            $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        }

        if (!$_POST)
            $form->populate(array_merge($page, $languages));
    }

    public function deleteAction() {    
        $q_delete = $this->_db->prepare('DELETE FROM page_language WHERE page_id = :page_id');
        $q_delete->bindValue(':page_id',$this->_getParam('id'));
        $q_delete->execute();
        
        $this->_delete();
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        
    }

}