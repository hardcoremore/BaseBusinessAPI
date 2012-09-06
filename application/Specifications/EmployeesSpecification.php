<?php

require_once 'application/libraries/BaseSpecification.php';
require_once 'application/vos/ModelVos/EmployeesVo.php';
require_once 'application/vos/ModelVos/EmployeesWorkingScenarioDayVo.php';
require_once 'application/vos/ModelVos/EmployeeEconomicsVo.php';

class EmployeesSpecification extends BaseSpecification
{
	public function create(  EmployeesVo $customer )
	{
		return TRUE;
	}
	
	public function update( EmployeesVo $employee )
	{
		if( $this->digitOnly( $employee->employee_id ) && $this->create( $employee ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	//economic
	public function createEconomic( EmployeeEconomicsVo $economic )
	{
		return TRUE;
	}
	
	//economic
	public function saveCostAndStimulation( EmployeeCostAndStimulationsVo $cost_and_stimulation )
	{
		return TRUE;
	}
	
	// working scenario
	public function workingScenario( EmployeeWorkingScenarioVo $ws )
	{
		return TRUE;
	}
	
	public function workingScenarioDay( EmployeesWorkingScenarioDayVo $wsd )
	{
		return TRUE;
	}
	
	// work sheet
	public function workSheet( EmployeeWorkSheetVo $ws )
	{
		return TRUE;
	}
	
	public function workSheetDay( EmployeeWorkDayVo $wd )
	{
		return TRUE;
	}
}

?>