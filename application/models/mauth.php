<?php

class Mauth extends CI_Model {
    
    private $_table = 'users';
    
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
    }
    
    public function create( $insert = array() )
    {
        $errors = array();
        if( !array_key_exists( 'name', $insert ) ) $errors[]    = 'Name is required';
        if( !array_key_exists( 'email', $insert ) ) $errors[]   = 'Email is required';
        if( !array_key_exists( 'userTypeId', $insert ) ) $errors[]  = 'User Type Id is required';
        
        if( count( $errors ) > 0 ) return $errors;
        
        if( !isset( $insert['username'] ) || is_null( $insert['username'] ) )
        {   
            $insert['username'] = $this->create_username( $insert['name'] );
        }
        $this->load->library( 'encryption' );
        
        $insert['nonce']    = do_hash( time() );
        $insert['pwhash']   = $this->encryption->encrypt( $insert['password'] );
        unset( $insert['password'] );
        $this->db->insert( $this->_table, $insert );
        return $this->db->insert_id();
    }
    
    public function read( $where=NULL )
    {
        if( !is_null( $where   ) ) $this->db->where( $where );
        $query  = $this->db->get( $this->_table );
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
    
    public function update( $userId, $update )
    {
        $this->db->where( 'id', $userId )->update( $this->_table, $update );
    }
    
    
    
    public function create_username( $name )
    {   
        $name	= preg_replace( '/[^a-zA-Z ]/', '', $name );
		$name	= explode( ' ', strtolower( $name ) );
        $username_pre   = substr( $name[0], 0, 1 ) . $name[count( $name ) - 1];
        $index  = '';
        while( TRUE )
        {
            $username   = $username_pre . $index; 
            $query  = $this->db->select( 'username' )->where( 'username', $username )->get( $this->_table );
            if( $query->num_rows() == 0 ) return $username;
            $index++;
        }
    }
    
    /**
     *  Validate the user. If TRUE, add user data  Session variables
     *  @return TRUE or FALSE
     */
	function validate()
	{	
		$this->load->library( 'encryption' );
        $this->db->where( 'username', $this->input->post( 'username' ) ); 
		$query	= $this->db->get( $this->_table );
		if( $query->num_rows() > 0 )
		{	
			foreach( $query->result_array()  as $row )
			{	
				if( $this->input->post('password') == $this->encryption->decrypt( $row['pwhash'] ) )
                {	
					$this->session->set_userdata(array(
								'id'		=> $row['id'],
								'name'		=> $row['name'],
//								'lastlogin'	=> $row['lastLogin'],
								'userTypeId'=> $row['userTypeId'],
								'status'	=> $row['status']
					));
/*					$this->db->where( 'id', $row['id']);
					$this->db->update( self::DataTable, array(
											'lastLogin'	=> $row['thisLogin'],
											'thisLogin'	=> time()
					));*/
					return TRUE;
				}
			}
		}
		return FALSE;
	}
    
    /**
     *  Get the user information based on the provided string
     *  @params: array of field/value pairs; connector for where method, either AND or OR
     *  @return If TRUE: user data; else FALSE
     */
    public function confirm( $whereArray, $connect = 'AND' )
    {
        if( !is_array( $whereArray ) ) return FALSE;
        
        foreach( $whereArray as $key => $value )
        {
            if( $connect == 'AND' )
            {
                $this->db->where( $key, $value );
            }
            else
            {
                $this->db->or_where( $key, $value );
            }
        }
        
        $query  = $this->db->get( $this->_table ); 
        
        if( $query->num_rows() == 1 )
        {
            return $query->row_array();
        }
        return FALSE;
    }
    
    public function readByUserTypeId( $userTypeId )
    {
        $query  = $this->db->where( 'userTypeId', $userTypeId )->order_by( 'name', 'ASC' )->get( $this->_table );
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
