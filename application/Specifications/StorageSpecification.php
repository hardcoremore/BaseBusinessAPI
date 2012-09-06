<?php

require_once 'application/libraries/BaseSpecification.php';

class StorageSpecification extends BaseSpecification
{
	public function createItem( StorageItemVo $item )
	{
		return TRUE;
	}
	
	public function updateItem( StorageItemVo $item )
	{
		return TRUE;
	}
		
	public function createItemCategory( StorageItemCategoryVo $item_category )
	{
		return TRUE;
	}
	
	public function updateItemCategory( StorageItemCategoryVo $item_category )
	{
		return TRUE;
	}
	
	public function createStorage( StorageVo $storage )
	{
		return TRUE;
	}
	
	public function updateStorage( StorageVo $storage )
	{
		return TRUE;
	}
}

?>