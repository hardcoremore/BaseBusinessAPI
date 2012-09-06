<?php

class AclVo
{
	public function __construct( $user_id = NULL, $module_id  = NULL, $action_id = NULL, $access = NULL )
	{
		$this->user_id 		= $user_id;
		$this->module_id	= $module_id;
		$this->action_id	= $action_id;
		$this->access		= $access;
	}
	
	public $user_id;
	public $module_id;
	public $action_id;
	public $access;

}
?>