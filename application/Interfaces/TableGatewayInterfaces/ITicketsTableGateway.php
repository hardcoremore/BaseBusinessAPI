<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/UserVo.php';

interface ITicketsTableGateway
{
	function &createUser( UserVo $userVo );
	function &readUser( TableGatewayReadVo $read );
	function &updateUser( UserVo $userVo );
	function &deleteUser( UserVo $userVo );
}

?>