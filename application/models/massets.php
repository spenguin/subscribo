<?php

class Massets extends CI_Model {
    
    private $_table = 'assets';
    
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
    
    public function update()
    {
        
    }
    
    public function delete( $id = NULL )
    {
        if( is_null( $id ) ) return NULL;
        
    }
    
    /*
     *  Reads all children of provided parent id
     *  @param int $parentId
     *  @param bool Recursive - FALSE: finds only immediate children; TRUE: finds all children
     *  @returns nested array of child tags
     */
    public function readByParent( $parentId, $recursive = FALSE )
    {
        $o      = array();
        if( $recursive )
        {
            $query  = $this->db->where( 'parentId', $parentId )->get( $this->_table );   // Get the direct children rows
            
            if( $query->num_rows() > 0 )
            {
                foreach( $query->result_array() as $row )
                {
                    $row['children']    = $this->readByParent( $row['id'], TRUE );
                    $o[$row['id']]      = $row;
                }
            }
        }
        else
        {
            $query  = $this->db->where( 'parentId', $parentId )->get( $this->_table );
            $o      = array();
            if( $query->num_rows() > 0 )
            {
                foreach( $query->result_array() as $row )
                {
                    $o[]    = $row;
                }
            }
        } 
        return $o;
    }
}