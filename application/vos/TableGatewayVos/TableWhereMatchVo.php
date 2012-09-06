<?php

require_once 'application/vos/TableGatewayVos/ColumnVo.php';

class TableWhereMatchVo
{
	public function __construct( $columns = NULL,  $value = NULL, $searchModifier = NULL, $operator = NULL )
	{
		$this->columns = $columns; // array ColumnVo objects
		$this->value = $value;
		$this->searchModifier = $searchModifier;
		$this->operator = $operator;
	}
	
	public $columns;
	public $value;
	public $searchModifier;
	public $operator;
	
}

?>