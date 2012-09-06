<?php

include_once "application/vos/ModelVos/ClientsVo.php";

class TestModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		
		echo "TestModel Loaded!<br>";
	}
	
	public function data()
	{
	   $a = array();
		
	   $q = $this->db->get( 'clients' );
	   
	   foreach ( $q->result( 'ClientsVo' ) as $row )
	   {
	      $a[] = $row;
	   }
	   
	   return $a;
	}
}

?>