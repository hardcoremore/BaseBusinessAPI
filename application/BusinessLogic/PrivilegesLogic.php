<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/Interfaces/BusinessLogic/IClientsLogic.php';
require_once 'system/application/libraries/ModuleCreator.php';
require_once 'system/application/vos/TableGatewayVos/ColumnVo.php';
require_once 'system/application/libraries/CRUD_OPERATIONS.php'; 

class ClientsLogic extends BusinessLogicBase implements IPrivilegesLogic
{

	protected $_acg_table;
	protected $_acgl_table;
	protected $_acl_table;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function init()
	{
		$this->_usersLogic = BusinessLogicFactory::USERS_LOGIC();
		$this->tableUtils = TableGatewayFactory::TABLE_UTIL_GATEWAY();
		
		parent::init();
	}
	
	public function initTable()
	{
		//$this->_tableGateway = $this->_logic_factory->();
	}
	
	public function initSpecification()
	{
		$this->_specification = SpecificationFactory::CLIENTS_SPEC();
	}
	
	public function readAcg( UserVo $user )
	{
		
	}
	
	public function saveAcg( AcgVo $acg )
	{
		
	}
	
	public function updateAcgName( AcgVo $acg )
	{
		
	}
	
	public function deleteAcg( AcgVo $acg )
	{
		
	}
	
	public function readUserAcl( UserVo $user )
	{
		
	}
	
}
?>