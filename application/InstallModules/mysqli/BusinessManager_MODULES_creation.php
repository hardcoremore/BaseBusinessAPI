<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/ModuleCreationBase.php';
require_once 'system/application/InstallModules/default/mysqli/MODULES_creation.php';

class BusinessManager_MODULES_creation extends MODULES_creation 
{
	
	const CLIENT_MODULES_TABLE_NAME 	= 'client_modules';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function create()
	{
		
		if( parent::create() )
		{
			/**********************
			 * 
			 * CLIENT_MODULES
			 * 
			 * client_key
			 * module_id
			 * module_name
			 * template
			 * active
			 * 
			 ***********************/
			
			// CLIENT MODULES
			$client_modules	= new CreateTableVo( 
												   self::CLIENT_MODULES_TABLE_NAME, 
												   array( 
												   			$this->client_key, 
												   		 	$this->module_id,
												   		 	$this->module_name, 
												   		  	$this->logic_template, 
												   		  	$this->active 
												   		), 
												   DatabaseEngineTypes::MYSQLI_InnoDB 
												);
	
												
			$client_modules_result	= $this->_table->createTable( $client_modules );
			
			$client_modules_result->status == BaseActiveRecord::STATUS_OK 
			? 
			array_push( 
						$this->_installed_tables, 
						$this->_table->getActiveRecord()->fullTableName()
					  )
			:
			array_push( 
						$this->_failed_tables, 
						$this->_table->getActiveRecord()->fullTableName() 
					  );
			
					  
			///////////////////////////////////////////////////////
			//
			//  CHECK TO SEE IF OPERATION WAS SUCCESSFUL
			//
			///////////////////////////////////////////////////////
			
			if( count( $this->_failed_tables ) == 0 )
			{
				return TRUE;
			}
			else 
			{
				return FALSE;
			}
		}
		else 
		{
			return FALSE; //parent create didn't return true
		}
	}
	

	public function destroy()
	{
		// @TODO implement destroy method
		
	}
	
	public function copyDataFromTemplateToTemplate( $from_template, $to_template )
	{
		// @TODO implement copyDataFromTemplateToTemplate method
	}
}


?>