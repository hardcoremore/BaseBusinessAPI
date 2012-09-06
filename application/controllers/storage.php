<?php if ( !defined('BASEPATH')) die();

require_once 'application/controllers/BaseController.php';
require_once 'application/vos/ModelVos/StorageItemCategoryVo.php';
require_once 'application/vos/ModelVos/StorageItemVo.php';
require_once 'application/vos/ModelVos/StorageVo.php';

class Storage extends BaseController
{

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model( 'Storage_model', 'storage_model' );
		$this->storage_model->loadDatabase();
	}
	
	/*
	=======================
	
	  ITEMS
	  
	=======================  
	*/ 
	
	public function createItem( StorageItemVo $item = NULL )
	{
		if( ! $item )
			$item = $this->getItemFromInput();
	 	
		$this->setDataHolderFromModelOperationVo( $this->storage_model->createItem( $item ) );
		$this->_data_holder->dispatchAll();
		
	}
	
	public function readItems( ReadTableVo $readVo = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		$this->setDataHolderFromModelOperationVo( $this->storage_model->readItems( $readVo ) );
		$this->_data_holder->dispatchAll();
	}
	
	
	public function updateItem( StorageItemVo $item = NULL )
	{
		if( ! $item )
			$item = $this->getItemFromInput();
	
		$this->setDataHolderFromModelOperationVo( $this->storage_model->updateItem( $item ) );
		$this->_data_holder->dispatchAll();

	}
	
	public function getItemFromInput()
	{
		$item = new StorageItemVo();
		$item->storage_item_bar_code = $this->input->post( 'storage_item_bar_code' );
		$item->storage_item_category = $this->input->post( 'storage_item_category' );
		$item->storage_item_code = $this->input->post( 'storage_item_code' );
		$item->storage_item_date_created = $this->input->post( 'storage_item_date_created' );
		$item->storage_item_description = $this->input->post( 'storage_item_description' );
		$item->storage_item_display_decimal = $this->input->post( 'storage_item_display_decimal' );
		$item->storage_item_id = $this->input->post( 'storage_item_id' );
		$item->storage_item_name = $this->input->post( 'storage_item_name' );
		$item->storage_item_order_quantity = $this->input->post( 'storage_item_order_quantity' );
		$item->storage_item_tax_percent = $this->input->post( 'storage_item_tax_percent' );
		$item->storage_item_type = $this->input->post( 'storage_item_type' );
		$item->storage_item_unit_of_measure = $this->input->post( 'storage_item_unit_of_measure' );
		$item->storage_item_volume = $this->input->post( 'storage_item_volume' );
		$item->storage_item_weight = $this->input->post( 'storage_item_weight' );
		
		return $item;
	}
	
	
	/*
	=======================
	
	 	CATEGORIES
	  
	=======================  
	*/ 
	
	public function createItemCategory( StorageItemCategoryVo $item_category = NULL )
	{
		if( ! $item_category )
			$item_category = $this->getItemCategoryFromInput();
	 	
		$this->setDataHolderFromModelOperationVo( $this->storage_model->createItemCategory( $item_category ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readItemCategories( ReadTableVo $readVo = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		$this->setDataHolderFromModelOperationVo( $this->storage_model->readItemCategories( $readVo ) );
		$this->_data_holder->dispatchAll();
	}
	
	
	public function updateItemCategory( StorageItemCategoryVo $item_category = NULL )
	{
		if( ! $item_category )
			$item_category = $this->getItemCategoryFromInput();
	
		$this->setDataHolderFromModelOperationVo( $this->storage_model->updateItemCategory( $item_category ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function updateItemCategoryField( UpdateTableFieldVo $update = NULL )
	{
		if( ! $update )
			$update = $this->getUpdateTableVo();
			
		$this->setDataHolderFromModelOperationVo( $this->storage_model->updateItemCategoryField( $update ) );	
		$this->_data_holder->dispatchAll();	
	}
	
	public function readItemCategoriesForSelect()
	{
		$this->setDataHolderFromModelOperationVo( $this->storage_model->readItemCategoriesForSelect() );
		$this->_data_holder->dispatchAll();
	}
	
	public function getItemCategoryFromInput()
	{
		$item_category = new StorageItemCategoryVo();
		$item_category->storage_item_category_id = $this->input->post( 'storage_item_category_id' );
		$item_category->storage_item_category_code = $this->input->post( 'storage_item_category_code' );
		$item_category->storage_item_category_name = $this->input->post( 'storage_item_category_name' );
		$item_category->storage_item_category_type = $this->input->post( 'storage_item_category_type' );
		
		return $item_category;
	}
	/*
	=======================
	
	 	STORAGES
	  
	=======================  
	*/ 
	
	public function createStorage( StorageVo $storage = NULL )
	{
		if( ! $storage )
			$storage = $this->getStorageFromInput();
	 	
		$this->setDataHolderFromModelOperationVo( $this->storage_model->createStorage( $storage ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readStorages( ReadTableVo $readVo = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		$this->setDataHolderFromModelOperationVo( $this->storage_model->readStorages( $readVo ) );
		$this->_data_holder->dispatchAll();
	}
	
	
	public function updateStorage( StorageVo $storage = NULL )
	{
		if( ! $storage )
			$storage = $this->getStorageFromInput();
	
		$this->setDataHolderFromModelOperationVo( $this->storage_model->updateStorage( $storage ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function updateStorageField( UpdateTableFieldVo $update = NULL )
	{
		if( ! $update )
			$update = $this->getUpdateTableVo();
			
		$this->setDataHolderFromModelOperationVo( $this->storage_model->updateStorageField( $update ) );	
		$this->_data_holder->dispatchAll();	
	}
	
	public function readStoragesForSelect()
	{
		$this->setDataHolderFromModelOperationVo( $this->storage_model->readStoragesForSelect() );
		$this->_data_holder->dispatchAll();
	}
	
	public function getStorageFromInput()
	{
		$storage = new StorageVo();
		$storage->storage_id = $this->input->post( 'storage_id' );
		$storage->storage_code = $this->input->post( 'storage_code' );
		$storage->storage_name = $this->input->post( 'storage_name' );
		$storage->storage_type = $this->input->post( 'storage_type' );		
		$storage->storage_address = $this->input->post( 'storage_address' );
		
		return $storage;
	}
	
}

?>