<?php if ( !defined('BASEPATH') ) die();

require_once 'application/libraries/BaseSpecification.php';

class ClientModuleSpecification extends BaseSpecification
{	
	
	public function __construct()
	{
	}
	
	public function id( $id )
	{
		if(  $this->digitOnly( $id ) && $id > 0 )
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
		if( $this->baseAlphaNumericName( $name ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function template( $template )
	{
		if( $this->baseAlphaNumericName( $template ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;;
		}
	}
	
	public function installModule( ModuleVo $module )
	{
		return $this->name( $module->name ) && $this->template( $module->template );
	}
	

	
}



?>