<?php if ( !defined('BASEPATH') ) die();

require_once 'application/libraries/database/BaseTableGateway.php';
require_once 'application/vos/TableGatewayVos/TableGatewayReadVo.php';
require_once 'application/vos/TableGatewayVos/TableGatewayReturnVo.php';
require_once 'application/vos/controllersVos/ClientsVo.php';


class ClientsTableGateway extends BaseTableGateway
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_active_record->setTableNAme( 'clients' ) ;
	}
	
	public function &readClient( TableGatewayReadVo $readVo )
	{
		$r = new TableGatewayReturnVo();
		
		$r->result = $this->_active_record->readAll()->run()->getResultAsArray();
		
		return $r;			      	
	}
	
	public function &createClient( ClientsVo $client )
	{
		$r = new TableGatewayReturnVo();
		
		$uuid = $this->_active_record->run( "SELECT UUID() AS uuid" )->getResultAsObject();
		$uuid = $uuid[0]->uuid;
		
		$k 		= new ColumnVo( 'key_id', $uuid );
		$ak 	= new ColumnVo( 'admin_key', $client->admin_key );
		$n 		= new ColumnVo( 'name', $client->name );
		$e 		= new ColumnVo( 'email', $client->email );
		$lo 	= new ColumnVo( 'logo', $client-> logo );
		$dc 	= new ColumnVo( 'date_created', 'now()');
		$no 	= new ColumnVo( 'note', $client->note );

		
		$alreadyExists = array();
		
		if( $this->_active_record->checkValueExists( $k ) )
			array_push( $alreadyExists, $k );
		
		if( $this->_active_record->checkValueExists( $n ) )
			array_push( $alreadyExists, $n );
		
		if( $this->_active_record->checkValueExists( $e ) )
			array_push( $alreadyExists, $e );

			
		// check if values are not unique	
		if( count( $alreadyExists ) > 0 )
		{
			$r->status =  self::STATUS_ALREADY_EXISTS;
			$r->errorCode = 0;
			$r->alreadyExistsFields = $alreadyExists;
		}
		else
		{
		
			$create = $this->_active_record->create( array( $k, $ak, $n, $e,  $lo, $dc, $no ) );
						
			if( $create === TRUE )
			{
				$r->status = self::STATUS_OK ;
				$r->result = array( $k ) ;
				$r->errorCode = 0; 
			}
			else if( $create ===  NULL )
			{
				$r->status = self::STATUS_ERROR;
				$r->errorCode =  ErrorCodes::DATABASE_ERROR;
				$r->message =  $this->_active_record->getErrorMessage();
				
				log_message('debug', 'ClientsTableGateway::createClient() error occured: ' .  $this->_active_record->getErrorMessage() );
				
			}
			else if( $create === FALSE   ) 
			{
				$r->status = self::STATUS_UNKNOWN_ERROR;
				log_message('debug', 'Failure occured at ClientsTableGateway::createClient(). No error message to display');
			}
			
				
		}
		
		return $r;
	}
	
	public function &updateClient( ClientsVo $client )
	{
		
	}
	
	public function &deleteClient( ClientsVo $client )
	{
		
	}
}

?>