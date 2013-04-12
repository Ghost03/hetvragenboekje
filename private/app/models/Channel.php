<?php

class Channel extends Model {
        
    public function findOne($id = false,$key = 's.id') 
    {
        $select = $this->db->select('*')
                           ->from( array( 's' => 'channel' ), array('*') )
                           ->join( array( 'l' => 'channel_language'),'l.channel_id = s.id',array('l.name','l.summary'))
                           ->where( $key . ' = ?', $id );
        
        $q = $this->db->query($select); 
        return $q->fetch(PDO::FETCH_ASSOC); 
    }
    
    public function findByUrl($url) 
    {
        $select = $this->db->select()
                           ->from( array( 'c' => 'channel' ), array('c.background','c.thumbnail') )
                           ->join( array( 'l' => 'channel_language'),'l.channel_id = c.id',array('l.name','l.summary','l.url'))
                           ->where( 'l.url = ?', $url )
                           ->limit( 1 );        
        $q = $this->db->query($select); 
        return $q->fetch(PDO::FETCH_ASSOC); 
    }    
    
    public function findAll() 
    {
        $select = $this->db->select()
                           ->from( array( 'c' => 'channel' ), array('c.thumbnail') )
                           ->join( array( 'l' => 'channel_language'),'l.channel_id = c.id',array('l.name','l.summary','l.url'))
                           ->where('c.date_live <= ?',date('Y-m-d'))
                           ->order( 'c.position ASC' );        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }    
}