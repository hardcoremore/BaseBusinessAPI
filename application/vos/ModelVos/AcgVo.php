<?php

require_once 'application/vos/ControllersVos/AclVo.php';

class AcgVo
{
	public function __construct( $acg_id = NULL, $acg_name = NULL, $acg_created_user_id = NULL )
	{
		$this->acg_id					= $acg_id;
		$this->acg_name					= $acg_name;
		$this->acg_created_user_id		= $acg_created_user_id;
	}
	
	public $acg_id;
	public $acg_name;
	public $acg_created_user_id;
	public $acg_global_access;
}
?>