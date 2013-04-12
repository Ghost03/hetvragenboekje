<?php

class HomepageController extends Cms {

    public function listAction() 
    {   
        $this->editAction();
        $this->_helper->viewRenderer->setRender('edit');
        
    }

    public function editAction() {

        $this->_helper->layout()->noBox = true;

        $form = $this->view->form = new homepageForm;
        $this->view->edit = $edit = $this->_request->getActionName() == 'list';
        $homepage = $languages = array();
        
        
        if ($edit) {
            $languages = index_by_full($this->_list(array(
                'fields'     => array('language_id','*','(SELECT l.code FROM language l WHERE l.id = language_id) AS language_code'),
                'relation'   => 'homepage_language',
                'where'      => "homepage_id = 1",
                'fetchMode'  => PDO::FETCH_ASSOC
            )),'language_code');
            
            
            $db = Zend_Registry::get('db');
            $homepage = $db->select()
                    ->from( 'homepage' )
                    ->where( 'id = 1' );
            
            $stmt = $db->query($homepage);
            $homepage = $stmt->fetch();
            
        }
        
        while ($_POST) {

            if (!$form->isValid($_POST)) break;

            list($data,$languages) = $this->_filter($form->getValues());

            if ($edit)
                $this->_merge($homepage, $data);
            else {
                $data['date_created'] = date('Y-m-d H:i:s');
                $homepage = $this->_add($data);
            }
            
            $this->_relation = 'homepage_language';
            foreach($languages as $code => $data) {
                $data['language_id'] = $this->getLanguageId($code);
                $data['homepage_id'] = 1;
                
                $this->_primaryKey = "language_id = '{$data['language_id']}' AND homepage_id = 1";

                if ($edit)
                    $this->_merge($languages[$id], $data, $this->_primaryKey);
                else
                    $this->_add($data);
            }

            $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        }

        if (!$_POST)
            $form->populate(array_merge($homepage, $languages));
    }

}