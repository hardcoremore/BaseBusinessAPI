<?php

require_once 'application/vos/controllersVos/DesktopBackgroundVo.php';

class DesktopStateVo
{
	public function __construct(){}
	
	public $taskBarLayout;
	public $taskBarPosition;
	public $wallPaper; // DesktopBackgroundVo
	public $autoStartModules;
	public $notifBarPosition;
	public $icons; // array of DesktopIconVo objects
	
}