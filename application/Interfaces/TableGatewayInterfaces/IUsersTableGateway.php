<?php if ( !defined('BASEPATH') ) die();

require_once 'application/vos/UserVo.php';
require_once 'application/vos/ControllersVos/AuthenticationVo.php';

interface IUsersTableGateway
{
	function &createUser( UserVo $userVo );
	function &readUser( TableGatewayReadVo $read );
	function &updateUser( UserVo $userVo );
	function &deleteUser( UserVo $userVo );
	
	function &authenticate( AuthenticationVo $authVo );
	function &loadUser( $id );
	function &checkLogin( AuthenticationVo $authVo );
	function &logout();
	
}

?>