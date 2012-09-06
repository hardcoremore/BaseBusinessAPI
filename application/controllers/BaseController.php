<?php

require_once 'application/Interfaces/IDispatcher.php';
require_once 'application/libraries/Event/EventDispatcher.php';
require_once 'application/libraries/utility/ServerCodes.php';
require_once 'application/libraries/utility/ServerMessages.php';
require_once 'application/Factories/ConfigFactory.php';
require_once 'application/libraries/CSession.php';
require_once 'application/libraries/CAcl.php';
require_once 'application/Factories/DataHolderFactory.php';
require_once 'application/Factories/BusinessLogicFactory.php';
require_once 'application/vos/ModelVos/ClientsVo.php';
require_once 'application/libraries/utility/ErrorCodes.php';
require_once 'application/vos/UpdateTableFieldVo.php';
require_once 'application/vos/ReadTableVo.php';
require_once 'application/vos/SearchParameterVo.php';

class BaseController extends CI_Controller implements IDispatcher
{
	private $__dispatcher;
	
	/*****************************
	 * 
	 * CONSTANTS
	 * 
	 *****************************/
	// system state name space
	const SYSTEM_SESSION_NAME_SPACE = "SYSTEM_SESSION_NS";
	
	const SYSTEM_SESSION_STATE_NAME = "SYSTEM_STATE_NS";
	const SYSTEM_SESSION_PRIVILEGES_NAME = "SYSTEM_PRIVILEGES_NS";
	
	const SYSTEM_LOGIN_STATE_UNAUTHENTICATED = -1;
	const SYSTEM_LOGIN_STATE_AUTHENTICATED = 1;
	const SYSTEM_LOGIN_STATE_PUBLIC_MODULES = 2;
	const SYSTEM_LOGIN_STATE_LOCKED = 3;
	
	const REQUEST_TYPE_AUTHENTICATION = 1;
	const REQUEST_TYPE_LOG_OUT = 2;
	const REQUEST_TYPE_LOAD_PUBLIC_MODULES = 3;
	const REQUEST_TYPE_CONTROLLER_NORMAL = 4;
	const REQUEST_TYPE_LOCK_USER = 5;
	const REQUEST_TYPE_UNLOCK_USER = 6;
	
	
	// operation status
	const STATUS_OK 			= 'ok';
	const STATUS_WARNING 		= 'warning';
	const STATUS_ERROR 			= 'error';
	
	// authentication session key names
	const SESS_USER_ID 			=  'userID';
	const SESS_USERNAME 		=  'username';
	const SESS_LANGUAGE 		=  'language';
	const SESS_USER_ACG 		=  'userAcg';
	
	
	const IS_SEARCH_NAME = "search_is_on";
	const SEARCH_PARAMETERS_NAME = "_search_parameters_name_";
	
	/*********************************
	 * 
	 * APP PARAMETERS
	 * 
	 *********************************/
	
	private static $__request_type;
	
	private static $__system_state;
	
	private static $__client_key;
	
	private static $__app_config;
	
	private static $__session_config;
	
	private static $__user_database_config;
	
	
	/***********************
	 * 
	 *  APP CONFIG STATIC PROPS
	 * 
	 *********************/
	public static function REQUEST_TYPE()
	{
		return self::$__request_type;
	}
	
	public static function SYSTEM_STATE()
	{
		return self::$__system_state;
	}
	
	public static function APP_CONFIG()
	{
		return self::$__app_config;
	}
	
	public static function SESSION_CONFIG()
	{
		return self::$__session_config;
	}
	
	public static function USER_DATABASE_CONFIG()
	{
		return self::$__user_database_config;
	}
	
	
	protected $_data_factory;
	
	protected $_data_holder;
	
	protected $_session;

	private  $__controllerSegment;

	private  $__methodSegment;

	
	public function CONTROLLER_SEGMENT()
	{
		return $this->__controllerSegment;
	}
	
	public function METHOD_SEGMENT()
	{
		return $this->__methodSegment;
	}
	
	public function &get_logic_factory()
	{
		return $this->__logic_factory;
	}
	
	public function __construct( )
	{	
		parent::__construct();
		$this->__dispatcher = new EventDispather( $this );
		$this->__initApp();
	}

	public function dispatcher()
	{
		return $this->__dispatcher;
	}
	
	public function resetDataHolder()
	{
		$this->_data_holder->reset();
	}
	
