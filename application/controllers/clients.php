<?php if ( !defined('BASEPATH')) die();

require_once 'application/controllers/BaseController.php';
require_once 'application/vos/ModelVos/ClientsVo.php';


class Clients extends BaseController 
{	
	const CLIENT_MODULES_POST_NAME	= '_CLIENT_MODULES_';
	
	function create( ClientsVo $client = NULL )
	{	
		if( $client == NULL )
		{
			$client = new ClientsVo();
			$client->client_key = $this->input->post( 'client_key' );
			$client->client_database_key = md5( md5( md5( $this->input->post( 'client_key' ) ) ) );
			$client->client_date_created = date( 'Y-m-d');
			$client->client_email = $this->input->post( 'client_email' );
			$client->client_max_users_allowed = $this->input->post( 'client_max_users_allowed' );
			$client->client_name = $this->input->post( 'client_name' );
			$client->client_subscription_valid = $this->input->post( 'client_subscription_valid' );
			$client->client_subscription_valid_till = $this->input->post( 'client_subscription_valid_till' );
			$client->client_payed_subscriptions = $this->input->post( 'client_payed_subscriptions' );
			$client->client_note = $this->input->post( 'client_note' );
		}	
		
		$this->setDataHolderFromModelOperationVo( $this->cm->create( $client ) );
		$this->_data_holder->dispatchAll();
	}

	function read()
	{
		$this->setDataHolderFromModelOperationVo( $this->cm->read() );
		$this->_data_holder->dispatchAll();
	}

	public function loadPublicModules()
	{
		
	}
	
	public function saveClientModules( $client_id = NULL, $modules = NULL )
	{
		
		if( ! $client_id )
			$client_id = $this->input->post( 'client_id' );
		
		if( ! $modules )
		{
			$modules = array();
			
			$post_modules =& $this->postArrayParser();
			$post_modules =  $post_modules[ self::CLIENT_MODULES_POST_NAME ];
			
			$module = NULL;
			foreach( $post_modules as $m )
			{
				if( is_array( $m ) )
				{
					$module = new ModuleVo();
					if( array_key_exists( "module_id", $m ) ) $module->module_id = $m[ "module_id" ];
					if( array_key_exists( "action", $m ) ) $module->action = $m[ "action" ];
					if( array_key_exists( "module_name", $m ) ) $module->module_name = $m[ "module_name" ];
					if( array_key_exists( "module_active", $m ) ) $module->module_active = $m[ "module_active" ];
					if( array_key_exists( "module_public", $m ) ) $module->module_public = $m[ "module_public" ];
					 
					array_push( $modules, $module );
				}
			}
		}
		
		
		
		$this->setDataHolderFromModelOperationVo( $this->cm->saveClientModules( $client_id, $modules ) );
		$this->_data_holder->dispatchAll();
		
	}
	
	public function loadClientModules( $client_id = NULL )
	{
		if( ! $client_id )
			$client_id = $this->input->post( 'client_id' );
		
		$this->setDataHolderFromModelOperationVo( $this->cm->loadClientModules( $client_id ) );
		$this->_data_holder->dispatchAll();	
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
		$client->logic_template_group_id	 	= $this->input->post( '_CLIENT_logic_template_group_id' );
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