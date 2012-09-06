<?php

require_once 'application/libraries/database/activeRecords/MysqliActiveRecord.php';
require_once 'application/vos/TableGatewayVos/TableGatewayReturnVo.php';


class BaseTableGateway
{
	protected $_active_record;
	
	protected $_databaseName;
	
	public function __construct()
	{
		$this->_database = self::DATABASE_NAME_DEFAULT;
		
		// for now mysqli is hardcoded.
		$this->_active_record = new MysqliActiveRecord();
	}
	
	public function getActiveRecord()
	{
		return $this->_active_record;
	}
}

?>