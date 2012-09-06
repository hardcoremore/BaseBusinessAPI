<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/ModuleCreationBase.php';

class CLIENTS_creation extends ModuleCreationBase 
{
	const CLIENTS_TABLE_NAME 				= 'clients';
	
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function create()
	{
	
		///////////////////////////////////////////////////////
		//
		//  CREATE TABLES
		//
		///////////////////////////////////////////////////////
		
		$key 					= new SaveColumnVo( 'key_id', DatabaseDataTypes::MYSQLI_CHAR, 36 );
		$key->primary 			= TRUE;
		
		$admin_key 				= new SaveColumnVo( 'admin_key', DatabaseDataTypes::MYSQLI_CHAR, 36 );
		
		$data_storage_id 		= new SaveColumnVo( 'data_storage_id', DatabaseDataTypes::MYSQLI_CHAR, 36 );
		
		$max_users 				= new SaveColumnVo( 'max_users_allowed', DatabaseDataTypes::MYSQLI_BIGINT );
		$max_users->attribute 	= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$name 					= new SaveColumnVo( 'name', DatabaseDataTypes::MYSQLI_VARCHAR, 255 );
		$name->fullText			= TRUE;
		
		$email 					= new SaveColumnVo( 'email', DatabaseDataTypes::MYSQLI_VARCHAR, 100 );
		$email->fullText		= TRUE;
		
		$logo 					= new SaveColumnVo( 'logo', DatabaseDataTypes::MYSQLI_VARCHAR, 100 );
		
		$created 				= new SaveColumnVo( 'date_created', DatabaseDataTypes::MYSQLI_DATETIME );
		
		$sub_valid				= new SaveColumnVo( 'subscription_valid', DatabaseDataTypes::MYSQLI_TINYINT );
		
		$sub_payed 				= new SaveColumnVo( 'payed_subscriptions', DatabaseDataTypes::MYSQLI_BIGINT );
		$sub_payed->attribute	= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$sub_valid_till				= new SaveColumnVo( 'subscription_valid_till', DatabaseDataTypes::MYSQLI_BIGINT );
		$sub_valid_till->attribute	= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		
		$note					= new SaveColumnVo( 'note', DatabaseDataTypes::MYSQLI_TEXT );
		$note->fullText			= TRUE;
		
		// CLIENTS
		$clients_table	= new CreateTableVo(  self::CLIENTS_TABLE_NAME, 
											  array( 
											  			$key, $admin_key, $data_storage_id,
											  			 $max_users,$name, $email, $logo, 
											  			 $created, $sub_valid, $sub_payed,
											  			  $sub_valid_till, $note 
													), 
											  DatabaseEngineTypes::MYSQLI_MyISAM 
											);
											 	
		$clients_result	= $this->_table->createTable( $clients_table );

		
		///////////////////////////////////////////////////////
		//
		//  CHECK TABLES CREATION STATUS AND FILL ARRAYS
		//
		///////////////////////////////////////////////////////
		
		$clients_result->status == BaseTableGateway::STATUS_OK 
		? 
		array_push( $this->_installed_tables, $this->_table->getActiveRecord()->fullTableName() . self::CLIENTS_TABLE_NAME )
		:
		array_push( $this->_failed_tables, $this->_table->getActiveRecord()->fullTableName() . self::CLIENTS_TABLE_NAME )
		;	
		
		///////////////////////////////////////////////////////
		//
		//  CHECK TO SEE IF OPERATION WAS SUCCESSFUL
		//
		///////////////////////////////////////////////////////
		
		if( count( $this->_failed_tables ) == 0 )
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
		
		// @TODO implement destroy method
	}
	
	public function copyDataFromTemplateToTemplate( $from_template, $to_template )
	{
		// @TODO implement copyDataFromTemplateToTemplate method
	}
}


?>