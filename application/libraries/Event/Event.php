<?php

class Event
{
	private $__type;
	
	private $__target;
	
	public function __construct( $type )
	{
		$this->__type = $type;
	}
	
	
	public function type()
	{
		return $this->__type;
	}
	
	public function target()
	{
		return $this->__target;
	}
	
	public function setTarget( $t )
	{
		$this->__target = $t;
	}
}


?>