<?php

require_once 'application/Specifications/DesktopSpecification.php';
require_once 'application/vos/ModelVos/DesktopAppearanceVo.php';

class Desktop_model extends BaseModel
{
	
	const DESKTOP_ICON_RESOURCE_TYPE_MODULE = 1;
	const DESKTOP_ICON_RESOURCE_TYPE_IMAGE = 2;
	const DESKTOP_ICON_RESOURCE_TYPE_TEXT = 3;
	
	const DESKTOP_WALLPAPER_TYPE_COLOR = 1;
	const DESKTOP_WALLPAPER_TYPE_IMAGE = 2;
	
	protected $_spec;
	
	public function __construct( DatabaseConfigVo $database = null )
	{
		parent::__construct( $database );
		$this->_spec = new DesktopSpecification();
	}
	
	public function createDesktopAppearance( DesktopAppearanceVo $appearance )
	{
		if( $this->_spec->createAppearance( $appearance ) )
		{
			
			$this->db->trans_start();
			
			$this->_resetDefaultAppearance( $appearance );
			
			unset( $appearance->desktop_appearance_id );
			$this->db->insert( 'desktop_appearance', $appearance );
			
			$this->db->trans_complete();
				
			if( $this->db->trans_status() === FALSE ) 
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
			}
			else
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->result = array( "desktop_appearance_id" => $this->db->insert_id(), 
														"desktop_appearance_name" => $appearance->desktop_appearance_name );
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
	
	public function readDesktopAppearances( ReadTableVo $readVo )
	{
		$tr = $this->_readFromTable( 'desktop_appearance', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'DesktopAppearanceVo' );
			$this->setOperationReadData( $result, $tr->totalRows );
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();

	}
	
	public function readDefaultDesktopAppearance()
	{
		$this->db->where( 'desktop_appearance_default', 1 );
		
		$q  = $this->db->get('desktop_appearance' );
		
		if( $q )
		{
			$result = $q->custom_result_object( 'DesktopAppearanceVo' );
			
			$this->setOperationReadData( $result, 1 );
			$this->operationData()->dataType = $this->operationData()->dataType = DataHolderDataType::CUSTOM_OBJECT;
		}
		else
		{
			$this->operationData()->status = BaseController::STATUS_ERROR;
			$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
			$this->operationData()->message = ServerMessages::DATABASE_ERROR;
		}
		
		return $this->operationData();
	}
	
	public function updateDesktopAppearance( DesktopAppearanceVo $appearance )
	{
		if( $this->_spec->updateAppearance( $appearance ) )
		{
		
			$this->db->trans_start();
			
			$this->_resetDefaultAppearance( $appearance );
			
			$this->db->where( 'desktop_appearance_id', $appearance->desktop_appearance_id );
			unset( $appearance->desktop_appearance_id );
			$this->db->update( 'desktop_appearance', $appearance );
			
			 
			$this->db->trans_complete();
			
			if( $this->db->trans_status() === FALSE ) 
			{
				$this->operationData()->status = BaseController::STATUS_ERROR;
				$this->operationData()->errorCode = ServerOperationCodes::DATABASE_ERROR;
				$this->operationData()->message = ServerMessages::DATABASE_ERROR;
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
	
	protected function _resetDefaultAppearance( DesktopAppearanceVo $appearance )
	{
		if( $appearance->desktop_appearance_default == 1 )
		{
				$this->db->where( 'desktop_appearance_default', 1 );
				$this->db->where( 'desktop_appearance_user_id', $appearance->desktop_appearance_user_id );
				$this->db->update( 'desktop_appearance', array( 'desktop_appearance_default' => 0 ) );
		}
	}
}

?>