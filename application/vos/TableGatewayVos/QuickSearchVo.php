<?php

class QuickSearchVo
{
	public function __construct( $query = NULL, $columns = NULL )
	{
		$this->query =  $query;
		$this->columns =  $columns;
	}
	
	public $query;
	public $columns;
}

?>