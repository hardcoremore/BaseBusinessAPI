<?php

if( $_SERVER['HTTP_HOST'] != 'localhost' ) die();

require_once 'application/libraries/dataBuilders/xml/XMLBuilder.php';

class XmlBuilderTest extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();		
	}
	
	public function test()
	{
		
		
		$xb = new XMLBuilder();

		$data = array( 'ime' => 'Caslav&', 'prezime' => '<Sabani');
		$data['entries'] = array( 'vrednost1', 'vrednost2', 'vrednost3');
		$data['email'] = 'email@email.com';
		$data['assoc'] = array( 'level1' => 'v1', 
								'level12' => 'v2]]>', 
								array( 'level21' => 'v1', 
									   'level22' => 'v2', 
									   'level23' => 'v3', 
									   'level24' => 'v4'
								     )
						      );
						      
		header( 'Content-type: text/xml' );				      
		echo '<?xml version="1.0" encoding="UTF-8"?><response>';
		echo $xb->convertFromArray($data);
		echo '</response>';
	}
}


?>