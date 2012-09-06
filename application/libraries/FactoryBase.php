<?php

require_once 'application/Events/Application/FactoryEvent.php';

class FactoryBase
{
	protected $__app_config;
		
	public function setAppConfig( ApplicationConfigVo $config )
	{
		$this->__app_config = $config;
	}
	
	public function appConfig()
	{
		return clone $this->__app_config;	
	}
}

?>