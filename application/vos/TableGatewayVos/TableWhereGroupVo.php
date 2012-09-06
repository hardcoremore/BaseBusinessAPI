<?php

require_once 'application/vos/TableGatewayVos/TableWhereReadVo.php';

class TableWhereGroupVo
{
	public function __construct(  $whereReadVos, $operator )
	{
		$this->whereReadVos = $whereReadVos; // array of TableWhereReadVos
		$this->operator = $operator;
	}
	
	public $whereReadVos;
	public $operator;
}

?>