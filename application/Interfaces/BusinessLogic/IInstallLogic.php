<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/InstallVo.php';
require_once 'system/application/vos/UserVo.php';

interface IInstallLogic
{
	/**
	 * 
	 * Installs application. Creates databases and installation log files
	 * 
	 * @param InstallVo $install
	 * 
	 * @return IDataHolder
	 * 
	 */
	function &install( InstallVo $install  );
	
	/**
	 * 
	 * Check to see if application is already installed
	 * 
	 * @param none
	 * 
	 * @return bool if application is installed false otherwise
	 * 
	 */
	function isAppInstalled();
	
	/**
	 * 
	 * Creates, update and deletes module for the application.
	 * 
	 * @param ModuleVo $module  to install, update or delete
	 * 
	 * @return IDataHolder
	 * 
	 */
	function &installModule( ModuleVo $module );
	
	/**
	 * 
	 * Load publicly available modules
	 * 
	 * @param string $key key of the client that has public modules
	 * 
	 * @return IDataHolder
	 * 
	 */
	function &loadPublicModules( $key );
	
	/**
	 * 
	 * Returns right database config from module
	 * 
	 * @param ModuleVo $module  to install, update or delete
	 * 
	 * @return IDataHolder
	 * 
	 */
	function &getDatabaseConfigFromModule( ModuleVo $module );
	
	/**
	 * 
	 * Returns right application config from module
	 * 
	 * @param ModuleVo $module  to install, update or delete
	 * 
	 * @return IDataHolder
	 * 
	 */
	function &getApplicationConfigFromModule( ModuleVo $module );
	
	/**
	 * 
	 * Displays the status of installed application
	 * 
	 * @param none
	 * 
	 * @return IDataHolder
	 * 
	 */
	function &status();
}


?>