	private function __initApp()
	{
		
		/***********************
		 * 
		 * Init CONFIG
		 *
		 ***********************/
		self::$__app_config = ConfigFactory::APPLICATION_CONFIG();
		
		self::$__session_config = ConfigFactory::SESSION_CONFIG();
		
		/***********************
		 * 
		 * Init DATA HOLDERS
		 * 
		 **********************/
		$this->_data_factory = DataHolderFactory::getInstance();

		$this->_data_holder = $this->_data_factory->createDataHolderFromConfig();
		
		$this->_session = CSession::getInstance();

		$this->__controllerSegment = $this->uri->segment( 1, 0 );
		
		$this->__methodSegment     = $this->uri->segment( 2, 0 );
		
		// init input that is comming from user
		$this->__initInputVars();
		
		// start app session
		$this->__startSession();
		
		$this->__checkRequestType();
		
		$this->__checkSystemState();
		
		self::$__user_database_config = ConfigFactory::DATABASE_CONFIG();
		
		// load models
		$this->load->model( 'Client_model', 'cm' );
		$this->cm->loadDatabase();
		
		// USER IS NOT LOGGED IN
		if( self::SYSTEM_STATE() == self::SYSTEM_LOGIN_STATE_UNAUTHENTICATED  )
		{
			if( self::REQUEST_TYPE() != self::REQUEST_TYPE_AUTHENTICATION && self::REQUEST_TYPE() != self::REQUEST_TYPE_LOAD_PUBLIC_MODULES )
			{
				$this->dieWithAccesAuthenticationRequired();
			}
			else if( self::REQUEST_TYPE() == self::REQUEST_TYPE_AUTHENTICATION || self::REQUEST_TYPE() == self::REQUEST_TYPE_LOAD_PUBLIC_MODULES )
			{
				if( ! self::$__client_key )
				{
					$this->returnErrorFromErrorCode( ErrorCodes::INVALID_INPUT )->dispatchAll();
					die(); // user didn't supply client key
				}
				else
				{
					$this->__initSessionModels();
				}	
			}
		} 
			// USER IS USING PUBLIC MODULES ONLY 
		else if( self::SYSTEM_STATE() == self::SYSTEM_LOGIN_STATE_PUBLIC_MODULES )
		{
			if(  self::REQUEST_TYPE() == self::REQUEST_TYPE_LOCK_USER || self::REQUEST_TYPE() == self::REQUEST_TYPE_UNLOCK_USER || self::REQUEST_TYPE() == self::REQUEST_TYPE_LOG_OUT )
			{
				//@todo die. public users cannot be locked or logged out
			}
		}
		
			// USER INTERFACE IS LOCKED
		else if( self::SYSTEM_STATE() == self::SYSTEM_LOGIN_STATE_LOCKED )
		{
			if( self::REQUEST_TYPE() != self::REQUEST_TYPE_UNLOCK_USER )
			{
				//@todo die. system is locked and unlocking is not requested
			}
		} 
		
			// USER IS LOGGED IN
		else if( self::SYSTEM_STATE() == self::SYSTEM_LOGIN_STATE_AUTHENTICATED )
		{
			// allow for user re-authentication
			if( self::REQUEST_TYPE() == self::REQUEST_TYPE_AUTHENTICATION  )
			{
				$this->_session->destroy();
	
				// start new session
				$this->__startSession();
				
				$this->__initSessionModels();
			}
			else if( self::REQUEST_TYPE() == self::REQUEST_TYPE_CONTROLLER_NORMAL )
			{
				self::$__user_database_config->database = $this->cm->currentClient()->client_database_key;
				
				//@todo check privileges		
			}
		}
	}
	
	
	private function __initSessionModels()
	{
		$clr = $this->cm->loadUserClient( self::$__client_key );
		
		// load client
		if( $clr->status != self::STATUS_OK )
		{
			// die. user client could not be loaded
			$this->dieWithError( ErrorCodes::UNABLE_TO_lOAD_CLIENT, "Unable to load client." );
		}
	
		self::$__user_database_config->database = $this->cm->currentClient()->client_database_key;
	}
	
	private function __initInputVars()
	{	
		// Try to get client key
		
		(string) self::$__client_key 						= @$_SERVER[ 'HTTP_CLIENT_KEY' ];
		if( ! self::$__client_key) self::$__client_key		= @$_COOKIE[ CSession::encodeName( 'CLIENT_KEY' ) ];
		if( ! self::$__client_key ) self::$__client_key 	= $this->input->post( 'CLIENT_KEY' );
		if( ! self::$__client_key ) self::$__client_key 	= $this->input->get( 'CLIENT_KEY' );
	
		//Try to get session id
		(string) $sessionId 			= @$_SERVER[ 'HTTP_' . strtoupper( self::SESSION_CONFIG()->session_id_name ) ];
		if( ! $sessionId ) $sessionId 	= @$_COOKIE[ CSession::encodeName( self::SESSION_CONFIG()->name ) ];
		if( ! $sessionId ) $sessionId 	= @$_POST[ self::SESSION_CONFIG()->session_id_name ];
		if( ! $sessionId ) $sessionId 	= @$_GET[ self::SESSION_CONFIG()->session_id_name ];
		
		self::SESSION_CONFIG()->id = $sessionId;
		
	}
	
