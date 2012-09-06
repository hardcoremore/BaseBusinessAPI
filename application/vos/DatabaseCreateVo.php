<?php
class DatabaseCreateVo
{
	public $name;
	public $default_character_set;
	public $collate;

	
	public function __construct( $name = NULL, $default_character_set = 'utf8',  $collate = 'utf8_unicode_ci'  )
	{	
		$this->name						= $name;
		$this->default_character_set	= $default_character_set;
		$this->collate					= $collate;
		
	}
}

?>