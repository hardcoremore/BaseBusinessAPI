<?php

class SearchParameterVo
{
	public $name;
	public $value;
	public $operand;
	
	public function __construct( $name, $value, $operand )
	{
		$this->name = $name;
		$this->value = $value;
		$this->operand = $operand;
	}
}

?>