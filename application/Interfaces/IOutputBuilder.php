<?php

require_once 'application/vos/OutputBuilderVo.php';

interface IOutputBuilder
{
	
	function setConfig( OutputBuilderVo $config );
	
	function getConfig();
	
	/**
	 * 
	 * Returns validated element name
	 * 
	 * @param string $name
	 * 
	 * @return string
	 */
	function getValidatedElementName( $name  );
	
	/**
	 * 
	 * Checks if $value is in valid format
	 * 
	 * @param string $value
	 * 
	 * @return boolean
	 */
	function isValueValid( &$value );
	
	/**
	*
	* This function converts object 
	* to specific format depending on the implementation.
	* 
	* @param object $data Object of data to convert
	* 
	* @return	string
	*/
	function convertFromObject( $data );
	
	/**
	*
	* This function converts array  
	* to specific format depending on the implementation.
	* 
	* @param array $data Array to convert
	* 
	* @return	string
	*/
	function convertFromArray( $data );
	
	
	/**
	 * 
	 * Compiles $value and $name to element string
	 * 
	 * @param $value string
	 * @param $name string
	 * 
	 * @return string
	 *
	 */
	function compileElement( $value, $name );
}

?>