<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/ModuleCreationInitializationBase.php';

class BusinessManager_USERS_creationInitialization extends ModuleCreationInitializationBase 
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
		// @TODO implement create method
		return FALSE;
	}
	
	public function destroy()
	{
		// @TODO implement destroy method
		return FALSE;
	}
	
	public function copyDataFromTemplateToTemplate( $from_template, $to_template )
	{
		// @TODO implement copyDataFromTemplateToTemplate method
	}
	
}
?>