<?php

class DataHolderVo
{
	public function __construct( $metadata = NULL,  $data = NULL  )
	{
		$this->metadata = $metadata;
		$this->data = $data;
	}
	
	public $data;
	public $metadata;

}

?>