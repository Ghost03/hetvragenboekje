<?php

class Episode extends Model {
      
    public function addView($id) 
    {
        $q = $this->db->prepare('UPDATE episode SET views = views + 1 WHERE id = :id LIMIT 1');
        $q->bindValue(':id',$id);
        $q->execute();
    }
    
    public function findOne($id = false,$key = 's.id') 
    {
        $select = $this->db->select('*')
                           ->from( array( 's' => 'episode' ) )
                           ->join( array( 'l' => 'episode_language'),'l.episode_id = s.id')
                           ->where( $key . ' = ?', $id );
        
        $q = $this->db->query($select); 
        return $q->fetch(PDO::FETCH_ASSOC); 
    }
    
    public function findByUrl($url) 
    {
        $select = $this->db->select()
                           ->from( array( 'e' => 'episode' ), array('e.image','e.thumb','e.followup') )
                           ->join( array( 'l' => 'episode_language'),'l.episode_id = e.id',array('l.id','l.name AS subtitle','l.summary','l.url'))
                           ->where( 'l.url = ?', $url )
                           ->limit( 1 );
        
        $q = $this->db->query($select); 
        return $q->fetch(PDO::FETCH_ASSOC); 
    }
    
    public function findAll($orderBy = 'e.id DESC',$limit = 16) 
    {
        $select = $this->db->select()
                           ->from( array( 'e' => 'episode' ), array('e.image','e.thumb','e.followup') )
                           ->join( array( 'l' => 'episode_language'),'l.episode_id = e.id',array('l.id','l.name AS subtitle','l.summary','l.url'))
                           ->join( array( 's' => 'show'),'e.show_id = s.id',array())
                           ->join( array( 'sl' => 'show_language'),'sl.show_id = s.id',array('sl.name AS title','sl.url AS show'))
                           ->order( $orderBy )
                           ->limit($limit);
        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function findByShow($show_id,$orderBy = 'e.id DESC') 
    {
        $select = $this->db->select()
                           ->from( array( 'e' => 'episode' ), array('e.image','e.thumb','e.followup') )
                           ->join( array( 'l' => 'episode_language'),'l.episode_id = e.id',array('l.id','l.name AS subtitle','l.summary','l.url'))
                           ->where( 'e.show_id = ?', $show_id )
                           ->order( $orderBy );
        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function findByDate($date,$orderBy = 'e.date_live DESC') 
    {
        $select = $this->db->select()
                           ->from( array( 'e' => 'episode' ), array('e.date_live','e.thumb') )
                           ->join( array( 'l' => 'episode_language'),'l.episode_id = e.id',array('l.id','l.name AS subtitle','l.summary','l.url'))
                           ->join( array( 's' => 'show'),'e.show_id = s.id',array())
                           ->join( array( 'sl' => 'show_language'),'sl.show_id = s.id',array('sl.name AS title','sl.url AS show'))
                           ->where( 'e.date_live LIKE ?', $date . '%' )
                           ->order( $orderBy );
        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function findReplies($episode_id) 
    {
        $select = $this->db->select()
                           ->from( array( 'e' => 'episode_reply' ), array('*') )
                           ->where( 'e.episode_id = ?', $episode_id )
                           ->order( 'e.date_created DESC' );
        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }
        
    public function search($q) 
    {
        $q = "%$q%";
        $select = $this->db->select()
                           ->from( array( 'e' => 'episode' ), array('e.id','e.thumb') )
                           ->join( array( 'el' => 'episode_language'),'el.episode_id = e.id', array('el.name AS h2','el.summary'))
                           ->join( array( 's' => 'show'),'e.show_id = s.id',array())
                           ->join( array( 'sl' => 'show_language'),'sl.show_id = s.id',array('sl.name AS h3'))
                           ->where( 'el.name LIKE ?', $q );
        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }
    
}