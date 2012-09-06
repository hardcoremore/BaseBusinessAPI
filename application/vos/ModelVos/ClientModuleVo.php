<?php

class ClientModuleVo
{
	public function __construct( $client_key = NULL, $module_id = NULL, $template_id = NULL, $active = NULL )
	{
		$this->client_key		= $client_key;
		$this->module_id		= $module_id;
		$this->template_id		= $template_id;
		$this->active			= $active;
	}
	
	public $client_key;
	public $module_id;
	public $template_id;
	public $active;
	
}
?>