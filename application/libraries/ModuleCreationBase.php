<?php if ( !defined('BASEPATH')) die();

require_once 'system/application/Interfaces/IModuleCreation.php';
require_once 'system/application/Factories/ConfigFactory.php';
require_once 'system/application/vos/TableGatewayVos/CreateTableVo.php';
require_once 'system/application/Factories/TableGatewayFactory.php';
require_once 'system/application/libraries/BusinessLogicBase.php';

abstract class ModuleCreationBase extends BusinessLogicBase implements IModuleCreation
{
	protected $_installed_tables;
	protected $_failed_tables;
	
	public  function __construct()
	{
		$this->_installed_tables 	= array();
		$this->_failed_tables 		= array();
		
	}
	
	public function initTable()
	{
		$this->_table = $this->_table_factory->TABLE_UTIL_GATEWAY();
	}
	
	public function getInstalledTables()
	{
		return $this->_installed_tables;
	}
	
	public function getFailedTables()
	{
		return $this->_failed_tables;
	}
	
	public function create()
	{
		// implemented in concrete class
	}
	
	public function isTemplateInstalled( $template )
	{
		
	}
	
	public function destroy()
	{
		// implemented in concrete class
	}
	
	public function copyDataFromTemplateToTemplate( $from_template, $to_template )
	{
		// implemented in concrete class
	}
}