<?php if ( !defined('BASEPATH')) die();

require_once 'application/controllers/BaseController.php';

class Privileges extends BaseController 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'Privileges_model', 'pm' );
		$this->pm->loadDatabase();
		
		$this->load->model( 'user_model', 'um');
		
	}
	
	public function loadUserPrivileges()
	{
		$client = $this->cm->currentClient();
		$user = $this->um->currentUser();
			
		$this->setDataHolderFromModelOperationVo( $this->pm->loadUserPrivileges( $client, $user ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function loadPrivileges(  ClientsVo $client = NULL, UserVo $user = NULL )
	{
		if( ! $client )
		{
			$client = $this->cm->currentClient();
		}
		
		if( ! $user )
		{
			$user = $this->um->currentUser();
		}
		
		$this->setDataHolderFromModelOperationVo( $this->pm->loadUserPrivileges( $client, $user ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readPrivilegesForSelect()
	{
		$this->setDataHolderFromModelOperationVo( $this->pm->readPrivilegesForSelect() );
		$this->_data_holder->dispatchAll();
	}
	
} 

/* End of file: acl.php */
/* Location: ./system/application/controllers/acl.php */