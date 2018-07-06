<?php

class Mtags extends CI_Model {
    
    private $_table = 'tags';
    
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
    }
    
    public function create( $insert = array() )
    {
        if( !isset( $insert['name'] ) ) return NULL;
        if( !isset( $insert['slug'] ) ) $insert['slug'] = url_title( $insert['name'], '_', TRUE );
        $this->db->insert( $this->_table, $insert );
        return $this->db->insert_id();
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
    
    /*
     *  Reads all children of provided parent id
     *  @param string $slug
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
    
    private function get_children( $parentId, $array )
    {
        $o  = array();
        if( isset( $array[$parentId] ) )
        {
            foreach( $array[$parentId] as $set )
            {
                $set['children']    = $this->get_children( $set['id'], $array );
                $o[$parentId][] = $set;
            }
        }
        return $o;
    }
}