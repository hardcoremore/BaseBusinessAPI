<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/TableGatewayInterfaces/IUsersTableGateway.php';
require_once 'application/libraries/MysqliBaseTableGateway.php';
require_once 'application/vos/TableGatewayVos/TableGatewayReadVo.php';
require_once 'application/vos/UserVo.php';


class TicketsTableGateway extends MysqliBaseTableGateway implements ITicketsTableGateway
{	
	public function __construct()
	{
		$this->_tableName = 'users';
		parent::__construct();
	}
	
	public function &createTicket( TicketsVo $ticket )
	{
			
		$r = new TableGatewayReturnVo();
		return $r;
				      	
	}
	
	public function &readTicket( TableGatewayReadVo $read )
	{
		
	}
	
	public function &readAnswers( $id )
	{
		
	}
	
	public function &answerToTicket( TicketsVo $ticket )
	{
		
	}
	
	public function &markTicketSolved( TicketsVo $ticket )
	{
		
	}
}

?>