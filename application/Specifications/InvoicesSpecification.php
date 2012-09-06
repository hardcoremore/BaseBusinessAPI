<?php

require_once 'application/libraries/BaseSpecification.php';

class InvoicesSpecification extends BaseSpecification
{
	public function createInvoice(  InvoiceVo $invoice )
	{
		return TRUE;
	}
	
	public function createItem( InvoiceItemVo $item )
	{
		return TRUE;
	}
	
}

?>