	/**
	 * 
	 * @name __checkSession
	 * 
	 * Check if session is valid
	 * 
	 * @return void
	 * 
	 **/
	private function __startSession()
	{
		// start session
		$sess_start = $this->_session->start( self::SESSION_CONFIG() );

 		if( ! $sess_start || $this->_session->getState() == CSession::STATE_ERROR )
		{
			$this->dieWithSessionError();
		}
		else if( $this->_session->getState() == CSession::STATE_EXPIRED )
		{
			$this->dieWithSessionExpired();
		}
		
		if( $this->_session->isNew() && $this->_session->getId() )
		{
			$m = $this->_data_holder->metadata()->getRawMetadata();
			$m[ $this->_session->config()->session_id_name ] = $this->_session->getId();
			$this->_data_holder->metadata()->setData( $m );
		}

	}
	
	/**
	 * 
	 * @name __checkRequestType
	 * 
	 * Check request type
	 * 
	 * @return void
	 * 
	 **/
	private function __checkRequestType()
	{
		if( $this->__controllerSegment === 'users' && $this->__methodSegment === 'authenticate' )
		{
			self::$__request_type = self::REQUEST_TYPE_AUTHENTICATION;
		}
		else if( $this->__controllerSegment === 'users' && $this->__methodSegment === 'logout' )
		{
			self::$__request_type = self::REQUEST_TYPE_LOG_OUT;
		}
		else if( $this->__controllerSegment === 'users' && $this->__methodSegment === 'lock' )
		{
			self::$__request_type = self::REQUEST_TYPE_LOCK_USER;
		}
		else if( $this->__controllerSegment === 'users' && $this->__methodSegment === 'unlock' )
		{
			self::$__request_type = self::REQUEST_TYPE_UNLOCK_USER;
		}
		else if( $this->__controllerSegment === 'cliens' && $this->__methodSegment === 'loadPublicModules' )
		{
			self::$__request_type = self::REQUEST_TYPE_LOAD_PUBLIC_MODULES;
		}
		else
		{
			self::$__request_type = self::REQUEST_TYPE_CONTROLLER_NORMAL;
		}
		
		log_message( 'debug', 'REQUEST TYPE: ' . self::REQUEST_TYPE() );
	}
	
	private function __checkSystemState()
	{
		if( $this->_session->has( self::SYSTEM_SESSION_NAME_SPACE, self::SYSTEM_SESSION_STATE_NAME ) )
		{
			self::$__system_state = $this->_session->get( self::SYSTEM_SESSION_NAME_SPACE, self::SYSTEM_SESSION_STATE_NAME ); 
		}
		else
		{
			self::$__system_state = self::SYSTEM_LOGIN_STATE_UNAUTHENTICATED;
		}
		
		log_message( 'debug', 'SYSTEM LOGIN STATE: ' . self::SYSTEM_STATE() );
	}
	
	/**
	 * 
	 * @name __checkModuleAccess
	 * 
	 * Check if user has privileges to access 
	 * requested module and action 
	 * 
	 * @return void
	 * 
	 **/
	private function __checkModuleAccess()
	{
	
		///// TEST - ACL NOT IMPLEMENTED YET /////////
		//

		RETURN;

		//
		////////////////////

		/**************************************
		 * 
		 * Checking if user has permissions 
		 * to requested controller and action
		 * 
		 *************************************/
		$this->__acl = CAcl::getInstance();
		
		if( ! $this->__acl->isAllowed( $this->__controllerSegment, $this->__methodSegment ) )
			$this->dieWithAccesDenied();

		log_message( 'debug', 'Session INVALID at PreController::checkAuthentication()' );

		/******************************************************************
		 * 
		 * if session is not set only 
		 * Authentication controller and Authentication->authenticate 
		 * methods are allowed.
		 * 
		 ****************************************************************/
		if( $this->__controllerSegment == "users" &&  $this->__methodSegment == "authenticate" )
		{
			// allow user to authenticate since session is invalid
		}
		else
		{
			/*******************************************************
			 * 
			 * User is not logged in. Other controllers are denied
			 * 
			 ******************************************************/ 
			$this->dieWithAccesDenied();
		}
		
	}
	
	
	
	
	
