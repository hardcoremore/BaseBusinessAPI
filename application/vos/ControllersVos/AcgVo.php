<?php

require_once 'application/vos/ControllersVos/AclVo.php';

class AcgVo
{
	public function __construct( $id = NULL, $admin_id = NULL, $name = NULL )
	{
		$this->id		= $id;
		$this->admin_id	= $admin_id;
		$this->name		= $name;
	}
	
	public $id;
	public $admin_id;
	public $admin_id_last_update;
	public $name;
	public $acl; // array of AclVo objects
}
?>