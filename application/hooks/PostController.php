<?php

class PostController
{
	public function init()
	{
		// send the session id to the client only if the session is new
		// and id is generated
		if( $this->_session->isNew() && $this->_session->getId() )
		{
			//echo "session is new. session id: " . $this->_session->getId();
			return;
			
			
			$m = $this->_data_holder->metadata()->getRawMetadata();
			$m[ $this->_session->config()->session_id_name ] = $this->_session->getId();
			$this->_data_holder->metadata()->setData( $m );
		}
		
		
	}
}
		
?>