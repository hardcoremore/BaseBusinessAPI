<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/ControllersVos/ClientModuleVo.php';
require_once 'system/application/vos/TableGatewayVos/TableGatewayReadVo.php';

interface IClientModulesTableGateway
{
	function &readClientModules( TableGatewayReadVo $read );
	function &readAllClientModules( $client_key );
	function &readActiveModules( $client_key );
	function &readInactiveModules( $client_key );
	
	function &createClientModule( ClientModuleVo $c_module );
	function &updateClientModule( ClientModuleVo $c_module ); 
	function &deleteClientModule( ClientModuleVo $c_module );
	
}

?>