<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_assets_table extends CI_Migration {

	public function up()
	{
        $this->dbforge->add_field( array(
                'id'    => array(
                    'type'  => 'INT',
                    'unsigned'  => TRUE,
                    'auto_increment'    => TRUE
                ),
                'name'  => array(
                    'type'  => 'VARCHAR',
                    'constraint'    => 255
                ),
                'assetTypeId'  => array(
                    'type'  => 'INT',
                    'unsigned'    => TRUE
                ),
                'originalName'  => array(
                    'type'  => 'VARCHAR',
					'constraint'	=> 255
                ),
				'filesize'	=> array(
					'type'	=> 'INT',
					'unsigned'	=> TRUE
				),
				'userId'	=> array(
					'type'	=> 'INT',
					'unsigned'	=> TRUE,
					'constraint'	=> 11
				),
				'created_at'	=> array(
					'type'	=> 'TIMESTAMP',
				),
				'updated_at'	=> array(
					'type'	=> 'TIMESTAMP',
				),
        ));
        $this->dbforge->add_key( 'id', TRUE );
        $this->dbforge->create_table( 'assets' );
	}

	public function down()
	{
        $this->dbforge->drop_table( 'assets' );
	}
}