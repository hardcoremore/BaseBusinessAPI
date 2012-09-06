<?php

class TableGatewayReturnVo
{
	
	public $status;
	public $errorCode;
	public $message;
	
	/*
	 * array() of table result if operation went successfuly
	 * 
	 */
	public $result;
	
	/*
	 * int num rows if operation was of read type
	 * 
	 */
	public $numRows;
	
	/*
	 * int affected rows if operation was of create type
	 * 
	 */
	public $affectedRows;
	
	public $alreadyExistsFields;
}
?>