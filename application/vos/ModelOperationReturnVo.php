<?php

class ModelOperationReturnVo
{
	public $status;
	public $errorCode;
	public $message;
	
	/*
	 * type of data that result is holding
	 * 
	 */
	public $dataType;
	/*
	 * data result from operation if operation went successfuly
	 * 
	 */
	public $result;
	
	/*
	 * int num rows if operation was of read type
	 * 
	 */
	public $numRows;
	
	/*
	 * int num total rows available if operation was of read type
	 * 
	 */
	public $totalRows;
	
	/*
	 * int affected rows if operation was of create type
	 * 
	 */
	public $affectedRows;
	
	public $alreadyExistsFields;
	
}

?>