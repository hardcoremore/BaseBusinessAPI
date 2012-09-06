<?php

require_once 'application/vos/TableGatewayVos/ColumnVo.php';
require_once 'application/vos/TableGatewayVos/PageVo.php';
require_once 'application/vos/TableGatewayVos/TableINVo.php';
require_once 'application/vos/TableGatewayVos/TableLimitVo.php';


class TableGatewayReadVo
{
	public function __construct( 
										$columns = NULL, 
										$tableWhereReadVos = NULL,
										PageVo  $page = NULL
								  )
	{
		$this->columns				=  $columns;
		$this->tableWhereReadVos	=  $tableWhereReadVos;
		$this->page					=  $page;
	}
	
	public $columns; // array of ColumnVo objects
	public $distinct;
	public $tableWhereReadVo;
	public $tableWhereGroupVos;
	public $tableINVo;
	public $groupByColumns;
	public $orderByVos;
	public $page; // PageVo
	public $limit; // LimitVo
}

?>