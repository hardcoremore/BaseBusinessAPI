<?php if ( !defined('BASEPATH') ) die();
 
require_once 'system/application/vos/ControllersVos/TicketsVo.php';
require_once 'system/application/vos/TableGatewayVos/TableGatewayReadVo.php';

interface ITicketsLogic
{
	function &create( TicketsVo $ticket );
	function &read( TableGatewayReadVo $read );
	function &update( TicketsVo $ticket );
	function &delete( TicketsVo $ticket );
	function &encodePassword( $password );
	function &changePrivilege( TicketsVo $ticket, $privileges );
	function &getStatistics( TicketsVo $ticket );
}


?>