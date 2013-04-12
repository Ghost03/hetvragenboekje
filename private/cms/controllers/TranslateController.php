<?php

class TranslateController extends Cms {

    public function listAction() 
    {   
        $this->editAction();
        $this->_helper->viewRenderer->setRender('edit');
        
    }

    public function editAction() {

        $this->_helper->layout()->noBox = true;

        $form = $this->view->form = new TranslateForm;
        $this->view->edit = $edit = $this->_request->getActionName() == 'list';
        $translate = $languages = array();
        
        
        if ($edit) {
            $languages = index_by_full($this->_list(array(
                'fields'     => array('language_id','*','(SELECT l.code FROM language l WHERE l.id = language_id) AS language_code'),
                'relation'   => 'translate_language',
                'where'      => "translate_id = 1",
                'fetchMode'  => PDO::FETCH_ASSOC
            )),'language_code');
            
            
            $db = Zend_Registry::get('db');
            $translate = $db->select()
                    ->from( 'translate' )
                    ->where( 'id = 1' );
            
            $stmt = $db->query($translate);
            $translate = $stmt->fetch();
            
        }
        
        while ($_POST) {

            if (!$form->isValid($_POST)) break;

            list($data,$languages) = $this->_filter($form->getValues());

            if ($edit)
                $this->_merge($translate, $data);
            else {
                $data['date_created'] = date('Y-m-d H:i:s');
                $translate = $this->_add($data);
            }
            
            $this->_relation = 'translate_language';
            foreach($languages as $code => $data) {
                $data['language_id'] = $this->getLanguageId($code);
                $data['translate_id'] = 1;
                
                $this->_primaryKey = "language_id = '{$data['language_id']}' AND translate_id = 1";

                if ($edit)
                    $this->_merge($languages[$id], $data, $this->_primaryKey);
                else
                    $this->_add($data);
            }

            $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list', 'id' => null));
        }

        if (!$_POST)
            $form->populate(array_merge($translate, $languages));
    }

}