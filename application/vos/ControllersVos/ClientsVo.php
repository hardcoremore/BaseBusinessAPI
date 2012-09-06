<?php

require_once 'application/vos/ModuleVo.php';

class ClientsVo
{
	public function __construct( $key_id  = NULL,$data_storage_id = NULL, $name = NULL, $email = NULL )
	{
		$this->key_id			= $key_id;
		$this->data_storage_id 	=$data_storage_id;
		$this->name				= $name;
		$this->email			= $email;
	}
	
	public $key_id;
	public $admin_key; // uuid key of the admin that creates the user
	public $data_storage_id; // uuid key of client storage. Typically database name
	public $modules; // array of ModuleVo objects
	public $name;
	public $email;
	public $logo;
	public $date_created;
	public $subscription_valid;
	public $payed_subscriptions;
	public $subscription_valid_till;
	public $note;
	public $max_users;
}
?>