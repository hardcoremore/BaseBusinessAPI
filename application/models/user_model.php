<?php

require_once 'application/Specifications/UsersSpecification.php';
require_once 'application/vos/AuthenticationVo.php';
require_once 'application/vos/ModelVos/UserVo.php';

class User_model extends BaseModel
{
	protected $_session;
	protected $_spec;
	
	const USER_SESSION_NAME = 'user_data';
	
	public function __construct()
	{
		parent::__construct();
		$this->_session 	= CSession::getInstance();
		$this->_spec = new UsersSpecification();
	}
	
	public function create( UserVo $user )
	{
		if( $this->_spec->create( $user ) )
		{
			unset( $user->user_id );
			
			$user->password = $this->encodePassword( $user->password );
			$this->db->insert( 'users', $user );
			
			if( $this->db->affected_rows() == 1 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}	
		
		return $this->operationData();
	}
	
	public function read( ReadTableVo $readVo )
	{
		
		$tr = $this->_readFromTable( 'users', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'UserVo' );
			$this->setOperationReadData( $result, $tr->totalRows );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
	
	public function update( UserVo $user )
	{
		if( $this->_spec->update( $user ) )
		{
		
			$this->db->where( 'user_id', $user->user_id );
			unset( $customer->user_id );
			$this->db->update( 'users', $user );
			
			if( $this->db->affected_rows() >= 0 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;	
		}
		
		return $this->operationData();
	}
	
	public function encodePassword( $password )
	{	
		return md5( md5( md5( $password . BaseController::APP_CONFIG()->salt ) ) );
	}
	
	public function authenticate( AuthenticationVo $authVo )
	{
		if( $this->_spec->authenticate( $authVo ) === TRUE  )
		{
			
			$this->db->where( 'username', $authVo->username );
			$this->db->where( 'password', $authVo->password );
			
			$user = $this->db->get( 'users' );
			
			if( $user )
			{
				if( $user->num_rows() == 1 )
				{
					if( $user )
					{
						$ur = $user->row( 0, 'UserVo' );
						$ur->password = "";
						
						// set session data
						$this->_session->set( BaseController::SYSTEM_SESSION_NAME_SPACE, BaseController::SYSTEM_SESSION_STATE_NAME,	BaseController::SYSTEM_LOGIN_STATE_AUTHENTICATED );
						$this->_session->set( BaseController::APP_CONFIG()->name, BaseController::SESS_LANGUAGE	,	$authVo->language );					
						$this->_session->set( BaseController::SYSTEM_SESSION_NAME_SPACE, self::USER_SESSION_NAME, serialize( $ur ) );
						
						$this->operationData()->status = BaseController::STATUS_OK;
						$this->operationData()->errorCode = 0;
						
						$this->operationData()->result = $ur;
						$this->operationData()->numRows = 1;
						$this->operationData()->dataType = DataHolderDataType::CUSTOM_OBJECT;

					}
				}
				else
				{
					$this->operationData()->status = BaseController::STATUS_ERROR;
					$this->operationData()->errorCode = ServerOperationCodes::NOT_FOUND;
					$this->operationData()->message = ServerMessages::NOT_FOUND;
				}
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
			}
		}
		else
		{

			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}
		
		
		return $this->operationData();

	}
	
	public function currentUser()
	{
		if( $this->_session->has( BaseController::SYSTEM_SESSION_NAME_SPACE, self::USER_SESSION_NAME ) )
		{
			return unserialize( $this->_session->get( BaseController::SYSTEM_SESSION_NAME_SPACE, self::USER_SESSION_NAME ) );
		}
	}
	
	public function checkLogin( AuthenticationVo $authVo )
	{
		$this->db->where( 'username', $authVo->username );
		$this->db->where( 'password', $authVo->password );
			
		$user = $this->db->get( 'users' );
		
		if( $user )
		{
			if( $user->num_rows() == 1 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
			}
			else 
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::NOT_FOUND;
				$this->operationData()->message = ServerMessages::NOT_FOUND;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
}

?>