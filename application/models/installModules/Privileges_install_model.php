<?php

require_once 'application/models/BaseModel.php';

class Privileges_install_model extends BaseModel
{
	public function loadDatabase( DatabaseConfigVo $database = NULL )
	{
		parent::loadDatabase( $database );
		$this->load->dbforge( $this->db );
		
		$this->db->query( "SET storage_engine=INNODB");
	}
	
	public function install()
	{
		/****
		 * 
		 * 	---		ACG 	----
		 * 	+---------------------+-----------------------+------+-----+---------+----------------+
			| Field               | Type                  | Null | Key | Default | Extra          |
			+---------------------+-----------------------+------+-----+---------+----------------+
			| acg_id              | smallint(5) unsigned  | NO   | PRI | NULL    | auto_increment |
			| acg_name            | varchar(20)           | NO   |     | NULL    |                |
			| acg_created_user_id | mediumint(8) unsigned | NO   |     | NULL    |                |
			| acg_global_access   | tinyint(3) unsigned   | NO   |     | NULL    |                |
			+---------------------+-----------------------+------+-----+---------+----------------+
		 ***/
		 
		
		$f_acg = array(
                        'acg_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'acg_name' => array(
                                                 'type' => 'VARCHAR',
                                          		 'constraint' => 20 
                                          ),
                        'acg_created_user_id' => array(
                                                 'type' =>'MEDIUMINT',
                                                 'unsigned' => TRUE
                                          ),
                        'acg_global_access' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          )
                );
                
		$this->dbforge->add_key('acg_id', TRUE);               
        $this->dbforge->add_field( $f_acg );    
        $this->dbforge->create_table( 'acg' );
        
        /******
         * -----	ACGL   -----
		 * 
		 * 	+-----------+----------------------+------+-----+---------+-------+
			| Field     | Type                 | Null | Key | Default | Extra |
			+-----------+----------------------+------+-----+---------+-------+
			| acg_id    | smallint(5) unsigned | NO   | MUL | NULL    |       |
			| module_id | smallint(5) unsigned | NO   | MUL | NULL    |       |
			| action_id | smallint(5) unsigned | NO   |     | NULL    |       |
			| access    | tinyint(3) unsigned  | NO   |     | NULL    |       |
			+-----------+----------------------+------+-----+---------+-------+
		 *
		 *
		 */
        
        		 
        $f_acgl = array(
                        'acg_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE
                                          ),
                        'module_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE
                                          ),
                        'action_id' => array(
                                                 'type' =>'SMALLINT',
                                                 'unsigned' => TRUE
                                          ),
                        'access' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          )
                );
                
		$this->dbforge->add_key( 'acg_id' );
		$this->dbforge->add_key( 'module_id' );               
        $this->dbforge->add_field( $f_acgl );    
        $this->dbforge->create_table( 'acgl' );
        
        /***
         * 
         *	----- ACL  -------
		 *	+-----------+-----------------------+------+-----+---------+-------+
			| Field     | Type                  | Null | Key | Default | Extra |
			+-----------+-----------------------+------+-----+---------+-------+
			| user_id   | mediumint(8) unsigned | NO   |     | NULL    |       |
			| module_id | smallint(5) unsigned  | NO   | MUL | NULL    |       |
			| action_id | smallint(5) unsigned  | NO   | MUL | NULL    |       |
			| access    | tinyint(3) unsigned   | NO   |     | NULL    |       |
			+-----------+-----------------------+------+-----+---------+-------+
		 * 
		 */
        
        
        $f_acl = array(
        				'user_id' => array(
                                                 'type' => 'MEDIUMINT',
                                                 'unsigned' => TRUE
                                          ),
                        'module_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE
                                          ),
                        'action_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE
                                          ),
                        'access' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          )
                );

        $this->dbforge->add_key( 'user_id' );
		$this->dbforge->add_key( 'module_id' );
		$this->dbforge->add_key( 'action_id' );               
        $this->dbforge->add_field( $f_acl );    
        $this->dbforge->create_table( 'acl' );
        
        
        
	}
	
	public function uninstall()
	{
		$this->dbforge->drop_table('acg');
		$this->dbforge->drop_table('acgl');
		$this->dbforge->drop_table('acl');
	}
}

?>