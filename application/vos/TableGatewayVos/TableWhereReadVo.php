<?php

require_once 'application/vos/TableGatewayVos/TableWhereVo.php';

class TableWhereReadVo
{
	public function __construct(  $whereVos, $operator = '' )
	{
		$this->whereVos = $whereVos; // array of TableWhereVos
		$this->operator = $operator;
	}
	
	public $whereVos;
	public $operator;
}

?>