<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/TableGatewayInterfaces/IACLTableGateway.php';
require_once 'application/libraries/MysqliBaseTableGateway.php';
require_once 'application/vos/UserVo.php';

class PrivilegesTableGateway extends MysqliBaseTableGateway implements IPrivilegesTableGateway
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function &readAcg( TableGatewayReadVo $read )
	{	
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acg_view';
		
		$acg = parent::readFromVo( $read )->run()->getResultAsArray();
		
		if( $acg !== NULL  )
		{
			if( $this->numRows() > 0 )
			{
				$r->errorCode = 0;
				$r->status = self::STATUS_OK;
				$r->result = $acg;
			}
			else
			{
				$r->status = self::STATUS_NOT_FOUND;
				$r->errorCode = 0;
			}
		}
		else
		{
			log_message( 'error', 'mysqli/PrivilegesTableGateway::readAcg() ErrorOcurred. ErrorMessage: ' . $this->getErrorMessage() );
				
			$r->status = self::STATUS_ERROR;
			$r->errorCode =  ErrorCodes::DATABASE_ERROR;
			$r->message =  $this->getErrorMessage();
		}
		
		return $r;
		

	}
	
	public function &readAcgl( TableGatewayReadVo $read )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acgl';
		
		$acgl = parent::readFromVo( $read )->run()->getResultAsArray();
		
		if( $acgl !== NULL  )
		{
			if( $this->numRows() > 0 )
			{
				$r->errorCode = 0;
				$r->status = self::STATUS_OK;
				$r->result = $acgl;
			}
			else
			{
				$r->status = self::STATUS_NOT_FOUND;
				$r->errorCode = 0;
			}
		}
		else
		{
			log_message( 'error', 'mysqli/PrivilegesTableGateway::readAcgl() ErrorOcurred. ErrorMessage: ' . $this->getErrorMessage() );
				
			$r->status = self::STATUS_ERROR;
			$r->errorCode =  ErrorCodes::DATABASE_ERROR ;
			$r->message =  $this->getErrorMessage();
		}
		
		return $r;
		
	}
	
	public function &readAcl( TableGatewayReadVo $read )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acl';
		
		$acl = parent::readFromVo( $read )->run()->getResultAsArray();
		
		if( $acl !== NULL  )
		{
			if( $this->numRows() > 0 )
			{
				$r->errorCode = 0;
				$r->status = self::STATUS_OK;
				$r->result = $acl;
			}
			else
			{
				$r->status = self::STATUS_NOT_FOUND;
				$r->errorCode = 0;
			}
		}
		else
		{
			log_message( 'error', 'mysqli/PrivilegesTableGateway::readAcl() ErrorOcurred. ErrorMessage: ' . $this->getErrorMessage() );
				
			$r->status = self::STATUS_ERROR;
			$r->errorCode =  ErrorCodes::DATABASE_ERROR ;
			$r->message =  $this->getErrorMessage();
		}
		
		return $r;
	}
	
	
	public function &createAcg( AcgVo $acg )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acg';
		
		$admin_id 	= new ColumnVo('admin_id', $this->escape( $acg->admin_id ) ); 
		$name 		= new ColumnVo('name', $this->escape( $acg->name ) );
		
		if( $this->checkValueExists( $name ) )
		{
			$r->status 		= self::STATUS_ALREADY_EXISTS;
			$r->errorCode 	= 0;
			$r->alreadyExistsFields = array( $name );
			
			return $r;	
		}
		
		
		$create = $this->create( array( $admin_id, $name ) );
		
		if( $create === TRUE )
		{
			$r->status 		= self::STATUS_OK;
			$r->errorCode 	= 0;
		}
		else if( $r === NULL )
		{
			$r->status 		= self::STATUS_ERROR;
			$r->errorCode 	= ErrorCodes::DATABASE_ERROR;
		}
		else 
		{
			$r->status = self::STATUS_UNKNOWN_ERROR;
		}
		
		
		return $r;
	}
	
	public function &createAcgl( AcglVo $acgl )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acgl';
		
		$acg_id 	= new ColumnVo( 'acg_id', $this->escape( $acgl->acg_id ) ); 
		$module_id 	= new ColumnVo( 'module_id', $this->escape( $acgl->acl->module_id ) );
		$action_id 	= new ColumnVo( 'action_id', $this->escape( $acgl->acl->action_id ) );
		
		if( $this->_checkAcglExists( $acg_id, $module_id, $action_id ) )
		{
			$r->status 		= self::STATUS_ALREADY_EXISTS;
			$r->errorCode 	= 0;
			$r->alreadyExistsFields = array( $action_id );
			
			return $r;	
		}
		
		
		$create = $this->create( array( $acg_id, $module_id, $action_id ) );
		
		if( $create === TRUE )
		{
			$r->status 		= self::STATUS_OK;
			$r->errorCode 	= 0;
		}
		else if( $r === NULL )
		{
			$r->status 		= self::STATUS_ERROR;
			$r->errorCode 	= ErrorCodes::DATABASE_ERROR;
		}
		else 
		{
			$r->status = self::STATUS_UNKNOWN_ERROR;
		}
		
		
		return $r;
	}
	
	public function &createAcl( AclVo $acl )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acl';
		
		$user_id 	= new ColumnVo( 'user_id',   $this->escape( $acl->user_id ) ); 
		$module_id 	= new ColumnVo( 'module_id', $this->escape( $acl->module_id ) );
		$action_id 	= new ColumnVo( 'action_id', $this->escape( $acl->action_id ) );
		$access 	= new ColumnVo( 'access',    $this->escape( $acl->access ) );
		
		if( $this->_checkAclExists( $user_id, $module_id, $action_id ) )
		{
			$r->status 				= self::STATUS_ALREADY_EXISTS;
			$r->errorCode 			= 0;
			$r->alreadyExistsFields = array( $action_id );
			
			return $r;	
		}
		
		
		$create = $this->create( array( $user_id, $module_id, $action_id, $access ) );
		
		if( $create === TRUE )
		{
			$r->status 		= self::STATUS_OK;
			$r->errorCode 	= 0;
		}
		else if( $r === NULL )
		{
			$r->status 		= self::STATUS_ERROR;
			$r->errorCode 	= ErrorCodes::DATABASE_ERROR;
		}
		else 
		{
			$r->status = self::STATUS_UNKNOWN_ERROR;
		}
		
		
		return $r;
	}
	
	
	public function &updateAcg( AcgVo $acg )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acg';
		
		$id 		= new ColumnVo( 'id', $this->escape( $acg->id ) );
		$admin_id 	= new ColumnVo('admin_id_last_update', $this->escape( $acg->admin_id_last_update ) ); 
		$name 		= new TableUpdateVo( new ColumnVo('name', $this->escape( $acg->name ) ) );
		
		$wr = new TableWhereReadVo( array( new TableWhereVo( $id ) ) );
		
		$update = $this->update( array( $admin_id, $name ) )->whereSimple( $wr )->run();
		
		if( ! $this->getErrorMessage() )
		{
			$r->errorCode 	= 0;
			
			if( $this->affectedRows() > 0 )
			{
				$r->status 		= self::STATUS_OK;
			}
			else
			{
				$r->status		= self::STATUS_NOT_CHANGED;
			}
		}
		else 
		{
			$r->status 		= self::STATUS_ERROR;
			$r->errorCode 	= ErrorCodes::DATABASE_ERROR;
		}
		
		
		return $r;
		
	}
	
	public function &updateAcl( AclVo $acl )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acl';
		
		$user_id 	= new TableWhereVo( new ColumnVo( 'user_id',   $this->escape( $acl->user_id ) ) ); 
		$module_id 	= new TableWhereVo( new ColumnVo( 'module_id', $this->escape( $acl->module_id ) ) );
		$action_id 	= new TableWhereVo( new ColumnVo( 'action_id', $this->escape( $acl->action_id ) ) );
		
		$access 	= new TableUpdateVo( new ColumnVo( 'access',    $this->escape( $acl->access ) ) );
		
		$wr = new TableWhereReadVo( array(  $user_id, $module_id, $action_id ) );
		
		
		$update = $this->update( array( $access ) )->whereSimple( $wr )->run();

		if( ! $this->getErrorMessage() )
		{
			$r->errorCode 	= 0;
			
			if( $this->affectedRows() > 0 )
			{
				$r->status 	= self::STATUS_OK;
			}
			else
			{
				$r->status	= self::STATUS_NOT_CHANGED;
			}
		}
		else 
		{
			$r->status 		= self::STATUS_ERROR;
			$r->errorCode 	= ErrorCodes::DATABASE_ERROR;
		}
		
		
		return $r;
	}
	
	
	public function &deleteAcg( AcgVo $acg )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acg';
		
		$id 	= new TableWhereVo( new ColumnVo('id', $this->escape( $acg->id ) ) ); 
		
		$delete = $this->delete()->whereSimple( new TableWhereReadVo( array( $id ) ) );
		
		if( ! $this->getErrorMessage() )
		{
			$r->errorCode 	= 0;
			
			if( $this->affectedRows() > 0 )
			{
				$r->status 	= self::STATUS_OK;
			}
			else 
			{
				$r->status 	= self::STATUS_NOT_CHANGED;
			}
			
		}
		else 
		{
			$r->status = self::STATUS_UNKNOWN_ERROR;
		}
		
		return $r;
	}
	
	public function &deleteAcgl( AcgVo $acgl )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acg';
		
		$id 	= new TableWhereVo( new ColumnVo('id', $this->escape( $acg->id ) ) ); 
		
		$delete = $this->delete()->whereSimple( new TableWhereReadVo( array( $id ) ) );
		
		if( ! $this->getErrorMessage() )
		{
			$r->errorCode 	= 0;
			
			if( $this->affectedRows() > 0 )
			{
				$r->status 	= self::STATUS_OK;
			}
			else 
			{
				$r->status 	= self::STATUS_NOT_CHANGED;
			}
			
		}
		else 
		{
			$r->status = self::STATUS_UNKNOWN_ERROR;
		}
		
		return $r;
	}
	
	public function &deleteAcl( AclVo $acl )
	{
		$r = new TableGatewayReturnVo();
		
		$this->_tableName = 'acl';
		
		$user_id 	= new TableWhereVo( new ColumnVo('user_id', 	$this->escape( $acl->user_id ) ) ); 
		$module_id 	= new TableWhereVo( new ColumnVo('module_id', 	$this->escape( $acl->module_id ) ) );
		$action_id 	= new TableWhereVo( new ColumnVo('action_id', 	$this->escape( $acl->action_id ) ) );
		
		
		$delete = $this->delete()->whereSimple( new TableWhereReadVo( array( $user_id, $module_id, $action_id ) ) );
		
		if( ! $this->getErrorMessage() )
		{
			$r->errorCode 	= 0;
			
			if( $this->affectedRows() > 0 )
			{
				$r->status 	= self::STATUS_OK;
			}
			else 
			{
				$r->status 	= self::STATUS_NOT_CHANGED;
			}
			
		}
		else 
		{
			$r->status = self::STATUS_UNKNOWN_ERROR;
		}
		
		return $r;
	}
	
	protected function &_checkAclExists( &$user_id, &$module_id, &$action_id )
	{
		$wu = new TableWhereVo( $user_id );
		$wm = new TableWhereVo( $module_id );
		$wa = new TableWhereVo( $action_id );
		
		$wr = new TableWhereReadVo( array( $wu, $wm, $wa ) );
		
		return $this->readAll()->whereSimple( $wr )->run()->numRows();
	}
	
	protected function &_checkAcglExists( &$acg_id, &$module_id, &$action_id )
	{
		$wi = new TableWhereVo( $acg_id );
		$wm = new TableWhereVo( $module_id );
		$wa = new TableWhereVo( $action_id );
		
		$wr = new TableWhereReadVo( array( $wi, $wm, $wa ) );
		
		return $this->readAll()->whereSimple( $wr )->run()->numRows();
	}
	
}

?>