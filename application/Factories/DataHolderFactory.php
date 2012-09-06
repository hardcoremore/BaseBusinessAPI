<?php if ( ! defined('BASEPATH') ) die();

class DataHolderFactory
{
	private static $__instance;
	
	private function __construct(){}
	
	public static function &getInstance()
	{
		if( !self::$__instance )
		{
			self::$__instance = new DataHolderFactory();
		}
		
		return self::$__instance;
	}
	
	public function createDataHolderFromConfig()
	{
//		should be instance of IDataHolder. Hardcoded for now
		return $this->createXMLDataHolder();
	}
	
	public function createXMLDataHolder()
	{
		require_once 'application/libraries/dataHolders/XMLDataHolder.php';
		return new XMLDataHolder();
	}
	
	public function createJASONDataHolder()
	{
		
	}
	
}

?>