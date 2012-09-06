<?php

class CrudOperations
{
	const CREATE	= 1;
	const READ		= 2;
	const UPDATE	= 4;
	const DELETE	= 8;
	
	public static function isCreate( $o )
	{
		return $o & self::CREATE != 0;
	}
	
	public static function isRead( $o )
	{
		return $o & self::READ != 0;
	}
	
	public static function isUpdate( $o )
	{
		return $o & self::UPDATE != 0;
	}
	
	public static function isDelete( $o )
	{
		return $o & self::DELETE != 0;
	}
	
	
	/**
	 * 
	 * Adds operation to operation holder
	 * 
	 * @param $operation holder int
	 * @param $operation code int
	 * 
	 * @return int
	 *
	 **/
	public static function addOperation( &$o, $opcode )
	{
		if( self::isOperationValid( $opcode ) )
		{
			return $o |= $opcode;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 
	 * Removes operation from operation holder
	 * 
	 * @param $operation holder int
	 * @param $operation code int
	 * 
	 * @return int
	 *
	 **/
	public static function removeOperation( &$o, $opcode )
	{
		if( self::isOperationValid( $opcode ) )
		{
			//inverse operation that is being added
			$opcode = $opcode XOR 15;
			
			return $o &= $opcode;
		}
		else
		{
			return false;
		}
	}
	
	public static function isOperationValid( $o )
	{
		return $o == self::CREATE || $o == self::READ || $o == self::UPDATE || $o == self::DELETE;
	}
}
?>