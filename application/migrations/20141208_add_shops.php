<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_shops extends CI_Migration {

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
					'constraint'    => 200
				),
				'slug'  => array(
					'type'  => 'VARCHAR',
					'constraint'    => 200
				),
				'userId'     => array(
					'type'  => 'INT',
					'unsigned'    => TRUE
				),
				'address'    => array(
					'type'  => 'TEXT'
				),
				'regionId'     => array(
					'type'  => 'int',
					'unsigned'    => TRUE,
					'null'	=> TRUE
				),
				'status'    => array(
					'type'  => 'TINYINT',
					'unsigned'  => TRUE,
					'constraint'    => 1
				),
				'created_at'    => array(
					'type'      => 'TIMESTAMP'
				),
				'updated_at'    => array(
					'type'      => 'TIMESTAMP'
				)
		));
		$this->dbforge->add_key( 'id', TRUE );
		$this->dbforge->create_table( 'shops' );
	}

	public function down()
	{
			$this->dbforge->drop_table( 'shops' );
	}
}