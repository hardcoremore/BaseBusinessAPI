<?php if ( !defined('BASEPATH')) die();

require_once 'system/application/controllers/authentication.php';


class AuthenticationControllerMock extends Controller
{	
	public $controller;
	
	public function AuthenticationControllerMock()
	{
		parent::Controller();
		
		$this->controller = new Authentication();
	}
	
	
	function authenticate( $outputResult = TRUE )
	{	
		$authVo = new AuthenticationVo( 
											'44d7db2d-2656-102e-acf7-3c78a6d744cd',
											'chaky',  
											'chaky123',
											'english'
									   );

		
		$r = $this->controller->authenticate( $authVo, TRUE );
		
		if( $outputResult )
		{
		
			echo 'AuthenticationControllerMock::authenticate()<br />';

		
		
			echo 'Status: ' . $r->metadata()->getStatus() . '<br />';
			
			echo 'ErrorCode: ' . $r->metadata()->getErrorCode() . '<br />';
			
			echo 'Result: <br />';
			
			echo '<pre>';
			print_r($r);
			echo '</pre>';
			
		}	
									   
				
	}

	function loadUser()
	{
		
		$this->authenticate( false );
		
		echo 'AuthenticationControllerMock::loadUser()<br />';

		$r = $this->controller->loadUser( 1, TRUE );
		
		echo 'Status: ' . $r->metadata()->getStatus() . '<br />';
		
		echo 'ErrorCode: ' . $r->metadata()->getErrorCode() . '<br />';
		
		echo 'Result: <br />';
		
		echo '<pre>';
		print_r($r);
		echo '</pre>';
		
		
	}
	
	public function checkLogin()
	{
		$authVo = new AuthenticationVo( 
											'44d7db2d-2656-102e-acf7-3c78a6d744cd',
											'chaky',  
											'chaky123',
											'english'
									   );
	
									   
		$r = $this->controller->authenticate( clone $authVo, TRUE );
		
									   
		$r = $this->controller->checkLogin( clone $authVo, TRUE );
		
		echo 'Status: ' . $r->metadata()->getStatus() . '<br />';
		
		echo 'ErrorCode: ' . $r->metadata()->getErrorCode() . '<br />';
		
		echo 'Result: <br />';
		
		echo '<pre>';
		print_r($r);
		echo '</pre>';
		
	}
	
	public function logout() 
	{
		
	}
	
} 

/* End of file authentication.php */
/* Location: ./system/application/controllers/authentication.php */