	/**************************
	 * HELPER METHODS
	 **************************/
	public function postArrayParser( $array = NULL, $separator = NULL )
	{
		if( $array == NULL)
			$array = $_POST;

		if( $separator == NULL )
			$separator = self::APP_CONFIG()->post_array_delimiter;

		$formated = array();
		(int) $index = 0;
		
		foreach( $array as $k => $v )
		{
			if( preg_match( '/^([a-zA-Z_-]+)([0-9]+)' . $separator . '([a-zA-Z0-9_]+)$/', $k, $m ) )
			{		
				if( count( $m ) == 4 )
				{
					$index = $m[2];
					
					if( array_key_exists( $m[1], $formated ) )
					{
						$formated[ $m[1] ][ $index ][ $m[3] ] = $v;
					}
					else
					{
						$formated[ $m[1] ][$index] = array( $m[3] => $v );
					}
				}
			}
		}
		
		return $formated;
	}
	
	private static $__update_table_vo;
	public function getUpdateTableVo()
	{
		if( ! self::$__update_table_vo )
		{
			self::$__update_table_vo = new UpdateTableFieldVo();
			self::$__update_table_vo->id_value = $this->input->post( 'id_value' );
			self::$__update_table_vo->value_name = $this->input->post( 'value_name' );
			self::$__update_table_vo->value = $this->input->post( 'value' );
		}
		
		return self::$__update_table_vo;
	}
	
	private static $__read_table_vo;
	public function getTableReadVo()
	{
		if( ! self::$__read_table_vo )
		{
			self::$__read_table_vo = new ReadTableVo();
			self::$__read_table_vo->pageNumber = $this->input->post( 'read_page_number' );
			self::$__read_table_vo->rowsPerPage = $this->input->post( 'read_rows_per_page' );
			self::$__read_table_vo->sortColumnName = $this->input->post( 'read_sort_column_name' );
			self::$__read_table_vo->sortDirection = $this->input->post( 'read_sort_direction' );
			self::$__read_table_vo->data_type = $this->input->post( 'read_data_type' );
			
			if( $this->input->post( 'search_is_on' ) )
			{
				$search_input = $this->postArrayParser();
				$search_input = $search_input[ self::SEARCH_PARAMETERS_NAME ];
				
				self::$__read_table_vo->is_search = TRUE;
				self::$__read_table_vo->search_parameters = array();
				
				foreach( $search_input as $v )
				{
					array_push( self::$__read_table_vo->search_parameters, new SearchParameterVo( $v[ 'name' ], $v[ 'value' ], $v[ 'operand' ] ) );
				}
				
			}
		}
		
		return self::$__read_table_vo;
		
	}
	
	public function serializeToKeyValueString( $a )
	{
		if( ! is_array( $a ) || count( $a ) < 1 )
			return;
		
		(string) $s = '';
		foreach( $a as $k => $v )
		{
			$s .= $k . '=' . $v . '&';
		}
		
		$s = substr_replace( $s, '', -1 );
	
	return $s;
	
	}
	
	public function gen_uuid() 
	{
    	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
	
	        // 16 bits for "time_mid"
	        mt_rand( 0, 0xffff ),
	
	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand( 0, 0x0fff ) | 0x4000,
	
	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand( 0, 0x3fff ) | 0x8000,
	
	        // 48 bits for "node"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    	);
	}
	
	public function setDataHolderFromModelOperationVo( ModelOperationReturnVo $mo )
	{
		if( $mo->errorCode == ServerOperationCodes::ALREADY_EXISTS )
		{
			$a = array();
			foreach( $mo->alreadyExistsFields as $v )
			{
				$a[ $v ] = 'VAE';
			}
		
			$this->_data_holder->data()->setData( $a );
			$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
			$this->_data_holder->metadata()->setErrorCode( ServerOperationCodes::ALREADY_EXISTS );
			$this->_data_holder->metadata()->setMessage( ServerMessages::ALREADY_EXISTS );
		}
		else
		{
			$this->_data_holder->metadata()->setStatus( $mo->status );
			$this->_data_holder->metadata()->setErrorCode( $mo->errorCode );
			$this->_data_holder->metadata()->setMessage( $mo->message );
			$this->_data_holder->metadata()->setDataType( $mo->dataType );
			
			$metadata = $this->_data_holder->metadata()->getRawMetadata();
			
			$add = array( 'numRows' => $mo->numRows, 'totalRows' => $mo->totalRows );
			
			if( is_array( $metadata ) )
			{
				array_merge( $metadata, $add );
			}
			else
			{
				$metadata = $add;
			}
			
			$this->_data_holder->metadata()->setData( $metadata );
			
			
			$this->_data_holder->data()->setData( $mo->result );
		}
	}
	
	
	public function dieWithSessionError()
	{
		$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
		$this->_data_holder->metadata()->setErrorCode( ErrorCodes::SESSION_ERROR );
		$this->_data_holder->metadata()->setMessage( ServerMessages::SESSION_ERROR );

		$this->_data_holder->dispatchAll();

		die();
	}

