<?php
class DatabaseConfigVo
{
	public $hostname;
	public $username;
	public $password;
	public $database;
	public $dbdriver;
	public $prefix;
	public $pc_connect;
	public $db_debug;
	public $cache_on;
	public $cache_dir;
	public $char_set;
	public $db_collat;
	public $prefix_delimiter;
	public $table_path;
	
	public function __construct( $hostname = NULL, $username = NULL, $password = NULL, $database = NULL, $dbdriver = NULL, $prefix = NULL  )
	{	
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->dbdriver = $dbdriver;
		$this->prefix = $prefix;
	}
}

?>