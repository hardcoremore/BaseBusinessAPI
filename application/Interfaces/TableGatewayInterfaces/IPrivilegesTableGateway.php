<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/TableGatewayVos/TableGatewayReadVo.php';
require_once 'system/application/vos/ControllersVos/AcgVo.php';
require_once 'system/application/vos/ControllersVos/AclVo.php';

interface IPrivilegesTableGateway
{
	
	function &readAcg( TableGatewayReadVo $read );
	function &readAcgl( TableGatewayReadVo $read );
	function &readAcl( TableGatewayReadVo $read );
	
	function &createAcg( AcgVo $acg );
	function &createAcgl( AcgVo $acgl );
	function &createAcl( AclVo $acl );
	
	function &updateAcg( AcgVo $acg );
	function &updateAcl( AclVo $acl );
	
	function &deleteAcg( AcgVo $acg );
	function &deleteAcgl( AcgVo $acgl );
	function &deleteAcl( AclVo $acl );
	
}

?>