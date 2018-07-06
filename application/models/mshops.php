<?php

class Mshops extends CI_Model {
    
    private $_table = 'posts';
    
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
    }
    
    public function create( $insert = NULL )
    {
        if( !isset( $insert['url_title'] ) ) $insert['url_title']   = url_title( strtolower( $insert['title'] ), 'underscore' );
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
    
    public function find( $str = NULL )
    {
        if( is_null( $str ) ) return NULL;
        
        return NULL;
    }
    
    public function readByTitle( $title )
    {
        $this->db->where( 'title', $title );
        $query  = $this->db->get( $this->_table );
        $o      = array();
        if( $query->num_rows() > 0 )
        {
            return $query->row_array();
        }
        return $o;
        
    }
/**
 *  Bespoke functions
 */
    public function joinInsert( $insert )
    {
        $this->db->insert( 'j_post_tag', $insert );
    }
    
    
    public function readByTagId( $tagId )
    {
        $query  = $this->db->join( 'j_post_tag', 'j_post_tag.postId = posts.id'  )->where( 'j_post_tag.tagId', $tagId )->order_by( 'posts.title', 'ASC' )->get( $this->_table );
        $o      = array();
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