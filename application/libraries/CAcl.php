<?php
class CAcl
{
	private $__acl 				= NULL;
	private $__acgl 			= NULL;
	private $__allowedModules	= array();
	
	private function __construct(){}
	
	const MODULE_NAME_KEY 		= 'name';
	const MODULE_ID_KEY 		= 'module_id';
	const ACTION_NAME_KEY 		= 'action_name';
	const ALLOWED_ACTIONS_KEY 	= 'allowed_actions';
	const ACCESS_KEY 			= 'access';
		
	public static function &getInstance()
	{
		static $instance;
		
		if(!$instance)
		{				
			$instance = new CAcl();
		}
		return $instance;
	}

	public function &parseAcl( $acgl, $acl )
	{
		if( ! $acgl || ! is_array( $acgl )|| ! is_array( $acl ) || ! $acl ) 
		{
			log_message( 'debug', 'Invalid input at CAcl::parseAcl()' );
			return;
		}
		
		$tmpModId = NULL;
		$tmpArr = array();
		$tmpActArr = array();
		$switch = 0;
		$tmpAllowedModules = array();
		
		foreach( $acgl as $v )
		{	
			if( $tmpModId == $v[ self::MODULE_ID_KEY ] )
			{				
				array_push( $tmpActArr, $v[ self::ACTION_NAME_KEY ] );
				$tmpModId = $v[ self::MODULE_ID_KEY ];
				$switch = $v[ self::MODULE_ID_KEY ];
				$name =  $v[ self::MODULE_NAME_KEY ];
				
				$tmpAllowedModules[ $v[ self::MODULE_ID_KEY ] ][ self::MODULE_NAME_KEY ] =  $v[ self::MODULE_NAME_KEY ];
				$tmpAllowedModules[ $v[ self::MODULE_ID_KEY ] ][ self::ALLOWED_ACTIONS_KEY ] =  $tmpActArr;
							
			}
			else
			{			
				
				if( $switch == 0 )
				{
					$switch   = $v[ self::MODULE_ID_KEY ];
					$name 	  = $v[ self::MODULE_NAME_KEY ];
					$tmpModId = $v[ self::MODULE_ID_KEY ];
					array_push( $tmpActArr, $v[ self::ACTION_NAME_KEY ] );
					continue;
				}

					$tmpAllowedModules[ $switch ][ self::MODULE_NAME_KEY ] =  $name; 
					$tmpAllowedModules[ $switch ][ self::ALLOWED_ACTIONS_KEY ] =  $tmpActArr;
					 
					$tmpActArr = array();
					$tmpModId = $v[ self::MODULE_ID_KEY ];							
					array_push( $tmpActArr, $v[ self::ACTION_NAME_KEY ] );
					
					$tmpAllowedModules[ $v[ self::MODULE_ID_KEY ] ][ self::MODULE_NAME_KEY] =  $v[ self::MODULE_NAME_KEY ];
					$tmpAllowedModules[ $v[ self::MODULE_ID_KEY ] ][ self::ALLOWED_ACTIONS_KEY ] =  $tmpActArr;										
						
			}
		}
		
		foreach( $acl as $v )
		{
			foreach( $tmpAllowedModules as $k2 => $v2 )
			{
				if( $v[ self::MODULE_ID_KEY ] == $k2 )
				{
					if($v[ self::ACCESS_KEY ] == 0)
					{
						if( $v[ self::ACTION_NAME_KEY ] == 'read' )
						{
							unset( $tmpAllowedModules[$k2] );
							continue;
						}
						else
						{
							$action = array_search( $v[ self::ACTION_NAME_KEY ], $v2[ self::ALLOWED_ACTIONS_KEY ] );
							if( $action !== FALSE )
							{
								unset( $tmpAllowedModules[$k2][ self::ALLOWED_ACTIONS_KEY ][$action] );
							}
						}
												
					}
					elseif( $v[ self::ACCESS_KEY ] == 1 )
					{
						array_push( $tmpAllowedModules[$k2][ self::ALLOWED_ACTIONS_KEY ], $v[ self::ACTION_NAME_KEY ] );
					}	
				}
			}
		}
		

		$this->__allowedModules =& $tmpAllowedModules;
		
		return $this;
	}
	
	public function setAcgl( $acgl )
	{
		
	}
	
	public function setAcl( $acl )
	{
		if( $acl && is_array( $acl ) && count( $acl ) > 0 )
		{
			$this->__allowedModules = $acl;
		}
		else
		{
			log_message( 'debug', 'Invalid input at CAcl::setAcl()' );
		}
	}
	
	public function getAcl()
	{
		return $this->__allowedModules;
	}
	
	public function getModuleAcl( $module )
	{
		if( $module && strlen( $module ) > 0 )
		{
			if( $this->isAclValid() )
			{
				foreach( $this->__allowedModules as $k => $v )
				{
					if( $v[ self::MODULE_NAME_KEY ] == $module )
					{
						return $this->__allowedModules[ $k ];
						break;
					}
				}
			}
			else
			{
				log_message('debug', 'Invalid acl at CAcl::getModuleAcl()');
				return FALSE;
			}
		}
		else
		{
			log_message('debug', 'Invalid input at CAcl::getModuleAcl()');
			return FALSE;
		}
	}
	
	public function hasModule( $module )
	{
		if( ! $module || strlen( $module ) < 3 )
		{
			log_message( 'debug', 'invalid input at CAcl::hasModule()');
			return;
		}
		
		if( $this->isAclValid() )
		{
			foreach( $this->__allowedModules as $k => $v )
			{
				if( $v[ self::MODULE_NAME_KEY ] == $module )
				{
					return TRUE;
				}
			}
		}
		else 
		{
			log_message('debug', 'Acl is invalid at CAcl::hasModule()' );
		}
		
		return FALSE;
	}
	
	public function isAllowed( $module, $action )
	{
		if( $module && $action )
		{
			if( $this->isAclValid() )
			{
				foreach( $this->__allowedModules as $k => $v )
				{
					if( $v[ self::MODULE_NAME_KEY ] == $module )
					{
						$action_search = array_search( $action, $v[ self::ALLOWED_ACTIONS_KEY ] );
						if( $action_search !== FALSE )
						{
							return true;
						}
						else
						{
							return false;
						}
					}
				}
				
			}
			else
			{
				log_message( 'debug', 'Acl is invalid at CAcl::isAllowed()');
				return false;
			}
		}
		else
		{
			log_message( 'debug', 'Invalid input at CAcl::isAllowed()');
			return false;
		}
	}
	
	public function isAclValid()
	{
		if(  $this->__allowedModules && is_array( $this->__allowedModules ) && count( $this->__allowedModules ) > 0 )
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