<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/TableGatewayInterfaces/ITableUtilGateway.php';
require_once 'application/libraries/database/BaseTableGateway.php';
require_once 'application/vos/TableGatewayVos/TableGatewayReturnVo.php';


class TableUtilGateway extends BaseTableGateway implements ITableUtilGateway
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function &createTable( CreateTableVo $table )
	{
		$r = new TableGatewayReturnVo();
		
		$d = $this->_active_record->createTable( $table );
		
		if( $d === TRUE )
		{
			$r->errorCode = 0;
			$r->status = self::STATUS_OK;
		}
		else 
		{
			$r->errorCode = ErrorCodes::DATABASE_ERROR;
			$r->status = self::STATUS_ERROR;
			$r->message = $this->_active_record->getErrorMessage();
			
		}
		
		
		return $r;
	}
	
	public function &checkDatabaseExists( $name )
	{
		$r = new TableGatewayReturnVo();
		
		$d = $this->_active_record->checkDatabaseExists( $name );
		
		if( $d === TRUE )
		{
			$r->errorCode = 0;
			$r->status = BaseActiveRecord::STATUS_OK;
		}
		else if( $d === FALSE )
		{
			$r->errorCode = 0;
			$r->status = self::STATUS_NOT_FOUND;
		}
		else 
		{
			$r->errorCode = ErrorCodes::DATABASE_ERROR;
			$r->status =  $this->_active_record->getStatus();
			$r->message = $this->_active_record->getErrorMessage();
		}
		
		
		return $r;
	}
	
	
	public function &getTables()
	{
		$r = new TableGatewayReturnVo();
		
		$d = $this->_active_record->getTables();
		
		if( $d === TRUE )
		{
			$t = $this->_active_record->getResultAsArray();
			$tables = array();
			
			foreach( $t as $v )
			{
				foreach( $v as $k => $table )
				{
					array_push( $tables, $table );
				}
			}
		
			$r->errorCode = 0;
			$r->status = self::STATUS_OK;
		
			$r->result = $tables;
			
		}
		else if( $d === NULL )
		{
			$r->errorCode = 0;
			$r->status = self::STATUS_NOT_FOUND;
		}
		else
		{
			$r->errorCode = ErrorCodes::DATABASE_ERROR;
			$r->status = self::STATUS_ERROR;
			$r->message = $this->_active_record->getErrorMessage();
		}
		
		
		return $r;	
	}
	
	public function &createDatabase( DatabaseCreateVo $database )
	{
		
		$r = new TableGatewayReturnVo();
		
		$e = $this->_active_record->checkDatabaseExists( $database->name );
		
		
		if( $this->_active_record->getStatus() == BaseActiveRecord::STATUS_OK )
		{
			$r->errorCode = ErrorCodes::ALREADY_EXISTS;
			$r->status = self::STATUS_ALREADY_EXISTS;
			$r->message = 'Database: ' . $database->name . ' already exists!';
			
		}
		else if( $this->_active_record->getStatus() == BaseActiveRecord::STATUS_NOT_FOUND )
		{
			
			/*
			 * Database does not exists. We are free to create one with that name now
			 */
			
			$d = $this->_active_record->createDatabase( $database );
			
			if( $d === TRUE )
			{
				$r->errorCode = 0;
				$r->status = BaseActiveRecord::STATUS_OK;
			}
			else 
			{
				$r->errorCode = ErrorCodes::DATABASE_ERROR;
				$r->status = self::STATUS_ERROR;
				$r->message = $this->_active_record->getErrorMessage();
			}
		}
		else
		{
			$r->errorCode = ErrorCodes::DATABASE_ERROR;
			$r->status = BaseActiveRecord::STATUS_ERROR;
			$r->message = $this->_active_record->getErrorMessage();
		}
		
		return $r;
		
	}
	
	public function &truncateTable( $name )
	{
		
	}
	
	public function &dropTable( $name )
	{
		$r = new TableGatewayReturnVo();
	
		$d = $this->_active_record->dropTable($name);
		
		if( $d === TRUE )
		{
			$r->errorCode = 0;
			$r->status = self::STATUS_OK;
		}
		else 
		{
			$r->errorCode = ErrorCodes::DATABASE_ERROR;
			$r->status = self::STATUS_ERROR;
		}
		
		return $r;
	}
	
	public function &dropView( $name )
	{
		$r = new TableGatewayReturnVo();
	
		$d = $this->_active_record->dropView($name);
		
		if( $d === TRUE )
		{
			$r->errorCode = 0;
			$r->status = self::STATUS_OK;
		}
		else 
		{
			$r->errorCode = ErrorCodes::DATABASE_ERROR;
			$r->status = self::STATUS_ERROR;
		}
		
		return $r;
	}
	
	public function &dropDatabase( $name )
	{
		$r = new TableGatewayReturnVo();
		
		$d = $this->_active_record->dropDatabase($name);
		
		if( $d === TRUE )
		{
			$r->errorCode = 0;
			$r->status = self::STATUS_OK;
		}
		else 
		{
			$r->errorCode = ErrorCodes::DATABASE_ERROR;
			$r->status = self::STATUS_ERROR;
		}
		
		return $r;
	}
}

?>