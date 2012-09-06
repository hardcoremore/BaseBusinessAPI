<?php

require_once '../libraries/SpecificationFactory.php';

class SpecFactoryTest
{
	public function __construct()
	{
		
		$specFactory = SpecificationFactory::getInstance(); 
		
		print_r( $specFactory );
	}
}


$var = SpecificationFactory::PARTNERI_SPEC();

print_r( $var );

?>