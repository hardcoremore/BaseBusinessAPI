<?php if ( !defined('BASEPATH') ) die();
 
require_once 'application/vos/ModelVos/UserVo.php';
require_once 'application/vos/TableGatewayVos/TableGatewayReadVo.php';
require_once 'application/vos/AuthenticationVo.php';

interface IUsersLogic
{
	
	function &create( UserVo $user );
	function &read( TableGatewayReadVo $read );
	function &update( UserVo $user );
	function &delete( UserVo $user );
	
	function &authenticate( AuthenticationVo $authVo );
	function &loadUser( $id );
	function &checkLogin( AuthenticationVo $authVo );
	function isUserLoggedIn();
	function logout();
	
	function &encodePassword( $password );
	function &changePrivilege( UserVo $user, $privileges );
	function &getStatistics( UserVo $user );
}


?>