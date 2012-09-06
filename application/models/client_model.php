<?php

require_once 'application/models/BaseModel.php';
require_once 'application/Specifications/ClientsSpecification.php';
require_once 'application/vos/ModelVos/ClientsVo.php';
require_once 'application/libraries/CrudOperations.php';

class Client_model extends BaseModel
{
	protected $_spec;
	
	const CLIENT_SESSION_NAME = 'user_client_data';// Should be instance of ClientsVo
	
	public function __construct()
	{
		parent::__construct();
		$this->_spec = new ClientsSpecification();
	}
	
	public function create( ClientsVo $client )
	{
		$this->load->dbforge( $this->db );
		
		if( $this->_spec->create( $client ) === TRUE )
		{
			
			$this->db->where( 'client_key', $client->client_key );
			if( $this->db->get( 'clients' )->num_rows() == 1 )
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::ALREADY_EXISTS;
				$this->operationData()->message = ServerMessages::ALREADY_EXISTS;
				$this->operationData()->alreadyExistsFields  = array( 'client_key' );
			}
			else
			{
				$insert_id = 0;
				
				$this->db->trans_start();
				$this->db->insert( 'clients', $client );
				$insert_id = $this->db->insert_id();
				
				$this->dbforge->create_database( $client->client_database_key );
				
				$this->db->trans_complete();
				
				if( $this->db->trans_status() === FALSE )
				{	
				    $this->operationData()->status = BaseController::STATUS_ERROR;
					$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
					$this->operationData()->message = ServerMessages::DATABASE_ERROR . $this->db->_error_message();
				}
				else
				{
					$this->operationData()->status = BaseController::STATUS_OK;
					$this->operationData()->errorCode = 0;
					$this->operationData()->result = array( 'client_id' => $insert_id );
				}
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}	
		
		return $this->operationData();
	}

