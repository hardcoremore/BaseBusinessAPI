<?php

require_once 'application/vos/ModelOperationReturnVo.php';
require_once 'application/libraries/CSession.php';
require_once 'application/libraries/dataBuilders/DataHolderDataType.php';
require_once 'application/vos/ReadTableReturnVo.php';
require_once 'application/vos/SearchParameterVo.php';

class BaseModel extends CI_Model
{
	
	const CURRENCY_TYPE_RSD = 1;  
	const CURRENCY_TYPE_DOLLAR = 2;  
	const CURRENCY_TYPE_EUR = 3;  
	const CURRENCY_TYPE_KM = 4;  
	
	const SEARCH_OPERAND_EQUAL = 'EQUAL';
	const SEARCH_OPERAND_LIKE = 'LIKE';
	const SEARCH_OPERAND_LOWER_THAN = 'LOWER_THAN';
	const SEARCH_OPERAND_GREATER_THAN = 'GREATER_THAN';
	const SEARCH_OPERAND_LOWER_OR_EQUAL = 'LOWER_OR_EQUAL';
	const SEARCH_OPERAND_GREATER_OR_EQUAL = 'GREATER_OR_EQUAL';
		
	private $__operation_data;
	protected $_session;
	protected $db;
	
	public function __construct( DatabaseConfigVo $database = null )
	{
		parent::__construct();
		$this->__operation_data = new ModelOperationReturnVo();
		$this->_session = CSession::getInstance();
	}
	
	public function loadDatabase( DatabaseConfigVo $database = NULL )
	{
		if( ! $database )
			$database = BaseController::USER_DATABASE_CONFIG();
			
		$this->db = $this->load->database( get_object_vars( $database ), true );
	}
	

	public function updateTableField( UpdateTableFieldVo $update )
	{
		$this->db->where( $update->id_name, $update->id_value );
		
		$this->db->update( $update->table_name, array( $update->value_name => $update->value ) );
		
		if( ! $this->db->_error_number() )
		{
			$this->operationData()->status = BaseController::STATUS_OK;
			$this->operationData()->affectedRows = $this->db->affected_rows();
			$this->operationData()->errorCode = 0;
			
		}
		else 
		{
			$this->setDatabaseError();
		}
	}
	
	public function operationData()
	{
		return $this->__operation_data;
	}
	
	public function resetOperationData()
	{
		$this->__operation_data = new ModelOperationReturnVo();
	}
	
	public function getRowsOffset( $page, $rowsPerPage, $totalRows )
	{
		if( $page < 0 || 
			$rowsPerPage < 0 || 
			$rowsPerPage > $totalRows ) return 0;
		
		
		return $rowsPerPage * $page - $rowsPerPage;
	}
	
	public function setDatabaseError()
	{
		$this->operationData()->status = BaseController::STATUS_ERROR;
		$this->operationData()->errorCode = ErrorCodes::DATABASE_ERROR;
		$this->operationData()->message = ServerMessages::DATABASE_ERROR;
	}
	
	public function setOperationReadData( $data, $totalRows, $data_type = NULL )
	{
		$this->operationData()->status = BaseController::STATUS_OK;
		$this->operationData()->errorCode = 0;
		$this->operationData()->result = $data;
		$this->operationData()->totalRows  = $totalRows;
		$this->operationData()->numRows = count( $data );
		
		if( ! $data_type )
		{
			$this->operationData()->dataType = DataHolderDataType::ARRAY_LIST;
		}
		else
		{
			$this->operationData()->dataType = $data_type;
		}
	}
	
	public function isOrder( ReadTableVo $readVo )
	{
		if( strlen( $readVo->sortColumnName ) > 0 && strlen( $readVo->sortDirection ) > 0 && 
			$readVo->sortColumnName != 'null' && $readVo->sortDirection != 'null' )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function isPage( ReadTableVo $readVo )
	{
		if( $readVo->pageNumber > 0 && $readVo->rowsPerPage > 0 )
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
	public static function getTimeStringFromSeconds( $seconds )
	{
		
		$minLeft 	= floor( $seconds / 60 );			
		$hoursLeft 	= floor( $minLeft / 60 );
		
		$secLeft = $seconds % 60;
		$minLeft %= 60;
		$hoursLeft %= 24;
	
		return $hoursLeft . ":" . $minLeft . ":" . $secLeft;	
	}
	
	protected function &_readFromTable( $table_name, ReadTableVo $readVo )
	{
		$r = new ReadTableReturnVo();
		
		if( $readVo->is_search )
		{
			$this->_setupSearch( $readVo->search_parameters );
		}
		
		if( $this->isOrder( $readVo ) )
			$this->db->order_by( $readVo->sortColumnName, $readVo->sortDirection );

	    $q =  NULL;		
		if( $this->isPage( $readVo ) )
		{	
			$r->offset = $this->getRowsOffset( $readVo->pageNumber, $readVo->rowsPerPage, $r->totalRows );
			$r->result = $this->db->get( $table_name, $readVo->rowsPerPage, $r->offset );
		}
		else
		{
			$r->result = $this->db->get( $table_name );
		}
		
		if( $readVo->is_search )
		{
			$this->_setupSearch( $readVo->search_parameters );
		}
	
		$r->totalRows = $this->db->count_all_results( $table_name );
		
		return $r;
	}
	
	protected function _setupSearch( array $parameters )
	{
		foreach( $parameters as $v )
		{
			switch( $v->operand )
			{
				case self::SEARCH_OPERAND_EQUAL:
					$this->db->where( $v->name, $v->value );
				break;
				
				case self::SEARCH_OPERAND_GREATER_OR_EQUAL:
					$this->db->where( $v->name . ' >=', $v->value );
				break;
				
				case self::SEARCH_OPERAND_GREATER_THAN:
					$this->db->where( $v->name . ' >', $v->value );
				break;
				
				case self::SEARCH_OPERAND_LIKE:
					$this->db->like( $v->name, $v->value );
				break;
				
				case self::SEARCH_OPERAND_LOWER_OR_EQUAL:
					$this->db->where( $v->name . ' <=', $v->value );
				break;
				
				case self::SEARCH_OPERAND_LOWER_THAN:
					$this->db->where( $v->name . ' <', $v->value );
				break;
				
			}
		}
	}
	
	
}

?>