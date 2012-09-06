<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/ControllerSpecificationInterfaces/IClientsSpecification.php';
require_once 'application/libraries/BaseSpecification.php';
require_once 'application/libraries/utility/ModuleNames.php';

class ClientsSpecification extends BaseSpecification implements  IClientsSpecification
{	 
	public function client_key( $key )
	{
		return preg_match( '/^[a-zA-z_.]+[0-9]*$/i', $key ) && strlen( $key ) >= 6;
	}
	
	public function client_database_key( $key )
	{
		return preg_match( '/[a-zA-z0-9]{32}/i', $key );
	}
	
	public function modules( $modules )
	{
		if( ! is_array( $modules ) || count( $modules ) < 2 )
		{
			return FALSE;
		}
		else
		{
			if( ! in_array( 'privileges', $modules ) || ! in_array( 'users', $modules ) )
			{
				return FALSE;
			}
			
			foreach( $modules as $m )
			{
				if( ! preg_match( '/^[a-z_]+[0-9]*$/', $m ) )
				{
					break;
					return FALSE;
				}
			}
			
			return TRUE;
		}
	}
	
	public function clientName( $name )
	{
		if( strlen( $name ) >= 6 &&  ! is_numeric( $name ) && strlen( $name ) < 255 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;	
		}
	}
	
	public function logicTemplateGroupId( $t_id )
	{
		if( is_numeric( $t_id ) && $t_id > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;	
		}
	}
	
	public function note( $note )
	{
		$l = strlen( $note );
		
		if( $l >= 0 && $l < 2000 )
		{
			return TRUE;
		} 
		else 
		{
			return FALSE;
		}
	}

	public function create( ClientsVo $client )
	{    
		if(  
				$this->client_key( $client->client_key ) &&
				$this->client_database_key( $client->client_database_key ) &&
				$this->clientName( $client->client_name ) &&
				$this->email( $client->client_email ) &&
				$this->note( $client->client_note )
		   )
		{
			
			if( ! $client->client_subscription_valid && $client->client_subscription_valid_till > time()  )
				return FALSE;
			
			return TRUE;	
			
		}
		else 
		{
			return FALSE;
		}
	}
	
	public function loadUserClient( $client_key )
	{
		if( $this->client_key( $client_key ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function saveClientModules( $client_id, $modules )
	{
		if( $this->digitOnly($client_id ) && is_array( $modules ) && count( $modules ) > 0 )
		 {
		 	return TRUE;
		 }
		 else
		 {
		 	return FALSE;
		 }
				
	}
	
	public function update( ClientsVo $client )
	{
		if( $this->digitOnly( $client->client_id ) && $this->create( $client ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	
}



?>