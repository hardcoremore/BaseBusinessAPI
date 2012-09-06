<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/ControllerSpecificationInterfaces/IAclSpecification.php';

class PrivilegesSpecification implements IAclSpecification 
{
	private $__authSpec;
	
	public function __construct()
	{
		
	}
	
	public function isAllowed( $controller, $action )
	{
		if( 
			$controller &&
			$action &&
			strlen( $controller ) >= 3 &&
			strlen( $action ) >= 3 
		  )
		  {
		  	return TRUE;
		  }
		  else
		  {
		  	return FALSE;
		  }
	}
	
	public function loadAcgl( $userAcgId )
	{
		$this->__loadAuthSpec();
		
		return $this->__authSpec->userId( $userAcgId );
		
	}
	
	public function loadAcl( $userId )
	{
		$this->__loadAuthSpec();
		
		return $this->__authSpec->userId( $userId );
	}
	
	
	private function __loadAuthSpec()
	{
		$this->__authSpec = SpecificationFactory::AUTHENTICATION_SPEC( ConfigFactory::APPLICATION_CONFIG() );
	}
}

?>