<?php if ( !defined('BASEPATH')) die();

require_once 'application/controllers/BaseController.php';
require_once 'application/vos/ModelVos/EmployeesVo.php';
require_once 'application/vos/ModelVos/EmployeeWorkDayVo.php';
require_once 'application/vos/ModelVos/EmployeeEconomicsVo.php';
require_once 'application/vos/ModelVos/EmployeeCostAndStimulationsVo.php';

class Employees extends BaseController
{

	const WORKING_DAYS_NAME = "_working_days_";
	const WORK_SHEET_DAYS_NAME = "_work_sheet_days_";
		
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model( 'Employees_model', 'employees_model' );
		$this->employees_model->loadDatabase();
	}
	
	
	/*
	=======================
	
	  EMPLOYEES
	  
	=======================  
	*/
	
	public function create( EmployeesVo $employee = NULL )
	{
		if( ! $employee )
		{
			$employee = $this->getEmployeeFromInput();	
		}
		
		$this->setDataHolderFromModelOperationVo( $this->employees_model->create( $employee ) );
		$this->_data_holder->dispatchAll();		
	}
	
	public function read( ReadTableVo $readVo = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->read( $readVo ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function update( EmployeesVo $employee = NULL )
	{
		if( ! $employee )
			$employee = $this->getEmployeeFromInput();
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->update( $employee ) );
		$this->_data_holder->dispatchAll();
	}
	
	
	/*
	=======================
	
	  ECONOMICS
	  
	=======================  
	*/ 
	
	public function createEconomic( EmployeesEconomicsVo $economic = NULL )
	{
		if( ! $economic )
			$economic = $this->getEmployeeEconomicsFromInput();
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->createEconomic( $economic ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readEconomics( ReadTableVo $readVo = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->readEconomics( $readVo ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readEconomicsForSelect()
	{
		$this->setDataHolderFromModelOperationVo( $this->employees_model->readEconomicsForSelect() );
		$this->_data_holder->dispatchAll();
	}
	
	public function updateEconomicField( UpdateTableFieldVo $update = NULL )
	{
		if( ! $update )
			$update = $this->getUpdateTableVo();
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->updateEconomicField( $update ) );	
		$this->_data_holder->dispatchAll();	
	}
	
	/*
	=======================
	
	  COSTS AND STIMULATIONS
	  
	=======================  
	*/ 
	
	public function saveCostAndStimulation( EmployeeCostAndStimulationsVo $cost_and_stimulation = NULL )
	{
		if( ! $cost_and_stimulation )
			$cost_and_stimulation = $this->getEmployeeCostsAndStimulationsFromInput();
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->saveCostAndStimulation( $cost_and_stimulation ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readCostAndStimulation( ReadTableVo $read = NULL )
	{
		if( ! $read )
			$read = $this->getTableReadVo();	
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->readCostAndStimulation( $read ) );
		$this->_data_holder->dispatchAll();	
	}
	
	/*
	=======================
	
	  WORKING SCENARIO
	  
	=======================  
	*/
	public function createWorkingScenario()
	{
		$this->setDataHolderFromModelOperationVo( $this->employees_model->createWorkingScenario( $this->getWorkingScenarioFromInput(), $this->getWorkDaysArrayFromInput() ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function updateWorkingScenario()
	{
		$this->setDataHolderFromModelOperationVo( $this->employees_model->updateWorkingScenario( $this->getWorkingScenarioFromInput(), $this->getWorkDaysArrayFromInput() ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readWorkingScenarios()
	{
		$this->setDataHolderFromModelOperationVo( $this->employees_model->readWorkingScenarios() );
		$this->_data_holder->dispatchAll();
	}
	
	
	public function readWorkingScenarioDetails( $ws_id )
	{
		$this->setDataHolderFromModelOperationVo( $this->employees_model->readWorkingScenarioDetails( $ws_id ) );
		$this->_data_holder->dispatchAll();
	}
	
	
	/*
	=======================
	
	  WORK SHEET
	  
	=======================  
	*/
	public function createWorkSheet( EmployeeWorkSheetVo $workSheet = NULL , $work_days = NULL )
	{
		if( ! $workSheet )
			$workSheet = $this->getWorkSheetFromInput();
			
		if( ! $work_days )
			$work_days = $this->getWorkSheetDaysArrayFromInput();
	
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->createWorkSheet( $workSheet, $work_days ) );
		$this->_data_holder->dispatchAll(); 
	}
	
	public function readWorkSheets( ReadTableVo $readVo = NULL, $employee_id = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		if( ! $employee_id )
			$employee_id = $this->input->post( 'employee_id' );

		$this->setDataHolderFromModelOperationVo( $this->employees_model->readWorkSheets( $readVo, $employee_id ) );
		$this->_data_holder->dispatchAll();	
	}
	
	public function readWorkSheetDays( $work_sheet_id = NULL )
	{
		if( ! $work_sheet_id )
			$work_sheet_id = $this->input->post( 'employee_work_sheet_id' );
			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->readWorkSheetDays( $work_sheet_id ) );
		$this->_data_holder->dispatchAll();	
	}
	
	public function updateWorkSheet( EmployeeWorkSheetVo $workSheet = NULL , $work_days = NULL )
	{
		if( ! $workSheet )
			$workSheet = $this->getWorkSheetFromInput();
			
		if( ! $work_days )
			$work_days = $this->getWorkSheetDaysArrayFromInput();

			
		$this->setDataHolderFromModelOperationVo( $this->employees_model->updateWorkSheet( $workSheet, $work_days ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function getEmployeeFromInput()
	{
		$employee = new EmployeesVo();
		$employee->employee_id = $this->input->post( 'employee_id' );
		$employee->employee_economics_id = $this->input->post( 'employee_economics_id' );
		$employee->employee_code = $this->input->post( 'employee_code' );
		$employee->employee_address = $this->input->post( 'employee_address' );
		$employee->employee_birth_date = $this->input->post( 'employee_birth_date' );
		$employee->employee_business_email = $this->input->post( 'employee_business_email' );
		$employee->employee_business_phone = $this->input->post( 'employee_business_phone' );
		$employee->employee_business_phone_extension = $this->input->post( 'employee_business_phone_extension' );
		$employee->employee_fire_date = $this->input->post( 'employee_fire_date' );
		$employee->employee_gender = $this->input->post( 'employee_gender' );
		$employee->employee_hire_date = $this->input->post( 'employee_hire_date' );
		$employee->employee_hired = $this->input->post( 'employee_hired' );
		$employee->employee_last_name = $this->input->post( 'employee_last_name' );
		$employee->employee_name = $this->input->post( 'employee_name' );
		$employee->employee_note = $this->input->post( 'employee_note' );
		$employee->employee_passport_number = $this->input->post( 'employee_passport_number' );
		$employee->employee_personal_email = $this->input->post( 'employee_personal_email' );
		$employee->employee_personal_number = $this->input->post( 'employee_personal_number' );
		$employee->employee_personal_phone = $this->input->post( 'employee_personal_phone' );
		$employee->employee_social_security_number = $this->input->post( 'employee_social_security_number' );
		$employee->employee_title = $this->input->post( 'employee_title' );
		$employee->employee_working_scenario_id = $this->input->post( 'employee_working_scenario_id' );
		$employee->employee_contract_type = $this->input->post( 'employee_contract_type' );
		
		return $employee;
	}
	
	public function getEmployeeEconomicsFromInput()
	{
		$employee_economics = new EmployeeEconomicsVo();
		$employee_economics->employee_economics_name = $this->input->post( 'employee_economics_name' );
		
		$employee_economics->employee_first_shift_hour_wage = $this->input->post( 'employee_first_shift_hour_wage' );
		$employee_economics->employee_second_shift_hour_wage = $this->input->post( 'employee_second_shift_hour_wage' );
		$employee_economics->employee_third_shift_hour_wage = $this->input->post( 'employee_third_shift_hour_wage' );
		
		$employee_economics->employee_first_shift_hour_overtime_wage = $this->input->post( 'employee_first_shift_hour_overtime_wage' );
		$employee_economics->employee_second_shift_hour_overtime_wage = $this->input->post( 'employee_second_shift_hour_overtime_wage' );
		$employee_economics->employee_third_shift_hour_overtime_wage = $this->input->post( 'employee_third_shift_hour_overtime_wage' );
		
		
		$employee_economics->employee_daily_wage = $this->input->post( 'employee_daily_wage' );
		$employee_economics->employee_business_phone_limit = $this->input->post( 'employee_business_phone_limit' );
		$employee_economics->employee_economics_id = $this->input->post( 'employee_economics_id' );
		$employee_economics->employee_gas_limit = $this->input->post( 'employee_gas_limit' );
		$employee_economics->employee_monthly_wage = $this->input->post( 'employee_monthly_wage' );
		$employee_economics->employee_weekly_wage = $this->input->post( 'employee_weekly_wage' );
		
		$employee_economics->employee_car_amortisation = $this->input->post( 'employee_car_amortisation' );
		
		return $employee_economics;
		
	}
	
	public function getEmployeeCostsAndStimulationsFromInput()
	{
		$employee_cost_and_stimulation = new EmployeeCostAndStimulationsVo();
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_id = $this->input->post( 'employee_costs_and_stimulations_id' );
		$employee_cost_and_stimulation->employee_id = $this->input->post( 'employee_id' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_year = $this->input->post( 'employee_costs_and_stimulations_year' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_month = $this->input->post( 'employee_costs_and_stimulations_month' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_phone_limit = $this->input->post( 'employee_costs_and_stimulations_phone_limit' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_phone_cost = $this->input->post( 'employee_costs_and_stimulations_phone_cost' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_phone_total = $this->input->post( 'employee_costs_and_stimulations_phone_total' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_internet_limit = $this->input->post( 'employee_costs_and_stimulations_internet_limit' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_internet_cost = $this->input->post( 'employee_costs_and_stimulations_internet_cost' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_internet_total = $this->input->post( 'employee_costs_and_stimulations_internet_total' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_car_amortization_limit = $this->input->post( 'employee_costs_and_stimulations_car_amortization_limit' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_car_amortization_cost = $this->input->post( 'employee_costs_and_stimulations_car_amortization_cost' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_car_amortization_total = $this->input->post( 'employee_costs_and_stimulations_car_amortization_total' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_gas_limit = $this->input->post( 'employee_costs_and_stimulations_gas_limit' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_gas_cost = $this->input->post( 'employee_costs_and_stimulations_gas_cost' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_gas_total = $this->input->post( 'employee_costs_and_stimulations_gas_total' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_bonus_number = $this->input->post( 'employee_costs_and_stimulations_bonus_number' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_bonus_percent = $this->input->post( 'employee_costs_and_stimulations_bonus_percent' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_penalty_number = $this->input->post( 'employee_costs_and_stimulations_penalty_number' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_penalty_percent = $this->input->post( 'employee_costs_and_stimulations_penalty_percent' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_penalty_type = $this->input->post( 'employee_costs_and_stimulations_penalty_type' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_bonus_type = $this->input->post( 'employee_costs_and_stimulations_bonus_type' );
		
		$employee_cost_and_stimulation->employee_costs_and_stimulations_limit_total = $this->input->post( 'employee_costs_and_stimulations_limit_total' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_cost_total = $this->input->post( 'employee_costs_and_stimulations_cost_total' );
		$employee_cost_and_stimulation->employee_costs_and_stimulations_total_total= $this->input->post( 'employee_costs_and_stimulations_total_total' );
		
		return $employee_cost_and_stimulation;
		
	}
	
	public function getWorkSheetFromInput()
	{
		$employee_ws = new EmployeeWorkSheetVo();
		$employee_ws->employee_work_sheet_id = $this->input->post( 'employee_work_sheet_id' );
		$employee_ws->employee_id = $this->input->post( 'employee_id' );
		
		$employee_ws->employee_work_sheet_date_start = $this->input->post( 'employee_work_sheet_date_start' );
		$employee_ws->employee_work_sheet_date_end = $this->input->post( 'employee_work_sheet_date_end' );
		
		$employee_ws->employee_work_sheet_business_trip_days_total = $this->input->post( 'employee_work_sheet_business_trip_days_total' );
		$employee_ws->employee_work_sheet_business_trip_time_total = $this->input->post( 'employee_work_sheet_business_trip_time_total' );
		
		$employee_ws->employee_work_sheet_first_shift_time_total = $this->input->post( 'employee_work_sheet_first_shift_time_total' );
		$employee_ws->employee_work_sheet_second_shift_time_total = $this->input->post( 'employee_work_sheet_second_shift_time_total' );
		$employee_ws->employee_work_sheet_third_shift_time_total = $this->input->post( 'employee_work_sheet_third_shift_time_total' );
		
		$employee_ws->employee_work_sheet_first_shift_overtime_total = $this->input->post( 'employee_work_sheet_first_shift_overtime_total' );
		$employee_ws->employee_work_sheet_second_shift_overtime_total = $this->input->post( 'employee_work_sheet_second_shift_overtime_total' );
		$employee_ws->employee_work_sheet_third_shift_overtime_total = $this->input->post( 'employee_work_sheet_third_shift_overtime_total' );
		
		$employee_ws->employee_work_sheet_not_working_days_total = $this->input->post( 'employee_work_sheet_not_working_days_total' );
		$employee_ws->employee_work_sheet_num_days_total = $this->input->post( 'employee_work_sheet_num_days_total' );
		$employee_ws->employee_work_sheet_sick_days_total = $this->input->post( 'employee_work_sheet_sick_days_total' );
		$employee_ws->employee_work_sheet_sick_time_total = $this->input->post( 'employee_work_sheet_sick_time_total' );
		
		$employee_ws->employee_work_sheet_work_days_total = $this->input->post( 'employee_work_sheet_work_days_total' );
		$employee_ws->employee_work_sheet_work_overtime_total = $this->input->post( 'employee_work_sheet_work_overtime_total' );
		$employee_ws->employee_work_sheet_work_time_total = $this->input->post( 'employee_work_sheet_work_time_total' );
		$employee_ws->employee_work_sheet_vacation_days_total = $this->input->post( 'employee_work_sheet_vacation_days_total' ); 	
		
		return $employee_ws;
	}
	
	public function getWorkingScenarioFromInput()
	{
		$working_scenario = new EmployeeWorkingScenarioVo();
		$working_scenario->employee_working_scenario_id = $this->input->post( 'employee_working_scenario_id' );
		$working_scenario->employee_working_scenario_name = $this->input->post( 'employee_working_scenario_name' );
		
		return $working_scenario;
	}
	
	public function getWorkDaysArrayFromInput()
	{
		$wd_input = $this->postArrayParser();
		$wd_array =  $wd_input[ self::WORKING_DAYS_NAME ];
		$work_days = array();
		
		$day = NULL;
		foreach( $wd_array as $d )
		{
			if( is_array( $d ) )
			{
				$day = new EmployeesWorkingScenarioDayVo();
				if( array_key_exists( "employees_working_scenario_day_id", $d ) ) $day->employees_working_scenario_day_id = $d["employees_working_scenario_day_id"];
				if( array_key_exists( "employees_working_scenario_day", $d ) ) $day->employees_working_scenario_day = $d["employees_working_scenario_day"];
				if( array_key_exists( "employees_working_scenario_day_first_shift", $d ) ) $day->employees_working_scenario_day_first_shift = $d["employees_working_scenario_day_first_shift"];
				if( array_key_exists( "employees_working_scenario_day_second_shift", $d ) ) $day->employees_working_scenario_day_second_shift = $d["employees_working_scenario_day_second_shift"];
				if( array_key_exists( "employees_working_scenario_day_third_shift", $d ) ) $day->employees_working_scenario_day_third_shift = $d["employees_working_scenario_day_third_shift"];
				if( array_key_exists( "employees_working_scenario_day_type", $d ) ) $day->employees_working_scenario_day_type = $d["employees_working_scenario_day_type"];
				if( array_key_exists( "employees_working_scenario_first_shift_start", $d ) ) $day->employees_working_scenario_first_shift_start = $d["employees_working_scenario_first_shift_start"];
				if( array_key_exists( "employees_working_scenario_first_shift_end", $d ) ) $day->employees_working_scenario_first_shift_end = $d["employees_working_scenario_first_shift_end"];
				if( array_key_exists( "employees_working_scenario_second_shift_start", $d ) ) $day->employees_working_scenario_second_shift_start = $d["employees_working_scenario_second_shift_start"];
				if( array_key_exists( "employees_working_scenario_second_shift_end", $d ) ) $day->employees_working_scenario_second_shift_end = $d["employees_working_scenario_second_shift_end"];
				if( array_key_exists( "employees_working_scenario_third_shift_start", $d ) ) $day->employees_working_scenario_third_shift_start = $d["employees_working_scenario_third_shift_start"];
				if( array_key_exists( "employees_working_scenario_third_shift_end", $d ) ) $day->employees_working_scenario_third_shift_end = $d["employees_working_scenario_third_shift_end"];
				
				array_push( $work_days, $day );
			}
		}
		
		return $work_days;
	}
	
	public function getWorkSheetDaysArrayFromInput()
	{
		$wd_input =& $this->postArrayParser();
		$wd_array =  $wd_input[ self::WORK_SHEET_DAYS_NAME ];
		$work_days = array();
		
		$day = NULL;
		foreach( $wd_array as $d )
		{
			if( is_array( $d ) )
			{
				$day = new EmployeeWorkDayVo();
				
				if( array_key_exists( "employee_work_sheet_id", $d ) ) $day->employee_work_sheet_id = $d["employee_work_sheet_id"];
				if( array_key_exists( "employee_work_day", $d ) ) $day->employee_work_day = $d["employee_work_day"];
				if( array_key_exists( "employee_work_day_date", $d ) ) $day->employee_work_day_date = $d["employee_work_day_date"];
				if( array_key_exists( "employee_work_day_type", $d ) ) $day->employee_work_day_type = $d["employee_work_day_type"];
				if( array_key_exists( "employee_work_day_id", $d ) ) $day->employee_work_day_id = $d["employee_work_day_id"];
				if( array_key_exists( "employee_work_day_wage", $d ) ) $day->employee_work_day_wage = $d["employee_work_day_wage"];
				if( array_key_exists( "employee_work_day_first_shift", $d ) ) $day->employee_work_day_first_shift = $d["employee_work_day_first_shift"];
				if( array_key_exists( "employee_work_day_second_shift", $d ) ) $day->employee_work_day_second_shift = $d["employee_work_day_second_shift"];
				if( array_key_exists( "employee_work_day_third_shift", $d ) ) $day->employee_work_day_third_shift = $d["employee_work_day_third_shift"];
				if( array_key_exists( "employee_work_day_first_shift_start", $d ) ) $day->employee_work_day_first_shift_start = $d["employee_work_day_first_shift_start"];
				if( array_key_exists( "employee_work_day_first_shift_end", $d ) ) $day->employee_work_day_first_shift_end = $d["employee_work_day_first_shift_end"];
				if( array_key_exists( "employee_work_day_first_shift_overtime", $d ) ) $day->employee_work_day_first_shift_overtime = $d["employee_work_day_first_shift_overtime"];
				if( array_key_exists( "employee_work_day_second_shift_start", $d ) ) $day->employee_work_day_second_shift_start = $d["employee_work_day_second_shift_start"];
				if( array_key_exists( "employee_work_day_second_shift_end", $d ) ) $day->employee_work_day_second_shift_end = $d["employee_work_day_second_shift_end"];
				if( array_key_exists( "employee_work_day_second_shift_overtime", $d ) ) $day->employee_work_day_second_shift_overtime = $d["employee_work_day_second_shift_overtime"];
				if( array_key_exists( "employee_work_day_third_shift_start", $d ) ) $day->employee_work_day_third_shift_start = $d["employee_work_day_third_shift_start"];
				if( array_key_exists( "employee_work_day_third_shift_end", $d ) ) $day->employee_work_day_third_shift_end = $d["employee_work_day_third_shift_end"];
				if( array_key_exists( "employee_work_day_third_shift_overtime", $d ) ) $day->employee_work_day_third_shift_overtime = $d["employee_work_day_third_shift_overtime"];
				if( array_key_exists( "employee_work_day_third_shift_overtime", $d ) ) $day->employee_work_day_third_shift_overtime = $d["employee_work_day_third_shift_overtime"];
				
				if( ! $day->employee_work_day_id )
				{
					$day->employee_work_day_id = 0;
				}
				
				array_push( $work_days, $day );
			}
		}
		
		return $work_days;
	}
}

?>