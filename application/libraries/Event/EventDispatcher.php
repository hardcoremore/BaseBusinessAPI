<?php

class EventDispather
{
	private $__listeners;
	private $__target;
	
	public function __construct( $target )
	{
		$this->__listeners = array();
		$this->__target = $target;
	}
	
	public function addEventListener( $type, $function )
	{
		try {
			
			$rl = $this->__listeners[ $type ];
			
			if( $rl )
			{
				if( is_array( $rl ) )
				{
					if( ! in_array( $function, $this->__listeners, true ) )
					{
						array_push( $rl, $function );
						
						$this->__listeners[ $type ] = $rl;
					}
				}
				else if( $rl !== $function )
				{
					$this->__listeners[ $type ] = array( $rl, $function);
				}
			}
		}
		catch( ErrorException $e )
		{
			
		}
		
		
	}

	public function removeAllListeners()
	{
		foreach ( $this->__listeners as $k => $v )
		{
			$this->removeEventListener( $k, $v );
		}
	}
	
	public function dispatchEvent( Event $event )
	{
		if( $event )
		{
			
			$event->setTarget( $this->__target );
			
			foreach( $this->__listeners as $k => $v )
			{
				if( $event->type() === $k )
				{
					try
					{
						$rl = $this->__listeners[ $k ];
						
						if( $rl )
						{
							if( is_array( $rl ) )
							{
								foreach( $rl as $f )
								{
									call_user_func( $f, $event );
								}
							}
							else
							{
								call_user_func( $v, $event );
							}
						}
						
					}
					catch( ErrorException $e )
					{
						
					}
				}
			}
		}
		
	}

	public function hasEventListener( $type )
	{
		return array_key_exists( $type, $this->__listeners );
	}
	
	public function removeEventListener( $type, $function )
	{
		try {

			$this->__listeners[ $type ] = null;
		}
		catch( ErrorException $e )
		{
			
		}
		
	}
	
	public function __destruct()
	{
		$this->__listeners = null;
	}
}

?>