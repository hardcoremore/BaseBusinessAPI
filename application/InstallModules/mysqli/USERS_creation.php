<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/ModuleCreationInitializationBase.php';

class USERS_creationInitialization extends ModuleCreationInitializationBase 
{
	const USERS_TABLE_NAME = 'users';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function init( &$key, ApplicationConfigVo &$app_config, DatabaseConfigVo &$db_config  )
	{
		parent::init( $key, $app_config, $db_config );
	}

	public function create()
	{	
		
		///////////////////////////////////////////////////////
		//
		//  CREATE TABLES
		//
		///////////////////////////////////////////////////////
		
		$idc 					= new SaveColumnVo( 'id', DatabaseDataTypes::MYSQLI_SMALLINT );
		$idc->autoIncrement 	= TRUE;
		$idc->primary 			= TRUE;
		$idc->attribute 		= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$key 			= new SaveColumnVo( 'key', DatabaseDataTypes::MYSQLI_CHAR, 36 );
		$key->unique	= TRUE;
		
		$slikac 		= new SaveColumnVo( 'slika', DatabaseDataTypes::MYSQLI_CHAR, 36 );
		
		$acg 			= new SaveColumnVo( 'acg', DatabaseDataTypes::MYSQLI_TINYINT );
		$acg->attribute = DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$type 			= new SaveColumnVo( 'user_type', DatabaseDataTypes::MYSQLI_ENUM );
		$type->values 	= array( 'SuperAdministrator', 'Administrator', 'Regular', 'Guest' );
		
		$name 			= new SaveColumnVo( 'name', DatabaseDataTypes::MYSQLI_VARCHAR, 50 );
		$last_name 		= new SaveColumnVo( 'last_name', DatabaseDataTypes::MYSQLI_VARCHAR, 50 );
		$username 		= new SaveColumnVo( 'username', DatabaseDataTypes::MYSQLI_VARCHAR, 30 );
		$password 		= new SaveColumnVo( 'password', DatabaseDataTypes::MYSQLI_CHAR, 32 );
		$creation_date 	= new SaveColumnVo( 'creation_date', DatabaseDataTypes::MYSQLI_DATETIME );
		
		$gender 		= new SaveColumnVo( 'gender', DatabaseDataTypes::MYSQLI_ENUM );
		$gender->values = array( 'm', 'f' );
		
		$phone_number	= new SaveColumnVo( 'phone_number', DatabaseDataTypes::MYSQLI_VARCHAR, 40 );
		$mobile_number 	= new SaveColumnVo( 'mobile_number', DatabaseDataTypes::MYSQLI_VARCHAR, 40 );
		$email 			= new SaveColumnVo( 'email', DatabaseDataTypes::MYSQLI_VARCHAR, 128 );
		
		$users_table 	= new CreateTableVo( 
												self::USERS_TABLE_NAME, 
												array( 
															$idc, $key, $slikac, $acg, $type, $name,
														  	$last_name, $username, $password, 
														  	$creation_date, $gender, $phone_number, 
														 	$mobile_number, $email 
													  ), 
												DatabaseEngineTypes::MYSQLI_InnoDB 
											);
														 
														 	
		$users_table_result = $this->_table->createTable( $users_table );
		
		///////////////////////////////////////////////////////
		//
		//  CHECK TABLES CREATION STATUS AND FILL ARRAYS
		//
		///////////////////////////////////////////////////////
		
		$users_table_result->status == BaseTableGateway::STATUS_OK
		?
		array_push( $this->_installed_tables, $this->_table->fullTableName() . self::USERS_TABLE_NAME )
		:
		array_push( $this->_failed_tables, $this->_table->fullTableName() . self::USERS_TABLE_NAME )
		;
		
		
		
		///////////////////////////////////////////////////////
		//
		// CHECK TO SEE IF OPERATION WAS SUCCESSFUL
		//
		///////////////////////////////////////////////////////
		
		if( count( $this->_failed_tables) == 0 )
		{
			
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	public function destroy()
	{
		$destroy_users_table = $this->table->dropTable( self::USERS_TABLE_NAME );
		
		if( $destroy_users_table->status == BaseTableGateway::STATUS_OK )
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	public function copyDataFromTemplateToTemplate( $from_template, $to_template )
	{
		// @TODO implement copyDataFromTemplateToTemplate method
	}
	
}
?>