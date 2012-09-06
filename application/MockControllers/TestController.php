<?php if ( !defined('BASEPATH')) die();

require_once 'system/application/controllers/base.php';

class TestController extends Base 
{	

	public $testTable;
	
	public function TestController()
	{
		parent::Base();	

		$dbConfig = ConfigFactory::DATABASE_CONFIG();
		$dbConfig->database = '44d7db2d-2656-102e-acf7-3c78a6d744cd';
		
		$this->testTable = TableGatewayFactory::AUTHENTICATION_TABLE_GATEWAY($dbConfig);
		$this->testTable->loadDriver();

	}
	
	function create()
	{
	 	
//		CREATE EXAMPLE		
		
		$ut = new ColumnVo('userType', 'SuperAdministrator' );
		$n  = new ColumnVo('name', 'Mikey');
		$ln = new ColumnVo('lastName','Spikey');
		$u  = new ColumnVo('username','s.mikey');
		$p  = new ColumnVo('password', "md5( md5('mike123') )");
		$d  = new ColumnVo('creationDate', 'now()' );
		
		echo 'TestController::create() <br />';
		
		echo 'Result: ' . $this->testTable->create( array( $ut, $n, $ln, $u, $p, $d) ) . '<br />';
		
		echo 'Affected rows: ' . $this->testTable->affectedRows() . '<br />';
		
		echo $this->testTable->getSql();
	}
	
	function read( TableGatewayReadVo $readVo = NULL, $return = FALSE )
	{	
		echo 'TestController::read() <br />';
		echo 'TotalNumRows: ' . $this->testTable->totalNumRows() . '<br />';
		
		// 		READ EXAMPLE
				
		$id = new ColumnVo('id', 1);
		$ut = new ColumnVo('userType', 'Radnik', 'TipRadnika');
		$n  = new ColumnVo('name');
		$ln = new ColumnVo('lastName','sabani');
		$u  = new ColumnVo('username', null, 'KorisnickoIme');
		
		
		$wId = new TableWhereVo( $id, '>');
		$wLn = new TableWhereVo( $ln, 'NOT LIKE', '%', '%');
		$wUt = new TableWhereVo( $ut, '=');
		
		$wr = new TableWhereReadVo( array( $wId, $wLn, $wUt ), '&&');
		
		$limit = new TableLimitVo(0, 20);
		
		$orderById = new TableOrderByVo( $id, 'DESC');
		$orderByName  = new TableOrderByVo( $n );
		
		$this->testTable->read( array( $id, $ut, $n, $ln, $u ) )->whereSimple( $wr )->orderBy( array( $orderById, $orderByName ) )->limit( null, $limit )->run();
		
		echo $this->testTable->getSql();
		
		echo '<pre>';
		print_r( $this->testTable->getResultAsArray() );
		echo '</pre>';
		
	}

	function update()
	{
		
		echo 'TestController::update() <br />';
		
		
		// UPDATE EXAMPLE
		
		$id = new ColumnVo('id', 38);
		$acg = new ColumnVo( 'acg', 2 );
		$n = new ColumnVo('name', 'Michael');
		$ut = new ColumnVo('userType', 'Radnik');
		$ln = new ColumnVo('lastName', 'Rockwell');
		$un = new ColumnVo('userName', 'NewUsername');
		
		$updateAcg = new TableUpdateVo( $acg );
		$updateName = new TableUpdateVo( $n );
		$updateUserType = new TableUpdateVo( $ut );
		$updateLastName = new TableUpdateVo( $ln );
		$updateUserName = new TableUpdateVo( $un );
		
		
		$udpateWhere = new TableWhereReadVo( array( new TableWhereVo( $id ) ) );
		
		$this->testTable->update( array( $updateAcg, $updateName, $updateUserType, $updateLastName, $updateUserName ) )->whereSimple( $udpateWhere )->run();
		
		echo 'Affected Rows: ' . $this->testTable->affectedRows() . '<br />';
		
		echo $this->testTable->getSql();
	}
	
	public function delete()
	{
		echo 'TestController::delete() <br />';
		
		// DELETE EXAMPLE
		
		$id = new ColumnVo( 'id', 1 );
		$where = new TableWhereReadVo( array( new TableWhereVo( $id, '>' ) ) );
		
		$this->testTable->delete()->whereSimple( $where )->run();
		
		echo 'Affected Rows: ' . $this->testTable->affectedRows() . '<br />';
		
		echo $this->testTable->getSql();
	}
	
} 

/* End of file TestController.php */
/* Location: ./system/application/controllers/TestController.php */