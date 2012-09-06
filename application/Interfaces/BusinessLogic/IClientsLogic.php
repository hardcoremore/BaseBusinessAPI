<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/TableGatewayVos/TableGatewayReadVo.php';
require_once 'system/application/vos/controllersVos/ClientsVo.php';
require_once 'system/application/vos/ControllersVos/CreateClientUserVo.php';
require_once 'system/application/vos/InstallVo.php';

interface IClientsLogic
{
	function &read( TableGatewayReadVo $readVo );
	function &update( ClientsVo $client );
	function &create( ClientsVo $client );
	function &createClientUser( CreateClientUserVo $create );
	function &createClientDatabase( $client_key );
	function &saveClientModules( ClientsVo $client, InstallVo $install );
	function &delete( ClientsVo $client );
}


?>