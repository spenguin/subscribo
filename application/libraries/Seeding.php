<?php

class Seeding extends CI_Loader
{

    public function run( $filename )
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->library( 'encryption' );
		
		$_seed_path = APPPATH . 'database/seeding/';
        
        include_once( $_seed_path . $filename . '.php' );
		
		foreach( $insert as $i )
		{
			$query  =   $CI->db->insert( $table, $i );
		}

	}

}
