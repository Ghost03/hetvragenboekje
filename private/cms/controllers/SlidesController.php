<?php

class SlidesController extends Cms {

    public function listAction() 
    {
        $q = $this->_db->prepare('SELECT * FROM slides');
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

        $form = $this->view->form = new SlidesForm($this->_getParam('id',false));
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
    
    public function deleteAction() {
        
        $q_delete = $this->_db->prepare('DELETE FROM clubs WHERE id = :id');
        $q_delete->bindValue(':id',$this->_getParam('id'));
        $q_delete->execute();
              
        $this->_delete();
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
    }

}