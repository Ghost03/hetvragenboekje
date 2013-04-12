<?php

class DashboardController extends Cms
{
    public function homeAction()
    {
        $this->_helper->layout()->title = 'Welkom !';
    }
    
    public function benchAction()
    {        
        if($this->_getParam('status',0) == 1)
            $_SESSION['benchmark'] = 1;    
        else
            unset($_SESSION['benchmark']);
        
        $this->_helper->getHelper('Redirector')->goToRouteAndExit(array('action'=>'home'));  
    }
    
    public function cacheAction()
    {
        if(class_exists('Memcache')) {
            try {
                define('MEMCACHED_HOST', '127.0.0.1');
                define('MEMCACHED_PORT', '11211');
                $memcache = new Memcache;
                if($memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT))
                    $memcache->flush();
            } catch(Exception $e) { }
        }
        
        $cache = Zend_Registry::get('cache-infinite');
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('content'));
        
        $cache = Zend_Registry::get('cache');
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG,array('content'));
        
        $this->_helper->getHelper('Redirector')->goToRouteAndExit(array('action'=>'home'));  
    }
    
    public function pingAction()
    {
        $_SESSION['ping'] = isset($_SESSION['ping']) ? $_SESSION['ping'] + 1 : 1;
        
        switch($_SESSION['ping']) {
            case 1: echo 'Never gonna give you up'; break;
            case 2: echo 'Never gonna let you down'; break;
            case 3: echo 'Never gonna run around and desert you'; break;
            case 4: echo 'Never gonna make you cry'; break;
            case 5: echo 'Never gonna say goodbye'; break;
            case 6: echo 'Never gonna tell a lie and hurt you'; break;
        }
        if($_SESSION['ping'] == 6) $_SESSION['ping'] = 0;
        exit;
    }

    public function profilingAction() {
        if ($this->_getParam('status', 0) == 1)
            $_SESSION['profiling'] = 1;
        else
            unset($_SESSION['profiling']);

        $this->_redirect($_SERVER['HTTP_REFERER']);
    }

    public function backupAction() {

        $q = $this->_db->prepare('SHOW TABLE STATUS');
        $q->execute();
        $tables = $q->fetchAll(PDO::FETCH_ASSOC);
        
        $sql = '';
        
        foreach($tables as $table) {
                        
            $q = $this->_db->prepare('SHOW CREATE TABLE `' . $table['Name'] . '`');
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            
            $sql .=  $data['Create Table'] . ";\r\n\r\n";
            
            $q = $this->_db->prepare('SELECT * FROM `' . $table['Name'] . '`');
            $q->execute();
            $records = $q->fetchAll(PDO::FETCH_ASSOC);
            
            $insert = ''; 
            foreach($records as $record) {
                
                foreach($record as $var => $value)
                    $record[$var] = str_replace("'","\'",$value);
                
                $insert .= "INSERT INTO `" . $table['Name'] . "` (`" . implode('`,`',array_keys($record)) . "`) VALUES ('" . implode("','",array_values($record)) . "')";
                $insert .= ";\r\n";
            }
            
            $sql .= $insert . "\r\n";
        }
        
        $handle = fopen(APP_PATH.'../backup/' . date('Y-m-d H:i:s') . '.sql','w');
        fwrite($handle,$sql);
        fclose($handle);
        
        $this->_helper->getHelper('Redirector')->goToRouteAndExit(array('action' => 'home'));
    }
}