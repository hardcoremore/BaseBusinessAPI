<?php

require_once 'application/models/BaseModel.php';

class Customers_install_model extends BaseModel
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
		 * 	---		CUSTOMERS 	----
		 * 
		 *  +-----------------------------+----------------------+------+-----+---------+----------------+
			| Field                       | Type                 | Null | Key | Default | Extra          |
			+-----------------------------+----------------------+------+-----+---------+----------------+
			| customer_id                 | smallint(5) unsigned | NO   | PRI | NULL    | auto_increment |
			| customer_code               | int(10) unsigned     | NO   |     | NULL    |                |
			| customer_sales_type         | tinyint(3) unsigned  | NO   |     | NULL    |                |
			| customer_tax_enabled        | tinyint(3) unsigned  | NO   |     | NULL    |                |
			| customer_vat_value	      | tinyint(3) unsigned  | NO   |     | NULL    |                |
			| customer_name               | varchar(128)         | NO   |     | NULL    |                |
			| customer_telephone          | varchar(50)          | NO   |     | NULL    |                |
			| customer_telephone2         | varchar(50)          | NO   |     | NULL    |                |
			| customer_mobile             | varchar(50)          | NO   |     | NULL    |                |
			| customer_mobile2            | varchar(50)          | NO   |     | NULL    |                |
			| customer_contact_person     | varchar(50)          | NO   |     | NULL    |                |
			| customer_country            | int(10) unsigned     | NO   |     | NULL    |                |
			| customer_zip_code           | int(8) unsigned      | NO   |     | NULL    |                |
			| customer_city               | varchar(50)          | NO   |     | NULL    |                |
			| customer_address            | varchar(128)         | NO   |     | NULL    |                |
			| customer_email_address      | varchar(256)         | NO   |     | NULL    |                |
			| customer_company_number     | int(10) unsigned     | NO   |     | NULL    |                |
			| customer_company_vat_number | int(10) unsigned     | NO   |     | NULL    |                |
			| customer_company_tax_number | int(10) unsigned     | NO   |     | NULL    |                |
			| customer_since              | date                 | NO   |     | NULL    |                |
			| customer_bank_account       | varchar(128)         | NO   |     | NULL    |                |
			| customer_bank_account2      | varchar(128)         | NO   |     | NULL    |                |
			| customer_bank_account3      | varchar(128)         | NO   |     | NULL    |                |
			| customer_currency           | tinyint(3) unsigned  | NO   |     | NULL    |                |
			| customer_credit_status      | tinyint(3) unsigned  | NO   |     | NULL    |                |
			| customer_credit_limit       | int(10) unsigned     | NO   |     | NULL    |                |
			| customer_note               | text                 | NO   |     | NULL    |                |
			+-----------------------------+----------------------+------+-----+---------+----------------+
		 
		 ***/
		 
		
		$customers = array(
                        'customer_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'customer_code' => array(
                                                 'type' => 'INT',
                                          		  'unsigned' => TRUE
                                          ),
                        'customer_sales_type' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'customer_tax_enabled' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'customer_vat_value' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'customer_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 128
                                          ),
                        'customer_telephone' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),
						'customer_telephone2' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),
						'customer_mobile' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),
                        'customer_mobile2' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),                                                                 			
                        'customer_contact_person' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),                  
						'customer_country' => array(
                                                 'type' =>'INT',
                                                 'unsigned' => TRUE
                                          ),                  
                                          
						'customer_zip_code' => array(
                                                 'type' =>'INT',
                                                 'constraint' => 8,
                                          		 'unsigned' => TRUE
                                          ),                  
						'customer_city' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),                  
  						'customer_address' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 128
                                          ),
                        'customer_email_address' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 256
                                          ),                                                          				
						'customer_company_number' => array(
                                                 	'type' =>'INT',
                                                 	'constraint' => 10,
                                          			'unsigned' => TRUE
                                          ),                  
						'customer_company_vat_number' => array(
                                                 	'type' =>'INT',
                                                 	'constraint' => 10,
                                          			'unsigned' => TRUE
                                          ),                  
  						'customer_company_tax_number' => array(
                                                 	'type' =>'INT',
                                                 	'constraint' => 10,
                                          			'unsigned' => TRUE
                                          ),	                                          
						'customer_sales_type' => array(
                                                 	'type' =>'TINYINT',
                                          			'unsigned' => TRUE
                                          ),
						'customer_since' => array(
                                                 	'type' =>'DATE'
                                          ), 
						'customer_bank_account' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 128
                                          ),
                        'customer_bank_account2' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 128
                                          ),
						'customer_bank_account3' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 128
                                          ),

						'customer_currency' => array(
                                                 	'type' =>'TINYINT',
                                                 	'unsigned' => TRUE
                                          ),  						                                        
						'customer_credit_limit' => array(
                                                 	'type' =>'DECIMAL',
                                          			'constraint' => '20,4'
                                          ), 
                        'customer_credit_status' =>array(
                                                 	'type' =>'TINYINT',
                                          			'unsigned' => TRUE
                                          ),                   						                                        
						'customer_note' => array(
                                                 	'type' =>'TEXT',
                                          ),  						                                        
                                          
                                          
                );
       
		$this->dbforge->add_key('customer_id', TRUE);               
        $this->dbforge->add_field( $customers );    
        $this->dbforge->create_table( 'customers' );
        
	}
	
	public function uninstall()
	{
		$this->dbforge->drop_table('customers');
	}
}

?>