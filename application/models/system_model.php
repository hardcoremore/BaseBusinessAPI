<?php

require_once 'application/models/BaseModel.php';
require_once 'application/Specifications/SystemSpecification.php';
require_once 'application/vos/ModelVos/UserVo.php';
require_once 'application/vos/ModelVos/DataHolderColumnVo.php';
require_once 'application/Specifications/UsersSpecification.php';


class System_model extends BaseModel
{
	
	const DATA_HOLDER_COLUMN_VISIBLE = 1;
	const DATA_HOLDER_COLUMN_INVISIBLE = 0;
	
	const DATA_HOLDER_COLUMN_CUSTOM_HEADER_YES = 1;
	const DATA_HOLDER_COLUMN_CUSTOM_HEADER_NO = 0;
	
	
	protected $_spec;
	protected $_user_spec;
	
	public function __construct( DatabaseConfigVo $database = null )
	{
		parent::__construct( $database );
		
		$this->_spec = new SystemSpecification();
		$this->_user_spec = new UsersSpecification();
	}
	
	public function readDataHolderColumns( $user_id, $data_holder_id )
	{
		if( $this->_user_spec->id( $user_id ) && $this->_spec->baseAlphaNumericName( $data_holder_id ) )
		{
			$this->db->where( "data_holder_id", $data_holder_id );
			$this->db->where( "data_holder_column_user_id", $user_id );
			$this->db->order_by( 'data_holder_column_position_index' );
			
			$q  = $this->db->get( 'data_holder_columns' );
			
			if( $q )
			{
				$result = $q->custom_result_object( 'DataHolderColumnVo' );
				$this->setOperationReadData( $result, $q->num_rows() );
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
				log_message( "debug", "System_model::readDataHolderColumns: " . $this->db->_error_message() );
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
	
	public function saveDataHolderColumns( array $columns = NULL )
	{
		if( is_array( $columns ) )
		{
			$this->db->trans_start();
			
			foreach( $columns as $col )
			{
				$this->saveDataHolderColumn( $col );
			}
			
			$this->db->trans_complete();
			
			if( $this->db->trans_status() === FALSE )
			{
			    $this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR .  $this->db->_error_message();
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
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
	
	public function saveDataHolderColumn( DataHolderColumnVo $col )
	{
		$this->db->where( "data_holder_id", $col->data_holder_id );
		$this->db->where( "data_holder_column_user_id", $col->data_holder_column_user_id );
		$this->db->where( "data_holder_column_data_field", $col->data_holder_column_data_field );
		
		$exists = $this->db->count_all_results( 'data_holder_columns' );
		
		if( $exists > 0 )
		{
			
			$this->db->where( "data_holder_id", $col->data_holder_id );
			$this->db->where( "data_holder_column_user_id", $col->data_holder_column_user_id );
			$this->db->where( "data_holder_column_data_field", $col->data_holder_column_data_field );
		
			unset( $col->data_holder_column_id );
			$this->db->update( 'data_holder_columns', $col );
		}
		else
		{
			unset( $col->data_holder_column_id );
			$this->db->insert( 'data_holder_columns', $col );
		}
		
		if( $this->db->affected_rows() >= 0 )
		{
			return TRUE;
		}
		else
		{
			log_message( "debug", $this->db->_error_message() );
			log_message( "debug", $this->db->last_query() );
			log_message( "debug", print_r( $col, true ) ); 
			return FALSE;
		}
		
	}
}

?>