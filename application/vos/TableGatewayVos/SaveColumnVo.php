<?php

class SaveColumnVo
{
	public function __construct( $name = NULL, $type = NULL, $length = NULL, $null = FALSE )
	{
		$this->name = $name;
		$this->type = $type;
		$this->length = $length;
		$this->null = $null;
	}
	
	public $name;
	public $type;
	public $length;
	public $values; // array() used with enum type to specify values that can be entered
	public $collation;
	public $attribute;
	public $null;
	public $default;
	public $autoIncrement;
	public $primary;
	public $index;
	public $unique;
	public $fullText; // boolean whether to add this column to fulltext index. In mysql only supported in MyIsam engine types
	public $comment;
	
}

?>