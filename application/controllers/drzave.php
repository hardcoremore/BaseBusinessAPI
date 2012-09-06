<?php
include_once('base.php');

class Drzave extends Base 
{

	function Drzave()
	{
		parent::Base();	
	}
	
	public function read()
	{
		 $query = $this->db->query( "SELECT id, naziv FROM drzave" );
 		 echo arrayToXml($query->result_array());								
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */