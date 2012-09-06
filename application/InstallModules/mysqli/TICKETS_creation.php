<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/ModuleCreationInitializationBase.php';

class TICKETS_creationInitialization extends ModuleCreationInitializationBase 
{

	const TICKET_QUESTIONS_TABLE_NAME 	= 'ticket_questions';
	const TICKET_ANSWERS_TABLE_NAME 	= 'ticket_answers';
	
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
	
		$id 					= new SaveColumnVo( 'id', DatabaseDataTypes::MYSQLI_BIGINT );
		$id->autoIncrement 		= TRUE;
		$id->primary 			= TRUE;
		$id->attribute 			= DatabaseAttributes::MYSQLI_UNSIGNED;
		
		$client_key 			= new SaveColumnVo( 'client_key', DatabaseDataTypes::MYSQLI_CHAR, 36 );
		
		$user_id 				= new SaveColumnVo( 'user_key', DatabaseDataTypes::MYSQLI_CHAR, 36 );
		
		$priority 				= new SaveColumnVo( 'priority', DatabaseDataTypes::MYSQLI_ENUM );
		$priority->values 		= array( "low", "mid", "high" ); 
		
		$ticket_answered 		= new SaveColumnVo( 'ticket_answered', DatabaseDataTypes::MYSQLI_TINYINT );
		
		$question 				= new SaveColumnVo( 'question', DatabaseDataTypes::MYSQLI_TEXT );
		$question->fullText		= TRUE;
		
		$date 					= new SaveColumnVo( 'creation_date', DatabaseDataTypes::MYSQLI_DATETIME );
		$solved					= new SaveColumnVo( 'solved', DatabaseDataTypes::MYSQLI_TINYINT );
		
		$can_other_user_answer	= new SaveColumnVo( 'can_other_user_answer', DatabaseDataTypes::MYSQLI_TINYINT );
		
		$ticket_question_table	= new CreateTableVo( 
														self::TICKET_QUESTIONS_TABLE_NAME, 
														array( 
																$id, $client_key, $user_id, 
																$question, $priority, $can_other_user_answer, 
																$ticket_answered, $date, $solved 
															  ), 
														DatabaseEngineTypes::MYSQLI_MyISAM 
													);
											 	
		$ticket_question_result	= $this->_table->createTable( $ticket_question_table );
		
		
		
		$q_id 					= new SaveColumnVo( 'question_id', DatabaseDataTypes::MYSQLI_BIGINT );
		$q_id->primary 			= TRUE;
		$q_id->attribute  		= DatabaseAttributes::MYSQLI_UNSIGNED;

		$admin_id 				= new SaveColumnVo( 'admin_id', DatabaseDataTypes::MYSQLI_INT );
		$admin_id->attribute 	= DatabaseAttributes::MYSQLI_UNSIGNED;
		$admin_id->index 		= TRUE;
		
		$answer					= new SaveColumnVo( 'answer', DatabaseDataTypes::MYSQLI_TEXT );
		$answer->fullText		= TRUE;
		
		$ticket_answer_table	= new CreateTableVo( 
														self::TICKET_ANSWERS_TABLE_NAME, 
														array( $q_id, $user_id, $admin_id, $answer, $date ), 
														DatabaseEngineTypes::MYSQLI_MyISAM 
													);

													
		$ticket_answer_result 	= $this->_table->createTable( $ticket_answer_table );
		
		
		
		$ticket_question_result->status == BaseTableGateway::STATUS_OK
		?
		array_push( $this->_installed_tables, $this->_table->fullTableName() . self::TICKET_QUESTIONS_TABLE_NAME )
		:
		array_push( $this->_failed_tables, $this->_table->fullTableName() . self::TICKET_QUESTIONS_TABLE_NAME )
		;
		
		$ticket_answer_result->status == BaseTableGateway::STATUS_OK
		?
		array_push( $this->_installed_tables, $this->_table->fullTableName() . self::TICKET_ANSWERS_TABLE_NAME )
		:
		array_push( $this->_failed_tables, $this->_table->fullTableName() . self::TICKET_ANSWERS_TABLE_NAME )
		;
		
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
		$destroyAnswerTable 	= $this->_table->dropTable( $this->_table->fullTableName() . self::TICKET_ANSWERS_TABLE_NAME	);
		$destroyQuestionTable	= $this->_table->dropTable( $this->_table->fullTableName() . self::TICKET_QUESTIONS_TABLE_NAME	);
		
		if( $destroyAnswerTable->status == BaseTableGateway::STATUS_OK &&
		    $destroyQuestionTable->status == BaseTableGateway::STATUS_OK 
		    )
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