	public function dieWithAccesDenied()
	{
		$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
		$this->_data_holder->metadata()->setErrorCode( ServerOperationCodes::ACCESS_DENIED );
		$this->_data_holder->metadata()->setMessage( ServerMessages::ACCESS_DENIED );

		$this->_data_holder->dispatchAll();

		die();
	}
	
	public function dieWithAccesAuthenticationRequired()
	{
		$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
		$this->_data_holder->metadata()->setErrorCode( ServerOperationCodes::AUTHENTICATION_REQUIRED );
		$this->_data_holder->metadata()->setMessage( ServerMessages::AUTHENTICATION_REQUIRED );

		$this->_data_holder->dispatchAll();

		die();
	}
	
	public function dieWithSessionExpired()
	{
		$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
		$this->_data_holder->metadata()->setErrorCode( ServerOperationCodes::SESSION_EXPIRED );
		$this->_data_holder->metadata()->setMessage( ServerMessages::SESSION_EXPIRED );

		$this->_data_holder->dispatchAll();

		die();
	}
	
	public function dieWithError( $code, $message )
	{
		$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
		$this->_data_holder->metadata()->setErrorCode( $code );
		$this->_data_holder->metadata()->setMessage( $message );

		$this->_data_holder->dispatchAll();

		die();
	}
	
	public function dieWithAppError()
	{
		$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
		$this->_data_holder->metadata()->setErrorCode( ServerOperationCodes::APP_ERROR );
		$this->_data_holder->metadata()->setMessage( ServerMessages::APP_ERROR );

		$this->_data_holder->dispatchAll();

		die();
	}
	
	public function &returnInvalidInputError()
	{
		$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
		$this->_data_holder->metadata()->setErrorCode( ServerOperationCodes::INVALID_INPUT );
		$this->_data_holder->metadata()->setMessage( ServerMessages::INVALID_INPUT );
		
		return $this->_data_holder;
	}
	
	public function &returnDatabaseError()
	{
		$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
		$this->_data_holder->metadata()->setErrorCode( ServerOperationCodes::DATABASE_ERROR  );
		$this->_data_holder->metadata()->setMessage( ServerMessages::DATABASE_ERROR );
		
		return $this->_data_holder;
	}
	
	public function &returnErrorFromErrorCode( $eCode )
	{
		switch( $eCode )
		{	
			case ServerOperationCodes::ACCESS_DENIED:
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( $eCode );
				$this->_data_holder->metadata()->setMessage( ServerMessages::ACCESS_DENIED );
			break;
			
			case ServerOperationCodes::USER_OR_PASS_WRONG:
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( $eCode  );
				$this->_data_holder->metadata()->setMessage( ServerMessages::USER_OR_PASS_WRONG  );
			break;
			
			case ServerOperationCodes::INVALID_INPUT:
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( $eCode  );
				$this->_data_holder->metadata()->setMessage( ServerMessages::INVALID_INPUT );
			break;
			
			case ServerOperationCodes::APP_ERROR:
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( $eCode  );
				$this->_data_holder->metadata()->setMessage( ServerMessages::APP_ERROR );
			break;
			
			case ServerOperationCodes::DATABASE_ERROR:
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( $eCode );
				$this->_data_holder->metadata()->setMessage( ServerMessages::DATABASE_ERROR );
			break;
			
			case ServerOperationCodes::SERVER_FAILED:
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( $eCode  );
				$this->_data_holder->metadata()->setMessage( ServerMessages::SERVER_FAILED );
			break;
			
			case ServerOperationCodes::NOT_FOUND:
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( $eCode  );
				$this->_data_holder->metadata()->setMessage( ServerMessages::NOT_FOUND );
			break;
			
			default:
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( $eCode  );
				$this->_data_holder->metadata()->setMessage( ServerMessages::GENERAL_ERR_MSG );
			break;
			
		}
		
		return $this->_data_holder;
	}
	
}

?>