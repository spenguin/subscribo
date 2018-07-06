<?php

class Manswers extends CI_Model {
    
    private $_table = 'answers';
    
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
    }
    
    public function read( $collection, $entry )
    {
        $query  = $this->db->where( 'collection', $collection )->where( 'entry', $entry )->get( $this->_table ); 
        if( $query->num_rows() > 0 )
        {
            $_res   = $query->row_array();
            return $_res['answer'];
        }
        return NULL;
        
    }
}