<?php

class Mpublishers extends CI_Model {
    
    private $_table = 'publishers';
    
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
    }
    
    public function create( $insert )
    {
        $this->db->insert( $this->_table, $insert );
    }
}