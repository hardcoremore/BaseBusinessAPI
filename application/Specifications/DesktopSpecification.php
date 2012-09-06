<?php if ( !defined('BASEPATH') ) die();

require_once 'application/libraries/BaseSpecification.php';
require_once 'application/vos/ModelVos/DesktopAppearanceVo.php';

class DesktopSpecification extends BaseSpecification
{
	
	public function __construct()
	{
	}
	
	public function createAppearance( DesktopAppearanceVo $appearance )
	{
		return TRUE;
	}
	
	public function updateAppearance( DesktopAppearanceVo $appearance )
	{
		return TRUE;
	}
	
	public function deleteAppearance( DesktopAppearanceVo $appearance )
	{
		return TRUE;
	}
}

?>