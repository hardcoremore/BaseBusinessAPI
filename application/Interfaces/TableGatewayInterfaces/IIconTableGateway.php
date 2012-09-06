<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/controllersVos/SaveIconVo.php';
require_once 'system/application/vos/controllersVos/UpdateIconVo.php';

interface IIconTableGateway
{
	function &createIcon( SaveIconVo $saveIconVo );
	function &updateIcon( SaveIconVo $saveIconVo );
	
	function &loadIcon( UpdateIconVo $updateIconVo );
	function &deleteIcon( UpdateIconVo $updateIconVo );
}

?>