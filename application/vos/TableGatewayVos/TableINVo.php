<?php

require_once 'application/vos/TableGatewayVos/ColumnVo.php';

class TableINVo
{
	public function __construct( ColumnVo $column = NULL,  $in = TRUE, $values = NULL )
	{
		$this->column = $column; // ColumnVo
		$this->in = $in; // if $in is false than  query will be NOT IN
		$this->values = $rightWild;
	}
	
	public $column;
	public $in;
	public $values;
	
}

?>