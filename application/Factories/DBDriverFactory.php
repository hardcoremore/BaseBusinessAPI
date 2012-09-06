<?php if( !defined( 'BASEPATH') ) die();

require_once 'application/vos/DatabaseConfigVo.php';
require_once 'application/libraries/database/utility/DatabaseDrivers.php';

class DBDriverFactory extends FactoryBase
{
	private static $__instance;
	
	public function __construct()
	{
		parent::__construct();
		
	}

	protected function &createMysqliDriver( DatabaseConfigVo &$config )
	{
		$ca =& $this->load->_ci_object_to_array( $config );
		$driver = $this->load->database( $ca, true );
		return $driver;
	}
	
	protected function &createOracleDriver( DatabaseConfigVo $config )
	{
		
	}
	
	protected function &createXMLDriver( DatabaseConfigVo $config )
	{
		
	}
	
	public function getDriver( DatabaseConfigVo $config )
	{
		switch( $config->dbdriver )
		{
			
			case DatabaseDrivers::MYSQLI_DRIVER:
				return $this->createMysqliDriver( $config );
				break;
				
			case DatabaseDrivers::ORACLE_DRIVER:
				return $this->createOracleDriver( $config );
				break;
			
			case DatabaseDrivers::XML_DRIVER:
				return $this->createXMLDriver( $config );
				break;
				
			default:
				log_message('error', 'Driver INVALID at DBDriverFactory::getDriver()');
				break;
			
		}
	}
	
	public function getDriverFromConfig()
	{
		return $this->getDriver( ConfigFactory::DATABASE_CONFIG() );
	}
	
	public static function &getInstance()
	{
		if( ! self::$__instance )
		{
			self::$__instance = new DBDriverFactory();		
		}
		
		return self::$__instance;
	}

}
?>