<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/InstallVo.php';
require_once 'system/application/vos/UserVo.php';

interface IModuleCreatorLogic
{
	
	/**
	 * 
	 * Installs, update or delete module depending on the $module->action property
	 * 
	 * @param ModuleVo $module
	 * 
	 * @return IDataHolder
	 * 
	 */
	function &installModule( ModuleVo $module  );
	
	/**
	 * 
	 * Check if module is already installed
	 * 
	 * @param ModuleVo $module
	 * 
	 * @return boolean
	 * 
	 */
	function &isModuleInstalled( ModuleVo $module );
	
	/**
	 * 
	 * Returns database conifg depending on the module if module are
	 * to be in separate databases or database servers
	 * 
	 * @param string $module
	 * 
	 * @return DatabaseConfigVo
	 * 
	 */
	function &getDatabaseConfigFromModule( ModuleVo $module );
}


?>