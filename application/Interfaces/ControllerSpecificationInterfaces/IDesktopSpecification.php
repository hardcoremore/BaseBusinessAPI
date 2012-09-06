<?php if ( ! defined('BASEPATH')) die();

require_once 'application/vos/controllersVos/SaveDesktopVo.php';
require_once 'application/vos/controllersVos/UpdateDesktopVo.php';
require_once 'application/vos/controllersVos/ChangeBackgroundVo.php';

interface IDesktopSpecification
{
	// for createDesktop and updateDesktop operations
	function saveDesktop( SaveDesktopVo $saveDesktopVo );
	
	// for loadDesktop and deleteDesktop operations
	function updateDesktop( UpdateDesktopVo $updateDesktopVo );

	
	function changeBackground( ChangeBackgroundVo $changeBckVo );
}


?>