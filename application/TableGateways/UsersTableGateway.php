<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/TableGatewayInterfaces/IUsersTableGateway.php';
require_once 'application/libraries/database/BaseTableGateway.php';
require_once 'application/vos/TableGatewayVos/TableGatewayReadVo.php';
require_once 'application/vos/UserVo.php';


class UsersTableGateway extends BaseTableGateway implements IUsersTableGateway
{
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_active_record->setTableName( 'users' );
	}
	
	public function &createUser( UserVo $user )
	{
		$s 	= new ColumnVo( 'slika'			, $this->escape( $user->slika 		    ));
		$a 	= new ColumnVo( 'acg'			, $this->escape( $user->acg				));
		$t 	= new ColumnVo( 'user_type'		, $this->escape( $user->user_type		));
		$n 	= new ColumnVo( 'name'			, $this->escape( $user->name			));
		$l 	= new ColumnVo( 'last_name'		, $this->escape( $user->last_name		));
		$u 	= new ColumnVo( 'username'		, $this->escape( $user->username		));
		$p 	= new ColumnVo( 'password'		, $this->escape( $user->password		));
		$c 	= new ColumnVo( 'creation_date'	, 'now()'								 );
		$g 	= new ColumnVo( 'gender'		, $this->escape( $user->gender			));
		$pn = new ColumnVo( 'phone_number'	, $this->escape( $user->phone_number	));
		$pm = new ColumnVo( 'mobile_number'	, $this->escape( $user->mobile_number	));
		$e 	= new ColumnVo( 'email'			, $this->escape( $user->email			));
		
	
		$alreadyExists = array();
		
		if( $this->_active_record->checkValueExists( $u ) )
			array_push( $alreadyExists, $u );
		
		if( $this->_active_record->checkValueExists( $e ) )
			array_push( $alreadyExists, $e );
			
			
		$r = new TableGatewayReturnVo();
			
		// check if values are not unique	
		if( count( $alreadyExists ) > 0 )
		{
			$r->status =  BaseActiveRecord::STATUS_ALREADY_EXISTS;
			$r->errorCode = 0;
			$r->alreadyExistsFields = $alreadyExists;
		}
		else
		{
		
			$create = $this->_active_record->create( array( $s, $a, $t, $n, $l, $u, $p, $c, $g, $pn, $pm, $e ) );

			$r->status = $this->_active_record->getStatus();
			
			if( $create === TRUE )
			{
				$id = new ColumnVo('id', $this->_active_record->lastInsertedId() );	
				$r->result = array( $id );
				$r->errorCode = 0; 
			}
			else if( $create ===  NULL )
			{
				$r->errorCode =  ErrorCodes::DATABASE_ERROR;
				$r->message =  ServerMessages::DATABASE_ERROR;
			}
				
		}
		
		return $r;		      	
	}
	
	public function &authenticate( AuthenticationVo $authVo )
	{
		$r = new TableGatewayReturnVo();
		
		$u = $this->_active_record->escape( trim( $authVo->username ) );
		$p = $this->_active_record->escape( $authVo->password );
		
		$username = new ColumnVo('username', $u );
		$password = new ColumnVo('password', $p );

		
		$id = new ColumnVo('id');
		$slika = new ColumnVo('slika');
		$acg = new ColumnVo('acg');
		$userType = new ColumnVo('user_type');
		
		
		$wu = new TableWhereVo( $username );
		$wp = new TableWhereVo( $password );
		
		$wr = new TableWhereReadVo( array( $wu, $wp ), '&&' );
		
		$q = $this->_active_record->read( array( $id, $slika, $acg, $userType ) )->whereSimple( $wr )->run()->getResultAsObject();
		
		if( $q !== NULL   )
		{	
			$r->errorCode = 0;
			
			if( $this->numRows() == 1  )
			{

				$u = new UserVo();
				$u->username = $authVo->username;
				$u->id = $q[0]->id;
				$u->acg = $q[0]->acg;
				$u->user_type = $q[0]->user_type;
			
				$r->result = $u;
				$r->status = BaseActiveRecord::STATUS_OK;
			}
			else if( $this->numRows() > 1 )
			{
				$r->status = BaseActiveRecord::STATUS_ERROR;
				$r->message = 'There are multiple users with this creditentials!';
			}
			else
			{
				$r->status = BaseActiveRecord::STATUS_NOT_FOUND;
				$r->message = 'User is not found!';
			}		
		}
		else
		{
			$r->errorCode =  ErrorCodes::DATABASE_ERROR ;
			$r->message =  ServerMessages::DATABASE_ERROR;	
		}
		
		return $r;			      	
	}
	
	public function &loadUser( $id )
	{
		$r = new TableGatewayReturnVo();
		
		$id = $this->_active_record->escape( $id );
		$idColumn = new ColumnVo('id', $id );
		
		$wId = new TableWhereVo( $idColumn );
		$wr = new TableWhereReadVo( array( $wId ) );
		
		$q = $this->_active_record->readAll()->whereSimple( $wr )->run();
		
		$r->status =  $this->_active_record->getStatus();
		
		if( $this->_active_record->getStatus() != BaseActiveRecord::STATUS_ERROR  )
		{
			
			$r->errorCode =  0;
			
			if( $this->_active_record->numRows() == 1  )
			{
				
				$q = $q[0];
				
				$u = new UserVo();
				$u->username		= $q->username;
				$u->id				= $q->id;
				$u->acg				= $q->acg;
				$u->user_type		= $q->user_type;
				$u->slika			= $q->slika;
				$u->name			= $q->name;
				$u->last_name		= $q->last_name;
				$u->email			= $q->email;
				$u->gender			= $q->gender;
				$u->creation_date	= $q->creation_date;
				$u->phone_number	= $q->phone_number;
				$u->mobile_number	= $q->mobile_number;
				
				$r->result = $u;
			}
			else
			{
				$r->status =  BaseActiveRecord::STATUS_NOT_FOUND;
			}
			
		}
		else
		{
			
			$r->errorCode =  ErrorCodes::DATABASE_ERROR;
			$r->message = ServerMessages::DATABASE_ERROR;		
		}
		
		return $r;
		
	}
	
	public function &checkLogin( AuthenticationVo $authVo )
	{
		$r = new TableGatewayReturnVo();
		
		$u = $this->_active_record->escape( trim( $authVo->username ) );
		$p = $this->_active_record->escape( $authVo->password );
		
		$username = new ColumnVo('username', $u );
		$password = new ColumnVo('password', $p );

		
		$id = new ColumnVo('id');
		
		$wu = new TableWhereVo( $username );
		$wp = new TableWhereVo( $password );
		
		$wr = new TableWhereReadVo( array( $wu, $wp ), '&&' );
		
		$q = $this->_active_record->read( array( $id ) )->whereSimple( $wr )->run()->getResultAsObject();

		if( $q !== NULL  )
		{	
			$r->errorCode = 0;
			
			if( $this->_active_record->numRows() == 1  )
			{
				$r->status =  self::STATUS_OK;
				//$r->result =  array( 'id' => $q[0]->id ); 
			}
			else
			{
				$r->status = self::STATUS_NOT_FOUND;
			}
			
		}
		else
		{
			log_message( 'error', 'mysqli/AuthenticationTableGateway::checkLogin() ErrorOcurred. ErrorMessage: ' . $this->getErrorMessage() );
				
			$r->status =  self::STATUS_ERROR;
			$r->errorCode = ErrorCodes::DATABASE_ERROR ;
			$r->message = $this->_active_record->getErrorMessage();
		}
		
		return $r;	
	}
	
	public function &logout()
	{
		
	}
	
	public function &readUser( TableGatewayReadVo $read )
	{
		
	}
	
	public function &updateUser( UserVo $user )
	{
		
	}
	
	public function &deleteUser( UserVo $user )
	{
		
	}
	
	
}

?>