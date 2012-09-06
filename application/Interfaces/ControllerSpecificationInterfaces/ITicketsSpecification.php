<?php if ( ! defined('BASEPATH') ) die();

require_once 'application/vos/UserVo.php';

interface ITicketsSpecification
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
	function create( UserVo $user );
	function update( UserVo $user );
	function delete( UserVo $user );
}


?>