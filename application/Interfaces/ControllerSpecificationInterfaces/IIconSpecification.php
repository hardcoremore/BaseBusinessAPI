<?php if ( ! defined('BASEPATH')) die();

require_once 'application/vos/controllersVos/SaveIconVo.php';
require_once 'application/vos/controllersVos/UpdateIconVo.php';

interface IIconSpecification
{
	// for createIcon and updateIcon operations
	function saveIcon( SaveIconVo $saveIconVo );
	
	// for loadIcon and deleteIcon operations
	function updateIcon( UpdateIconVo $updateIconVo );
	
}


?>