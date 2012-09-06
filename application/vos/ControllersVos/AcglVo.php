<?php

require_once 'application/vos/ControllersVos/AclVo.php';

class AcglVo
{
	public function __construct( $acg_id = NULL, AclVo $acl  = NULL )
	{
		$this->acg_id 	= $acg_id;
		$this->acl		= $acl;
		
	}
	
	public $acg_id;
	public $acl; // AclVo object
	
}
?>