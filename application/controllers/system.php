<?php if ( !defined('BASEPATH')) die();

require_once 'application/controllers/BaseController.php';
require_once 'application/vos/ModelVos/DataHolderColumnVo.php';

class System extends BaseController
{
	const DATA_HOLDER_COLUMNS_NAME = "_data_holder_columns_";
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model( 'System_model', 'system_model' );
		$this->system_model->loadDatabase();
	}
	
	public function readDataHolderColumns( $user_id = NULL, $data_holder_id = NULL )
	{
		if( ! $user_id )
			$user_id = $this->input->post( 'user_id' );	
	
		if( ! $data_holder_id )
			$data_holder_id = $this->input->post( 'data_holder_id' );		
			
		$this->setDataHolderFromModelOperationVo( $this->system_model->readDataHolderColumns( $user_id, $data_holder_id ) );
		$this->_data_holder->dispatchAll(); 
	}
	
	public function saveDataHolderColumns( array $columns = NULL )
	{
		if( ! $columns )
			$columns = $this->getDataHolderColumnsFromInput();	
			
		$this->setDataHolderFromModelOperationVo( $this->system_model->saveDataHolderColumns( $columns ) );
		$this->_data_holder->dispatchAll(); 
	}
	
	public function getDataHolderColumnsFromInput()
	{
		$cols_input = $this->postArrayParser();
		$cols_array =  $cols_input[ self::DATA_HOLDER_COLUMNS_NAME ];
		$columns = array();
		
		$col = NULL;
		foreach( $cols_array as $c )
		{
			if( is_array( $c ) )
			{
				$col = new DataHolderColumnVo();
							
				if( array_key_exists( "data_holder_columns_id", $c ) ) $col->data_holder_column_id = $c["data_holder_columns_id"];
				if( array_key_exists( "data_holder_id", $c ) ) $col->data_holder_id = $c["data_holder_id"];
				if( array_key_exists( "data_holder_column_user_id", $c ) ) $col->data_holder_column_user_id = $c["data_holder_column_user_id"];
				if( array_key_exists( "data_holder_column_header_text", $c ) ) $col->data_holder_column_header_text = $c["data_holder_column_header_text"];
				if( array_key_exists( "data_holder_column_visible", $c ) ) $col->data_holder_column_visible = $c["data_holder_column_visible"];
				if( array_key_exists( "data_holder_column_position_index", $c ) ) $col->data_holder_column_position_index = $c["data_holder_column_position_index"];
				if( array_key_exists( "data_holder_column_data_field", $c ) ) $col->data_holder_column_data_field = $c["data_holder_column_data_field"];
				if( array_key_exists( "data_holder_column_custom_header", $c ) ) $col->data_holder_column_custom_header = $c["data_holder_column_custom_header"];
				if( array_key_exists( "data_holder_column_custom_header", $c ) ) $col->data_holder_column_custom_header = $c["data_holder_column_custom_header"];
				if( array_key_exists( "data_holder_column_custom_header_text", $c ) ) $col->data_holder_column_custom_header_text = $c["data_holder_column_custom_header_text"];
				
				// code igniter bug
				if( ! $col->data_holder_column_id )
				{
					$col->data_holder_column_id = 0;
				}
				
				array_push( $columns, $col );
			}
		}
		
		return $columns;
	}
}

?>