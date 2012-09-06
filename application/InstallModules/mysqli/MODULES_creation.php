<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/ModuleCreationBase.php';

class MODULES_creation extends ModuleCreationBase 
{
	const MODULES_TABLE_NAME			= 'modules';
	const MODULE_ACTIONS_TABLE_NAME 	= 'module_actions';
	const MODULE_ACCESS_TABLE_NAME 		= 'module_access';
	
/*****************************
 * 
 * TABLE COLUMNS
 * 
 ****************************/
	
	public $client_key;
	public $module_id;
	public $module_name;
	public $logic_template;
	public $active;
	public $action_id;
	public $action_name;
	public $action_crud;
	public $is_public;
	
/********* END OF TABLE COLUMNS ***********/		
		
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->client_key	= new SaveColumnVo( 'client_key', DatabaseDataTypes::MYSQLI_CHAR, 36 );
		$this->module_id  	= new SaveColumnVo( 'module_id', DatabaseDataTypes::MYSQLI_INT );
		$this->module_name  = new SaveColumnVo( 'module_name', DatabaseDataTypes::MYSQLI_VARCHAR, 50);
		
		$this->logic_template  = new SaveColumnVo( 'logic_template', DatabaseDataTypes::MYSQLI_VARCHAR, 50 );
		
		$this->active		= new SaveColumnVo( 'active', DatabaseDataTypes::MYSQLI_TINYINT );
		
		$this->action_id	= new SaveColumnVo( 'id', DatabaseDataTypes::MYSQLI_INT );
		$this->action_id->primary			= TRUE;
		$this->action_id->autoIncrement	= TRUE;
	    $this->action_id->attribute		= DatabaseAttributes::MYSQLI_UNSIGNED;
	    
	    $this->action_name  = new SaveColumnVo( 'action_name', DatabaseDataTypes::MYSQLI_VARCHAR, 50 );
	    $this->action_crud  = new SaveColumnVo( 'action_crud', DatabaseDataTypes::MYSQLI_TINYINT );
	    $this->is_public  	= new SaveColumnVo( 'is_public', DatabaseDataTypes::MYSQLI_TINYINT);
		
	}
	
	public function create()
	{
		
		/************
		 * 
		 * MODULES
		 * 
		 * module_id
		 * module_name
		 * 
		 ****************/
				  
		// MODULES
		$modules			= new CreateTableVo( 
														self::MODULES_TABLE_NAME, 
														array( 
																$this->module_id, 
																$this->module_name
															  ),
														DatabaseEngineTypes::MYSQLI_InnoDB 
													);
													
		$modules_result	= $this->_table->createTable( $modules );
		
		$modules_result->status == BaseActiveRecord::STATUS_OK 
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
		
		/**********************
		 * 
		 * MODULE_ACTIONS
		 * 
		 * action_id
		 * module_id
		 * action_name
		 * action_crud
		 * 
		 ***********************/		  
		
		// MODULE ACTIONS
		$module_actions			= new CreateTableVo( 
														self::MODULE_ACTIONS_TABLE_NAME, 
														array( 
																$this->action_id, 
																$this->module_id, 
																$this->action_name,
																$this->action_crud
															  ),
														DatabaseEngineTypes::MYSQLI_InnoDB 
													);
													
		$module_actions_result	= $this->_table->createTable( $module_actions );
		
		$module_actions_result->status == BaseActiveRecord::STATUS_OK 
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
				  
		
		
		/**********************
		 * 
		 * MODULE_ACCESS
		 * 
		 * client_key
		 * module_id
		 * action_id
		 * is_public
		 * 
		 ***********************/	
						  
		// MODULE ACCESS
		$module_access			= new CreateTableVo( 
														self::MODULE_ACCESS_TABLE_NAME, 
														array( 
																$this->client_key,
																$this->module_id,
																$this->action_id,  
																$this->is_public
															  ),
														DatabaseEngineTypes::MYSQLI_InnoDB 
													);

		$module_access_result	= $this->_table->createTable( $module_access );
		
		$module_access_result->status == BaseActiveRecord::STATUS_OK 
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