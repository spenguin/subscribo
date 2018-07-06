<?php

class Msubscriptions extends CI_Model {
    
    private $_table = 'subscriptions';
    
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
    }
    
    public function create( $insert )
    {
        $this->db->insert( $this->_table, $insert );
    }
    
    public function read( $where = NULL )
    {
        if( !is_null( $where ) ) $this->db->where( $where );
        $query  = $this->db->get( $this->_table );
        $o  = array();
        if( $query->num_rows() > 0 )
        {
            foreach( $query->result_array() as $row )
            {
                $o[$row['id']]  = $row;
            }
        }
        return $o;
    }
}