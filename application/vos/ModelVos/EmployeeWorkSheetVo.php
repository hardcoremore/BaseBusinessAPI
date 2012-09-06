<?php

class EmployeeWorkSheetVo
{
	public $employee_work_sheet_id;
	public $employee_id;
	
	public $employee_work_sheet_date_start;
	public $employee_work_sheet_date_end;
	
	public $employee_work_sheet_work_time_total;
	
	public $employee_work_sheet_business_trip_time_total;
	public $employee_work_sheet_sick_time_total;
	public $employee_work_sheet_work_overtime_total;
	
	public $employee_work_sheet_first_shift_time_total;
	public $employee_work_sheet_second_shift_time_total;
	public $employee_work_sheet_third_shift_time_total;
		
	public $employee_work_sheet_first_shift_overtime_total;
	public $employee_work_sheet_second_shift_overtime_total;
	public $employee_work_sheet_third_shift_overtime_total;
	
	public $employee_work_sheet_num_days_total;
	public $employee_work_sheet_work_days_total;
	public $employee_work_sheet_business_trip_days_total;
	public $employee_work_sheet_sick_days_total;
	public $employee_work_sheet_vacation_days_total;
	
	public $employee_work_sheet_not_working_days_total;
}

?>