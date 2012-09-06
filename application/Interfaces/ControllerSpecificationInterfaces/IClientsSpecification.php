<?php if ( ! defined('BASEPATH')) die();

require_once 'application/vos/ModelVos/ClientsVo.php';

interface IClientsSpecification
{
	function client_key( $key );
	function client_database_key( $key );
	function modules( $modules );
	function clientName( $name );
	function logicTemplateGroupId( $t_id );
	function note( $note );
	
	function create( ClientsVo $client );
	function loadUserClient( $client_key );
	function saveClientModules( $client_key, $modules );
	function update( ClientsVo $client );
}


?>