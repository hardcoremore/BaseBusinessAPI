<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/TableGatewayInterfaces/IIconTableGateway.php';
require_once 'application/libraries/MysqliBaseTableGateway.php';

class IconTableGateway extends MysqliBaseTableGateway implements IIconTableGateway
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
	

}

?>