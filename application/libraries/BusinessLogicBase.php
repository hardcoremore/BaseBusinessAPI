<?php if ( !defined('BASEPATH')) die();

require_once 'application/Factories/DataHolderFactory.php';
require_once 'application/Factories/TableGatewayFactory.php';
require_once 'application/Factories/ConfigFactory.php';

class BusinessLogicBase
{
	
	
	protected $_data_factory;
	
	protected $_data_holder;
	
	protected $_app_config;
	
	protected $_table_factory;
	
	protected $_logic_factory;
	
	public function __construct()
	{
		$this->_data_factory 		= DataHolderFactory::getInstance();
		//$this->_logic_factory		= PreController::GET_LOGIC_FACTORY();
		$this->_data_holder 		= $this->_data_factory->createDataHolderFromConfig();
		$this->_app_config			= ConfigFactory::APPLICATION_CONFIG();
	}
	
	public function init()
	{	
	}
	
	public function getLogicFactory()
	{
		return $this->_logic_factory;
	}
	
	public function setAppConfig( ApplicationConfigVo $app_config )
	{
		$this->_app_config = $app_config;
	}

	
	
	
}