	public function read()
	{
		$this->db->select( 'clients.*' );
		
		if( $this->isOrder() )
		$this->db->order_by( BaseController::SORT_COLUMN_NAME(), BaseController::SORT_DIRECTION() );
		
		$q  = $this->db->get('clients', BaseController::ROWS_PER_PAGE(), $this->getRowsOffset( BaseController::PAGE_NUMBER(), BaseController::ROWS_PER_PAGE() ) );
		
		if( $q )
		{
			$this->operationData()->status = BaseController::STATUS_OK;
			$this->operationData()->errorCode = 0;
			$this->operationData()->result = $q->result_array();
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
	
	public function loadClient( $client_id )
	{
		if( $this->_spec->digitOnly( $client_id ) )
		{
			
			
			$this->db->where( 'client_id', $client_id );
			$client = $this->db->get( 'clients' );
			
			
			if( $client )
			{
				if( $client->num_rows() == 1 )
				{
					$cr = $client->row( 0, 'ClientsVo' );
					
					$this->operationData()->status = BaseController::STATUS_OK;
					$this->operationData()->errorCode = 0;
					
					$this->operationData()->result = $cr;
					$this->operationData()->numRows = 1;
				}
				else
				{
					$this->operationData()->status = BaseController::STATUS_ERROR;
					$this->operationData()->errorCode = ServerOperationCodes::NOT_FOUND;
					$this->operationData()->message = ServerMessages::NOT_FOUND;
				}
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}
	}
	
	public function loadUserClient( $client_key )
	{
		if( $this->_spec->loadUserClient( $client_key ) )
		{
			$this->db->where( 'client_key', $client_key );
			$client = $this->db->get( 'clients' );
			
			if( $client )
			{
				if( $client->num_rows() == 1 )
				{
					$cr = $client->row( 0, 'ClientsVo' );
					
					$this->_session->set( BaseController::SYSTEM_SESSION_NAME_SPACE, self::CLIENT_SESSION_NAME, serialize( $cr ) );
					$this->operationData()->status = BaseController::STATUS_OK;
					$this->operationData()->errorCode = 0;
					
					$this->operationData()->result = $cr;
					$this->operationData()->numRows= 1;
				}
				else
				{
					$this->operationData()->status = BaseController::STATUS_ERROR;
					$this->operationData()->errorCode = ServerOperationCodes::NOT_FOUND;
					$this->operationData()->message = ServerMessages::NOT_FOUND;
				}
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}
		
		return $this->operationData();
	}
	
	public function currentClient()
	{
		if( $this->_session->has( BaseController::SYSTEM_SESSION_NAME_SPACE, self::CLIENT_SESSION_NAME ) )
		{
			return unserialize( $this->_session->get( BaseController::SYSTEM_SESSION_NAME_SPACE, self::CLIENT_SESSION_NAME ) );
		}
	}
	
	public function saveClientModules( $client_id, $client_modules )
	{
		
		if( $this->_spec->saveClientModules( $client_id, $client_modules ) )
		{
			// load client
			$this->loadClient( $client_id );
			$client = null;
			$database_config = null;
			
			if( $this->operationData()->status != BaseController::STATUS_OK )
			{	
				return $this->operationData();
			}
			else 
			{
				$client = clone $this->operationData()->result;
				
				$database_config = ConfigFactory::DATABASE_CONFIG();
				$database_config->database = $client->client_database_key;
			}	
			
			$this->resetOperationData();
			
			$this->db->trans_start();
			$modules_affected = array();
			
			foreach( $client_modules as $module )
			{
				// if module action is of type CREATE and
				// module is already installed skip it
				if( $module->action == CrudOperations::CREATE )
				{
					$this->db->where( 'client_id', $client_id );
					$this->db->where( 'module_id', $module->module_id );
					
					if( $this->db->get('client_modules')->num_rows() == 1 )
					{				
						continue;
					}

				}
				
				// load module install model
				$install_model_name = ucfirst( $module->module_name ) . '_install_model';
				
				$this->load->model( 'installModules/' . $install_model_name, $install_model_name );
				
				// load client database into model
				$this->$install_model_name->loadDatabase( $database_config );

				
				// load module default data model
				$data_model_name = ucfirst( $module->module_name ) . '_data_model';
				$this->load->model( 'installModuleDefaultData/' . $data_model_name, $data_model_name );
					
				// load client database into model
				$this->$data_model_name->loadDatabase( $database_config );
					
				
				// build create or update array for active record
				$cm = array();
				$cm[ 'module_active' ] = $module->module_active;
				$cm[ 'module_public' ] = $module->module_public;

				
				// switch module action		
				switch( $module->action )
				{
					case CrudOperations::CREATE:

						$cm[ 'client_id' ] = $client_id;
						$cm[ 'module_id' ] = $module->module_id;

						$this->db->insert( 'client_modules', $cm );
					
						$this->$install_model_name->install();
						
						$this->$data_model_name->addData();
						
						array_push( $modules_affected, $module->module_name );
						
						
					break;

					case CrudOperations::UPDATE:
						
						$this->db->where( 'client_id', $client_id );
						$this->db->where( 'module_id', $module->module_id );
						
						$this->db->update( 'client_modules', $cm );
						
						$this->$data_model_name->updateData();
						
					break;
					
					case CrudOperations::DELETE:
						
						$this->db->where( 'client_id', $client_id );
						$this->db->where( 'module_id', $module->module_id );
						
						$this->db->delete( 'client_modules' );
						$this->$install_model_name->uninstall();
						
					break;
				}// END SWITCH
				
					
				if( $module->action == CrudOperations::CREATE || $module->action == CrudOperations::UPDATE )
				{
					
				}
				
			}// END FOREACH( $client->modules as $module )
			
			$this->db->trans_complete();
			
			if( $this->db->trans_status() === FALSE )
			{
			    $this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR . $this->db->_error_message();
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->result = array( "modules_affected" => $modules_affected );
			}
				
		}// END IF $this->_spec->saveClientModule( $client_id, $modules )
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}
		
		return $this->operationData();
	}
	
	public function loadCLientModules( $client_id )
	{
		if( $this->_spec->digitOnly( $client_id ) )
		{
			$this->db->select( 'modules.module_name, modules.module_deployed, 
								client_modules.*' );
			
			$this->db->join( 'modules', "modules.module_id = client_modules.module_id", 'inner' );
			$this->db->where( 'client_modules.client_id', $client_id );
			
			$q = $this->db->get( 'client_modules' );

			if( $q )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->message = '';
				
				$this->operationData()->result = $q->result_array();
				$this->operationData()->numRows = $q->num_rows();
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR . " " . $this->db->_error_message();
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}
		
		return $this->operationData();
	}
	
	public function &update( ClientsVo $client )
	{
		if( $this->_specification->update( $client ) )
		{
		}
		else
		{
			return $this->returnInvalidInputError();
		}	
	}
}

?>