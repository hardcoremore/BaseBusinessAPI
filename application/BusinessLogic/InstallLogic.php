<?php if ( ! defined('BASEPATH') ) die();

require_once 'system/application/libraries/BusinessLogicBase.php';
require_once 'system/application/Interfaces/BusinessLogic/IInstallLogic.php';
require_once 'system/application/BusinessLogic/default/ModuleCreatorLogic.php';

class InstallLogic extends BusinessLogicBase implements IInstallLogic
{
	
	protected $_table;
	
	protected $_log_exists;
	
	protected $_module_creator_logic;
	
	protected $_install_config;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_install_config = ConfigFactory::INSTALLATION_CONFIG();
		
		$this->_module_creator_logic = new ModuleCreatorLogic();
	}

	public function init()
	{
		parent::init();
	}

	public function initTable()
	{
		$this->_table = $this->_table_factory->TABLE_UTILITIES();
	}

	public function initSpecification()
	{
		
	}
	
	public function &install( InstallVo $install )
	{
		
		if(  $install->key  == '24d299b9-7136-102e-8945-a5392c337dda' )
		{
			
			$app_db = $this->_table->createDatabase( new DatabaseCreateVo( ConfigFactory::DATABASE_CONFIG() ) );
			
			if( $app_db->status == BaseActiveRecord::STATUS_OK )
			{
				echo 'install ok';
			}
			else
			{
				echo 'install error';
			}
		}
		
		
		return $this->_data_holder;
	}
	
	public function isAppInstalled()
	{
		$db = $this->_table->checkDatabaseExists( ConfigFactory::DATABASE_CONFIG()->database )->status;
		$log = file_exists( 'INSTALLATION_LOG.php' );
		
		if( $db == BaseActiveRecord::STATUS_OK && $log )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function &installModules( $modules )
	{
		$var = '';
		return $var;
	}
	
	public function &loadPublicModules( $key )
	{
		
	}
	
	public function &createAdmin( UserVo $user )
	{
		
	}
	
	public function &status()
	{

		$installation = $this->checkInstallation();

		$data = array();
		$message = '';
		
		@include 'INSTALLATION_LOG.php';
		
		if( $installation === TRUE )
		{
			$message = "Application installed successfully";
		}
		else if( $installation === FALSE )
		{
			$message = "Application installed partially. Remove all files and databases manually!";	
		}	
		else if( $installation === NULL )
		{
			$message = "Application is not installed!";
		}
			
		
		
		if( $this->_log_exists )
		{
			$data['installation_time'] = date( 'Y:m:d H:i:s', $installation_time );
			$data['installation_template'] = $installation_template;
			$data['installed_tables'] = $installed_tables;
			$data['installed_modules'] = $installed_modules;
			$this->_data_holder->data()->setData( $data );
		}
		
		
		$this->_data_holder->metadata()->setStatus( self::STATUS_OK );
		$this->_data_holder->metadata()->setMessage( $message );
		$this->_data_holder->metadata()->setErrorCode(0);
		
		return $this->_data_holder;
	}
	
	private function __checkInstallation()
	{
		
		
	}

}

?>