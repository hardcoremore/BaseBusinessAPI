<?php

require_once 'application/vos/TableGatewayVos/ColumnVo.php';

class TableWhereVo
{
	public function __construct( ColumnVo $column = NULL,  $operator = '=', $leftWild = '', $rightWild = '' )
	{
		$this->column = $column; // ColumnVo
		$this->operator = $operator;
		$this->leftWild = $leftWild;
		$this->rightWild = $rightWild;
	}
	
	public $column;
	public $operator;
	public $leftWild;
	public $rightWild;
	
}

?>