<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),
                    'username' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'password'=>['type'=>'varchar', 'constraint'=>250],

                    'role' => array(
                        'type' => 'ENUM',
                        'constraint'     => ['admin', 'user', 'manager'],
                        'default'        => 'user',
                    ),
                    'firstName' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                    ),

                    'lastName' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'mobile_no' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'email' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                        'null'=>true
                    ),
                    'gender' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'city' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    'logo' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '200',
                    ),
                    'status' => array(
                        'type' => 'ENUM',
                        'constraint'     => ['Y', 'N'],
                        'default'        => 'Y',
                    
                    ),
                    'address' => array(
                        'type' => 'TEXT',
                        'null' => true,
                    ),
                    'fb' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '200',
                    ),
                    'youtube' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '200',
                    ),
                    'instagram' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '200',
                    ),
                    'telegram' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '200',
                    ),
                    
                    'description' => array(
                        'type' => 'TEXT',
                        'null' => true,
                    ),

                    'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
                    
                   
                ));
                $this->dbforge->add_key('id',TRUE);
		        $this->dbforge->create_table('user', TRUE);
        }

        public function down()
        {
                $this->dbforge->drop_table('user');
        }
}

    ?>