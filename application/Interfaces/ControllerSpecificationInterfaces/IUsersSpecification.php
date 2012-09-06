<?php if ( ! defined('BASEPATH') ) die();

require_once 'application/vos/ModelVos/UserVo.php';
require_once 'application/vos/AuthenticationVo.php';

interface IUsersSpecification
{
	function id( $id );
	function slika( $slika );
	function acg( $acg );
	function userName( $userName );
	function password( $password );
	function userType( $userType );
	function name( $name );
	function lastName( $lastName );
	function gender( $gender );
	
	
	function authenticate( AuthenticationVo $authVo );
	
	function create( UserVo $user );
	function update( UserVo $user );
	function delete( UserVo $user );
}


?>