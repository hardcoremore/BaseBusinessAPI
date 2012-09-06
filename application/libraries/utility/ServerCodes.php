<?php if ( ! defined('BASEPATH')) die();

class ServerOperationCodes
{
	// errors
	const GENERAL_ERROR 					= 100;
	const SERVER_FAILED 					= 1000;
	const SESSION_EXPIRED 					= 1500;
	const SESSION_ERROR 					= 1600;
	const INVALID_INPUT 					= 3000;
	const ALREADY_EXISTS 					= 3050;
	const AUTHENTICATION_REQUIRED 			= 3150;
	const USER_OR_PASS_WRONG 				= 3500;
	const ACCESS_DENIED 					= 3800;
	const APP_ERROR 						= 1200;
	const APP_PARTIALLY_INSTALL_ERROR 		= 4001;
	const DATABASE_ERROR 					= 1400;

	
	//info
	
	const NOT_FOUND = 5000;
	
	
	
}

?>