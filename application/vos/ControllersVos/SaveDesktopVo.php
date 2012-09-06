<?php

require_once 'application/vos/controllersVos/DesktopStateVo.php';

class SaveDesktopVo
{
	public function __construct(){}
								
	public $userId;
	public $desktopName;
	public $desktop; // DesktopStateVo
	
}
?>