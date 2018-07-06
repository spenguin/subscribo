<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_answers_table extends CI_Migration {

	public function up()
	{
        $this->dbforge->add_field( array(
                'id'    => array(
                    'type'  => 'INT',
                    'unsigned'  => TRUE,
                    'auto_increment'    => TRUE
                ),
                'collection'  => array(
                    'type'  => 'VARCHAR',
                    'constraint'    => 255
                ),
                'entry'  => array(
                    'type'  => 'VARCHAR',
                    'constraint'    => 255
                ),
                'answer'  => array(
                    'type'  => 'TEXT'
                )
        ));
        $this->dbforge->add_key( 'id', TRUE );
        $this->dbforge->create_table( 'answers' );
	}

	public function down()
	{
        $this->dbforge->drop_table( 'answers' );
	}
}