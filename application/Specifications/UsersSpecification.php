<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/ControllerSpecificationInterfaces/IUsersSpecification.php';
require_once 'application/libraries/BaseSpecification.php';
require_once 'application/Specifications/ClientsSpecification.php';

class UsersSpecification extends BaseSpecification implements IUsersSpecification
{	
	public function id( $id )
	{
		if(  is_numeric( $id ) &&  $id > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	public function slika( $slika )
	{
		if( $this->image( $slika ))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function acg( $acg )
	{
		if( $this->id( $acg ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;;
		}
	}
	
	public function userName( $userName )
	{
		
		if( !is_numeric( $userName ) && strlen( $userName ) >= 3 && $userName < 31 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;;
		}
	}
	
	public function password( $password )
	{
		
		if( strlen( $password ) >= 6  )
		{
			return TRUE;
		}
		else
		{
			return FALSE;;
		}
	}
	
	public function userType( $userType )
	{
		if( 
			$userType == 'SuperAdministrator' || 
			$userType == 'Administrator' || 
			$userType == 'Regular' ||
			$userType == 'Guest'
		  )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function name( $name )
	{
		if( !is_numeric($name) && strlen( $name ) > 1 && $name < 51 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function lastName( $lastName )
	{
		if( $this->name( $lastName ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function gender( $gender )
	{
		if( $gender == 1 || $gender == 2 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	public function authenticate( AuthenticationVo $authVo )
	{
		if( 
			$this->userName( $authVo->username ) &&
			$this->password( $authVo->password )
		  )
		  {
		  	return TRUE;
		  }
		  else
		  {
		  	return FALSE;
		  }
	}
	
	public function create( UserVo $user )
	{
		if(
			$this->name( $user->user_name ) &&
			$this->lastName( $user->user_last_name ) &&
			$this->userName( $user->username ) &&
			$this->password( $user->password ) &&
			$this->email( $user->user_email ) &&
			$this->gender( $user->user_gender ) 
		  )
		{
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
	
	public function update( UserVo $user )
	{
		if( $this->id( $user->user_id ) && $this->create( $user ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function delete( UserVo $user )
	{
		if( $this->id( $user->user_id ) )
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