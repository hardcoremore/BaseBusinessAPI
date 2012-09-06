<?php

class ColumnVo
{
	public function __construct( $name = NULL,  $value = NULL, $asName = NULL, $table_name = NULL )
	{
		$this->name = $name;
		$this->value = $value;
		$this->asName = $asName;
		$this->table_name = $table_name;
	}
	
	public $name;
	public $value;
	public $asName;
	public $table_name;
}

?>