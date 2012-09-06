<?php

require_once 'application/vos/UserVo.php';

class CreateClientUserVo
{
	public function __construct( $client_key = NULL, UserVo $user )
	{
		$this->client_key	= $client_key;
		$this->user 		= $user;
	}
								
	public $client_key;
	public $user; // UserVo
}
?>