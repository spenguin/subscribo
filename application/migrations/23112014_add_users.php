<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {

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
                    'username'  => array(
                        'type'  => 'VARCHAR',
                        'constraint'    => 200
                    ),
                    'email'     => array(
                        'type'  => 'VARCHAR',
                        'constraint'    => 100
                    ),
                    'pwhash'    => array(
                        'type'  => 'VARCHAR',
                        'constraint'    => 255
                    ),
                    'nonce'     => array(
                        'type'  => 'VARCHAR',
                        'constraint'    => 255
                    ),
                    'userTypeId'    => array(
                        'type'  => 'INT',
                        'unsigned'  => TRUE,
                    ),
                    'status'    => array(
                        'type'  => 'TINYINT',
                        'unsigned'  => TRUE,
                        'constraint'    => 1
                    ),
                    'remember_token'    => array(
                        'type'  => 'VARCHAR',
                        'constraint'    => 255
                    ),
                    'created_at'    => array(
                        'type'      => 'TIMESTAMP'
                    ),
                    'updated_at'    => array(
                        'type'      => 'TIMESTAMP'
                    )
            ));
            $this->dbforge->add_key( 'id', TRUE );
            $this->dbforge->create_table( 'users' );
        }

        public function down()
        {
                $this->dbforge->drop_table( 'users' );
        }
}