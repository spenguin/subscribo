<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_subscriptions_table extends CI_Migration {

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
				'email'  => array(
					'type'  => 'VARCHAR',
					'constraint'    => 200
				),
				'subStartIssue'     => array(
					'type'  => 'INT',
					'unsigned'    => TRUE
				),
				'length'    => array(
					'type'  => 'INT',
					'unsigned'	=> TRUE
				),
				'quantity'     => array(
					'type'  => 'INT',
					'unsigned'    => TRUE,
				)
		));
		$this->dbforge->add_key( 'id', TRUE );
		$this->dbforge->create_table( 'subscriptions' );
	}

	public function down()
	{
			$this->dbforge->drop_table( 'subscriptions' );
	}
}