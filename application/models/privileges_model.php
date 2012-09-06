<?php

require_once 'application/models/BaseModel.php';
require_once 'application/vos/ModelVos/AcgVo.php';

class Privileges_model extends BaseModel
{
	public function loadUserPrivileges( ClientsVo $client, UserVo $user )
	{
		$this->db->select( 'appdata.modules.module_name, ' . $client->client_database_key . '.acgl.module_id' );
		
		$this->db->join( 'appdata.modules', 
						 $client->client_database_key . '.acgl.module_id = appdata.modules.module_id'  , 
						 'inner' );
		
		
					 
		$this->db->where( $client->client_database_key . '.acgl.acg_id', $user->user_acg_id );
		$this->db->where(  'appdata.modules.module_deployed', 1 );
		
		$this->db->group_by( $client->client_database_key . '.acgl.module_id' );
		
		$mq = $this->db->get( $client->client_database_key . '.acgl' );
		
		if( $mq )
		{
			
			$acl = array();
			$user_modules = $mq->result_array();
			$module_actions = NULL;
			$actions = NULL;
			
			foreach ( $user_modules as $m )
			{
				
				$this->db->select( 'appdata.module_actions.module_action_name,'.
									$client->client_database_key . '.acgl.access, 
									appdata.module_actions.module_action_crud' );
			
				$this->db->join( 'appdata.module_actions', 
						 		  $client->client_database_key . '.acgl.action_id = appdata.module_actions.module_action_id'  , 
						 		 'inner' );
						 
				$this->db->where(  $client->client_database_key . '.acgl.module_id', $m[ 'module_id' ] );
		
				$maq = $this->db->get( $client->client_database_key . '.acgl' );
				
				if( $maq )
				{
					$actions = $maq->result_array();
					array_push( $acl, array( 'module' => $m, 'actions' => $actions ) );
				}
				
			}
			
			$this->db->where( 'acg_id', $user->user_acg_id );
			$acg_q = $this->db->get( 'acg' );
			
			$privileges = array( 'acg' => $acg_q->result_array(), 'acl' => $acl ); 
			$this->operationData()->status = BaseController::STATUS_OK;
			$this->operationData()->errorCode = 0;
			$this->operationData()->result = $privileges;
			
			$this->_session->set( BaseController::SYSTEM_SESSION_NAME_SPACE, BaseController::SYSTEM_SESSION_PRIVILEGES_NAME, $privileges );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		
		return $this->operationData();
		
	}
	
	public function privileges()
	{
		if( $this->_session->has( BaseController::SYSTEM_SESSION_NAME_SPACE, BaseController::SYSTEM_SESSION_PRIVILEGES_NAME ) )
		{
			$this->operationData()->status = BaseController::STATUS_OK;
			$this->operationData()->errorCode = 0;
			
			$this->operationData()->result = $this->_session->get( BaseController::SYSTEM_SESSION_NAME_SPACE, BaseController::SYSTEM_SESSION_PRIVILEGES_NAME );
		}
		else 
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::NOT_FOUND;
			$this->operationData()->message = ServerMessages::NOT_FOUND;	
		}
		
		return $this->operationData();
	}
	
	public function readPrivilegesForSelect()
	{
		$this->db->select( "acg_id, acg_name" );
		
		$q = $this->db->get( 'acg' );
		
		if( $q )
		{
			$result = $q->custom_result_object( 'AcgVo' );
			$this->setOperationReadData( $result, count( $result ) );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
}

?>