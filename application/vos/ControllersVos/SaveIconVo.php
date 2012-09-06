<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/controllersVos/DesktopIconVo.php';

class SaveIconVo
{
	public function __construct(){}
								
	public $userId;
	public $desktopName;
	public $icon; // DesktopIconVo
	
}
?>