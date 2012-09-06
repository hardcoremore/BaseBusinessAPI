<?php

require_once 'application/Interfaces/IOutputBuilder.php';
require_once 'application/Factories/ConfigFactory.php';

abstract  class OutputBuilderBase implements IOutputBuilder
{
	protected $_config;
	
	public function __construct()
	{
		$this->setConfig( ConfigFactory::OUTPUT_BUILDER_CONFIG() );
	}
	
	public function setConfig( OutputBuilderVo $config )
	{
		$this->_config = $config;
	}
	
	public function getConfig()
	{
		return $this->_config;
	}
}

?>