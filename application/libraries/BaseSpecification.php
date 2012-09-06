<?php if ( ! defined('BASEPATH')) die();

class BaseSpecification
{
	public function uuid( $uuid )
	{
		$kp = preg_match( '/^[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}$/i', $uuid );
		
		if( $kp  )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function email( $e )
	{
		$ep = preg_match( '/^[a-zA-Z0-9._%+-]+@([A-Z0-9-]+)+\.[a-zA-Z]{2,6}$/i', $e );
		
		if( $ep  )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function image( $i )
	{
	  $ip = preg_match( '/^[a-zA-Z0-9-_.]+\.(jpg|gif|png)$/i', $i );
		
		if( $ip  )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function digitOnly( $digit )
	{
		return preg_match( '/\d+/i', $digit );
	}
	
	public function primaryKeyAutoIncrement( $key )
	{
		return $this->digitOnly( $key ) && $key > 0;
	}
	
	public function baseAlphaNumericName( $name )
	{
		return preg_match( '/^[a-zA-z_]+[0-9]*$/i', $name );
	}
}

?>