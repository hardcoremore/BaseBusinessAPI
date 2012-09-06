<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/TableGatewayVos/TableGatewayReadVo.php';
require_once 'system/application/vos/UserVo.php';
require_once 'system/application/vos/ControllersVos/AcgVo.php';

interface IPrivilegesLogic
{
	function readAcg( UserVo $user );
	
	function saveAcg( AcgVo $acg );
	function updateAcgName( AcgVo $acg );
	
	function deleteAcg( AcgVo $acg );
	
	function readUserAcl( UserVo $user );
	
}


?>