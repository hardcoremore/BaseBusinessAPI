<?php

require_once 'application/vos/TableGatewayVos/ColumnVo.php';

class TableUpdateVo
{
	public function __construct( ColumnVo $column = NULL,  $operator = '=' )
	{
		$this->column = $column; // ColumnVo
		$this->operator = $operator;
	}
	
	public $column;
	public $operator;
	
}

?>