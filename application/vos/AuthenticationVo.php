<?php 

class AuthenticationVo
{
	public function __construct( $username = '', $password = '', $language = '' )
	{
		$this->username = $username;
		$this->password = $password;
		$this->language = $language;
	}
	
	public $username;
	public $password;
	public $language;
}


?>