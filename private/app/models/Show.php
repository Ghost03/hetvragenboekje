<?php

class Show extends Model {
      
    public function addView($id) 
    {
        $q = $this->db->prepare('UPDATE `show` SET views = views + 1 WHERE id = :id LIMIT 1');
        $q->bindValue(':id',$id);
        $q->execute();
    }
     
    public function findButtons($id)
    {
        $q = $this->db->prepare('SELECT title AS text,href,\'_blank\' AS target, \'\' AS rel FROM show_button 
                                 WHERE show_id = :id 
                                 AND title != \'\'
                                 ORDER BY position ASC LIMIT 4');
        $q->bindValue(':id',$id);
        $q->execute();
        
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }        
    
    public function findOne($id = false,$key = 'id') 
    {
        $select = $this->db->select('*')
                           ->from( array( 's' => 'show' ) )
                           ->join( array( 'l' => 'show_language'),'l.show_id = s.id')
                           ->where( $key . ' = ?', $id );
        
        $q = $this->db->query($select); 
        return $q->fetch(PDO::FETCH_ASSOC); 
    }
        
    public function search($q) 
    {
        $q = "%$q%";
        $select = $this->db->select('*')
                           ->from( array( 's' => 'show' ) )
                           ->join( array( 'l' => 'show_language'),'l.show_id = s.id')
                           ->where( 'l.name LIKE ?', $q );
        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    public function findAll($orderBy = 's.id DESC') 
    {
        $select = $this->db->select()
                           ->from( array( 's' => 'show' ) )
                           ->join( array( 'l' => 'show_language'),'l.show_id = s.id')
                           ->order( $orderBy );
        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    public function findByChannel($channel_id,$orderBy = 's.id DESC') 
    {
        $select = $this->db->select()
                           ->from( array( 's' => 'show' ) )
                           ->join( array( 'l' => 'show_language'),'l.show_id = s.id')
                           ->join( array( 'c' => 'show_has_channel'),'c.show_id = s.id')
                           ->where( 'c.channel_id = ?', $channel_id )
                           ->order( $orderBy );
        
        $q = $this->db->query($select); 
        return $q->fetchAll(PDO::FETCH_ASSOC); 
    }
    
}