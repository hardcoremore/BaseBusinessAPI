<?php

require_once 'application/models/BaseModel.php';
require_once 'application/vos/ModelVos/StorageVo.php';
require_once 'application/vos/ModelVos/StorageItemVo.php';
require_once 'application/vos/ModelVos/StorageItemCategoryVo.php';
require_once 'application/Specifications/StorageSpecification.php';


class Storage_model extends BaseModel
{
	const STORAGE_TYPE_CENTRAL = 1;
	const STORAGE_TYPE_INNER_BUSINESS = 2;
	const STORAGE_TYPE_STORAGE_BUSINESS = 3;
	const STORAGE_TYPE_STORAGE_INNER_PERSONAL = 4;
	const STORAGE_TYPE_STORAGE_PERSONAL = 5;
	const STORAGE_TYPE_TEMPORARY = 6;
	
	const STORAGE_ITEM_CATEGORY_TYPE_FINISHED_GOODS = 1;
	const STORAGE_ITEM_CATEGORY_TYPE_RAW_MATERIALS = 2;
	const STORAGE_ITEM_CATEGORY_TYPE_VIRTUAL = 3;
	const STORAGE_ITEM_CATEGORY_TYPE_LABOR = 4;
	
	const STORAGE_ITEM_TYPE_ASSEMBLY = 1;
	const STORAGE_ITEM_TYPE_KIT = 2;
	const STORAGE_ITEM_TYPE_MANUFACTURED = 3;
	const STORAGE_ITEM_TYPE_PHANTOM = 4;
	const STORAGE_ITEM_TYPE_PURCHASED = 5;
	const STORAGE_ITEM_TYPE_LABOR = 6;
	
	// UOM = unit of measure
	const STORAGE_ITEM_UOM_EACH = 1;
	const STORAGE_ITEM_UOM_KGS = 2;
	const STORAGE_ITEM_UOM_LENGTH = 3;
	const STORAGE_ITEM_UOM_LITERS = 4;
	const STORAGE_ITEM_UOM_METERS = 5;
	
	const STORAGE_ITEM_TAX_PERCENT_0 = 0;
	const STORAGE_ITEM_TAX_PERCENT_8 = 8;
	const STORAGE_ITEM_TAX_PERCENT_10 = 10;
	const STORAGE_ITEM_TAX_PERCENT_18 = 18;
	
	protected $_spec;
	
