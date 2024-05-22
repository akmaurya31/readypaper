<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_food extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                    
                    'id' => array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_increment' => TRUE
                    ),

                    'created_by' => array(
                        'type' => 'INT',
                        'constraint' => 15,
                        'unsigned' => TRUE,   
                        'null' => true,                    
                    ),

                    'head' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '100',
                    ),
                    
                    'logo' => array(
                        'type' => 'VARCHAR',
                        'constraint' => '200',
                    ),
                    'description' => array(
                        'type' => 'TEXT',
                        'null' => true,
                    ),

                    
                    'status' => array(
                        'type' => 'ENUM',
                        'constraint'     => ['Y', 'N'],
                        'default'        => 'Y',                    
                    ),

                    'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',

                ));
                
                $this->dbforge->add_key('id',TRUE);
               
		        $this->dbforge->create_table('tbl_food', TRUE);

               
        }

        public function down()
        {
                   //$forge->dropForeignKey('tablename','users_foreign');
                $this->dbforge->drop_table('tbl_food');
        }
}

    ?>