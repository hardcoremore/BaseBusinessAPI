<?php if ( !defined('BASEPATH') ) die();

require_once 'application/Interfaces/IDataHolder.php';
require_once 'application/vos/DataHolderVo.php';

class XMLDataHolder implements IDataHolder
{
	private $__metadata;
	
	private $__data;
	
	
	public function __construct()
	{
		
		require_once 'application/libraries/dataBuilders/xml/MetadataXMLBuilder.php';
		require_once 'application/libraries/dataBuilders/xml/DataXMLBuilder.php';
		
		
		// here MetadataXMLBuilder is hardcoded. But because it  implements IMetadataBuilder
		// it can be easily created from factory when another implementation is needed.
		
		$this->__metadata = new MetadataXMLBuilder(); 
		
		
		// same as MetadataXMLBuilder
		$this->__data = new DataXMLBuilder();
	}
	
	// reset data holder
	public function reset()
	{
		$this->__metadata->reset();
		$this->__data->reset();
	}
	
	public function metadata()
	{
		return $this->__metadata;
	}
	
	public function data()
	{
		return $this->__data;
	}
	
	public function &getAll()
	{
		(string) $xml = '<?xml version="1.0" encoding="utf-8"?><response>';
		
				 $xml .= $this->metadata()->getFormatedMetadata();
				 
				 $xml .= $this->data()->getFormatedData();
				 
				 $xml .= "</response>";
				 
		return $xml;		 
	}
	
	public function &getRawData()
	{
		$vo = new DataHolderVo( $this->__metadata->getRawMetadata(), $this->__data->getRawData() );
		return $vo;
	}
	
	public function dispatchAll()
	{
		header( "Content-type:text/xml" );
		echo $this->getAll();
	}
}

?>