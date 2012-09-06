<?php if ( !defined('BASEPATH')) die();

require_once 'system/application/Interfaces/BusinessLogic/IModuleCreatorLogic.php';

class ModuleCreatorLogic extends BusinessLogicBase implements IModuleCreatorLogic
{	
	protected $_module_creation;
	
	protected $_spec;
	
	private $__database_config;
	
	public function __construct()
	{
		parent::__construct();
		$this->_database_config = ConfigFactory::DATABASE_CONFIG();
	}
	
	public function &installModule( ModuleVo $module  )
	{
		if( $this->_spec->installModule( $module ) )
		{
			$this->_createModuleInstaller( $module->name, $module->template );
			
			if( $this->_module_creation )
			{
				$r = $this->_module_creation->create();
			}
		}
		else 
		{
//			@TODO invalid input error			
		}
		
	}
	
	public function &isModuleInstalled( ModuleVo $module )
	{
		
	}
	
	public function &getDatabaseConfigFromModule( ModuleVo $module )
	{
		
	}
	
	public function initSpecification()
	{
		$this->_spec = new ClientModuleSpecification();
	}
	
	public function overrideDatabaseConfig( DatabaseConfigVo $database )
	{
		$this->_database_config = $database;
	}
	
	protected function &_createModuleInstaller( $module_name, $template )
	{
		( string ) $class_name = strtoupper( $module_name ) . '_creation';
		
		if( $template != 'default' )
		{
			$class_name =  $template . '_' . $class_name;
		}
		
		(string) $file_name  = $class_name . EXT;
		(string) $full_path  = $this->_path . $template . '/' . $this->_database_config->dbdriver . '/' . $file_name;
		
		@require_once $full_path;
		
		if( class_exists( $class_name ) )
		{
			$this->_module_creation = new $class_name();
			return true;
		}
		else
		{
			log_message('debug', "Error occured at ModuleCreator::getInitializatorClass(). \n\t\t Class: " . $class_name . 
						" could not be loaded. Module name :" . $module_name . "\n. Module template: " . $template );
		}
		
		return false;
	}
}