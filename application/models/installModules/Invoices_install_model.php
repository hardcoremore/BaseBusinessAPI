<?php

require_once 'application/models/BaseModel.php';

class Invoices_install_model extends BaseModel
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
		 * 
		 * 	+---------------------------+----------------------+------+-----+---------+----------------+
			| Field                     | Type                 | Null | Key | Default | Extra          |
			+---------------------------+----------------------+------+-----+---------+----------------+
			| invoice_id                | int(10) unsigned     | NO   | PRI | NULL    | auto_increment |
			| invoice_code              | varchar(128)         | NO   |     | NULL    |                |
			| invoice_year              | smallint(5) unsigned | NO   |     | NULL    |                |
			| invoice_creation_date     | date                 | NO   |     | NULL    |                |
			| invoice_number            | int(10) unsigned     | NO   |     | NULL    |                |
			| invoice_prefix            | varchar(128)         | NO   |     | NULL    |                |
			| invoice_type              | tinyint(3) unsigned  | NO   |     | NULL    |                |
			| invoice_customer_id       | int(10) unsigned     | NO   |     | NULL    |                |
			| invoice_price_without_tax | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_tax_percent       | tinyint(3) unsigned  | NO   |     | NULL    |                |
			| invoice_tax_value         | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_number_items      | tinyint(3) unsigned  | NO   |     | NULL    |                |
			| invoice_total_amount      | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_total_price_bruto | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_total_discount    | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_payed_total       | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_amount_to_pay     | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_place             | varchar(128)         | NO   |     | NULL    |                |
			| invoice_date              | date                 | NO   |     | NULL    |                |
			| invoice_days_to_pay       | smallint(5) unsigned | NO   |     | NULL    |                |
			| invoice_payment_due_date  | date                 | NO   |     | NULL    |                |
			| invoice_note              | text                 | NO   |     | NULL    |                |
			| user_id                   | int(10) unsigned     | NO   |     | NULL    |                |
			+---------------------------+----------------------+------+-----+---------+----------------+
		 * 
		 * 
		 */
		$invoices = array(
		
                        'invoice_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'invoice_code' => array(
                                                 'type' => 'VARCHAR',
                                          		 'constraint' => 128 
                                          ),
                        'invoice_year' => array(
                                                 'type' => 'SMALLINT',
                                          		 'unsigned' => TRUE 
                                          ),
                        'invoice_creation_date' => array(
                                                 'type' =>'DATE'
                                          ),
                        'invoice_number' => array(
                                                 'type' =>'INT',
                                                 'unsigned' => TRUE
                                          ),
                        'invoice_prefix' => array(
                                                 'type' => 'VARCHAR',
                                          		 'constraint' => 128
                                          ),
                        'invoice_type' => array(
                                                 'type' => 'TINYINT',
                                          		 'unsigned' => TRUE
                                          ),
                        'invoice_customer_id' => array(
                                                 'type' => 'INT',
                                          		 'unsigned' => TRUE
                                          ),
                        'invoice_price_without_tax' => array(
                                                 'type' => 'DECIMAL',
                                          		 'constraint' => '20,4'
                                          ),
                        'invoice_tax_percent' => array(
                                                 'type' => 'TINYINT',
                                          		 'unsigned' => TRUE
                                          ),
						'invoice_tax_value' => array(
                                                 'type' => 'DECIMAL',
                                          		 'constraint' => '20,4'
                                          ),                                          
                        'invoice_number_items' => array(
                                                 'type' => 'TINYINT',
                                          		 'unsigned' => TRUE
                                          ),
                        'invoice_total_amount' => array(
                                                 'type' => 'DECIMAL',
                                          		 'constraint' => '20,4'
                                          ),                  
                        'invoice_total_price_bruto' => array(
                                                 'type' => 'DECIMAL',
                                          		 'constraint' => '20,4'
                                          ),                  
                        'invoice_total_discount' => array(
                                                 'type' => 'DECIMAL',
                                          		 'constraint' => '20,4'
                                          ),                  
                        'invoice_payed_total' => array(
                                                 'type' => 'DECIMAL',
                                          		 'constraint' => '20,4'
                                          ),                  
                        'invoice_amount_to_pay' => array(
                                                 'type' => 'DECIMAL',
                                          		 'constraint' => '20,4'
                                          ),                  
                        'invoice_place' => array(
                                                 'type' => 'VARCHAR',
                                          		 'constraint' => 128
                                          ),                  
                        'invoice_date' => array(
                                                 'type' => 'DATE'
                                          ),                  
                        'invoice_days_to_pay' => array(
                                                 'type' => 'SMALLINT',
                                          		 'unsigned' => TRUE
                                          ),                  
                        'invoice_payment_due_date' => array(
                                                 'type' => 'DATE'
                                          ),                  
                        'invoice_note' => array(
                                                 'type' => 'TEXT'
                                          ),              
                        'user_id' => array(
                                                 'type' => 'INT',
                                          		 'unsigned' => TRUE
                                          )              
                );
                
		$this->dbforge->add_key('invoice_id', TRUE);               
        $this->dbforge->add_field( $invoices );    
        $this->dbforge->create_table( 'invoices' );
        
     
        /****
         * 
         * 	+-------------------------------+----------------------+------+-----+---------+----------------+
			| Field                         | Type                 | Null | Key | Default | Extra          |
			+-------------------------------+----------------------+------+-----+---------+----------------+
			| invoice_item_id               | int(10) unsigned     | NO   | MUL | NULL    | auto_increment |
			| invoice_id                    | int(10) unsigned     | NO   |     | NULL    |                |
			| item_id                       | int(10) unsigned     | NO   |     | NULL    |                |
			| invoice_item_number           | smallint(5) unsigned | NO   |     | NULL    |                |
			| invoice_item_amount           | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_item_price            | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_item_discount_percent | tinyint(4)           | NO   |     | NULL    |                |
			| invoice_item_discount_value   | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_item_tax_percent      | tinyint(4)           | NO   |     | NULL    |                |
			| invoice_item_tax_value        | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_item_price_withot_tax | decimal(20,4)        | NO   |     | NULL    |                |
			| invoice_item_price_with_tax   | decimal(20,4)        | NO   |     | NULL    |                |
			+-------------------------------+----------------------+------+-----+---------+----------------+
         * 
         */
        $invoice_items = array(
        				'invoice_item_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE,
        										 'auto_increment' => TRUE
                                          ),
 						'invoice_id' => array(
                                                'type' => 'INT',
                                                'unsigned' => TRUE
                                          ),
						'item_id' => array(
                                                'type' => 'INT',
                                                'unsigned' => TRUE
                                          ),                                          	                                         
                        'invoice_item_number' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE
                                          ),
                        'invoice_item_amount' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'invoice_item_price' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'invoice_item_discount_percent' => array(
                                                 'type' => 'TINYINT'
                                          ),
                        'invoice_item_discount_value' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'invoice_item_tax_percent' => array(
                                                 'type' => 'TINYINT'
                                          ),
                        'invoice_item_tax_value' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'invoice_item_price_withot_tax' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'invoice_item_price_with_tax' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          ),
                        'invoice_item_tax_value' => array(
                                                 'type' => 'DECIMAL',
                                                 'constraint' => '20,4'
                                          )
                        
                );

        $this->dbforge->add_key( 'invoice_item_id' );               
        $this->dbforge->add_field( $invoice_items );    
        $this->dbforge->create_table( 'invoice_items' );
        
	}
	
	public function uninstall()
	{
		$this->dbforge->drop_table('invoices');
		$this->dbforge->drop_table('invoice_items');
	}
}

?>