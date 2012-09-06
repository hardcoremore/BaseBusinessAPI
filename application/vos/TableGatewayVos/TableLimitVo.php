<?php

class TableLimitVo
{
	public function __construct( $offset = 5, $limit = 0 )
	{
		$this->offset = $offset;
		$this->limit = $limit;
	}	
	
	public $offset;
	public $limit;
	
}

?>