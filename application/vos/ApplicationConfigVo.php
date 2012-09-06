<?php

class ApplicationConfigVo
{
	
	public $name;
	public $salt;
	public $domain;
	public $extend_session;
	public $post_array_delimiter;
	public $specifications_path;
	public $logic_path;
	public $app_root_folder;
	public $controller_root_uri;
	public $require_authentication;
	
	public function __construct( $name = NULL, $salt = NULL, $domain = NULL )
	{
		$this->name 	= $name;
		$this->salt 	= $salt;
		$this->domain 	= $domain;
	}
}


?>
