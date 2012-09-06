<?php

require_once 'application/models/BaseModel.php';

class Users_install_model extends BaseModel
{
	public function loadDatabase( DatabaseConfigVo $database = NULL )
	{
		parent::loadDatabase( $database );
		$this->load->dbforge( $this->db );
		
		$this->db->query( "SET storage_engine=INNODB");
	}
	
	public function install()
	{
		
		
		/***		
			+--------------------+--------------------------------------------------------------+------+-----+---------+----------------+
			| Field              | Type                                                         | Null | Key | Default | Extra          |
			+--------------------+--------------------------------------------------------------+------+-----+---------+----------------+
			| user_id            | int(10) unsigned                                             | NO   | PRI | NULL    | auto_increment |
			| user_slika         | char(36)                                                     | NO   |     | NULL    |                |
			| user_acg_id        | tinyint(3) unsigned                                          | NO   |     | NULL    |                |
			| user_type          | enum('SuperAdministrator','Administrator','Regular','Guest') | NO   |     | NULL    |                |
			| user_name          | varchar(50)                                                  | NO   |     | NULL    |                |
			| user_last_name     | varchar(50)                                                  | NO   |     | NULL    |                |
			| username           | varchar(30)                                                  | NO   |     | NULL    |                |
			| password           | char(32)                                                     | NO   |     | NULL    |                |
			| user_creation_date | date	                                                        | NO   |     | NULL    |                |
			| user_gender        | enum('m','f')                                                | NO   |     | NULL    |                |
			| user_phone_number  | varchar(40)                                                  | NO   |     | NULL    |                |
			| user_mobile_number | varchar(40)                                                  | NO   |     | NULL    |                |
			| user_email         | varchar(128)                                                 | NO   |     | NULL    |                |
			+--------------------+--------------------------------------------------------------+------+-----+---------+----------------+
		***/
		
		$fields = array(
                        'user_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'user_acg_id' => array(
                                                 'type' => 'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'user_type' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'user_name' => array(
                                                 'type' => 'VARCHAR',
                                           		 'constraint' => 50, 
                                                 'null' => TRUE
                                          ),
                        'user_last_name' => array(
                                                 'type' => 'VARCHAR',
                                           		 'constraint' => 50, 
                                                 'null' => TRUE
                                          ),
                        'username' => array(
                                                 'type' => 'VARCHAR',
                                           		 'constraint' => 20,
                                                 'null' => TRUE,
                                          ),
                        'password' => array(
                                                 'type' => 'CHAR',
                                          		 'constraint' => 32, 
                                                 'null' => TRUE,
                                          ),
                        'user_creation_date' => array(
                                                 'type' => 'DATE',
                                                 'null' => FALSE,
                                          ),
                        'user_gender' => array(
                                                 'type' => 'TINYINT',
                                          		 'unsigned' => TRUE,
                                                 'null' => false,
                                          ),
                        'user_phone_number' => array(
                                                 'type' => 'VARCHAR',
                                           		 'constraint' => 30,
                                                 'null' => TRUE,
                                          ),
                        'user_mobile_number' => array(
                                                 'type' => 'VARCHAR',
                                           		 'constraint' => 30,
                                                 'null' => TRUE,
                                          ),
                        'user_email' => array(
                                                 'type' => 'VARCHAR',
                                           		 'constraint' => 40,
                                                 'null' => TRUE,
                                          ),
                        'user_skype' => array(
                                                 'type' => 'VARCHAR',
                                           		 'constraint' => 150,
                                                 'null' => TRUE,
                                          ),
                                  
                );

 		 $this->dbforge->add_key('user_id', TRUE);               
         $this->dbforge->add_field( $fields );    
         $this->dbforge->create_table( 'users' );
	}
	
	public function uninstall()
	{
		$this->dbforge->drop_table('users');
	}
}

?>