	public function __construct()
	{
		parent::__construct();
		$this->_spec = new StorageSpecification();
	}
	
	
	/*
	=======================
	
	  ITEMS
	  
	=======================  
	*/ 
	public function createItem( StorageItemVo $item )
	{
		if( $this->_spec->createItem( $item ) )
		{
			unset( $item->storage_item_id );
			unset( $item->storage_item_category_name );
			
			$this->db->insert( 'storage_items', $item );
			
			if( $this->db->affected_rows() == 1 )
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
	
	public function readItems( ReadTableVo $readVo )
	{
		$this->db->select( 'storage_items.*, storage_item_categories.storage_item_category_name' );
		$this->db->join( 'storage_item_categories', 'storage_item_categories.storage_item_category_id = storage_items.storage_item_category', 'inner' );
		
		$tr = $this->_readFromTable( 'storage_items', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'StorageItemVo' );
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
	
	
	
	public function updateItem( StorageItemVo $item )
	{
		if( $this->_spec->updateItem( $item ) )
		{
		
			$this->db->where( 'storage_item_id', $item->storage_item_id );
			
			unset( $item->storage_item_id );
			unset( $item->storage_item_category_name );
			
			$this->db->update( 'storage_items', $item );
			
			if( $this->db->affected_rows() >= 0 )
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
	
	
	/*
	=======================
	
	 	CATEGORIES
	  
	=======================  
	*/ 
	
	public function createItemCategory( StorageItemCategoryVo $item_category )
	{
		if( $this->_spec->createItemCategory( $item_category ) )
		{
			if( ! $item_category->storage_item_category_code )
			{
				$item_category->storage_item_category_code = $this->db->count_all_results( 'storage_item_categories' ) + 1;
			}
			
			unset( $item_category->storage_item_category_id );
			$this->db->insert( 'storage_item_categories', $item_category );
			
			if( $this->db->affected_rows() == 1 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->affectedRows = 1;
				$this->operationData()->dataType = DataHolderDataType::CUSTOM_OBJECT;
				
				
				$this->db->where( 'storage_item_category_id', $this->db->insert_id() );
				$new = $this->db->get( 'storage_item_categories' );
				
				$this->operationData()->result = $new->row( 0 , 'StorageItemCategoryVo' ); 
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
	
	public function readItemCategories( ReadTableVo $readVo )
	{
		
		$tr = $this->_readFromTable( 'storage_item_categories', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'StorageItemCategoryVo' );
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
	
	
	
	public function updateItemCategory( StorageItemCategoryVo $item_category )
	{
		if( $this->_spec->updateItemCategory( $item_category ) )
		{
		
			$this->db->where( 'storage_item_category_id', $item_category->storage_item_category_id );
			unset( $item_category->storage_item_category_id );
			$this->db->update( 'storage_item_categories', $item_category );
			
			if( $this->db->affected_rows() >= 0 )
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
	
	public function readItemCategoriesForSelect()
	{
		$this->db->select( 'storage_item_category_id, storage_item_category_name');
		
		$q = $this->db->get( 'storage_item_categories' );
		
		if( $q )
		{
			$result = $q->custom_result_object( 'StorageItemCategoryVo' );
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
	
	public function updateItemCategoryField( UpdateTableFieldVo $update )
	{
		$update->table_name = 'storage_item_categories';
		$update->id_name = 'storage_item_category_id';
		
		$this->updateTableField( $update );
		
		return $this->operationData();
	}
	/*
	=======================
	
	 	STORAGES
	  
	=======================  
	*/ 
	
	public function createStorage( StorageVo $storage )
	{
		if( $this->_spec->createStorage( $storage ) )
		{
			if( ! $storage->storage_code )
			{
				$storage->storage_code = $this->db->count_all_results( 'storages' ) + 1;
			}
			
			unset( $storage->storage_id );
			$this->db->insert( 'storages', $storage );
			
			if( $this->db->affected_rows() == 1 )
			{
				$this->operationData()->status = BaseController::STATUS_OK;
				$this->operationData()->errorCode = 0;
				$this->operationData()->affectedRows = 1;
				$this->operationData()->dataType = DataHolderDataType::CUSTOM_OBJECT;
				
				
				$this->db->where( 'storage_id', $this->db->insert_id() );
				$new = $this->db->get( 'storages' );
				
				$this->operationData()->result = $new->row( 0 , 'StorageVo' ); 
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
	
	public function readStorages( ReadTableVo $readVo )
	{
		
		$tr = $this->_readFromTable( 'storages', $readVo );
		
		if( $tr )
		{
			$result = $tr->result->custom_result_object( 'StorageVo' );
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
	
	
	
	public function updateStorage( StorageVo $storage )
	{
		if( $this->_spec->updateStorage( $storage ) )
		{
		
			$this->db->where( 'storage_id', $storage->storage_id );
			unset( $storage->storage_id );
			$this->db->update( 'storages', $storage );
			
			if( $this->db->affected_rows() >= 0 )
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
	
	public function readStoragesForSelect()
	{
		$this->db->select( 'storage_id, storage_name');
		
		$q = $this->db->get( 'storages' );
		
		if( $q )
		{
			$result = $q->custom_result_object( 'StorageVo' );
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
	
	public function updateStorageField( UpdateTableFieldVo $update )
	{
		$update->table_name = 'storages';
		$update->id_name = 'storage_id';
		
		$this->updateTableField( $update );
		
		return $this->operationData();
	}
}

?>