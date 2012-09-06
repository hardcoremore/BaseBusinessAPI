<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Factories/DBDriverFactory.php';
require_once 'application/Factories/ConfigFactory.php';
require_once 'application/Interfaces/IActiveRecord.php';
require_once 'application/libraries/database/utility/DatabaseOperators.php';

 abstract class BaseActiveRecord implements IActiveRecord
 {
 	const STATUS_ERROR 				= 'databaseError';
 	const STATUS_WARNING 			= 'databaseWarning';
 	const STATUS_OK 				= 'databaseOk';
 	const STATUS_NOT_FOUND 			= 'queryNotFound';
 	const STATUS_NOT_CHANGED 		= 'notChanged';
 	const STATUS_ALREADY_EXISTS 	= 'alreadyExists';
 	const STATUS_UNKNOWN_ERROR 		= 'unknownError';
 	
 	
 	protected $_sql;
	protected $_pageCount;
	protected $_pageNumber;
	protected $_table_name = '';
	protected $_driver_factory;
	protected $_driver;
	protected $_isDriverLoaded;
	protected $_error_message;
	protected $_status;
	

	protected $_select_q;
	protected $_from_q;
	protected $_where_q;
	
	protected $_queries;
	
	public function __construct()
	{
		$this->_driver_factory = DBDriverFactory::getInstance();
		$this->_queries = array();
	}
	
	protected function _setStatus( $status )
	{
		if( strlen( $status ) > 0 )
		{
			$this->_status = $status;
			
			if( $this->_status == self::STATUS_ERROR || $this->_status == self::STATUS_WARNING )
			{
				log_message('error', "ACTIVE RECORD ERROR. Message:\n" . $this->getErrorMessage() . "\nSql: " .$this->getSql() );
			}
		}
	}
	
	public function &run( $sql = NULL )
	{
		
	}
	
	public function getTableName()
	{
		return $this->_table_name;
	}
	
	public function getStatus()
	{
		return $this->_status;
	}
	
 	public function setTableName( $name )
	{
		if( $this->checkDatabaseOrTableName( $name ) )
		{
			$this->_table_name = $name;
		}
		else
		{
			log_message('error', 'INVALID table name at BaseActiveRecord::setTableName()');
		}
	}
	
	/*
	public function fullTableName()
	{
		if( $this->_database_config )
		{
			return $this->_database_config->prefix . $this->_database_config->prefix_delimiter . $this->_table_name;
		}
		else
		{
			$this->_error_message = 'INVALID database config at BaseActiveRecord::fullTableName()';
			$this->_setStatus( BaseActiveRecord::STATUS_ERROR );
		}
	}
	*/
	
 	public function loadDriver()
	{
		
		if( ! $this->getDatabaseConfig() ) $this->setDatabaseConfig( ConfigFactory::DATABASE_CONFIG() );
		
		$this->_driver = $this->_driver_factory->getDriver( $this->getDatabaseConfig() );
		
		if( ! $this->_driver )
		{
			$this->_error_message = 'Database driver invalid at MysqliBaseTableGateway::loadDriver()' . 
				".\nDatabase config:\n" . print_r( $this->_database_config, true);
			
			$this->_setStatus( self::STATUS_ERROR );
		}
		else
		{
			$this->_isDriverLoaded = TRUE;
		}
		
	}
	
	public function reloadDriver( DatabaseConfigVo $config = NULL )
	{
		if( $config ) $this->setDatabaseConfig( $config );
		
		$this->_driver = NULL;
		$this->_isDriverLoaded = false;
		$this->loadDriver();
	}
	
 	public function &readFromVo( TableGatewayReadVo $read )
	{
		
		if( is_array( $read->columns ) &&  count( $read->columns ) > 0 )
		{
			$this->read( $read->columns, $read->distinct );
		}
		else 
		{
			$this->readAll();
		}
		
		if( $read->tableWhereReadVo )
		{
			$this->whereSimple( $tableWhereReadVo );
		}
		
		if( is_array( $read->orderByVos ) && count( $read->orderByVos ) > 0 )
		{
			$this->orderBy( $read->orderByVos );
		}
		
		if( $read->page )
		{
			$this->limit( $page );
		}
		
		return $this;
	}
	
	public function setDatabaseConfig( DatabaseConfigVo $config )
	{
		$this->_database_config = $config;
	}
	
	public function getDatabaseConfig()
	{
		return $this->_database_config;
	}
	
	public function isDriverLoaded()
	{
		return $this->_isDriverLoaded;
	}
	
 	public function &checkValueExists( ColumnVo $column )
	{
		$r = NULL;
		
		// reset error message before every operation
		$this->_error_message = NULL;
		
		if( ! $column || ! $column->name || ! $column->value )
		{
			$this->_error_message = '$column is  invalid at MysqlBaseTableGateway::checkValueExists()';
			$this->_setStatus( self::STATUS_ERROR );
			
			return $r;
		}
		
		
		$w = new TableWhereVo( $column );
		$tr = new TableWhereReadVo( array( $w ) );
		
		$this->readAll()->whereSimple( $tr )->run();
		
		if( $this->_status != self::STATUS_ERROR )
		{
			$r = $this->numRows();
		}
		
		return $r;
	}
	
	public function getSql()
	{
		return $this->_sql;
	}
	
	public function calculateOffset( $pageNumber, $limit )
	{
		if( !$pageNumber || $pageNumber == 0 ) $pageNumber = 1;
		
		return  ( $pageNumber - 1 )  *  $limit;
	}
	
	public function getErrorMessage()
	{
		return $this->_error_message;
	}
	
 }

?>