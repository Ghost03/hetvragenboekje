<?php

class SidebarController extends Cms {

    public function listAction() 
    {
        while($_POST) {
            $ids = explode(',',$_POST['ids']);
            $i = 1;
            $db = Zend_Registry::get('db');
            $q = $db->prepare('UPDATE sidebar SET position = :position WHERE id = :id LIMIT 1');
            foreach ($ids as $id) {
                $q->bindValue(':id', $id);
                $q->bindValue(':position', $i);
                $q->execute();
                $i++;
            }
            echo 'OK';
            exit;
        }
        
        $q = $this->_db->prepare('SELECT c.*, cl.title, cl.content 
                                  FROM sidebar c 
                                  LEFT JOIN sidebar_language cl ON cl.sidebar_id = c.id 
                                  WHERE cl.language_id = :language_id
                                  ORDER BY c.sidebar_id IS NULL ASC, c.sidebar_id ASC, c.position ASC');
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

        $form = $this->view->form = new sidebarForm($this->_getParam('id',false));
        $this->view->edit = $edit = $this->_request->getActionName() == 'edit';
        $sidebar = $languages = array();

        if ($edit) {
            $sidebar = $this->_get();

            $languages = index_by_full($this->_list(array(
                'fields'     => array('language_id','*','(SELECT l.code FROM language l WHERE l.id = language_id) AS language_code'),
                'relation'   => 'sidebar_language',
                'where'      => "sidebar_id = {$sidebar['id']}",
                'fetchMode'  => PDO::FETCH_ASSOC
            )),'language_code');
        }
        
        while ($_POST) {

            if (!$form->isValid($_POST)) break;

            list($data,$languages) = $this->_filter($form->getValues());

            if ($edit)
                $this->_merge($sidebar, $data);
            else
                $sidebar = $this->_add($data);
            
            $q_delete = $this->_db->prepare('DELETE FROM sidebar_language WHERE sidebar_id = :sidebar_id');
            $q_delete->bindValue(':sidebar_id',$sidebar['id']);
            $q_delete->execute();
            
            $this->_relation = 'sidebar_language';
            foreach($languages as $code => $data) {
                $data['language_id'] = $this->getLanguageId($code);
                $data['sidebar_id'] = $sidebar['id'];
                
                $this->_primaryKey = "language_id = '{$data['language_id']}' AND sidebar_id = {$sidebar['id']}";

                $this->_add($data);
            }

            $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        }

        if (!$_POST)
            $form->populate(array_merge($sidebar, $languages));
    }

    public function deleteAction() {    
        $q_delete = $this->_db->prepare('DELETE FROM sidebar_language WHERE sidebar_id = :sidebar_id');
        $q_delete->bindValue(':sidebar_id',$this->_getParam('id'));
        $q_delete->execute();
        
        $this->_delete();
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        
    }

}