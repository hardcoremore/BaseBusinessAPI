<?php

class SessionVo
{
	/*
	 * String
	 * 
	 *  Session id name. Key of the session id value.
	 */
	public $session_id_name;
	
	/*
	 * String
	 * 
	 *  Session extend name. Key of the session extend value.
	 */
	public $extend_session;
	
	/*
	 * String
	 * 
	 *  Session id
	 */
	public $id;
	
	
	/*
	 * String
	 * 
	 *  Session name
	 */
	public $name;
	
	
	/*
	 * int
	 * 
	 * Time for lifetime of unused session in minutes
	 */
	public $expire;
	
	
	/*
	 * Boolean 
	 */
	public $force_ssl;
	
	/*
	 * Boolean 
	 */
	public $fix_browser;
	
	/*
	 * Boolean 
	 */
	public $fix_address;
	
	
}
?>