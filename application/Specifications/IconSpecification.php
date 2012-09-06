<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/ControllerSpecificationInterfaces/IIconSpecification.php';

class IconSpecification implements IIconSpecification
{
	
	public function __construct()
	{
	}
	
	// created or updates icon
	function saveIcon( SaveIconVo $saveIconVo )
	{
		
	}
	
	// loads or deletes icon
	function updateIcon( UpdateIconVo $updateIconVo )
	{
		
	}
	
}

?>