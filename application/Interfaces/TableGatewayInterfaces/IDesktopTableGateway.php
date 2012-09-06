<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/controllersVos/SaveIconVo.php';
require_once 'system/application/vos/controllersVos/SaveDesktopVo.php';
require_once 'system/application/vos/controllersVos/UpdateDesktopVo.php';
require_once 'system/application/vos/controllersVos/UpdateIconVo.php';
require_once 'system/application/vos/controllersVos/ChangeBackgroundVo.php';

interface IDesktopTableGateway
{
	function &createIcon( SaveIconVo $saveIconVo );
	function &updateIcon( SaveIconVo $saveIconVo );
	
	function &loadIcon( UpdateIconVo $updateIconVo );
	function &deleteIcon( UpdateIconVo $updateIconVo );
	
	function &createDesktop( SaveDesktopVo $saveDesktopVo );
	function &updateDesktopState( SaveDesktopVo $saveDesktopVo );
	
	function &loadDesktop( UpdateDesktopVo $updateDesktopVo );
	function &deleteDesktop( UpdateDesktopVo $updateDesktopVo );
	
	function &changeBackground( ChangeBackgroundVo $changeBckVo );
}

?>