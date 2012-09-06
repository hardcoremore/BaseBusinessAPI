<?php

require_once 'application/vos/ModuleVo.php';

class ClientsVo
{
	public $client_id;
	public $client_key;
	public $client_database_key; 

								// uuid key of the admin that creates the user
								// uuid key of client storage. Typically database name
	
	public $client_max_users_allowed;
	public $client_name;
	public $client_email;
	public $client_date_created;
	public $client_subscription_valid;
	public $client_payed_subscriptions;
	public $client_subscription_valid_till;
	public $client_note;
}
?>