<?php
if ( !defined('BASEPATH')) die();

interface IMetadataBuilder
{
	function setStatus( $status );
	function setMessage( $message );
	function setErrorCode( $errorCode );
	function setDataType( $data_type );
	
	function getStatus();
	function getMessage();
	function getErrorCode();
	function getDataType();
	
	function setData( $data );
	function getFormatedMetadata();
	function getRawMetadata();
	function reset();
}

?>