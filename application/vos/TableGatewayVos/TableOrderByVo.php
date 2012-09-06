<?php

class TableOrderByVo
{
	public function __construct( $column, $operator = '' )
	{
		$this->column = $column;
		$this->operator = $operator;
	}
	
	public $column;
	public $operator;
	
}

?>