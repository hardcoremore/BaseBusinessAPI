<?php

require_once 'application/vos/ModelVos/EmployeesVo.php';
require_once 'application/Specifications/EmployeesSpecification.php';

require_once 'application/vos/ModelVos/EmployeesWorkingScenarioDayVo.php';
require_once 'application/vos/ModelVos/EmployeeWorkingScenarioVo.php';

require_once 'application/vos/ModelVos/EmployeeWorkSheetVo.php';
require_once 'application/vos/ModelVos/EmployeeWorkDayVo.php';
require_once 'application/vos/ModelVos/EmployeeEconomicsVo.php';


class Employees_model extends BaseModel
{
	const EMPLOYEE_GENDER_MALE = 1;
	const EMPLOYEE_GENDER_FEMALE = 2;
	
	const EMPLOYEE_CONTRACT_TYPE_ALL_NONE = 0;
	const EMPLOYEE_CONTRACT_TYPE_ALL_TIME = 1;
	const EMPLOYEE_CONTRACT_TYPE_TEMP = 2;
	const EMPLOYEE_CONTRACT_TYPE_FREE_LANCE = 3;
	const EMPLOYEE_CONTRACT_TYPE_VOLUNTEER = 4;
	
	const EMPLOYEE_CONTRACT_EVENT_TYPE_HIRED = 1;
	const EMPLOYEE_CONTRACT_EVENT_TYPE_CHANGED = 2;
	const EMPLOYEE_CONTRACT_EVENT_TYPE_FIRED = 3;
	
	const EMPLOYEE_HIRED_TRUE = 1;
	const EMPLOYEE_HIRED_FALSE = 0;
	
	
	const EMPLOYEE_ITEM_CHARGE_TYPE_COMPNAY = 1;
	const EMPLOYEE_ITEM_CHARGE_TYPE_PERSONAL = 2;
	
	const EMPLOYEE_WORK_DAY_TYPE_NORMAL = 1;
	const EMPLOYEE_WORK_DAY_TYPE_BUSSINESS_TRIP = 2;
	const EMPLOYEE_WORK_DAY_TYPE_SICK = 3;
	const EMPLOYEE_WORK_DAY_TYPE_NOT_WORKING = 4;
	const EMPLOYEE_WORK_DAY_TYPE_VACATION = 5;
	
	
	protected $_spec;
	
