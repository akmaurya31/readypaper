<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_packages extends CI_Migration {

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

                    'name' => array(
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

                    'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',

                ));
                
                $this->dbforge->add_key('id',TRUE);
               
		        $this->dbforge->create_table('tbl_packages', TRUE);

               
        }

        public function down()
        {
                   //$forge->dropForeignKey('tablename','users_foreign');
                $this->dbforge->drop_table('tbl_packages');
        }
}

    ?>