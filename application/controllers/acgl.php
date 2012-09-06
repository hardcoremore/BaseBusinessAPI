<?php if ( !defined('BASEPATH')) die();

require_once 'system/application/controllers/base.php';
require_once 'system/application/Factories/BusinessLogicFactory.php';

class Acgl extends Base 
{
	public function Acgl()
	{
		parent::Base();
		$this->_businessLogic = BusinessLogicFactory::ACGL_LOGIC();		
	}
	
	public function createAcgl()
	{
		
	}
	
	public function readAcgl( $user_id = NULL, $return = FALSE )
	{
		(int) $id = $this->input->post( 'id' );
		
		if( $this->_specification->loadAcgl( $id ) )
		{
			$acl =& $this->_tableGateway->loadUserAcl( $id );
			
			if( $acl === FALSE )
			{
				$this->showDatabaseError();
				return;
			}
			else
			{
				$this->_dataHolder->metadata()->setStatus( self::STATUS_OK );
				$this->_dataHolder->metadata()->setErrorCode( 0 );
				$this->_dataHolder->data()->setData(  $this->load->_ci_object_to_array( $user ) );	
			}
					
		}
		else
		{
			$this->showInvalidInputError();
			return;
		}
	}
	
	public function updateAcgl( $user_acg_id )
	{
		
	}
	
	
	
	public function deleteAcgl()
	{
		/*
		if( $this->userInfo )
		{	
		
			$query = $this->db->query( "SELECT acgl.*, modules.*, module_actions.action_name
										FROM acgl
										INNER JOIN modules ON acgl.module_id = modules.id 
										INNER JOIN module_actions ON acgl.action_id = module_actions.id
										WHERE acg_id = '".$this->userInfo['acg']."'
										ORDER BY modules.name ASC"
							 );
						
			$this->acgl = $query->result_array();
						
			$query = $this->db->query ("SELECT acl.*, modules.* ,  module_actions.action_name
										   FROM acl 
										   INNER JOIN modules ON acl.module_id = modules.id
										   INNER JOIN module_actions ON acl.action_id = module_actions.id
										   WHERE user_id = '".$this->userInfo['id']."'"
							  );
			
			
						
			$this->acl = $query->result_array();
			
			$this->setAcl();
			
					
		}
		else
		{
			log_message( 'debug', 'Failed to load acl. User info invalid.' . ErrorCodes::APP_ERROR() );
		}
		*/
	}
} 

/* End of file: acgl.php */
/* Location: ./system/application/controllers/acgl.php */