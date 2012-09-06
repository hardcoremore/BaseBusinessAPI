<?php if ( ! defined('BASEPATH') ) die();

require_once 'application/vos/controllersVos/AuthenticationVo.php';

interface IPrivilegesSpecification
{
	function createAcg( AcgVo $acg );
	function createAcgl( AcglVo $acgl );
	
	function isAllowed( $controller, $action );
	function loadAcgl( $userAcgId );
	function loadAcl( $userId );
}


?>