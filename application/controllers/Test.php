<?php
// allow locally only
if( !( $_SERVER['HTTP_HOST'] == 'localhost' ||  $_SERVER['HTTP_HOST'] == '127.0.0.1' ) ) die();

require_once 'application/controllers/BaseController.php';

class Test extends BaseController
{
	public function __construct()
	{
		parent::__construct( $this );
		
		$this->loadModel( 'TestModel', 'tm', true, get_object_vars( ConfigFactory::DATABASE_CONFIG() ) );
	}
	
	public function XmlBuilderTest()
	{
		require_once 'application/libraries/dataBuilders/xml/XMLBuilder.php';
		
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
	
	public function CRUD_OperationsTest()
	{
		require_once 'application/libraries/CrudOperations.php';
		
		$oh = 0;
		
		CrudOperations::addOperation( $oh, CrudOperations::CREATE );
		CrudOperations::addOperation( $oh, CrudOperations::DELETE );
		//CrudOperations::addOperation( $oh, CrudOperations::READ );
		CrudOperations::addOperation( $oh, CrudOperations::UPDATE );
	
		CrudOperations::removeOperation( $oh, CrudOperations::READ );
		
		echo CrudOperations::isCreate( $oh ) . "<br>";
		echo CrudOperations::isRead( $oh ) . "<br>";
		echo CrudOperations::isUpdate( $oh ) . "<br>";
		echo CrudOperations::isDelete( $oh ) . "<br>";
		
		echo $oh;
	}
	
	public function testModel()
	{
		echo "<pre>";
		//print_r( $this->tm->data() );
		echo "</pre>";
	}
}


?>