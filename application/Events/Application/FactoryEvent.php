<?php

require_once 'application/libraries/Event/Event.php';

class FactoryEvent extends Event
{
	const TEMPLATE_CHANGE = "templateChange";

	protected $_newTemplate;
	
	public function setNewTemplate( $t )
	{
		$this->_newTemplate = $t;
	}
	
	public function getNewTemplate( $t )
	{
		return $this->_newTemplate;
	}
	
	
	protected $_oldTemplate;
	
	public function setOldTemplate( $ot )
	{
		$this->_oldTemplate = $ot;
	}
	
	public function getOldTemplate( $ot )
	{
		return $this->_oldTemplate;
	}
	
}

?>