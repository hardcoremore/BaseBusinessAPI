<?php

require_once 'application/vos/TableGatewayVos/SaveColumnVo.php';

class CreateTableVo
{
	public function __construct( $name = NULL, $columns = NULL, $engine = NULL, $character_set = 'utf8', $collate = 'utf8_unicode_ci' )
	{
		$this->name = $name;
		$this->columns = $columns; // array of SaveColumnVo objects
		$this->engine = $engine;
		$this->character_set = $character_set;
		$this->collate = $collate;
		
	}
	
	public $name;
	public $columns;
	public $engine;
	public $character_set;
	public $collate;
	public $comment;
	
}

?>