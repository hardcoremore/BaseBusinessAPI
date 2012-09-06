<?php

require_once 'application/vos/TableGatewayVos/ColumnVo.php';

class TableJoinVo
{
	public function __construct(
									 ColumnVo $column = NULL, 
									 ColumnVo $join_column = NULL,
									 $join_type = NULL, 
									 $operator = NULL
								)
	{
		$this->column = $column;
		$this->join_column = $join_column;
		$this->join_type = $join_type;
		$this->operator= $operator;
	}
	
	public $column;
	public $join_column;
	public $join_type;
	public $operator;
}

?>