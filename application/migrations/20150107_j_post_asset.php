<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_J_post_asset extends CI_Migration {

	public function up()
	{
        $this->dbforge->add_field( array(
                'postId'    => array(
                    'type'  => 'INT',
                    'unsigned'  => TRUE,
                ),
                'assetId'    => array(
                    'type'  => 'INT',
                    'unsigned'  => TRUE,
                ),
        ));
        $this->dbforge->create_table( 'j_post_asset' );
	}

	public function down()
	{
        $this->dbforge->drop_table( 'j_post_asset' );
	}
}