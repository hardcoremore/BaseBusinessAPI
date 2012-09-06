<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/ModuleCreationInitializationBase.php';

class PRIVILEGES_creationInitialization extends ModuleCreationInitializationBase 
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function init( &$key, ApplicationConfigVo &$app_config, DatabaseConfigVo &$db_config  )
	{
		parent::init( $key, $app_config, $db_config );	
	}
	
	public function create()
	{
	
		$idc 					= new SaveColumnVo( 'id', DatabaseDataTypes::MYSQLI_SMALLINT );
		$idc->autoIncrement 	= TRUE;
		$idc->primary 			= TRUE;
		$idc->attribute 		= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$namec 					= new SaveColumnVo( 'name', DatabaseDataTypes::MYSQLI_VARCHAR, 100 );
		
		$acg_table 				= new CreateTableVo( 'acg', array( $idc, $namec ), DatabaseEngineTypes::MYSQLI_InnoDB );											 	
		$acg_table_result 		= $this->_table->createTable( $acg_table );
		
		
		$acg_id 				= new SaveColumnVo( 'acg_id', DatabaseDataTypes::MYSQLI_TINYINT );
		$acg_id->index 			= TRUE;
		$acg_id->attribute  	= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$module_id 				= new SaveColumnVo( 'module_id', DatabaseDataTypes::MYSQLI_SMALLINT );
		$module_id->attribute 	= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$action_id 				= new SaveColumnVo( 'action_id', DatabaseDataTypes::MYSQLI_TINYINT );
		$action_id->attribute 	= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$acgl_table				= new CreateTableVo( 'acgl', array( $acg_id, $module_id, $action_id ), DatabaseEngineTypes::MYSQLI_InnoDB );
		$acgl_table_result 		= $this->_table->createTable( $acgl_table );
	
		
		$user_id 				= new SaveColumnVo( 'user_id', DatabaseDataTypes::MYSQLI_SMALLINT );
		$user_id->index 		= TRUE;
		$user_id->attribute 	= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$access 				= new SaveColumnVo( 'access', DatabaseDataTypes::MYSQLI_TINYINT );
		$access->attribute 		= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$acl_table				= new CreateTableVo( 'acl', array( $user_id, $module_id, $action_id, $access ), DatabaseEngineTypes::MYSQLI_InnoDB );								
		$acl_table_result 		= $this->_table->createTable( $acl_table );
			
		
		$acgl_view  = "CREATE VIEW " . $this->_db_config->prefix . "acgl_view AS";
		$acgl_view  = "SELECT " . $acgl_table->name . ".*, appdata.*, appdata.module_actions.action_name
										FROM ".$acgl_table->name."
										INNER JOIN appdata.client_modules ON ".$acgl_table->name.".module_id = appdata.client_modules.module_id 
										INNER JOIN appdata.module_actions ON ".$acgl_table->name.".action_id = appdata.module_actions.id
										WHERE appdata.client_modules.client_key = '". $this->_key ."' &&
										   	  appdata.client_modules.active = '1'";
		
		/*
		SELECT acgl.*, modules.*, module_actions.action_name
										FROM acgl
										INNER JOIN modules ON acgl.module_id = modules.id 
										INNER JOIN module_actions ON acgl.action_id = module_actions.id
										WHERE acg_id = '".$this->userInfo['acg']."'
										ORDER BY modules.name ASC
										
										
		
										SELECT acl.*, modules.* ,  module_actions.action_name
										   FROM acl 
										   INNER JOIN modules ON acl.module_id = modules.id
										   INNER JOIN module_actions ON acl.action_id = module_actions.id
										   WHERE user_id = '".$this->userInfo['id']."'"
										   
			*/							   
										   
		$acl_view	 = "CREATE VIEW " . $this->_db_config->prefix . "acl_view AS ";
		$acl_view	.= "SELECT ".$acl_table->name.".*, appdata.client_modules.* ,  appdata.module_actions.action_name
										   FROM ".$acl_table->name." 
										   INNER JOIN appdata.client_modules ON ".$acl_table->name.".module_id = appdata.client_modules.module_id
										   INNER JOIN appdata.module_actions ON ".$acl_table->name.".action_id = appdata.module_actions.id
										   WHERE appdata.client_modules.client_key = '". $this->_key ."' &&
										   		 appdata.client_modules.active = '1'";
		
		if( 
			$acg_table_result->status  		== BaseTableGateway::STATUS_OK && 
			$acgl_table_result->status 		== BaseTableGateway::STATUS_OK && 
			$acl_table_result->status  		== BaseTableGateway::STATUS_OK 
			//$modules_table_result->status 	== BaseTableGateway::STATUS_OK &&
			//$modules_actions_result->status == BaseTableGateway::STATUS_OK
		  )
		{
			
			return TRUE;
			
			// clone does not work for $this->table->run();
			//$acgl_view_error = clone $this->table->run( $acgl_view )->getErrorMessage();
			//$acl_view_error = clone  $this->table->run( $acl_view )->getErrorMessage();
						
			if( 
				$acgl_view_error == NULL &&
				$acl_view_error == NULL
			  )
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
			return FALSE;
		}
	}
	
	public function destroy()
	{
		$destroyAcgTable 			= 	$this->table->dropTable( $this->_db_config->prefix . 'acg' );
		$destroyAcglTable 			= 	$this->table->dropTable( $this->_db_config->prefix . 'acgl' );
		$destroyAclTable 			= 	$this->table->dropTable( $this->_db_config->prefix . 'acl' );
		$destroyModulesTable 		= 	$this->table->dropTable( $this->_db_config->prefix . 'modules' );
		$destroyModuleActionsTable	= 	$this->table->dropTable( $this->_db_config->prefix . 'module_actions' );
		
		$destroyAclView 	= $this->table->dropView( $this->_db_config->prefix . 'acgl_view' );
		$destroyAcglView	= $this->table->dropView( $this->_db_config->prefix . 'acl_view' );
		
		if( 
			$destroyAcgTable->status			== 	BaseTableGateway::STATUS_OK	&&
			$destroyAcglTable->status			== 	BaseTableGateway::STATUS_OK	&& 
			$destroyAclTable->status			== 	BaseTableGateway::STATUS_OK	&&
			$destroyModulesTable->status		== 	BaseTableGateway::STATUS_OK	&&
			$destroyModuleActionsTable->status	== 	BaseTableGateway::STATUS_OK &&
			$destroyAclView						== 	BaseTableGateway::STATUS_OK &&
			$destroyAcglView					== 	BaseTableGateway::STATUS_OK 
		  )
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	public function copyDataFromTemplateToTemplate( $from_template, $to_template )
	{
		
	} 
}


?>