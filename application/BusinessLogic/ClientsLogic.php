<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/BusinessLogic/IClientsLogic.php';
require_once 'application/libraries/ModuleCreator.php';
require_once 'application/vos/TableGatewayVos/ColumnVo.php';
require_once 'application/libraries/CRUD_OPERATIONS.php'; 
require_once 'application/Specifications/ClientsSpecification.php';

class ClientsLogic extends BusinessLogicBase implements IClientsLogic
{

	
	
	public function &read( TableGatewayReadVo $readVo )
	{
		
	}
	
	

}
?>