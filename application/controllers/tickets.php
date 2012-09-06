<?php if ( !defined('BASEPATH')) die();

require_once 'system/application/controllers/base.php';
require_once 'system/application/Factories/BusinessLogicFactory.php';
require_once 'system/application/vos/ControllersVos/ClientsVo.php';
require_once 'system/application/vos/TableGatewayVos/TableGatewayReadVo.php';

class Tickets extends Base 
{
	
	public function Tickets()
	{
		parent::Base();	
		$this->_businessLogic = BusinessLogicFactory::TICKETS_LOGIC( $this->_config ); 
	}
	
	function create( ClientsVo $client = NULL,  $return = FALSE )
	{	
		if( $client == NULL )
			$this->_getClientFromPost();
		
		
		$r = $this->_businessLogic->create( $client );

		if( $return )
		{
			return $r;
		}
		elseif( $r )
		{
			$r->dispatchAll();
			return 0;
		}
		
	}

	function read( TableGatewayReadVo $read )
	{
		
	}
	
	
	public function saveClientModules( ClientsVo $client = NULL, $return = FALSE )
	{
		
		if( $client == NULL )
		{
			$client = new ClientsVo();
			$client->key_id 	= $this->input->post( '_CLIENT_key_id' );
			
			$modules 			= $this->postArrayParser();
			$client->modules 	= $modules[ self::CLIENT_MODULES_POST_NAME ];
		}
		
		$r = $this->_businessLogic->saveClientModules( $client );

		if( $return )
		{
			return $r;
		}
		elseif( $r )
		{
			$r->dispatchAll();
			return 0;
		}
		
	}
	
	public function createClientUser( $client_key = NULL, UserVo $user = NULL, $return = FALSE )
	{
	
		if( $client_key == NULL )
			  $client_key = $this->input->post( '_CLIENT_key_id' );
			
		if( $user == NULL )
			$user = $this->_getUserFromPost();
		
	
		$r = $this->_businessLogic->createClientUser( $client_key,  $user );

		if( $return )
		{
			return $r;
		}
		elseif( $r )
		{
			$r->dispatchAll();
			return 0;
		}
	}
	
	
	public function update( ClientsVo $client = NULL,  $return = FALSE )
	{
		
		if( $client == NULL )
			$this->_getClientFromPost();
		
		
		$r = $this->_businessLogic->update( $client );

		if( $return )
		{
			return $r;
		}
		elseif( $r )
		{
			$r->dispatchAll();
			return 0;
		}
		
	}
	
	public function delete() 
	{
		if( $client == NULL )
			$this->_getClientFromPost();
		
		
		$r = $this->_businessLogic->delete( $client );

		if( $return )
		{
			return $r;
		}
		elseif( $r )
		{
			$r->dispatchAll();
			return 0;
		}
	}
	
	protected function &_getClientFromPost()
	{
		$client = new ClientsVo();
		$client->admin_key 						= $this->input->post( '_CLIENT_admin_key' );
		$client->name 							= $this->input->post( '_CLIENT_name' );
		$client->email 							= $this->input->post( '_CLIENT_email' );
		$client->business_logic_template_name 	= $this->input->post( '_CLIENT_business_logic_template_name' );
		$client->specification_template_name 	= $this->input->post( '_CLIENT_specification_template_name' );
		$client->note 							= $this->input->post( '_CLIENT_note' );
		$client->logo 							= $this->input->post( '_CLIENT_logo' );
		$client->subscription_valid_till 		= $this->input->post( '_CLIENT_subscription_valid_till' );
		
		return $client;
	}
	
	
	protected function &_getUserFromPost()
	{
		$user = new UserVo();
		$user->acg 			=  $this->input->post( '_USER_acg' );
		$user->gender 		=  $this->input->post( '_USER_gender' );
		$user->user_type 	=  $this->input->post( '_USER_user_type' );
		$user->name 		=  $this->input->post( '_USER_name' );
		$user->last_name 	=  $this->input->post( '_USER_last_name' );
		$user->username 	=  $this->input->post( '_USER_username' );
		$user->password 	=  $this->input->post( '_USER_password' );
		$user->email 		=  $this->input->post( '_USER_email' );
		$user->gender 		=  $this->input->post( '_USER_gender' );
		$user->slika 		=  $this->input->post( '_USER_slika' );
		
		return $user;
	}
	
} 

/* End of file clients.php */
/* Location: ./system/application/controllers/clients.php */