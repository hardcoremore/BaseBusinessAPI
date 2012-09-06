<?php if ( !defined('BASEPATH') ) die(	"Direct Script Access Denied" );

require_once 'application/Factories/ConfigFactory.php';
require_once 'application/libraries/BusinessLogicBase.php';
require_once 'application/Interfaces/BusinessLogic/IUsersLogic.php';
require_once 'application/Specifications/UsersSpecification.php';
require_once 'application/libraries/CSession.php';
require_once 'application/libraries/ClientLogicTemplate.php';


class UsersLogic extends BusinessLogicBase implements IUsersLogic
{
	
	protected $_session;
	protected $_table;
	protected $_spec;
	protected $_client_logic_template;
	
	public function __construct()
	{
		parent::__construct();
		$this->_session 	= CSession::getInstance();
	}
	
	public function init()
	{
		parent::init();
		
		$this->_spec = new UsersSpecification();
	}
	
	public function &create( UserVo $user )
	{
		
		if( $this->_spec->create( $user ) )
		{
			$user->password = $this->encodePassword( $user->password );
			
			$userResult = $this->_table->createUser( $user );
			
			if( $userResult->status == BaseTableGateway::STATUS_OK )
			{
				$this->_data_holder->metadata()->setStatus( self::STATUS_OK );
				$this->_data_holder->metadata()->setErrorCode( 0 );	
			}
			else if( $userResult->status == BaseTableGateway::STATUS_ERROR  )
			{
				
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( ErrorCodes::DATABASE_ERROR );
				$this->_data_holder->metadata()->setMessage( $this->_table->getErrorMessage() );
			}
			
		}
		else
		{
			$this->_data_holder =  $this->returnInvalidInputError();
		}
		
		return $this->_data_holder;	
		
		
		
	}
	
	public function &read( TableGatewayReadVo $read )
	{
		
	}
	
	public function &update( UserVo $user )
	{
		
	}
	
	public function &delete( UserVo $user )
	{
		
	}
	
	
	
	public function &changePrivilege( UserVo $user, $privileges )
	{
		
	}
	
	public function &getStatistics( UserVo $user )
	{
		
	}
	
	public function &authenticate( AuthenticationVo $authVo )
	{
		// send the session id to the client only if the session is new
		// and id is generated
		if( $this->_session->isNew() && $this->_session->getId() )
		{
			$m = $this->_data_holder->metadata()->getRawMetadata();
			$m[ $this->_session->config()->session_id_name ] = $this->_session->getId();
			$this->_data_holder->metadata()->setData( $m );
		}

		if( $this->_spec->authenticate( $authVo ) === TRUE )
		{
			$this->_database_config->database = $authVo->key;
			$this->_table->setDatabaseConfig( $this->_database_config );
			
			$authVo->password	= $this->encodePassword( $authVo->password );
			$r 					= $this->_table->authenticate( $authVo );
				
				
			if( $r->errorCode == 0  )
			{
				if( $r->status == BaseTableGateway::STATUS_OK )
				{
					
					// load client logic template
					$logic_result = $this->_client_logic_template->buildTemplate( $authVo->key );
					
					if( $logic_result !== TRUE )
					{
						//return $this->returnErrorFromErrorCode( ErrorCodes::APP_ERROR );
					}
					
					$this->_data_holder->metadata()->setStatus( self::STATUS_OK );
					$this->_data_holder->metadata()->setErrorCode( 0 );
						
					$u =& $r->result;
					$d =& $this->_ci->load->_ci_object_to_array( $u );
						
					$this->_data_holder->data()->setData( array( $d ), FALSE );
					
					// set session data
					$this->_session->set( $this->_app_config->name, self::SESS_DATABASE_KEY	,	$authVo->key );
					$this->_session->set( $this->_app_config->name, self::SESS_USERNAME		,	$authVo->username );
					$this->_session->set( $this->_app_config->name, self::SESS_LANGUAGE		,	$authVo->language );
					$this->_session->set( $this->_app_config->name, self::SESS_USER_ID		,	$u->id );
					$this->_session->set( $this->_app_config->name, self::SESS_USER_ACG		,	$u->acg );
					
				}
				else if( $r->status == BaseTableGateway::STATUS_NOT_FOUND )
				{
					$this->_data_holder->metadata()->setStatus(		self::STATUS_ERROR  );
					$this->_data_holder->metadata()->setErrorCode(	ErrorCodes::USER_OR_PASS_WRONG  );
					$this->_data_holder->metadata()->setMessage(		ServerMessages::USER_OR_PASS_WRONG  );
				}

				return $this->_data_holder;

			}
			else if( $r->status == BaseTableGateway::STATUS_ERROR  )
			{

				return $this->returnErrorFromErrorCode( $r->errorCode );
			}
			else
			{
				return $this->returnErrorFromErrorCode( $r->errorCode );
			}
		}
		else
		{
			return $this->returnInvalidInputError();
		}

	}
	
	

	public function &loadUser( $id )
	{
		if( $this->_spec->loadUser( $id ) === TRUE )
		{
			$r =& $this->_table->loadUser( $id );
				
			if( $r->errorCode == 0   )
			{
				if( $r->status == BaseTableGateway::STATUS_OK )
				{
					$this->_data_holder->metadata()->setStatus( self::STATUS_OK );
					$this->_data_holder->metadata()->setErrorCode( 0 );
					$this->_data_holder->data()->setData( array( $this->_ci->load->_ci_object_to_array( $r->result ) ) );
						
				}
				else if( $r->status == BaseTableGateway::STATUS_NOT_FOUND )
				{
					$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR  );
					$this->_data_holder->metadata()->setErrorCode( ErrorCodes::USER_NOT_FOUND  );
					$this->_data_holder->metadata()->setMessage( ServerMessages::USER_NOT_FOUND  );
				}

				return $this->_data_holder;
			}
			else if( $r->status == BaseTableGateway::STATUS_ERROR  )
			{
				return $this->returnErrorFromErrorCode( $r->errorCode );
			}
				
		}
		else
		{
			return $this->returnInvalidInputError();
		}

	}
	
	public function &checkLogin( AuthenticationVo $authVo )
	{

		if( $this->_spec->checklogin( $authVo ) === TRUE )
		{
			$authVo->password = $this->encodePassword( $authVo->password );

			$r = $this->_table->checkLogin( $authVo );

			if( $r->errorCode == 0   )
			{
				if( $r->status == BaseTableGateway::STATUS_OK )
				{
					$this->_data_holder->metadata()->setStatus( self::STATUS_OK );
					$this->_data_holder->metadata()->setErrorCode( 0 );
				}
				else if( $r->status == BaseTableGateway::STATUS_NOT_FOUND  )
				{
					$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR  );
					$this->_data_holder->metadata()->setErrorCode( ErrorCodes::USER_OR_PASS_WRONG  );
					$this->_data_holder->metadata()->setMessage( ServerMessages::USER_OR_PASS_WRONG  );
				}
					
				return $this->_data_holder;
					
			}
			else if( $r->status == BaseTableGateway::STATUS_ERROR  )
			{
				return $this->returnErrorFromErrorCode( $r->errorCode );
			}

		}
		else
		{
			return $this->returnInvalidInputError();
		}
	}
		
	public function logout()
	{

	}
	
}
?>