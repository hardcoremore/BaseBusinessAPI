<?php if ( !defined('BASEPATH') ) die();

interface IDataBuilder
{
	function setData( $data );
	function getFormatedData();
	function getRawData();
	function reset();
}
?>