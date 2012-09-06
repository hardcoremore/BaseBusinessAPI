<?php

require_once 'application/libraries/dataBuilders/OutputBuilderBase.php';

class XMLBuilder extends OutputBuilderBase
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * @see IOutputBuilder::convertFromObject()
	 */
	public function convertFromObject( $data )
	{
		$class_name = get_class( $data );
		$class_vars = get_class_vars( $class_name );
		$xml = "";
		
		foreach ( $class_vars as $name => $value ) 
		{
			if( property_exists( $data, $name ) === TRUE )
			{
    			$xml .= $this->compileElement( $data->$name, $name );
			}
		}

		return $xml;
	}
	
	
	
	/**
	 * @see IOutputBuilder::convertFromArray()
	 */
	public function convertFromArray( $data )
	{
		if( ! is_array( $data ) || count( $data ) < 1 ) return;
		
	    (string)$xml = '';
	    $class_name = "";
	    
		foreach( $data as $k => $v )
		{
			$n = $this->getValidatedElementName( $k );
			
			if( is_array( $v ) )
			{		
					
				$xml .= '<'.$n.'>';
				$xml .= $this->convertFromArray( $v );
				$xml .= '</'.$n.'>';
							
			}
			else if( is_object( $v ) )
			{
				// if node name is changed by getValidatedElementName 
				// because being invalid use class name instead
				if( $n !== $k )
				{
					$n = get_class( $v );
				}
				
				$xml .= '<'.$n.'>';
				$xml .= $this->convertFromObject( $v );
				$xml .= '</'.$n.'>';
			}
			else
			{
				
				// if there is not value and $countEmptyValues is false 
				// continue to next element in array 
				if( strlen( $v ) < 1 && ! $this->_config->include_empty_values ) continue;
				
				//element is not array. compile it and add it to xml data
				$xml .= $this->compileElement( $v, $k );
				
			}
		}
		
		return $xml;
	}
	
	public function getValidatedElementName( $name  )
	{
		// check if name is vallid xml element name
		if( preg_match('/^[a-zA-Z_]+[0-9-]*$/i', $name ) )
		{
			return  $name;
			
		}// if element is not valid check to see if its only numeric
		else if( preg_match('/^\d+$/i', $name ) && $this->_config->preserve_numeric_names )
		{
			$name =  $this->_config->numeric_name_namespace . $name;
		}
		else
		{
			$name = $this->_config->default_name;
		}
		
		return  $name;
	}
	
	public function isValueValid( &$value )
	{
		if( is_string( $value ) && strlen( $value ) == 0 )
		{
			return true;
		}
		
		if( preg_match( '/<|&|<\!\[CDATA\[|\]\]>/i', $value ) === 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	/**
	 * @see IOutputBuilder::compileElement()
	 */
	public function compileElement( $value, $name  )
	{
		/**
		 * 
		 * XML element value cannot contain ]]>. If  value contain
		 * 
		 * < or & it will be wrapped inside cdata
		 * 
		 * XML node name cannot start with number
		 * 
		 */
		
		(string)$element = '<';
		
		$name = $this->getValidatedElementName( $name );
		
		
		// escape illegal characters
		$value = preg_replace( '/]]>/', ']]&gt;', $value );
		
		
		$element .= $name . '>';
		
		// check to se if cdata has to be used
		if( $this->isValueValid( $value ) !== true )
		{
			$element .= '<![CDATA[' . $value . ']]>';
		}
		else
		{
			$element .= $value;
		}
		
		$element .= '</' . $name . '>';
		
		return $element;
				
	}
}
?>