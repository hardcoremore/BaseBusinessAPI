<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/Interfaces/TableGatewayInterfaces/IClientModulesTableGateway.php';
require_once 'system/application/libraries/MysqliBaseTableGateway.php';

class ClientModulesTableGateway extends MysqliBaseTableGateway implements IClientModulesTableGateway
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table_name = 'client_modules';
	}
	
	public function &readClientModules( TableGatewayReadVo $read )
	{

	}
	
	public function &readAllClientModules( $client_key )
	{
		$r = new TableGatewayReturnVo();
		
		$key = $this->escape( trim( $client_key ) );
		
		$key_column = new ColumnVo('client_key', $key );
		
		$wk = new TableWhereVo( $key_column );
		
		$wr = new TableWhereReadVo( array( $wk ) );
		
		$q = $this->readAll()->whereSimple( $wr )->run()->getResultAsArray();
		
		
		if( $q !== NULL && ! $this->getErrorMessage() )
		{	
			if( $this->numRows() > 0  )
			{
				$r->errorCode = 0;
				$r->status = self::STATUS_OK;
				$r->result = $q;
			}
			else
			{
				$r->status = self::STATUS_NOT_FOUND;
				$r->errorCode = 0;
			}
			
		}
		else
		{
			
			log_message( 'error', 'mysqli/ClientModulesTableGateway::readAllClientModules() ErrorOcurred. ErrorMessage: ' . $this->getErrorMessage() );
				
			$r->status = self::STATUS_ERROR;
			$r->errorCode =  ErrorCodes::DATABASE_ERROR ;
			$r->message =  $this->getErrorMessage();
			
		}
		
		
		return $r;
	}

	public function &readActiveModules( $client_key )
	{
		return $this->_readActiveInactiveModules( $client_key, 1 );
	}
	
	public function &readInactiveModules( $client_key )
	{
		return $this->_readActiveInactiveModules( $client_key, 0 );
	}
	
	public function &createClientModule( ClientModuleVo $c_module )
	{
		$k 	= new ColumnVo( 'client_key'	, $this->escape( $c_module->client_key 	));
		$m 	= new ColumnVo( 'module_id'		, $this->escape( $c_module->module_id		));
		$t 	= new ColumnVo( 'template_id'	, $this->escape( $c_module->template_id	));
		$a 	= new ColumnVo( 'active'		, $this->escape( $c_module->active			));

		$already_exists = FALSE;
		$exists = $this->_checkClientModuleExists( $k, $m );
		
		if( $exists > 0 )
			$already_exists = TRUE;
			
		$r = new TableGatewayReturnVo();
			
		// check if values are not unique	
		if( $already_exists )
		{
			$r->status =  self::STATUS_ALREADY_EXISTS;
			$r->errorCode = 0;
			$r->alreadyExistsFields = array($m);
		}
		else
		{
		
			$create = $this->create( array( $k, $m, $t, $a ) );
						
			if( $create === TRUE )
			{
				$r->status = self::STATUS_OK;
				$r->errorCode = 0; 
			}
			else if( $create === FALSE   ) 
			{
				$r->status = self::STATUS_UNKNOWN_ERROR;
				log_message('debug', 'Failure occured at ClientModulesTableGateway::createClientModule(). No error message to display');
			}
			else if( $create ===  NULL )
			{
				$r->status 		=  self::STATUS_ERROR;
				$r->errorCode 	=  ErrorCodes::DATABASE_ERROR;
				$r->message 	=  $this->getErrorMessage();
			}
			else 
			{
				$r->status = self::STATUS_UNKNOWN_ERROR;
			}
				
		}
		
		return $r;	
	}
	
	public function &updateClientModule( ClientModuleVo $c_module )
	{
		$k 	= new ColumnVo( 'client_key'	, $this->escape( $c_module->client_key 	));
		$m 	= new ColumnVo( 'module_id'		, $this->escape( $c_module->module_id		));
		$t 	= new ColumnVo( 'template_id'	, $this->escape( $c_module->template_id	));
		$a 	= new ColumnVo( 'active'		, $this->escape( $c_module->active			));

		
		$already_exists = FALSE;
		$exists = $this->_checkClientModuleExists( $k, $m );
		
		
		if( $exists > 0 )
			$already_exists = TRUE;
			
		$r = new TableGatewayReturnVo();
			
		// check if values are not unique	
		if( $already_exists )
		{
			$r->status =  self::STATUS_ALREADY_EXISTS;
			$r->errorCode = 0;
		}
		else
		{
			
			$u_m = new TableUpdateVo( $m );
			$u_t = new TableUpdateVo( $t );
			$u_a = new TableUpdateVo( $a );
			
			$update = $this->update( array( $u_m, $u_t, $u_a ) );
						
			if( $update === TRUE )
			{
				$r->status = self::STATUS_OK;
				$r->errorCode = 0; 
			}
			else if( $update === FALSE   ) 
			{
				$r->status = self::STATUS_UNKNOWN_ERROR;
				log_message('debug', 'Failure occured at ClientModulesTableGateway::updateClientModule(). No error message to display');
			}
			else if( $update ===  NULL )
			{
				$r->status 		=  self::STATUS_ERROR;
				$r->errorCode 	=  ErrorCodes::DATABASE_ERROR;
				$r->message 	=  $this->getErrorMessage();
			}
			else 
			{
				$r->status = self::STATUS_ERROR;
			}
				
		}
		
		return $r;	
	} 
	
	public function &deleteClientModule( ClientModuleVo $c_module )
	{
		
	}
	
	protected function &_readActiveInactiveModules( &$client_key, &$active )
	{
		$r = new TableGatewayReturnVo();
		
		$key = $this->escape( trim( $client_key ) );
		
		$key_column 	= new ColumnVo('client_key', $key );
		$active_column	= new ColumnVo('active', $active );
		
		$wk = new TableWhereVo( $key_column );
		$wa = new TableWhereVo( $active_column );
		
		$wr = new TableWhereReadVo( array( $wk, $wa ) );
		
		$q = $this->readAll()->whereSimple( $wr )->run()->getResultAsArray();
		
		
		if( $q !== NULL && ! $this->getErrorMessage() )
		{	
			if( $this->numRows() > 0  )
			{
				$r->errorCode = 0;
				$r->status = self::STATUS_OK;
				$r->result = $q;
			}
			else
			{
				$r->status = self::STATUS_NOT_FOUND;
				$r->errorCode = 0;
			}
			
		}
		else
		{
			log_message( 'error', 'mysqli/ClientModulesTableGateway::readActiveModules() ErrorOcurred. ErrorMessage: ' . $this->getErrorMessage() );
				
			$r->status = self::STATUS_ERROR;
			$r->errorCode =  ErrorCodes::DATABASE_ERROR ;
			$r->message =  $this->getErrorMessage();
			
		}
		
		return $r;
	}
	
	protected function &_checkClientModuleExists( ColumnVo &$client_key, ColumnVo &$module_id )
	{
		$wk = new TableWhereVo( $client_key );
		$wm = new TableWhereVo( $module_id );
		
		$wr = new TableWhereReadVo( array( $wk, $wm ) );
		
		return $this->readAll()->whereSimple( $wr )->run()->numRows();
	}
}

?>