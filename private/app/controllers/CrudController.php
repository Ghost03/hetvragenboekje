<?php

abstract class CrudController extends Zend_Controller_Action {

    protected $_db;
    protected $_relation;
    protected $_primaryKey;
    protected $_primaryKeyParam;
    protected $_fields;
    protected $_orderBy;
    protected $_limit;
    protected $_fetchMode = PDO::FETCH_ASSOC;

    public function indexAction() 
    {     
        $this->_helper->redirector->gotoRouteAndExit(array('action' => 'list'));
    }
    
    public function init() {
        $this->_db = Zend_Registry::get('db');
        
        if (!$this->_relation)
            $this->_relation = strtolower(substr(get_class($this), 0, -strlen('Controller')));
        if (!$this->_primaryKey)
            $this->_primaryKey = 'id';
        if (!$this->_primaryKeyParam)
            $this->_primaryKeyParam = 'id';
        $this->_fields = '*';
    }

    protected function _getSelect($parameters = array()) {
        $fields     = isset($parameters['fields'])  ? $parameters['fields']  : $this->_fields; 
        $orderBy    = isset($parameters['orderBy']) ? $parameters['orderBy'] : $this->_orderBy; 
        $limit      = isset($parameters['limit'])   ? $parameters['limit']   : $this->_limit; 
        $relation   = isset($parameters['relation'])? $parameters['relation']: $this->_relation; 
        $where      = isset($parameters['where'])   ? $parameters['where']   : false ;   
        $joins      = isset($parameters['joins'])   ? $parameters['joins']   : false ;   
        
        $q = $this->_db->select()->from(array('i' => $relation), $fields);
        if ($orderBy)   $q->order($orderBy);
        if ($where)     $q->where($where);
        if ($joins)     foreach($joins as $relation => $on) $q->join($relation,$on);
        if ($limit)     $q->limit($limit);
        
        return $q;
    }

    protected function _list($parameters = array()) {
        $limit     = isset($parameters['limit'])     ? $parameters['limit']     : $this->_limit; 
        $fetchMode = isset($parameters['fetchMode']) ? $parameters['fetchMode'] : $this->_fetchMode;   
        return $this->_db->query($this->_getSelect($parameters))->fetchAll($fetchMode);
    }

    protected function _get($parameters = array()) {
        $primaryKeyValue = $this->_request->getParam($this->_primaryKeyParam);
        if (!$primaryKeyValue)
            throw new CrudException(404);

        $q = $this->_db->select()->from($this->_relation, $this->_fields)
                ->where("$this->_primaryKey = ?");
        
        $result = $this->_db->query($q, $primaryKeyValue)->fetch();
        if (!$result) {
            throw new CrudException(404);
        }

        return $result;
    }
    
    protected function _merge($original, $altered, $where = false) {                
        $changed = array();
        foreach ($altered as $field => $value)
            if ($original[$field] != $value)
                $changed[$field] = $value;
            
        if (!$changed)
            return false;

        if (!$where)
            $where = array("$this->_primaryKey = ?" => $original[$this->_primaryKey]);
        
        $this->_db->update($this->_relation, $changed, $where);

        return true;
    }

    protected function _add($new) {
        $this->_db->insert($this->_relation, $new);
        $new[$this->_primaryKey] =
                $this->_db->lastInsertId($this->_relation, $this->_primaryKey);

        return $new;
    }

    protected function _delete() {
        $primaryKeyValues = $this->_request->getParam($this->_primaryKeyParam);
        
        if (!$primaryKeyValues)
            throw new CrudException(404);

        $this->_db->delete($this->_relation,"$this->_primaryKey IN ($primaryKeyValues)");
    }

    protected function _filter($values = array(),$filters = false) 
    {        
        if(!$filters) {
            $filters = array();
            foreach($this->languages as $language)
                $filters[] = $language->code;
        }
        
        foreach ($filters as $filter) {
            $filtered[$filter] = isset($values[$filter]) ? $values[$filter] : array();
            unset($values[$filter]);
        }
        return array($values, $filtered);
    }

}

class CrudException extends Exception {

    public function __construct($code, $message = null) {
        parent::__construct($message, $code);
    }

}