<?php

require_once 'application/libraries/BaseSpecification.php';

class CustomersSpecification extends BaseSpecification
{
	public function create( CustomersVo $customer )
	{
		return TRUE;
	}
	
	public function update( CustomersVo $customer )
	{
		if( $this->digitOnly( $customer->customer_id ) && $this->create( $customer ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
}

?>