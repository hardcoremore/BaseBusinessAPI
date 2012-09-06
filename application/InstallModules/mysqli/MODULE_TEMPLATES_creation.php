<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/ModuleCreationBase.php';

class MODULE_TEMPLATE_creation extends ModuleCreationBase 
{
	const LOGIC_TEMPLATES_TABLE_NAME 		= 'logic_templates';
	const LOGIC_TEMPLATE_GROUP_TABLE_NAME 	= 'logic_template_group';
	const LOGIC_TEMPLATE_LIST_TABLE_NAME 	= 'logic_template_list';
	
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
		
		
		$temp_group_id 					= new SaveColumnVo( 'id', DatabaseDataTypes::MYSQLI_INT );
		$temp_group_id->primary			= TRUE;
		$temp_group_id->autoIncrement	= TRUE;
		$temp_group_id->attribute		= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		
		$name 					= new SaveColumnVo( 'name', DatabaseDataTypes::MYSQLI_VARCHAR, 100 );
		$name->unique			= TRUE;
		
		
		// LOGIC TEMPLATES
		$logic_templates		= new CreateTableVo( self::LOGIC_TEMPLATES_TABLE_NAME, array( $temp_group_id, $name ),DatabaseEngineTypes::MYSQLI_InnoDB );										
		$logic_templates_result	= $this->_table->createTable( $logic_templates );
		
		
		
		// LOGIC TEMPLATE GROUP
		$logic_template_group			= new CreateTableVo( self::LOGIC_TEMPLATE_GROUP_TABLE_NAME, array( $temp_group_id, $admin_key, $name ),DatabaseEngineTypes::MYSQLI_InnoDB );
		$logic_template_group_result	= $this->_table->createTable( $logic_template_group );
		
		
		$logic_template_group_id 			= new SaveColumnVo( 'logic_template_group_id', DatabaseDataTypes::MYSQLI_MEDIUMINT );
		$logic_template_group_id->attribute = DatabaseAttributes::MYSQLI_UNSIGNED;
		
		// LOGIC TEMPLATE LIST
		$logic_template_list		= new CreateTableVo(self::LOGIC_TEMPLATE_LIST_TABLE_NAME, array( $logic_template_group_id, $module_id, $template_id ),DatabaseEngineTypes::MYSQLI_InnoDB );
		$logic_template_list_result	= $this->_table->createTable( $logic_template_list );
		
		
		// MODULE TEMPLATES
		$module_templates			= new CreateTableVo( self::MODULE_TEMPLATES_TABLE_NAME, array( $module_id, $template_id ),DatabaseEngineTypes::MYSQLI_InnoDB );
		$module_templates_result	= $this->_table->createTable( $module_templates );
		
		$logic_templates_result->status == BaseTableGateway::STATUS_OK 
		? 
		array_push( $this->_installed_tables, $this->_table->fullTableName() . self::LOGIC_TEMPLATES_TABLE_NAME )
		:
		array_push( $this->_failed_tables, $this->_table->fullTableName() . self::LOGIC_TEMPLATES_TABLE_NAME )
		;
		
		$logic_template_group_result->status == BaseTableGateway::STATUS_OK 
		? 
		array_push( $this->_installed_tables, $this->_table->fullTableName() . self::LOGIC_TEMPLATE_GROUP_TABLE_NAME )
		:
		array_push( $this->_failed_tables, $this->_table->fullTableName() . self::LOGIC_TEMPLATE_GROUP_TABLE_NAME )
		;
		
		$logic_template_list_result->status == BaseTableGateway::STATUS_OK 
		? 
		array_push( $this->_installed_tables, $this->_table->fullTableName() . self::LOGIC_TEMPLATE_LIST_TABLE_NAME )
		:
		array_push( $this->_failed_tables, $this->_table->fullTableName() . self::LOGIC_TEMPLATE_LIST_TABLE_NAME )
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
		
		/*
		$destroyAnswerTable 	= $this->table->dropTable( 'ticket_answers'	);
		$destroyQuestionTable	= $this->table->dropTable( 'ticket_questions'	);
		
		if( 1 || $destroyAnswerTable && $destroyQuestionTable )
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
		
		*/
	}
	
	public function copyDataFromTemplateToTemplate( $from_template, $to_template )
	{
		// @TODO implement copyDataFromTemplateToTemplate method
	}
}


?>