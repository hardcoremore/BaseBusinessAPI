<?php

require_once 'application/Specifications/InvoicesSpecification.php';

class Invoices_model extends BaseModel
{
	const CUSTOMER_TYPE_BUYER = 1;
	const CUSTOMER_TYPE_SUPPLIER = 2;
	const CUSTOMER_TYPER_BOTH = 3;
	
	
	protected $_spec;
	
	public function __construct( DatabaseConfigVo $database = null )
	{
		parent::__construct( $database );
		$this->_spec = new InvoicesSpecification();
	}
	
	public function create( InvoiceVo $invoice, array $items )
	{
		if( $this->_spec->createInvoice( $invoice ) )
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
	
	public function readInvoices( ReadTableVo $readVo )
	{
		
		$tr = $this->_readFromTable( 'invoices', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'InvoiceVo' );
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
	
	public function readInvoiceItems( $invoice_id )
	{
		
		$tr = $this->_readFromTable( 'invoice_items', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'InvoiceItemVo' );
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
}

?>