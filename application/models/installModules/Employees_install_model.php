<?php

require_once 'application/models/BaseModel.php';

class Employees_install_model extends BaseModel
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
		 * 	---		EMPLOYEES 	----
		 * 
		 *  
		 
		 ***/
		$result = false;
		
		$employees = array(
                        'employee_id' => array(
                                                 'type' => 'SMALLINT',
                                                 'unsigned' => TRUE,
                                                 'auto_increment' => TRUE
                                          ),
 						'employee_economics_id' => array(
				        							'type' =>'INT',
				                                    'unsigned' => TRUE
						    			 ),                                         
                        'employee_code' => array(
                                                 'type' => 'INT',
                                          		  'unsigned' => TRUE
                                          ),
                        'employee_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),
                        'employee_last_name' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),
                        'employee_gender' => array(
                                                 'type' =>'TINYINT',
                                                 'unsigned' => TRUE
                                          ),
						'employee_birth_date' => array(
                                                 'type' =>'DATE'
                                          ),
						'employee_address' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 50
                                          ),
                        'employee_social_security_number' => array(
                                                 	'type' =>'VARCHAR',
                                                	 'constraint' => 50
                                          ),                                                                 			
                        'employee_personal_number' => array(
	                                                 'type' =>'VARCHAR',
	                                                 'constraint' => 50
                                          ),                  
						'employee_passport_number' => array(
                                                 	 'type' =>'VARCHAR',
	                                                 'constraint' => 50
                                          ),                  
                                          
						'employee_hired' => array(
                                                 'type' =>'TINYINT',
                                          		 'unsigned' => TRUE
                                          ),                  
						'employee_hire_date' => array(
                                                 'type' =>'DATE'
                                          ),                  
  						'employee_fire_date' => array(
                                                 'type' =>'DATE'
                                          ),                                                                                    
                        'employee_title' => array(
                                                 'type' =>'VARCHAR',
                                                 'constraint' => 20
                                          ),                                                          				
						'employee_personal_email' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 50
                                          ),                  
						'employee_personal_phone' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 20
                                          ),                  
  						                                 
						'employee_business_email' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 50
                                          ),
						'employee_business_phone' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 50
                                          ), 
                        'employee_business_phone_extension' => array(
                                                 	'type' =>'VARCHAR',
                                                 	'constraint' => 128
                                          ),
						'employee_contract_type' => array(
                                                 	'type' =>'TINYINT',
                                                 	'unsigned' => TRUE
                                          ),
						'employee_working_scenario_id' => array(
                                                 	'type' =>'TINYINT',
                                                 	'unsigned' => TRUE
                                          ),
						'employee_note' => array(
                                                 	'type' =>'TEXT'
                                                 	
                                          )                                          
                );
       
		$this->dbforge->add_key( 'employee_id', TRUE );    
		$this->dbforge->add_key( 'employee_working_scenario_id' );           
		$this->dbforge->add_key( 'employee_economics_id' );           
        $this->dbforge->add_field( $employees );    
        $result = $this->dbforge->create_table( 'employees' );
        
        $employee_contract_history = array(

        									'employee_contract_history_id' => array(
				        											'type' =>'INT',
				                                               		'unsigned' => TRUE,
                                                					'auto_increment' => TRUE
						    			 	),
						    			 	
						    			 	'employee_id' => array(
				        											'type' =>'MEDIUMINT',
				                                               		'unsigned' => TRUE,
						    			 	),
						    			 	
						    			 	'employee_contract_event_type' => array(
				        											'type' =>'TINYINT',
				                                               		'unsigned' => TRUE,
						    			 	),
						    			 	
						    			 	'employee_contract_type' => array(
				        											'type' =>'TINYINT',
				                                               		'unsigned' => TRUE,
						    			 	),
						    			 	
						    			 	'employee_contract_start' => array(
				        											'type' =>'DATE'
						    			 	),
						    			 	
						    			 	'employee_contract_end' => array(
				        											'type' =>'DATE'
						    			 	),
        
        
        );
        
        
        $this->dbforge->add_key( 'employee_contract_history_id', TRUE );    
		$this->dbforge->add_key( 'employee_id' );           
        $this->dbforge->add_field( $employee_contract_history );    
        $result = $this->dbforge->create_table( 'employee_contract_history' );
        
        
        $employee_economics = array( 
        								'employee_economics_id' => array(
				        													'type' =>'INT',
				                                               				'unsigned' => TRUE,
                                                					   		'auto_increment' => TRUE
						    			 ),
						    			'employee_economics_name' => array(
						                                                 'type' => 'VARCHAR',
						                                                 'constraint' => 150
						    			 								 
                                                 
                                         ),
						        		'employee_daily_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
                                         ), 
										'employee_first_shift_hour_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
				                         ),                                                                                     
										'employee_second_shift_hour_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
				                         ),                                                                                     
										'employee_third_shift_hour_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
				                         ),                                                                                     
										'employee_weekly_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
				                         ), 
										'employee_monthly_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
				                         ),                                                                                     
										'employee_first_shift_hour_overtime_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
				                          ), 
										'employee_second_shift_hour_overtime_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
				                          ), 
										'employee_third_shift_hour_overtime_wage' => array(
							                                                 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
				                          ), 
				                        'employee_business_phone_limit' => array(
                                                 	 						 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
                                          ),
				                        'employee_gas_limit' => array(
                                                 	 						 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
                                          ),
				                        'employee_car_amortisation' => array(
                                                 	 						 'type' =>'DECIMAL',
							                                          		 'unsigned' => TRUE,
							                                                 'constraint' => '20,4',
							                                                 'default' => 0
                                          ),
						        	);
						        												
        
        $this->dbforge->add_key('employee_economics_id', TRUE);          
        $this->dbforge->add_field( $employee_economics );    
        $result = $this->dbforge->create_table( 'employee_economics' );

        
        $employee_item_charges = array( 
        									'employee_item_charge_id' => array(
				        														 'type' =>'INT',
				                                               					 'unsigned' => TRUE,
                                                					   			 'auto_increment' => TRUE
						        												),
        									'employee_id' => array(
	        														 'type' =>'INT',
	                                               					 'unsigned' => TRUE
			        											 ),
        									'employee_item_charged' => array(
	        														 'type' =>'TINYINT',
	                                               					 'unsigned' => TRUE
			        											 ),
        									'employee_item_charge_storage_id' => array(
				        														 'type' =>'INT',
			        											 				 'unsigned' => TRUE
						        												),
        									'employee_item_charge_item_id' => array(
				        														 'type' =>'INT',
			        											 				 'unsigned' => TRUE
						        												),
        									'employee_item_charge_type' => array(
				        														 'type' =>'TINYINT',
			        											 				 'unsigned' => TRUE
						        												),
        									'employee_item_charge_description' => array(
				        														 'type' =>'TEXT'
						        												),
											'employee_item_charge_monthly_value' => array(
				        														 'type' =>'DECIMAL',
			        											 				 'constraint' => '20,4'
						        												),						        												
											'employee_item_charge_start_date' => array(
				        														 'type' =>'DATE'
						        												)					        												
        									);
        									
        $this->dbforge->add_key('employee_item_charge_id', TRUE);   
        $this->dbforge->add_key('employee_id' );            
        $this->dbforge->add_field( $employee_item_charges );    
        $this->dbforge->create_table( 'employee_item_charges' );
        
        
        $employees_item_charge_costs = array( 
        									 'employee_item_charge_cost_id' => array(
        																'type' => 'INT',
        																'unsigned' => TRUE,
                                                					    'auto_increment' => TRUE
        
        									 ),	
        									 'employee_item_charge_id' => array(
				        														 'type' =>'INT',
				                                               					 'unsigned' => TRUE
						        												),
        									 'employee_item_charge_amount_spent' => array(
				        														 'type' =>'DECIMAL',
				                                               					 'constraint' => '20,4'
						        												),
        									 'employee_item_charge_date' => array(
				        														 'type' =>'DATE'
						        												)
        									);
        									   
		$this->dbforge->add_key( 'employee_item_charge_cost_id' );      									
        $this->dbforge->add_key( 'employee_item_charge_id' );               
        $this->dbforge->add_field( $employees_item_charge_costs );    
        $result = $this->dbforge->create_table( 'employees_item_charge_costs' );
        
        
        
        
        
        $employee_working_sheet = array( 
        									'employee_work_sheet_id' => array(
				        														 'type' =>'INT',
				                                               					 'unsigned' => TRUE,
                                                 								 'auto_increment' => TRUE
						        												),
        									'employee_id' => array(
	        														 'type' =>'INT',
	                                               					 'unsigned' => TRUE
			        												),
        									'employee_work_sheet_date_start' => array(
				        														 'type' =>'DATE'
						        											),
        									'employee_work_sheet_date_end' => array(
				        														 'type' =>'DATE'
						        											),
        									'employee_work_sheet_work_time_total' => array(
				        														  'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
        									'employee_work_sheet_business_trip_time_total' => array(
				        														  'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
        									'employee_work_sheet_sick_time_total' => array(
				        														  'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
        									'employee_work_sheet_work_overtime_total' => array(
				        														 'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
						        			'employee_work_sheet_first_shift_time_total' => array(
				        														  'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
        									'employee_work_sheet_second_shift_time_total' => array(
				        														  'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
        									'employee_work_sheet_third_shift_time_total' => array(
				        														  'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
						        			'employee_work_sheet_first_shift_overtime_total' => array(
				        														  'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
        									'employee_work_sheet_second_shift_overtime_total' => array(
				        														  'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
        									'employee_work_sheet_third_shift_overtime_total' => array(
				        														 'type' =>'MEDIUMINT',
						        												 'unsigned' => TRUE
						        											),
        									'working_sheet_num_days_total' => array(
				        														 'type' =>'TINYINT',
						        												 'unsigned' => TRUE
						        											),
        									'working_sheet_work_days_total' => array(
				        														 'type' =>'TINYINT',
						        												 'unsigned' => TRUE
						        											),
        									'working_sheet_business_trip_days_total' => array(
				        														 'type' =>'TINYINT',
						        												 'unsigned' => TRUE
						        											),
        									'working_sheet_sick_days_total' => array(
				        														 'type' =>'TINYINT',
						        												 'unsigned' => TRUE
						        											),
        									'working_sheet_vacation_days_total' => array(
				        														 'type' =>'TINYINT',
						        												 'unsigned' => TRUE
						        											),
        									'working_sheet_not_working_days_total' => array(
				        														 'type' =>'TINYINT',
						        												 'unsigned' => TRUE
						        											),
        									);
        									
        $this->dbforge->add_key( 'employee_work_sheet_id', TRUE );               
        $this->dbforge->add_field( $employee_working_sheet );    
        $result = $this->dbforge->create_table( 'employee_work_sheet' );
        
        
         $employees_work_days = array( 
         									
        									'employee_work_day_id' => array(
			        														 'type' =>'BIGINT',
			                                               					 'unsigned' => TRUE,
                                                							 'auto_increment' => TRUE
					        												),
        									'employee_work_sheet_id' => array(
				        														 'type' =>'INT',
				                                               					 'unsigned' => TRUE
						        												),
        									'employee_work_day_type' => array(
				        														 'type' =>'TINYINT',
				                                               					 'unsigned' => TRUE
						        												),
        									'employe_work_day_date' => array(
				        														 'type' =>'DATE'
						        											),
        									'employe_work_day_day' => array(
				        														 'type' =>'TINYINT',
						        												 'unsigned' => TRUE
						        											),
        									'employe_work_day_wage' => array(
				        														 'type' =>'DECIMAL',
						        												 'constraint' => '20,2'
						        											),
        									'employee_work_day_first_shift' => array(
				        														 'type' =>'TINYINT',
				                                               					 'unsigned' => TRUE
						        											),
        									'employee_work_day_second_shift' => array(
				        														 'type' =>'TINYINT',
				                                               					 'unsigned' => TRUE
						        											),
        									'employee_work_day_third_shift' => array(
				        														 'type' =>'TINYINT',
				                                               					 'unsigned' => TRUE
						        											),
						        			'employee_work_day_first_shift_start' => array(
				        														 'type' =>'TIME'
						        											),
						        			'employee_work_day_first_shift_end' => array(
				        														 'type' =>'TIME'
						        											),
						        			'employee_work_day_second_shift_start' => array(
				        														 'type' =>'TIME'
						        											),
						        			'employee_work_day_second_shift_end' => array(
				        														 'type' =>'TIME'
						        											),
						        			'employee_work_day_third_shift_start' => array(
				        														 'type' =>'TIME'
						        											),
						        			'employee_work_day_third_shift_end' => array(
				        														 'type' =>'TIME'
						        											),
						        			'employee_work_day_first_shift_overtime' => array(
				        														 'type' =>'TIME'
						        											),			
						        			'employee_work_day_second_shift_overtime' => array(
				        														 'type' =>'TIME'
						        											),			
						        			'employee_work_day_third_shift_overtime' => array(
				        														 'type' =>'TIME'
						        											)			
						        											
        									);

		$this->dbforge->add_key( 'employee_work_day_id', TRUE );          									
        $this->dbforge->add_key( 'employee_working_sheet_id' );               
        $this->dbforge->add_field( $employees_work_days );    
        $result = $this->dbforge->create_table( 'employees_work_days' );
        
        
        
        
       	$employees_working_scenario = array( 
        									'employee_working_scenario_id' => array(
				        														 'type' =>'INT',
				                                               					 'unsigned' => TRUE,
                                                 								 'auto_increment' => TRUE
						        												),
        									
        									'employee_working_scenario_name' => array(
				        														 'type' =>'VARCHAR',
						        												 'constraint' => 50
						        											)
        									);
        									
        $this->dbforge->add_key( 'employees_working_scenario_id', TRUE  );               
        $this->dbforge->add_field( $employees_working_scenario );    
        $this->dbforge->create_table( 'employees_working_scenario' );
        
       	$employees_working_scenario_details = array( 
        									'employees_working_scenario_day_id' => array(
				        														 'type' =>'INT',
				                                               					 'unsigned' => TRUE,
                                                 								 'auto_increment' => TRUE
						        												),
        									
        									'employees_working_scenario_id' => array(
				        														 'type' =>'INT',
				                                               					 'unsigned' => TRUE
						        											),
        									'employees_working_scenario_day' => array(
				        														 		'type' =>'TINYINT',
						        														'unsigned' => TRUE
						        														),
        									'employees_working_scenario_day_type' => array(
				        														 		'type' =>'TINYINT',
						        														'unsigned' => TRUE,
						        														'default' => 1
						        														),
        									'employees_working_scenario_day_first_shift' => array(
				        														 			'type' =>'TINYINT',
						        															'unsigned' => TRUE,
						        															'default' => 0
						        														),
        									'employees_working_scenario_day_second_shift' => array(
				        														 			'type' =>'TINYINT',
						        															'unsigned' => TRUE,
						        															'default' => 0
						        														),
        									'employees_working_scenario_day_third_shift' => array(
				        														 			'type' =>'TINYINT',
						        															'unsigned' => TRUE,
						        															'default' => 0
						        														),
        									'employees_working_scenario_first_shift_start' => array(
				        														 'type' =>'TIME'
						        														),
        									'employees_working_scenario_first_shift_end' => array(
				        														 'type' =>'TIME'
						        														),
        									'employees_working_scenario_second_shift_start' => array(
				        														 'type' =>'TIME'
						        											),
        									'employees_working_scenario_second_shift_end' => array(
				        														 'type' =>'TIME'
						        											),
						        											
        									'employees_working_scenario_third_shift_start' => array(
				        														 'type' =>'TIME'
						        											),
						        											
        									'employees_working_scenario_third_shift_end' => array(
				        														 'type' =>'TIME'
						        											)
        									);
        									
        									
        $this->dbforge->add_key( 'employees_working_scenario_day_id', TRUE  );               
        $this->dbforge->add_field( $employees_working_scenario_details );    
        $result = $this->dbforge->create_table( 'employees_working_scenario_details' );
       
        
        $employee_costs_and_stimulations = array( 
        
        									'employee_costs_and_stimulations_id' => array(
							        														 'type' =>'INT',
							                                               					 'unsigned' => TRUE,
			                                                 								 'auto_increment' => TRUE
						        												),
        									'employee_id' => array(
	        														 'type' =>'INT',
	                                               					 'unsigned' => TRUE
		        											),
        									
        									'employee_costs_and_stimulations_year' => array(
							        														 'type' =>'MEDIUMINT',
									        												 'unsigned' => TRUE
						        													),
        									
        									'employee_costs_and_stimulations_month' => array(
						        														 	'type' =>'MEDIUMINT',
								        												 	'unsigned' => TRUE
								        											),
						        											
        									'employee_costs_and_stimulations_phone_limit' => array(
									        														 'type' =>'DECIMAL',
											        												 'constraint' => '20,4'
											        												 
											        											),
											        											
        									'employee_costs_and_stimulations_phone_cost' => array(
									        														 'type' =>'DECIMAL',
											        												 'constraint' => '20,4'
											        												 
											        											),
											        											
        									'employee_costs_and_stimulations_phone_total' => array(
									        														 'type' =>'DECIMAL',
											        												 'constraint' => '20,4'
											        												 
											        										),
						        											
        									'employee_costs_and_stimulations_internet_limit' => array(
									        														 'type' =>'DECIMAL',
											        												 'constraint' => '20,4'
						        												 
						        																),
						        											
        									'employee_costs_and_stimulations_internet_cost' => array(
								        														 		'type' =>'DECIMAL',
										        												 		'constraint' => '20,4'
										        											),
						        											
        									'employee_costs_and_stimulations_internet_total' => array(
										        														 'type' =>'DECIMAL',
												        												 'constraint' => '20,4'
						        												
						        															 ),
						        											
        									'employee_costs_and_stimulations_car_amortization_limit' => array(
										        														 'type' =>'DECIMAL',
												        												 'constraint' => '20,4'
												        												 
												        											),
						        											
        									'employee_costs_and_stimulations_car_amortization_cost' => array(
										        														 'type' =>'DECIMAL',
												        												 'constraint' => '20,4'
						        												 
						        																	),
						        											
        									'employee_costs_and_stimulations_car_amortization_total' => array(
										        														 'type' =>'DECIMAL',
												        												 'constraint' => '20,4'
												        												 
												        											),
						        											
        									'employee_costs_and_stimulations_gas_limit' => array(
								        														 'type' =>'DECIMAL',
										        												 'constraint' => '20,4'
										        										),
						        											
        									'employee_costs_and_stimulations_gas_cost' => array(
							        														 	'type' =>'DECIMAL',
									        												 	'constraint' => '20,4'
									        											),
						        											
        									'employee_costs_and_stimulations_gas_total' => array(
								        														 'type' =>'DECIMAL',
										        												 'constraint' => '20,4'
										        											),
						        			'employee_costs_and_stimulations_bonus_type' => array(
									        														 'type' =>'TINYINT',
											        												 'unsigned' => TRUE
											        											),
											        											
											'employee_costs_and_stimulations_penalty_type' => array(
									        														 'type' =>'TINYINT',
											        												 'unsigned' => TRUE
											        											),
											        											        																			
        									'employee_costs_and_stimulations_bonus_number' => array(
									        														 'type' =>'DECIMAL',
											        												 'constraint' => '20,4',
											        												 'default' => 0
											        											),
						        											
        									'employee_costs_and_stimulations_bonus_percent' => array(
									        														 'type' =>'TINYINT',
											        												 'unsigned' => TRUE,
											        												 'default' => 0
											        											),
						        											
        									'employee_costs_and_stimulations_penalty_number' => array(
									        														 'type' =>'DECIMAL',
											        												 'constraint' => '20,4',
											        												 'default' => 0
											        										),
											        										
											'employee_costs_and_stimulations_penalty_percent' => array(
									        														 'type' =>'TINYINT',
											        												 'unsigned' => TRUE,
											        												 'default' => 0
											        											),
											        																	        											
        									'employee_costs_and_stimulations_limit_total' => array(
								        														 	'type' =>'DECIMAL',
										        												 	'constraint' => '20,4',
											        												'default' => 0
										        											),
						        											
        									'employee_costs_and_stimulations_cost_total' => array(
				        														 					'type' =>'DECIMAL',
						        												 					'constraint' => '20,4',
										        													'default' => 0
						        														),	
						        											
        									'employee_costs_and_stimulations_total_total' => array(
				        														 					'type' =>'DECIMAL',
						        												 					'constraint' => '20,4',
						        																	'default' => 0
						        														)	
						        											
        									);

 		
        $this->dbforge->add_key( 'employee_costs_and_stimulations_id', TRUE  );  
        $this->dbforge->add_key( 'employee_id' );               
        $this->dbforge->add_field( $employee_costs_and_stimulations );    
		$result = $this->dbforge->create_table( 'employee_costs_and_stimulations' );
		
		return $result;
				
	}
	
	public function uninstall()
	{
		$this->dbforge->drop_table( 'employees' );
		$this->dbforge->drop_table( 'employee_economics' );
		$this->dbforge->drop_table( 'employees_working_scenario' );
		$this->dbforge->drop_table( 'employees_working_scenario_details' );
		$this->dbforge->drop_table( 'employees_work_days' );
		$this->dbforge->drop_table( 'employee_working_sheet' );
		$this->dbforge->drop_table( 'employees_item_charge_costs' );
		$this->dbforge->drop_table( 'employee_item_charges' );
		$this->dbforge->drop_table( 'employee_costs_and_stimulations' );
	}
}

?>