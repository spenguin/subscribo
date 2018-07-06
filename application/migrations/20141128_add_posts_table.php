<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_posts_table extends CI_Migration {

	public function up()
	{
        $this->dbforge->add_field( array(
                'id'    => array(
                    'type'  => 'INT',
                    'unsigned'  => TRUE,
                    'auto_increment'    => TRUE
                ),
                'title'  => array(
                    'type'  => 'VARCHAR',
                    'constraint'    => 255
                ),
                'url_title'  => array(
                    'type'  => 'VARCHAR',
                    'constraint'    => 255
                ),
				'body'		=> array(
					'type'	=> 'LONGTEXT'
				),
				'excerpt'	=> array(
					'type'	=> 'TEXT'
				),
				'created_at'	=> array(
					'type'	=> 'TIMESTAMP',
				),
				'updated_at'	=> array(
					'type'	=> 'TIMESTAMP',
				),
				'status'	=> array(
					'type'	=> 'TINYINT',
					'default'	=> 0
				),
				'userId'	=> array(
					'type'	=> 'INT',
					'unsigned'	=> TRUE,
					'constraint'	=> 11
				)

        ));
        $this->dbforge->add_key( 'id', TRUE );
        $this->dbforge->create_table( 'posts' );
	}

	public function down()
	{
        $this->dbforge->drop_table( 'posts' );
	}
}