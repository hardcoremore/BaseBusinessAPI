<?php 

class AuthenticationVo
{
	public function __construct( $database_key = NULL, $username = NULL, $password = NULL, $language = NULL )
	{
		$this->key = $database_key;
		$this->username = $username;
		$this->password = $password;
		$this->language = $language;

	}

	public $key;
	public $clientId;
	public $username;
	public $password;
	public $language;
}


?>