<?php if ( !defined('BASEPATH') ) die();

interface IDataHolder
{
	function reset();
	function data();
	function metadata();
	
	/*
	 * returns metadata and data in xml, json or other string. it depends on the implementation
	 * 
	 */
	function &getAll();
	
	/*
	 * returns DataHolderVo with  metadata data array and data data array
	 * 
	 */
	function &getRawData();
	
	/*
	 * dispatches all data like echoing it or writing it to file. it depends on the implementation
	 * 
	 */
	function dispatchAll();
	
}
?>