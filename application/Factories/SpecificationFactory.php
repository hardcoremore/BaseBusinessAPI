<?php if ( !defined('BASEPATH') ) die();

class SpecificationFactory
{

	static public function &CLIENTS_SPEC( ApplicationConfigVo $appConfig = NULL )
	{
		
		$i =  self::GET_INSTANCE_FROM_CLASSNAME(  $appConfig,  'ClientsSpecification' );
		
		return $i;
	}
	
	static public function &USERS_SPEC( ApplicationConfigVo $appConfig = NULL )
	{
		
		$i =  self::GET_INSTANCE_FROM_CLASSNAME(  $appConfig,  'UsersSpecification' );
		
		return $i;
	}
	
	static public function &AUTHENTICATION_SPEC( ApplicationConfigVo $appConfig = NULL )
	{
		
		$i =  self::GET_INSTANCE_FROM_CLASSNAME(  $appConfig,  'AuthenticationSpecification' );
		
		return $i;
	}
	
	static public function &TICKETS_SPEC( ApplicationConfigVo $appConfig = NULL )
	{
		
		$i =  self::GET_INSTANCE_FROM_CLASSNAME(  $appConfig,  'TicketsSpecification' );
		
		return $i;
	}
	
	static public function &PARTNERI_SPEC( ApplicationConfigVo $appConfig = NULL )
	{
		
		$i =  self::GET_INSTANCE_FROM_CLASSNAME(  $appConfig,  'PartneriSpecification' );
		
		return $i;
	}
	
	
	static public function &DESKTOP_SPEC( ApplicationConfigVo $appConfig )
	{
		
		$i =  self::GET_INSTANCE_FROM_CLASSNAME(  $appConfig,  'DesktopSpecification' );
		
		return $i;
	}
	
	static public function &ICON_SPEC( ApplicationConfigVo $appConfig )
	{
		
		$i =  self::GET_INSTANCE_FROM_CLASSNAME(  $appConfig,  'IconSpecification' );
		
		return $i;
		
	}
	
	static public function &ACL_SPEC( ApplicationConfigVo $app_config )
	{
		$i =  self::GET_INSTANCE_FROM_CLASSNAME(  $app_config,  'AclSpecification' );
		
		return $i;
	}
	

	public static function &GET_INSTANCE_FROM_CLASSNAME(  $class_name )
	{
		if(  $app_config == NULL ) $app_config = ConfigFactory::APPLICATION_CONFIG();
		
		$inst = NULL;
		
		if( !$app_config->specTemplateId || !$class_name ) return $inst;
		
		if( $app_config->specTemplateId != 'default' )
		{
			$class_name = strtoupper( $app_config->specTemplateId ) . '_' . $class_name;
		}
		
		if( !class_exists( $class_name ) )
		{
			(string) $full_Path = self::GET_PATH_FROM_TEMPLATE( $app_config->specTemplateId ) . $class_name . '.php';
			
			if( file_exists( $full_Path  ) )
			{
				require_once $full_Path;
			}
			else
			{
				require_once self::GET_PATH_FROM_TEMPLATE( 'default' ) . $class_name . '.php';
			}
			
			if( !class_exists( $class_name  )  )
			{
				log_message( 'error', 'Class not found at SpecificationFactory::GET_INSTANCE_FROM_CLASSNAME()' );
				return $inst;
			}
			
		}
		
		$inst = new $class_name();
		
		return $inst;
		
	}

}

?>