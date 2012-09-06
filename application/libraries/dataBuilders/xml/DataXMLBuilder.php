<?php if ( !defined('BASEPATH')) exit();

require_once 'application/Interfaces/IDataBuilder.php';
require_once 'application/libraries/dataBuilders/xml/XMLBuilder.php';

class DataXMLBuilder extends XMLBuilder implements IDataBuilder
{
	private $__data;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function setData( $data )
	{
		$this->__data = $data;
	}
	
	public function getFormatedData()
	{		
		(string) $data = "<data>";
		
		if( is_array( $this->__data ) )
		{
			$data .= $this->convertFromArray( $this->__data );
		}
		else if( is_object( $this->__data ) )
		{
			$class_name = get_class( $this->__data );
			
			$data .= '<' . $class_name . '>';
			$data .= $this->convertFromObject( $this->__data );
			$data .= '</' . $class_name . '>';
		}
		 
		 $data .= "</data>";
		 
		 return $data;
	}
	
	public function getRawData()
	{
		$d = $this->__data;
		 
		return $d;
	}
	
	public function reset()
	{
		$this->__data = NULL;
	}
}

?>