<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/controllersVos/AuthenticationVo.php';
require_once 'system/application/vos/ControllersVos/ClientsVo.php';

interface IClientsTableGateway
{
	function &readClient( TableGatewayReadVo $readVo );
	function &createClient( ClientsVo $client );
	function &updateClient( ClientsVo $client );
	function &deleteClient( ClientsVo $client );
}

?>