	public function __construct( DatabaseConfigVo $database = null )
	{
		parent::__construct( $database );
		$this->_spec = new EmployeesSpecification();
	}
	
	
	/***
	=======================
	
	  EMPLOYEES
	  
	=======================  
	****/
	public function create( EmployeesVo $employee )
	{
		if( $this->_spec->create( $employee ) )
		{
			unset( $employee->employee_id );
			$this->db->insert( 'employees', $employee );
			
			if( $this->db->affected_rows() == 1 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR . " " . $this->db->_error_message();
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}	
		
		return $this->operationData();
	}
	
	public function read( ReadTableVo $readVo )
	{
		$tr = $this->_readFromTable( 'employees', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'EmployeesVo' );
			$this->setOperationReadData( $result, $tr->totalRows, $readVo->data_type );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
	
	public function update( EmployeesVo $employee )
	{
		if( $this->_spec->update( $employee ) )
		{
			$this->db->where( 'employee_id', $employee->employee_id );
			unset( $employee->employee_id );
			$this->db->update( 'employees', $employee );
			 
			
			
			if( ! $this->db->_error_number() )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;	
		}
		
		return $this->operationData();
	}
	
	/***
	=======================
	
	  ECONOMICS
	  
	=======================  
	****/
	public function createEconomic( EmployeeEconomicsVo $economic )
	{
		if( $this->_spec->createEconomic( $economic ) )
		{
			unset( $economic->employee_economics_id );
			$this->db->insert( 'employee_economics', $economic );
			
			if( $this->db->affected_rows() == 1 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->affectedRows = 1;
				$this->operationData()->dataType = DataHolderDataType::CUSTOM_OBJECT;
				
				
				$this->db->where( 'employee_economics_id', $this->db->insert_id() );
				$new = $this->db->get( 'employee_economics' );
				
				$this->operationData()->result = $new->row( 0 , 'EmployeeEconomicsVo' ); 
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}	
		
		return $this->operationData();
	}
	
	public function readEconomics( ReadTableVo $readVo )
	{
		$tr = $this->_readFromTable( 'employee_economics', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'EmployeeEconomicsVo' );
			$this->setOperationReadData( $result, $tr->totalRows, $readVo->data_type );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
	
	public function readEconomicsForSelect()
	{
		$this->db->select( 'employee_economics_id, employee_economics_name');
		
		$q = $this->db->get( 'employee_economics' );
		
		if( $q )
		{
			$result = $q->custom_result_object( 'EmployeeEconomicsVo' );
			$this->setOperationReadData( $result, count( $result ) );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
	
	public function updateEconomicField( UpdateTableFieldVo $update )
	{
		$update->table_name = 'employee_economics';
		$update->id_name = 'employee_economics_id';
		
		$this->updateTableField( $update );
		
		return $this->operationData();
	}
	
	/***
	=======================
	
	  COST AND STIMULATION
	  
	=======================  
	****/
	
	public function saveCostAndStimulation( EmployeeCostAndStimulationsVo $cost_and_stimulation = NULL )
	{
		if( $this->_spec->saveCostAndStimulation( $cost_and_stimulation ) )
		{
			
			log_message( "debug", print_r( $cost_and_stimulation, true ) );
			
			$this->db->where( 'employee_id', $cost_and_stimulation->employee_id );
			$this->db->where( 'employee_costs_and_stimulations_year', $cost_and_stimulation->employee_costs_and_stimulations_year );
			$this->db->where( 'employee_costs_and_stimulations_month', $cost_and_stimulation->employee_costs_and_stimulations_month );
			
			$exists = $this->db->count_all_results( 'employee_costs_and_stimulations' );
			$id = $cost_and_stimulation->employee_costs_and_stimulations_id;
			unset( $cost_and_stimulation->employee_costs_and_stimulations_id );
			
			if( $exists > 0 )
			{
				$this->db->where( 'employee_id', $cost_and_stimulation->employee_id );
				$this->db->where( 'employee_costs_and_stimulations_year', $cost_and_stimulation->employee_costs_and_stimulations_year );
				$this->db->where( 'employee_costs_and_stimulations_month', $cost_and_stimulation->employee_costs_and_stimulations_month );
			
				$this->db->update( 'employee_costs_and_stimulations', $cost_and_stimulation );
				$cost_and_stimulation->employee_costs_and_stimulations_id = $id;
			}
			else
			{
				$this->db->insert( 'employee_costs_and_stimulations', $cost_and_stimulation );
				$cost_and_stimulation->employee_costs_and_stimulations_id = $this->db->insert_id();
			}
			
			if( $this->db->affected_rows() >= 0 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->affectedRows = 1;
				$this->operationData()->result = $cost_and_stimulation;
				$this->operationData()->dataType = DataHolderDataType::CUSTOM_OBJECT;
			}
			else
			{
				$this->setDatabaseError();
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;
		}
		
		return $this->operationData();
	}
	
	public function readCostAndStimulation( ReadTableVo $readVo )
	{		
		$tr = $this->_readFromTable( 'employee_costs_and_stimulations', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'EmployeeCostAndStimulationsVo' );
			$this->setOperationReadData( $result, $tr->totalRows, $readVo->data_type );
			
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}	
			
		return $this->operationData();
	}
	
	
	/***
	=======================
	
	  WORKING SCENARIO
	  
	=======================  
	****/
	public function createWorkingScenario( EmployeeWorkingScenarioVo $ws, array $work_days )
	{
	
		if( $this->isWorkingScenarioInSpec( $ws, $work_days ) )
		{
			$this->db->trans_start();
			
			unset( $ws->employee_working_scenario_id );
			$this->db->insert( 'employees_working_scenario', $ws );
			$ws_id = $this->db->insert_id();
			
			foreach( $work_days as $wd )
			{
				unset( $wd->employees_working_scenario_day_id );
				$wd->employees_working_scenario_id = $ws_id;
				$this->db->insert( 'employees_working_scenario_details', $wd );
			}
			
			$this->db->trans_complete();
			
			if( $this->db->trans_status() === FALSE )
			{
			    $this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR .  $this->db->_error_message();
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->result = array( "employee_working_scenario_id" => $ws_id, 
														"employee_working_scenario_name" => $ws->employee_working_scenario_name );
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;	
		}
		
		return $this->operationData();
	}
	
	
	public function readWorkingScenarios()
	{
		$q  = $this->db->get( 'employees_working_scenario' );
		
		if( $q )
		{
			$result = $q->custom_result_object( 'EmployeeWorkingScenarioVo' );
			$this->setOperationReadData( $result, $q->num_rows() );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR . $this->db->_error_message();
		}
		
		return $this->operationData();
	}
	
	public function readWorkingScenarioDetails( $ws_id )
	{
		if( $this->_spec->primaryKeyAutoIncrement( $ws_id ) )
		{
			$this->db->where( "employees_working_scenario_id", $ws_id );
			$this->db->order_by( "employees_working_scenario_day" );
			
			$q  = $this->db->get( 'employees_working_scenario_details' );
			
			if( $q )
			{
				$result = $q->custom_result_object( 'EmployeesWorkingScenarioDayVo' );
				$this->setOperationReadData( $result, $q->num_rows() );
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR . $this->db->_error_message();
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;	
		}
		
		return $this->operationData();
	}

	public function updateWorkingScenario( EmployeeWorkingScenarioVo $ws, array $work_days )
	{
		if( $this->isWorkingScenarioInSpec( $ws, $work_days ) )
		{
			$this->db->trans_start();
			
			$ws_id = $ws->employee_working_scenario_id;
			unset( $ws->employee_working_scenario_id );
			
			$this->db->where( "employee_working_scenario_id", $ws_id );
			$this->db->update( 'employees_working_scenario', $ws );
			
			
			foreach( $work_days as $wd )
			{
				$wd->employees_working_scenario_id = $ws_id;
				
				$this->db->where( "employees_working_scenario_day_id", $wd->employees_working_scenario_day_id );
				unset( $wd->employees_working_scenario_day_id );
				$this->db->update( 'employees_working_scenario_details', $wd );
			}
			
			$this->db->trans_complete();
			
			if( $this->db->trans_status() === FALSE )
			{
			    $this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR .  $this->db->_error_message();
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->result = array( "employee_working_scenario_id" => $ws_id, 
														"employee_working_scenario_name" => $ws->employee_working_scenario_name );
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;	
		}
		
		return $this->operationData();
	}
	
	
	/***
	=======================
	
	  WORK SHEET
	  
	=======================  
	****/
	public function createWorkSheet( EmployeeWorkSheetVo $work_sheet, array $work_sheet_days )
	{
		
		if( $this->isWorkSheetInSpec( $work_sheet, $work_sheet_days ) )
		{
			$this->db->trans_start();
			
			unset( $work_sheet->employee_work_sheet_id );
			
			$this->db->insert( 'employee_work_sheet', $work_sheet );
			$work_sheet->employee_work_sheet_id = $this->db->insert_id();
			
			if( $this->db->_error_number() )
			{
				log_message( "debug", $this->db->_error_message() );
				log_message( "debug", $this->db->last_query() );
			}
			
			foreach( $work_sheet_days as $wd )
			{
				$wd->employee_work_sheet_id = $work_sheet->employee_work_sheet_id;
				$this->saveWorkSheetDay( $wd );
			}
			
			
			$this->db->trans_complete();
			
			if( $this->db->trans_status() === FALSE )
			{
			    $this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR .  $this->db->_error_message();
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				
				$this->db->where( 'employee_work_sheet_id', $work_sheet->employee_work_sheet_id );
				$row = $this->db->get( 'employee_work_sheet' )->row( 0, 'EmployeeWorkSheetVo' );
				
				$this->operationData()->dataType = DataHolderDataType::CUSTOM_OBJECT;
				$this->operationData()->result = $row;
				$this->operationData()->affectedRows = 1;
				$this->operationData()->numRows = 1;
				$this->operationData()->totalRows = 1;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;	
		}
		
		return $this->operationData();
	}
	
	public function readWorkSheets( ReadTableVo $readVo, $employee_id )
	{
		//@todo check specification
		
		
		$this->db->where( 'employee_id', $employee_id );
		
		$tr = $this->_readFromTable( 'employee_work_sheet', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'EmployeeWorkSheetVo' );
			$this->setOperationReadData( $result, $tr->totalRows, $readVo->data_type );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		 		
		return $this->operationData();
	}
	
	public function updateWorkSheet( EmployeeWorkSheetVo $work_sheet, array $work_sheet_days )
	{
		if( $this->isWorkSheetInSpec( $work_sheet, $work_sheet_days ) )
		{
			$this->db->trans_start();
			
			$ws_id = $work_sheet->employee_work_sheet_id;
			unset( $work_sheet->employee_work_sheet_id );
			
			$this->db->where( 'employee_work_sheet_id', $ws_id );
			$this->db->update( 'employee_work_sheet', $work_sheet );
			
			if( $this->db->_error_number() )
			{
				log_message( "debug", $this->db->_error_message() );
				log_message( "debug", $this->db->last_query() );
			}
			
			foreach( $work_sheet_days as $wd )
			{
				$this->saveWorkSheetDay( $wd );
			}
			
			$this->db->trans_complete();
			
			if( $this->db->trans_status() === FALSE )
			{
			    $this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR .  $this->db->_error_message();
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;	
		}
		
		return $this->operationData();
	}
	
	public function saveWorkSheetDay( EmployeeWorkDayVo $day )
	{
		$this->db->where( "employee_work_day_id", $day->employee_work_day_id );
		$exists = $this->db->get( 'employees_work_days' )->num_rows();
		
		if( $exists > 0 )
		{
			$this->db->where( "employee_work_day_id", $day->employee_work_day_id );
			unset( $day->employee_work_day_id );
			$this->db->update( 'employees_work_days', $day );
		}
		else
		{
			unset( $day->employee_work_day_id );
			$this->db->insert( 'employees_work_days', $day );
		}
		
		if( $this->db->affected_rows() >= 0 )
		{
			return TRUE;
		}
		else
		{
			log_message( "debug", $this->db->_error_message() );
			log_message( "debug", $this->db->last_query() );
			log_message( "debug", print_r( $day, true ) ); 
			return FALSE;
		}
	}
	
	
	
	public function readWorkSheetDays( $work_sheet_id )
	{
		
		if( $this->_spec->primaryKeyAutoIncrement( $work_sheet_id ) )
		{
			$this->db->where( "employee_work_sheet_id", $work_sheet_id );
			$this->db->order_by( "employee_work_day_date" );
			
			$q  = $this->db->get( 'employees_work_days' );
			
			if( $q )
			{
				$result = $q->custom_result_object( 'EmployeeWorkDayVo' );
				$this->setOperationReadData( $result, $q->num_rows() );
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
				log_message( "debug", $this->db->_error_message() );
			}
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::INVALID_INPUT;
			$this->operationData()->message = ServerMessages::INVALID_INPUT;	
		}
		
		return $this->operationData();
	}
	
	
	public function isWorkingScenarioInSpec( EmployeeWorkingScenarioVo $ws, array $work_days )
	{
		$is_in_spec = $this->_spec->workingScenario( $ws ) && count( $work_days ) > 0;
		
		foreach ( $work_days as $wd )
		{
			$is_in_spec = $this->_spec->workingScenarioDay( $wd );
		}
		
		return $is_in_spec;
	}
	
	public function isWorkSheetInSpec( EmployeeWorkSheetVo $ws, $work_days )
	{
		$is_in_spec = $this->_spec->workSheet( $ws ) && count( $work_days ) > 0;
		
		foreach ( $work_days as $wd )
		{
			$is_in_spec = $this->_spec->workSheetDay( $wd );
		}
		
		return $is_in_spec;
	}
}

?>