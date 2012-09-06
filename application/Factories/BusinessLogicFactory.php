<?php if ( !defined('BASEPATH') ) die();

require_once 'application/vos/AuthenticationVo.php';
require_once 'application/Factories/ConfigFactory.php';
require_once 'application/libraries/FactoryBase.php';

class BusinessLogicFactory extends FactoryBase
{
	/**************
	 * 
	 * LOGICS
	 * 
	 ***************/
	public function &INSTALL_LOGIC()
	{
		$i =  $this->GET_LOGIC_INSTANCE( 'InstallLogic' );
		return $i;
	}
	
	public function &PRIVILEGES_LOGIC()
	{
		$i =  $this->get_logic_instance( 'PrivilegesLogic' );
		return $i;
	}
	
	public function &USERS_LOGIC()
	{
		$i =  $this->get_logic_instance( 'UsersLogic' );	
		return $i;
	}
	
	public function &CLIENTS_LOGIC()
	{
		$i =  $this->get_logic_instance( 'ClientsLogic' );
		
		return $i;
	}
	
	public function &TICKETS_LOGIC()
	{
		$i =  $this->get_logic_instance( 'TicketsLogic' );
		
		return $i;
	}
	 
	public function &DESKTOP_LOGIC()
	{
		
		$i =  $this->get_logic_instance( 'DesktopLogic' );
		
		return $i;
	}
	
	public function &get_logic_instance( $class_name )
	{
		$inst = NULL;		
		
		$file_name =  $class_name . EXT;
		
		if( ! class_exists( $class_name ) )
		{
			(string) $full_path = $this->appConfig()->logic_path . $file_name;

			if( file_exists( $full_path  ) )
			{
				require_once $full_path;
			}
			else
			{
				log_message( 'error', "Class NOT found at BusinessLogicFactory::GET_LOGIC_INSTANCE(). FullPath: " . $full_path );
				return $inst;
			}	
		}
		
		$inst = new $class_name();
		 
		return $inst;
	}
	
}

?>