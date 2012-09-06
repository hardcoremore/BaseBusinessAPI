<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/TableGatewayInterfaces/IAuthenticationTableGateway.php';
require_once 'application/libraries/MysqliBaseTableGateway.php';
require_once 'application/vos/UserVo.php';

class DesktopTableGateway extends MysqliBaseTableGateway implements IDesktopTableGateway
{
	public function __construct()
	{
		parent::__construct();
		$this->_tableName = 'icons';
	}
	
	function &createIcon( SaveIconVo $saveIconVo )
	{
		
	}
	
	function &updateIcon( SaveIconVo $saveIconVo )
	{
		
	}
	
	function &loadIcon( UpdateIconVo $updateIconVo )
	{
		
	}
	
	function &deleteIcon( UpdateIconVo $updateIconVo )
	{
		
	}
	
	function &createDesktop( SaveDesktopVo $saveDesktopVo )
	{
		
	}
	
	function &updateDesktopState( SaveDesktopVo $saveDesktopVo )
	{
		
	}
	
	function &loadDesktop( UpdateDesktopVo $updateDesktopVo )
	{
		
	}
	
	function &deleteDesktop( UpdateDesktopVo $updateDesktopVo )
	{
		
	}
	
	function &changeBackground( ChangeBackgroundVo $changeBckVo )
	{
		
	}

}

?>