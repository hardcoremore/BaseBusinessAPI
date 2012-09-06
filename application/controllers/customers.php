<?php if ( !defined('BASEPATH')) die();

require_once 'application/controllers/BaseController.php';
require_once 'application/vos/ModelVos/CustomersVo.php';

class Customers extends BaseController
{
	const INVOICE_ITEMS_NAME = "_invoice_items_";
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model( 'Customers_model', 'customer_model' );
		$this->customer_model->loadDatabase();
	}
	
	public function create( CustomersVo $customer = NULL )
	{
		if( ! $customer )
			$customer = $this->getCustomerFromInput();
	 	
		$this->setDataHolderFromModelOperationVo( $this->customer_model->create( $customer ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function read( ReadTableVo $readVo = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		$this->setDataHolderFromModelOperationVo( $this->customer_model->read( $readVo ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function update( CustomersVo $customer = NULL  )
	{
		if( ! $customer )
			$customer = $this->getCustomerFromInput();
	
		$this->setDataHolderFromModelOperationVo( $this->customer_model->update( $customer ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function suggestCustomerFromName( $name )
	{
		
	}
	
	public function suggestCustomerFromId( $id )
	{
		
	}
	
	public function getInvoiceFromInput()
	{
		$invoice = new InvoiceVo();
		
		return $invoice;
	}
	
	public function getInvoiceItemsFromInput()
	{
		$items_input = $this->postArrayParser();
		$items_array =  $items_input[ self::INVOICE_ITEMS_NAME ];
		$invoice_items = array();
		
		$item = NULL;
		foreach( $items_array as $i )
		{
			if( is_array( $i ) )
			{
				$item = new InvoiceItemVo();
				if( array_key_exists( "invoice_item_id", $i ) ) $item->invoice_item_id = $i["invoice_item_id"];
				
				array_push( $invoice_items, $item );
			}
		}
		
		return $invoice_items;
	}
}

?>