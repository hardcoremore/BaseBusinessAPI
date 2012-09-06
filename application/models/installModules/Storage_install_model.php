<?php

require_once 'application/models/BaseModel.php';

class Storage_install_model extends BaseModel
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
		 * 	---		STORAGES 	----
		 * 	+---------------------+-----------------------+------+-----+---------+----------------+
			| Field               | Type                  | Null | Key | Default | Extra          |
			+---------------------+-----------------------+------+-----+---------+----------------+
			| acg_id              | smallint(5) unsigned  | NO   | PRI | NULL    | auto_increment |
			| acg_name            | varchar(20)           | NO   |     | NULL    |                |
			| acg_created_user_id | mediumint(8) unsigned | NO   |     | NULL    |                |
			| acg_global_access   | tinyint(3) unsigned   | NO   |     | NULL    |                |
			+---------------------+-----------------------+------+-----+---------+----------------+
		 ***/
		 
		
		$storages = array(
                        'storage_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'storage_code' => array(
                                                 'type' => 'VARCHAR',
                                          		 'constraint' => 128 
                                          ),
                        'storage_name' => array(
                                                 'type' => 'VARCHAR',
                                          		 'constraint' => 128 
                                          ),
                        'storage_type' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'storage_address' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 64
                                          )
                );
                
		$this->dbforge->add_key('storage_id', TRUE);               
        $this->dbforge->add_field( $storages );    
        $this->dbforge->create_table( 'storages' );
        
       
        /****
		 * 
		 * 	---		STORAGE ITEM storage_item_categories	----
		 * 	+---------------------+-----------------------+------+-----+---------+----------------+
			| Field               | Type                  | Null | Key | Default | Extra          |
			+---------------------+-----------------------+------+-----+---------+----------------+
			| acg_id              | smallint(5) unsigned  | NO   | PRI | NULL    | auto_increment |
			| acg_name            | varchar(20)           | NO   |     | NULL    |                |
			| acg_created_user_id | mediumint(8) unsigned | NO   |     | NULL    |                |
			| acg_global_access   | tinyint(3) unsigned   | NO   |     | NULL    |                |
			+---------------------+-----------------------+------+-----+---------+----------------+
		 ***/
        
        $storage_item_categories = array(
        				'storage_item_category_id' => array(
                                                 'type' => 'MEDIUMINT',
                                                 'unsigned' => TRUE,
        										 'auto_increment' => TRUE
                                          ),
 						'storage_item_category_code' => array(
                                                 	'type' => 'VARCHAR',
                                                 	'constraint' => 50
                                          ),	                                         
                        'storage_item_category_name' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 50
                                          ),
                        'storage_item_category_type' => array(
                                                 'type' => 'TINYINT',
                                                 'unsigned' => TRUE
                                          )
                );

        $this->dbforge->add_key( 'storage_item_category_id' );               
        $this->dbforge->add_field( $storage_item_categories );    
        $this->dbforge->create_table( 'storage_item_categories' );
        
        /****
		 * 
		 * 	---		STORAGE ITEMS 	----
		 * 	+---------------------+-----------------------+------+-----+---------+----------------+
			| Field               | Type                  | Null | Key | Default | Extra          |
			+---------------------+-----------------------+------+-----+---------+----------------+
			| acg_id              | smallint(5) unsigned  | NO   | PRI | NULL    | auto_increment |
			| acg_name            | varchar(20)           | NO   |     | NULL    |                |
			| acg_created_user_id | mediumint(8) unsigned | NO   |     | NULL    |                |
			| acg_global_access   | tinyint(3) unsigned   | NO   |     | NULL    |                |
			+---------------------+-----------------------+------+-----+---------+----------------+
		 ***/
        
        $storage_items = array(
        				'storage_item_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE,
        										 'auto_increment' => TRUE
                                          ),
                        'storage_item_code' => array(
                                                 'type' => 'MEDIUMINT',
                                                 'unsigned' => TRUE
                                          ),
                        'storage_item_name' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 50
                                          ),
                        'storage_item_description' => array(
                                                 'type' => 'TEXT'
                                          ),
                        'storage_item_category' => array(
                                                 'type' => 'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'storage_item_order_quantity' => array(
                                                 'type' => 'MEDIUMINT',
                                                 'unsigned' => TRUE
                                          ),
                        'storage_item_volume' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'storage_item_weight' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'storage_item_type' => array(
                                                 'type' => 'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'storage_item_unit_of_measure' => array(
                                                 'type' => 'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'storage_item_display_decimal' => array(
                                                 	'type' => 'TINYINT',
                                                 	'unsigned' => TRUE
                                          ),
                        'storage_item_bar_code' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
                        'storage_item_tax_percent' => array(
                                                 'type' => 'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'storage_item_date_created' => array(
                                                 'type' => 'DATE'
                                          )
                );

        $this->dbforge->add_key( 'storage_item_id' );               
        $this->dbforge->add_field( $storage_items );    
        $this->dbforge->create_table( 'storage_items' );
        
        
        /****
		 * 
		 * 	---		STORAGE CONTENTS    ----
		 * 	
		 ***/
        
        $storage_contents = array(
        				
        				'storage_id' => array(
                                                 'type' => 'MEDIUMINT',
                                                 'unsigned' => TRUE,
                                          ),
						'storage_item_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),                                          
						'storage_item_amount' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'storage_item_price' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          )
                );
                
        
        
        $this->dbforge->add_key( 'storage_id' );        
        $this->dbforge->add_key( 'storage_item_id' );
        
        $this->dbforge->add_field( $storage_contents );    
        $this->dbforge->create_table( 'storage_contents' );
        
        /****
		 * 
		 * 	---		STORAGE ITEMS INPUT    ----
		 * 
		 *  +-----------------------------------+------------------+------+-----+---------+----------------+
			| Field                             | Type             | Null | Key | Default | Extra          |
			+-----------------------------------+------------------+------+-----+---------+----------------+
			| storage_items_input_id            | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
			| storage_items_input_code          | varchar(150)     | NO   |     | NULL    |                |
			| storage_items_input_date          | date             | NO   |     | NULL    |                |
			| storage_items_input_ammount_total | int(10) unsigned | NO   |     | NULL    |                |
			| storage_items_input_price_total   | decimal(10,0)    | NO   |     | NULL    |                |
			+-----------------------------------+------------------+------+-----+---------+----------------+
		 * 	
		 ***/
        
        $storage_items_input = array(
        				
        				'storage_items_input_id' => array(
                                                 'type' => 'INT',
        										 'auto_increment' => TRUE,
                                                 'unsigned' => TRUE
                                          ),
        				'storage_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
						'storage_items_input_code' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 150
                                          ),                                          
						'storage_items_input_date' => array(
                                                 'type' => 'DATE'
                                          ),
                        'storage_items_input_ammount_total' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
						'storage_items_input_price_total' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
						'storage_items_input_tax_total' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          )
                );
                
        
        
        $this->dbforge->add_key( 'storage_items_input_id', TRUE );        
        $this->dbforge->add_key( 'storage_id', TRUE );
        
        $this->dbforge->add_field( $storage_items_input );    
        $this->dbforge->create_table( 'storage_items_input' );
        
        /****
		 * 
		 * 	---		STORAGE ITEMS INPUT CONTENTS    ----
		 * 
		 *  +------------------------+------------------+------+-----+---------+-------+
			| Field                  | Type             | Null | Key | Default | Extra |
			+------------------------+------------------+------+-----+---------+-------+
			| storage_items_input_id | int(10) unsigned | NO   |     | NULL    |       |
			| storage_item_id        | int(10) unsigned | NO   |     | NULL    |       |
			| storage_item_amount    | mediumint(9)     | NO   |     | NULL    |       |
			| storage_item_price     | decimal(20,4)    | NO   |     | NULL    |       |
			+------------------------+------------------+------+-----+---------+-------+
		 * 	
		 ***/
        
        $storage_items_input_contents = array(
        				
        				'storage_items_input_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
                                          
						'storage_item_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
                                                                                    
						'storage_item_amount' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                                          
                        'storage_item_price' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                                          
                        'storage_item_tax_amount' => array(
                                                 'type' => 'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                                          
                        'storage_item_price_total' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                                          
                        'storage_item_tax_total' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          )
                );
                
        
        
        $this->dbforge->add_key( 'storage_items_input_id' );        
        $this->dbforge->add_key( 'storage_item_id' );
        
        $this->dbforge->add_field( $storage_items_input_contents );    
        $this->dbforge->create_table( 'storage_items_input_contents' );
        
        
	}
	
	public function uninstall()
	{
		$this->dbforge->drop_table('storages');
		$this->dbforge->drop_table('storage_item_categories');
		$this->dbforge->drop_table('storage_items');
		$this->dbforge->drop_table('storage_contents');
		$this->dbforge->drop_table('storage_items_input');
		$this->dbforge->drop_table('storage_items_input_contents');
	}
}

?>