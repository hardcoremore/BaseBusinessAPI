<?php

require_once 'application/models/BaseModel.php';

class Desktop_install_model extends BaseModel
{
	public function loadDatabase( DatabaseConfigVo $database = NULL )
	{
		parent::loadDatabase( $database );
		$this->load->dbforge( $this->db );
		$this->db->query( "SET storage_engine=INNODB");
	}
	
	public function install()
	{
		
		
		$desktop_appearance = array(
		
                        'desktop_appearance_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                        'desktop_appearance_user_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
                        'desktop_appearance_name' => array(
                                                 'type' => 'VARCHAR',
                                          		  'constraint' => 50
                                          ),
                        'desktop_appearance_default' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
                        'desktop_appearance_icon_size' => array(
                                                 'type' =>'MEDIUMINT',
                                                 'unsigned' => TRUE
                                          ),                                                                 			
                        'desktop_appearance_font_size' => array(
                                                 'type' =>'MEDIUMINT',
                                                 'unsigned' => TRUE
                                          ),					                                        
						'desktop_appearance_controll_button_size' => array(
                                                 	'type' =>'MEDIUMINT',
                                                 	'unsigned' => TRUE
                                          ), 
						'desktop_appearance_wallpaper_type' => array(
                                                 	'type' =>'VARCHAR',
                                          			'constraint' => 30
                                          ), 
						'desktop_appearance_wallpaper_url' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 255
                                          ), 
						'desktop_appearance_wallpaper_color' => array(
                                                 	'type' =>'BIGINT',
                                                 	'unsigned' => TRUE
                                          ), 
                        'desktop_appearance_window_background_color' =>array(
                                                 	'type' =>'INT',
                                          			'unsigned' => TRUE
                                          ),                   						                                        
						'desktop_appearance_window_background_alpha' => array(
                                                 	'type' =>'DECIMAL',
                                          			'constraint' => '2,1'
                                          ),  						                                        
						'desktop_appearance_window_border_color' => array(
                                                 	'type' =>'MEDIUMINT',
                                          			'unsigned' => TRUE
                                          ),  						                                        
						'desktop_appearance_window_border_alpha' => array(
                                                 	'type' =>'DECIMAL',
                                          			'constraint' => '2,1'
                                          ),
						'desktop_appearance_taskbar_position' => array(
                                                 	'type' =>'VARCHAR',
                                          			'constraint' => 50
                                          ),
						'desktop_appearance_taskbar_label_visible' => array(
                                                 	'type' =>'TINYINT',
                                          			'unsigned' => TRUE
                                          ),
						'desktop_appearance_taskbar_thickness' => array(
                                                 	'type' =>'MEDIUMINT',
                                          			'unsigned' => TRUE 
                                          ),
						'desktop_appearance_taskbar_color' => array(
                                                 	'type' =>'INT',
                                          			'unsigned' => TRUE 
                                          ),
						'desktop_appearance_taskbar_alpha' => array(
                                          			'type' =>'DECIMAL',
                                          			'constraint' => '2,1'
                                          ),
	                                          
                                          
                                          
                );
       
		$this->dbforge->add_key('desktop_appearance_id', TRUE);               
        $this->dbforge->add_field( $desktop_appearance );    
        $this->dbforge->create_table( 'desktop_appearance' );
        
        
		$desktop_icons = array(
		
                        'desktop_icon_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
                                          
                                          
                        'desktop_icon_user_id' => array(
                                                 'type' => 'INT',
                                                 'unsigned' => TRUE
                                          ),
                        'desktop_icon_x' => array(
                                                 'type' => 'DECIMAL',
                                          		 'constraint' => '20,4',
                                          		 'unsigned' => TRUE
                                          ),
                        'desktop_icon_y' => array(
                                                 'type' =>'DECIMAL',
                                          		 'constraint' => '20,4',
                                                 'unsigned' => TRUE
                                          ),
                        'desktop_icon_image_url' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 250
                                          ),                 
						'desktop_icon_resource_type' => array(
                                                 'type' => 'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
						'desktop_icon_resource_url' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 250
                                          )
                                          	                                          
                );
       
		$this->dbforge->add_key('desktop_icon_id', TRUE);               
        $this->dbforge->add_field( $desktop_icons );    
        $this->dbforge->create_table( 'desktop_icons' );
        
       
       
        
	}
	
	public function uninstall()
	{
		$this->dbforge->drop_table( 'desktop_icons' );
		$this->dbforge->drop_table( 'desktop_appearance' );
	}
}

?>