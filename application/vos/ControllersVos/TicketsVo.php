<?php

class TicketsVo
{
	public function __construct( $key_id  = NULL, $name = NULL, $email = NULL )
	{
		$this->key_id	= $key_id;
		$this->name		= $name;
		$this->email	= $email;
	}
	
	public $key_id;
	public $admin_key; // uuid key of the admin that creates the user
	public $modules; // array of modules that client can use
	public $name;
	public $email;
	public $logo;
	public $business_logic_template_name;
	public $specification_template_name;
	public $date_created;
	public $subscription_valid;
	public $payed_subscriptions;
	public $subscription_valid_till;
	public $note;
}
?>