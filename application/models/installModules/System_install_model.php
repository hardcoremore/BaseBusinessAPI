<?php

require_once 'application/models/BaseModel.php';

class System_install_model extends BaseModel
{
	public function loadDatabase( DatabaseConfigVo $database = NULL )
	{
		parent::loadDatabase( $database );
		$this->load->dbforge( $this->db );
		$this->db->query( "SET storage_engine=INNODB");
	}
	
	public function install()
	{ 
		 $data_holder = array(
		
                        'data_holder_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                                          
                                          
                        'data_holder_user_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
                        'data_holder_name' => array(
                                                 'type' => 'VARCHAR',
                                          		 'constraint' => 50
                                          )                                          
                );
       
		    $this->dbforge->add_key('data_holder_id', TRUE);               
        $this->dbforge->add_field( $data_holder );    
        $this->dbforge->create_table( 'data_holder' );
        
        
        $data_holder_columns = array(
		
                        'data_holder_column_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                                          
                        'data_holder_id' => array(
                                              'type' => 'VARCHAR',
                                          		'constraint' => 150
                                          ),
                                          
                        'data_holder_user_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
                                          
            						'data_holder_column_position_index' => array(
                                                           'type' => 'TINYINT',
                                                      		 'unsigned' => TRUE
                                                      ),
                                                                                                                   
            						'data_holder_column_data_field' => array(
                                                             'type' => 'VARCHAR',
                                                      		   'constraint' => 150
                                                      ),
                                                                                                
            						'data_holder_column_header_text' => array(
                                                             'type' => 'VARCHAR',
                                                      		   'constraint' => 150
                                                      ),
                                                                                                
            						'data_holder_column_visible' => array(
                                                             'type' => 'TINYINT',
                                                      		 'unsigned' => TRUE
                                                      ),
                                                                                                
            						'data_holder_column_custom_header_text' => array(
                                                             'type' => 'VARCHAR',
                                                      		 'constraint' => 150
                                                      ),
                                                                                                
            						'data_holder_column_custom_header' => array(
                                                             'type' => 'TINYINT',
                                                      		   'unsigned' => TRUE,
                                                      		   'default' => 0
                                                      )                                          
                                                                                    
                );
       
		    $this->dbforge->add_key( 'data_holder_columns_id', TRUE );               
        $this->dbforge->add_field( $data_holder_columns );    
        $this->dbforge->create_table( 'data_holder_columns' );
        
        
	}
	
	public function uninstall()
	{
		$this->dbforge->drop_table( 'data_holder' );
		$this->dbforge->drop_table( 'data_holder_columns' );
	}
}

?>