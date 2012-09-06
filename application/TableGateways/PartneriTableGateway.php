<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/TableGatewayInterfaces/IPartneriTableGateway.php';
require_once 'application/libraries/MysqlBaseTableGateway.php';

class PartneriTableGateway extends MysqliBaseTableGateway implements IPartneriTableGateway
{

	public function __construct()
	{
		$this->_tableName = 'partneri';
	}
	
	public function &readAll()
 	{
 		
 	}
 	
	public function &readPage( $pageNumber, $rowsPerPage, $query = NULL )
	{
		$r = parent::readPage( $pageNumber, $rowsPerPage, NULL );
		
		return $r;
	}
	
	public function deleteBatch( $ids )
	{
		
	}
	
	public function create( PartneriVo $partner )
	{
		
	}
	
	public function update( PartneriVo $partner )
	{
		
	}
	
	public function delete( PartneriVo $partner )
	{
		
	}
	
	public function quickSearch( $query  )
	{
		
	}
	
	public function advancedSearch( PartneriVo $partner )
	{
		
	}
}

?>