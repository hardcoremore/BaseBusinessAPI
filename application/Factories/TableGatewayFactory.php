<?php if( !defined( 'BASEPATH') ) die( "Direct Script Access Denied" );

require_once 'application/vos/DatabaseConfigVo.php';
require_once 'application/Factories/ConfigFactory.php';
require_once 'application/libraries/FactoryBase.php';

class TableGatewayFactory extends FactoryBase
{ 
	private $__database_config;
	
	public function __construct()
	{
		parent::__construct();
	}

	public function setDatabaseConfig( DatabaseConfigVo &$database )
	{
		$this->__database_config = $database;
	}
	
	public function getDatabaseConfig()
	{
		return $this->__database_config;
	}
	
	public function &TABLE_UTILITIES()
	{
		$i = $this->get_table_instance( 'TableUtilGateway', $t );
		
		return $i;
	}
	
	public function &USERS()
	{
		$i = $this->get_table_instance( 'UsersTableGateway' );
		
		return $i;
	}
	
	public function &CLIENT_MODULES()
	{
		$i = $this->get_table_instance( 'ClientModulesTableGateway' );
		
		return $i;
	}
	
	public function &PARTNERI()
	{
		$i = $this->get_table_instance( 'PartneriTableGateway' );
		
		return $i;
	}
	
	public function &CLIENTS()
	{
		$i = $this->get_table_instance( 'ClientsTableGateway' );
		
		return $i;
	}
	
	public function &TICKETS()
	{
		$i = $this->get_table_instance( 'TicketsTableGateway' );
		
		return $i;
	}
	
	public function &DESKTOP()
	{
		$i = $this->get_table_instance( 'DesktopTableGateway' );
		
		return $i;
	}
	
	public function &ICON()
	{
		$i = $this->get_table_instance( 'IconTableGateway' );
		
		return $i;
	}
	
	public function &PRIVILEGES()
	{
		$i = $this->get_table_instance( 'PrivilegesTableGateway' );
		
		return $i;
	}
	
	public function &get_table_instance( $class_name )
	{
		$inst = NULL;
		
		if( ! class_exists( $class_name ) )
		{
			$file_name = $class_name . EXT;
			
			(string) $full_path = '';//$this->getDatabaseConfig()->table_path . $file_name;

			if( file_exists( $full_path  ) )
			{
				require_once $full_path;
			}
			else
			{
				log_message( 'error', "Class NOT found at TableGatewayFactory::get_table_instance(). FullPath: " . $full_path );
				return $inst;
			}	
		}
		
		$inst = new $class_name();
		
		$db =  clone $this->getDatabaseConfig();
		
		if( $inst->database() != BaseTableGateway::DATABASE_NAME_DEFAULT )
		{
			$db->database = $this->session()->get( PreController::SYSTEM_SESSION_NAME_SPACE, PreController::SYSTEM_USER_DATABASE_SESSION_NAME );
		}
		
		$inst->getActiveRecord()->setDatabaseConfig( $db );
		
		return $inst;
	}
}

?>