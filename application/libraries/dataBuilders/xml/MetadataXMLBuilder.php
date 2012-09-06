<?php if ( !defined('BASEPATH')) die();

require_once 'application/Interfaces/IMetadataBuilder.php';
require_once 'application/libraries/dataBuilders/xml/XMLBuilder.php';

class MetadataXMLBuilder extends XMLBuilder implements IMetadataBuilder
{
	private $__status;
	
	private $__message;
	
	private $__errorCode;
	
	private $__metadata;
	
	private $__data_type;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function setStatus( $status )
	{
		$this->__status = $status;
	}
	
	public function setMessage( $message )
	{
		$this->__message = $message;
	}
	
	public function setErrorCode( $errorCode )
	{
		$this->__errorCode = $errorCode;
	}
	
	public function setDataType( $data_type )
	{
		$this->__data_type = $data_type;
	}
	
	public function getStatus()
	{
		return $this->__status;
	}
	
	public function getMessage()
	{
		return $this->__message;
	}
	
	public function getErrorCode()
	{
		return $this->__errorCode;
	}
	
	public function getDataType()
	{
		return $this->__data_type;
	}
	
	public function setData( $data )
	{
		if( $this->__metadata != $data && is_array( $data ) )
		{
			$this->__metadata = $data;
		}
	}
	
	public function getFormatedMetadata()
	{	
		(string)$md = '<metadata>';
		
		$md .= $this->compileElement( $this->__status, 'status' );
		$md .= $this->compileElement( $this->__errorCode, 'errorCode' );
		$md .= $this->compileElement( $this->__message, 'message' );
		$md .= $this->compileElement( $this->__data_type, 'dataType' );
		
		if( is_array( $this->__metadata ) )
		{
			$md .= $this->convertFromArray( $this->__metadata );
		}
		else if( is_object( $this->__metadata ) )
		{
			$md .= $this->convertFromObject( $this->__metadata );
		}
		
		$md .= '</metadata>';
		return $md;
	}
	
	public function getRawMetadata()
	{
		if( is_object( $this->__metadata ) )
		{
			$this->__metadata->status 		= $this->__status;
			$this->__metadata->errorCode	= $this->__errorCode; 
			$this->__metadata->message		= $this->__message;
		}
		else if( is_array( $this->__metadata ) )
		{
			$a[ 'status' ] 		= $this->__status;
			$a[ 'errorCode' ] 	= $this->__errorCode; 
			$a[ 'message' ] 	= $this->__message;
		}
		
		return $this->__metadata;
	}
	
	public function reset()
	{
		$this->__status 	= NULL;
		$this->__message 	= NULL;
		$this->__errorCode 	= NULL;
		$this->__metadata 	= NULL;	
	}
}

?>