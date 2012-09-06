<?php if ( ! defined('BASEPATH')) die();

require_once 'application/Factories/ConfigFactory.php';
require_once 'application/vos/ModelVos/ClientsVo.php';
require_once 'application/Factories/TableGatewayFactory.php';

class ClientLogicTemplate
{
	private static $__instance;
	
	protected $_table_factory;
	protected $_templates;
	protected $_logic_build;
	protected $_table;
	
	
	public static function getInstance()
	{
		if( !self::$__instance )
		{
			self::$__instance = new ClientLogicTemplate();
		}
		
		return self::$__instance;
	}
	
	private function __construct()
	{
		//$this->_table_factory = TableGatewayFactory
	}
	
	public function buildTemplate( $client_key )
	{
		if( ! $this->_logic_build )
		{
			//$r = $this->_client_logic->readClientLogicTemplate( $client_key );	
		}	
	}
	
	public function getTemplateFromLogic()
	{
		
	}
}

?>