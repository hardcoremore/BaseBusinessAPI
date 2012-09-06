<?php

require_once 'application/Interfaces/IDispatcher.php';

class BaseObject extends CI_Controller implements IDispatcher
{
	private $__dispatcher;
	
	public function __construct()
	{
		parent::__construct();
		$this->__dispatcher = new EventDispather( $this );	
	}
	
	public function dispatcher()
	{
		return $this->__dispatcher;
	}
}

?>