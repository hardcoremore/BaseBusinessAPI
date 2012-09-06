<?php if ( !defined('BASEPATH')) die();

require_once 'application/controllers/BaseController.php';

class Users extends BaseController
{
	protected $_user_logic;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model( 'User_model', 'um' );
		$this->um->loadDatabase();
	}
	
	public function authenticate( AuthenticationVo $authVo = NULL )
	{		
		if( $authVo == NULL )
		{
			$authVo = new AuthenticationVo( 
											$this->input->post( 'username' ),  
											$this->um->encodePassword( $this->input->post( 'password' ) ),
											$this->input->post( 'language' ) 
										   );
		}
		
		
		$this->setDataHolderFromModelOperationVo( $this->um->authenticate( $authVo ) );
		$this->_data_holder->dispatchAll();
	}

	public function checkLogin( AuthenticationVo $authVo = NULL )
	{
		
		if( $authVo == NULL )
		{
			$authVo = new AuthenticationVo( 	
												$this->um->currentUser()->username,  
												$this->um->encodePassword( $this->input->post( 'password' ) )
										   );
		}
		
		
		
		$r = $this->um->checkLogin( $authVo );
		
		if( $r->status == self::STATUS_OK )
		{
			$this->_data_holder->metadata()->setStatus( self::STATUS_OK );
			$this->_data_holder->metadata()->setErrorCode( 0 );
			
		}
		else
		{
			$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
			$this->_data_holder->metadata()->setErrorCode( $r->errorCode );
			$this->_data_holder->metadata()->setMessage( $r->message );
		}
		
		$this->_data_holder->dispatchAll();
	}
	
	public function logout() 
	{
	
	}
	
	public function lock()
	{
		$this->_session->set( BaseController::SYSTEM_SESSION_NAME_SPACE, BaseController::SYSTEM_SESSION_STATE_NAME,	BaseController::SYSTEM_LOGIN_STATE_LOCKED );
	}
	
	public function unlock()
	{
		
	}
	
	public function create( CustomersVo $user = NULL )
	{
		if( ! $user )
			$user = $this->getUserFromInput();
	 	
		$this->setDataHolderFromModelOperationVo( $this->um->create( $user ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function read( ReadTableVo $readVo = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		$this->setDataHolderFromModelOperationVo( $this->um->read( $readVo ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function update( UserVo $user = NULL  )
	{
		if( ! $user )
			$user = $this->getUserFromInput();
	
		$this->setDataHolderFromModelOperationVo( $this->um->update( $user ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function delete()
	{
		
	}
	
	public function getUserFromInput()
	{
		$user = new UserVo();
		$user->password = $this->input->post( 'password' );
		$user->user_acg_id = $this->input->post( 'user_acg_id' );
		$user->user_creation_date = date("Y-m-d");
		$user->user_email = $this->input->post( 'user_email' );
		$user->user_gender = $this->input->post( 'user_gender' );
		$user->user_id = $this->input->post( 'user_id' );
		$user->user_last_name = $this->input->post( 'user_last_name' );
		$user->user_mobile_number = $this->input->post( 'user_mobile_number' );
		$user->user_name = $this->input->post( 'user_name' );
		$user->user_phone_number = $this->input->post( 'user_phone_number' );
		$user->username = $this->input->post( 'username' );
		
		return $user;
	}
	
}
?>