<?php

if( $_SERVER['HTTP_HOST'] != 'localhost' ) die();

require_once 'system/application/TableGateways/default/UsersTableGateway.php';

class TableGatewayTest extends Controller
{

	public function TableGatewayTest()
	{
		parent::Controller();
	}
	
	public function test()
	{
		
		$db = ConfigFactory::DATABASE_CONFIG();
		$db->database = 'appdata';
		
		$tf = new TableGatewayFactory();
		$tf->setDatabaseConfig( $db );
		
		
		$t = 'default';
		
		$ut = $tf->CLIENTS( $t );
		
		
		echo '<pre>';
		print_r( $ut->readClient( new TableGatewayReadVo() ) );
		echo '</pre>';
		
	}
}


?>