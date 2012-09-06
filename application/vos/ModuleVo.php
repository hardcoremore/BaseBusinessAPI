<?php
class ModuleVo
{
	public function __construct( $id = NULL, $action = NULL, $name = NULL, $active = NULL, $public = NULL )
	{
		$this->module_id			= $id;
		$this->action			    = $action;
		$this->module_name			= $name;
		$this->module_active		= $active;
		$this->module_public		= $public;
	}
	
	public $module_id;
	public $action;
	public $module_name;
	public $module_active;
	public $module_public;
	
}
?>