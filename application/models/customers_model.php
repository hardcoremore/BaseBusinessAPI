<?php

require_once 'application/Specifications/CustomersSpecification.php';

class Customers_model extends BaseModel
{
	const CUSTOMER_TYPE_BUYER = 1;
	const CUSTOMER_TYPE_SUPPLIER = 2;
	const CUSTOMER_TYPER_BOTH = 3;
	
	
	protected $_spec;
	
	public function __construct( DatabaseConfigVo $database = null )
	{
		parent::__construct( $database );
		$this->_spec = new CustomersSpecification();
	}
	
	public function create( CustomersVo $customer )
	{
		if( $this->_spec->create( $customer ) )
		{
			unset( $customer->customer_id );
			$this->db->insert( 'customers', $customer );
			
			if( $this->db->affected_rows() == 1 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
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
	
	public function read( ReadTableVo $readVo )
	{
		
		$tr = $this->_readFromTable( 'customers', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'CustomersVo' );
			$this->setOperationReadData( $result, $tr->totalRows );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
	
	public function update( CustomersVo $customer )
	{
		if( $this->_spec->update( $customer ) )
		{
		
			$this->db->where( 'customer_id', $customer->customer_id );
			unset( $customer->customer_id );
			$this->db->update( 'customers', $customer );
			
			if( $this->db->affected_rows() >= 0 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
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
}

?>