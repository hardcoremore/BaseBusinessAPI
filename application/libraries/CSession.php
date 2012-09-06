<?php defined('BASEPATH') or die('DirectScriptAccessDenied');

require_once 'application/vos/SessionVo.php';
require_once 'application/Interfaces/IDispatcher.php';
require_once 'application/libraries/Event/EventDispatcher.php';

class CSession implements IDispatcher
{
	const STATE_ACTIVE			= 'active';
	const STATE_EXPIRED			= 'expired';
	const STATE_EXTENDING		= 'extending';
	const STATE_RESTARTING		= 'restarting';
	CONST STATE_ERROR			= 'error';
	const STATE_DESTROYED 		= 'destroyed';
	
	const SECURITY_FIXED_ADDRESS	 = 'fixed_address';
	const SECURITY_FIXED_BROWSER	 = 'fixed_browser';
	const SECURITY_FORSE_SSL		 = 'forse_ssl';
	
	
	/**
	 * CSession class instance
	 *
	 * @access private
	 * @var	CSession
	 */
	 private static $_instance = NULL;
	 
	 
	 /**
	 * CSession SessionVo config object
	 *
	 * @access private
	 * @var	CSession
	 */
	 private $__config = NULL;
	 
	  /**
	 * Expiration of session
	 *
	 * @access private
	 * @var	string $__isNew if user is first time. if session is created with __createSessionId()
	 * 	insead of passing already created id
	 * @see isNew()
	 */
	 private $__isNew;
	 
	 
	 /**
	 * Expiration of session
	 *
	 * @access private
	 * @var	string $__expire lifetime of unused session in minutes
	 * @see getExpire()
	 */
	 private $__expire;
	 
	 
	/**
	 * internal state
	 *
	 * @access protected
	 * @var	string $_state one of 'active'|'expired'|'destroyed|'error'
	 * @see getState()
	 */
	private $_state 	= '';

	/**
	 * Error Message
	 *
	 * @access private
	 * @var	string $__errorMessage error message of session object
	 * @see getErrorMessage()
	 */
	private $__errorMessage 	= '';

	/**
	* security policy
	*
	* Default values:
	*  - fix_browser
	*  - fix_adress
	*
	* @access private
	* @var array $_security list of checks that will be done.
	*/
	private $__security = array();

	/**
	 * event dispatcher
	 *
	 * @access private
	 * 
	 **/
	private $__dispatcher;
	
	/**
	* Force cookies to be SSL only
	*
	* @access private
	* @default false
	* @var bool $force_ssl
	*/
	private $__force_ssl = false;

	
	/**
	* Constructor
	*
	* @access private
	* 
	*/
	private function __construct()
	{
		//set default sessios save handler
		ini_set('session.save_handler', 'files');

		//disable transparent sid support
		ini_set('session.use_trans_sid', '0');
		
		$this->__dispatcher = new EventDispather( $this );
	}
	
	public function dispatcher()
	{
		return $this->__dispatcher;
	}
	
	/**
	* Start a session
	*
	* Creates a session (or resumes the current one based on the state of the session)
 	*
 	* @param $config Config to start the session with
 	* 
	* @access public
	* @return boolean true on success false on failure
	*/
	public function start( SessionVo $config )
	{
		// session is already started return false
		if( $this->getState() == self::STATE_ACTIVE )
			return false;
		
		
		// set config
		if( $config )
		{
			$this->__config = $config;
		}
		else
		{
			$this->__errorMessage = '$this->__config invalid at CSession::start()';
			log_message( 'error', $this->__errorMessage );
			return FALSE;
		}
		
		// unset any previous sessions
		if( strlen( $this->__config->id ) > 10 && session_id() != '' )
		{
			session_unset();
			session_destroy();
		}
			
		//set options
		$this->__setOptions();
		
		
		/********initialise the session**********/
		
			session_cache_limiter('none');
			@session_start();
			
		/******************************************/

		// perform security checks
		if( $this->__validate() === TRUE )
		{
			$this->_state =	self::STATE_ACTIVE;
		}
		else
		{
			$this->__errorMessage = 'Session security failed at CSession::start()';
			log_message( 'error', $this->__errorMessage );
			return FALSE;
		}
		
		// check if this is a new session
		if( $this->has( 'session', 'timer.start' ) || $this->has( 'session', 'timer.last' ) )
		{
			$this->__isNew = FALSE;
		}
		else
		{
			$this->__isNew = TRUE;
		}
		
		
		$this->_setTimers();
		$this->_setCounter();
		
		return TRUE;
	}

	public function config()
	{
		return $this->__config;
	}
	
	/**
	 * Set counter of session usage
	 *
	 * @access protected
	 * @return true on succsess false on failure
	 **/
	protected function _setCounter()
	{
		if( $this->getState() != self::STATE_ACTIVE )
			return FALSE;
		
		$c;
		
		if( ! $this->has( 'session' , 'counter' ) )
		{
			$c = 0;
		}
		else
		{
			$c = $this->get( 'session', 'counter' );
			++$c;
		}
		
		$this->set( 'session', 'counter', $c );
		return TRUE;
	}

	/**
	* Set the session timers
	*
	* @access protected
	* @return boolean $result true on success
	*/
	protected function _setTimers()
	{
		$start	= time();
		
		if( ! $this->has( 'session', 'timer.start' ) )
		{
			$this->set( 'session', 'timer.start', $start );
		}

		$this->set( 'session', 'timer.last', $start );
	}
	
	/**
	 * Check is session is expired
	 *
	 * @access public
	 * @return Boolean If is expired returns true else returns false
	 */
	public function isExpired()
	{
		// if $this->__expire is not set session never expires and 
		// function always returns false
		
		if( $this->__expire > 0 )
		{
			$curTime =	time();
			$maxTime =	$this->get( 'session', 'timer.last') +  ( $this->__expire * 60 );
			
			// empty session variables
			if( $maxTime < $curTime ) 
			{
				$this->_state =	self::STATE_EXPIRED;
				return TRUE;
			}
		}
		
		return FALSE;
		
	}
	
	/**
	* Check whether this session is currently created
	*
	* @access public
	* @return boolean $result true on success
	*/
	public function isNew()
	{
		return $this->__isNew;
	}
	
	/**
	 * Get error message of session
	 *
	 * @access public
	 * @return string The session errorMessage
	 */
	public function getErrorMessage()
	{
		return $this->__errorMessage;
	}
	
    /**
	 * Session object destructor
	 *
	 * @access private
	 * 
	 **/
	 function __destruct() 
	 {
		$this->close();
	 }

	/**
	 * Returns a reference to the global CSession object, only creating it
	 * if it doesn't already exist.
	 *
	 * This method must be invoked as:
	 * 		<pre>  $session = &CSession::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JSession	The Session object.
	 * @since	1.5
	 */
	public static function &getInstance()
	{
	    if(!CSession::$_instance)
		{
			CSession::$_instance = new CSession();
		}
		
		return CSession::$_instance;		
	}

	/**
	 * Get current state of session
	 *
	 * @access public
	 * @return string The session state
	 */
    public function getState() 
	{
		return $this->_state;
	}

	/**
	 * Get expiration time in minutes
	 *
	 * @access public
	 * @return integer The session expiration time in minutes
	 */
    public function getExpire() 
	{
		return $this->__expire;
    }

	/**
	 * Get a session token, if a token isn't set yet one will be generated.
	 *
	 * Tokens are used to secure forms from spamming attacks. Once a token
	 * has been generated the system will check the post request to see if
	 * it is present, if not it will invalidate the session.
	 *
	 * @param boolean $forceNew If true, force a new token to be generated
	 * @access public
	 * @return string The session token
	 */
	public function getToken( $forceNew = false )
	{
		$token = $this->get( 'session', 'token' );

		//create a token
		if( $token === null || $forceNew ) 
		{
			$token	=	$this->_createToken( 12 );
			$this->set( 'session', 'token', $token );
		}

		return $token;
	}

	/**
	 * Method to determine if a token exists in the session. If not the
	 * session will be set to expired
	 *
	 * @param	string	Hashed token to be verified
	 * @param	boolean	If true, expires the session
	 * @since	1.5
	 * @static
	 */
	function hasToken($tCheck, $forceExpire = true)
	{
		// check if a token exists in the session
		$tStored = $this->get( 'session', 'token' );

		//check token
		if(($tStored !== $tCheck))
		{
			if($forceExpire) 
			{
				$this->_state = self::STATE_EXPIRED;
			}
			return false;
		}

		return true;
	}

	/**
	 * Get session name
	 *
	 * @access public
	 * @return string The session name
	 */
	public function getName()
	{
		if( $this->_state === self::STATE_DESTROYED ) 
		{
			return NULL;
		}
		return session_name();
	}

	/**
	 * Get session id
	 *
	 * @access public
	 * @return string The session name
	 */
	public function getId()
	{
		if( $this->_state === self::STATE_DESTROYED ) 
		{
			return NULL;
		}
		return session_id();
	}


	 /**
	 * Get data from the session store
	 *
	 * @static
	 * @access public
	 * @param  string $name			Name of a variable
	 * @param  mixed  $default 		Default value of a variable if not set
	 * @param  string 	$namespace 	Namespace to use, default to 'default'
	 * @return mixed  Value of a variable
	 */
	public function get($namespace, $name, $default = NULL)
	{
		
		$namespace = '__' . $namespace;
		
		if( $this->_state !== self::STATE_ACTIVE ) 
		{
			if(  !$this->_state == self::STATE_EXTENDING || $name != 'timer.last' )
			{
				return;
			}
		}
		
		if($name === "%")
		{
			if ( isset($_SESSION[$namespace]) ) 
			{
				return $_SESSION[$namespace];
			}
			
		}else{
			
			if (isset($_SESSION[$namespace][$name])) 
			{
				return $_SESSION[$namespace][$name];
			}
		}
		
		return $default;
	}

	/**
	 * Set data into the session store
	 *
	 * @access public
	 * @param  string $name  		Name of a variable
	 * @param  mixed  $value 		Value of a variable
	 * @param  string 	$namespace 	Namespace to use, default to 'default'
	 * @return mixed  Old value of a variable
	 */
	public	function set($namespace, $name, $value)
	{
		
		$namespace = '__' . $namespace;
		
		if( $this->_state !== self::STATE_ACTIVE )
		{
			if(  !$this->_state == self::STATE_EXTENDING || $name != 'timer.last' )
			{
				return;
			}
		}
		
		
		$old = isset( $_SESSION[$namespace][$name] ) ?  $_SESSION[$namespace][$name] : null;
		
		if ( $value === NULL ) 
		{
			unset( $_SESSION[$namespace][$name] );
			
		}
		else
		{
			
			$_SESSION[$namespace][$name] = $value;
		}
		
		return $old;
	}

	/**
	* Check wheter data exists in the session store
	*
	* @access public
	* @param string 	$name 		Name of variable
	* @param  string 	$namespace 	Namespace to use, default to 'default'
	* @return boolean $result true if the variable exists
	**/
	public function has( $namespace, $name )
	{
		$namespace = '__' . $namespace;
		
		if( $this->_state !== self::STATE_ACTIVE ) 
		{
			return;
		}

		if($name === "%")
		{
			return isset( $_SESSION[$namespace] );
		}
		else
		{
			return isset( $_SESSION[$namespace][$name] );			
		}
	}

	/**
	* Unset data from the session store
	*
	* @access public
	* @param  string 	$name 		Name of variable
	* @param  string 	$namespace 	Namespace to use, default to 'default'
	*/
	
	public	function clear( $namespace, $name )
	{
		$namespace = '__' . $namespace;
		if( $this->_state !== self::STATE_ACTIVE )
		{
			return;
		}
		
		if($name === '%')
		{
			if( isset( $_SESSION[$namespace] ) ) 
			{
				unset( $_SESSION[$namespace] );
			}
		}
		else
		{
			if( isset( $_SESSION[$namespace][$name] ) ) 
			{
				unset( $_SESSION[$namespace][$name] );
			}
		}
	}

	/**
	 * Frees all session variables and destroys all data registered to a session
	 *
	 * This method resets the $_SESSION variable and destroys all of the data associated
	 * with the current session in its storage (file or DB). It forces new session to be
	 * started after this method is called. It does not unset the session cookie.
	 *
	 * @static
	 * @access public
	 * @return void
	 * @see	session_unset()
	 * @see	session_destroy()
	 */
	public function destroy()
	{
		// if session was already destroyed
		if( $this->_state === self::STATE_DESTROYED ) 
		{
			return TRUE;
		}

		// In order to kill the session altogether, like to log the user out, the session id
		// must also be unset. If a cookie is used to propagate the session id (default behavior),
		// then the session cookie must be deleted.
		if ( isset( $_COOKIE[ session_name() ] ) ) 
		{
			setcookie( session_name(), '', time() - 42000, '/' );
		}

		session_unset();
		session_destroy();

		$this->__config = NULL;
		$this->_state = self::STATE_DESTROYED;
		
		log_message('debug', 'Session destroyed at CSession::destroy()');
		return TRUE;
	}

	/**
    * restart an expired or locked session
	*
	* @access public
	* @return boolean $result true on success
	* @see destroy
	**/
	public function extend()
	{
		if( $this->__validate() )
		{	
			$this->_state	= self::STATE_EXTENDING;
			log_message( 'info', 'Session extending at CSession::extend()');
			$this->_setTimers();
			$this->_state	= self::STATE_ACTIVE;
		}
	}

	public static function encodeName( $n )
	{
		return md5( md5( $n ) );
	}
	
	 /**
	 * Writes session data and ends session
	 *
	 * Session data is usually stored after your script terminated without the need
	 * to call CSession::close(),but as session data is locked to prevent concurrent
	 * writes only one script may operate on a session at any time. When using
	 * framesets together with sessions you will experience the frames loading one
	 * by one due to this locking. You can reduce the time needed to load all the
	 * frames by ending the session as soon as all changes to session variables are
	 * done.
	 *
	 * @access public
	 * @see	session_write_close()
	 */
	public function close() 
	{
		session_write_close();
	}


	 /**
	 * Set session cookie parameters
	 *
	 * @access private
	 */
	private function __setCookieParams() 
	{
		$cookie	=	session_get_cookie_params();
		if($this->__force_ssl) 
		{
			$cookie['secure'] = true;
		}
		session_set_cookie_params( $this->getExpire() * 60, $cookie['path'], $cookie['domain'], $cookie['secure'] );
	}

	/**
	* Create a token-string
	*
	* @access protected
	* @param int $length lenght of string
	* @return string $id generated token
	*/
	protected function _createToken( $length = 32 )
	{
		static $chars	=	'0123456789abcdef';
		$max			=	strlen( $chars ) - 1;
		$token			=	'';
		$name 			=  session_name();
		for( $i = 0; $i < $length; ++$i ) 
		{
			$token .=	$chars[ (rand( 0, $max )) ];
		}

		return md5($token.$name);
	}

	

	/**
	* set additional session options
	*
	* @access private
	* @param array $options list of parameter
	* @return boolean $result true on success
	*/
	private function __setOptions()
	{
		
		// set name
		if( $this->__config->name ) 
		{
			session_name( self::encodeName( $this->__config->name ) );
		}

		log_message( "debug", "sess id: " . $this->__config->id );
		// set id
		if( $this->__config->id && $this->__config->id != null && $this->__config->id != 'null' && strlen( $this->__config->id ) > 0 ) 
		{	
			log_message( "debug", "SESSION IS SET. Id: " . $this->__config->id );
			session_id( $this->__config->id );
		}
		else
		{
			$this->__config->id = $this->__createSessionId(); 
			log_message( "debug", "SESSION IS NOT SET. Generated ID: " . $this->__config->id );
			session_id( $this->__config->id );
		}
		
		

		// set expire time
		if( $this->__config->expire ) 
		{
			$this->__expire = $this->__config->expire;
		}

		// get security options
		if( $this->__config->fix_browser )
		{
			array_push( $this->__security, self::SECURITY_FIXED_BROWSER );
		}
		
		if( $this->__config->fix_address )
		{
			array_push( $this->__security, self::SECURITY_FIXED_ADDRESS );
		}
		
		if( $this->__config->force_ssl )
		{
			array_push( $this->__security, self::SECURITY_FORSE_SSL );
		}
		
		
		//sync the session maxlifetime
		ini_set('session.gc_maxlifetime', $this->__expire);

		return true;
	}
	
	/**
	 * Create a  unique session id
	 *
	 * @static
	 * @access private
	 * @return string Session ID
	 */
	private function &__createSessionId()
	{
		//ce1e288142-02a84c-8fb7ae-3140c8-34ab500c40af3b
		
		(string) $stringId = '';
		
		(int) $c = 0;
		for( (int) $i = 0; $i < 5; $i ++ )
		{
			
			$r = mt_rand( -99, 99 );
			$r2 = mt_rand( 0, 99 );
			$r3 = mt_rand( -1, 1);
			
			$id = md5( md5( microtime() . md5( substr( 'weerwre4321896754zxcvzxcvkkh<>?jkghjvxf/,.,/.?><!@#$%^&_)(*klhkjghfgrutyurty234565766&^%$!@#~```~~..', $r, $r2  ) ) ) );
			$id .= $id;
			
			if( $r3 ) 
			{
				$id .= $id;
			}
			else
			{
				$id = substr( $id, strlen($id) / 2 );
			}
			
			(string) $tmpS = '';
			
			switch( $i )
			{
				case 0:
					$c = 10;
					usleep( 1000 );
					break;
					
				case 1:
					$c = 6;
					usleep( 1500 );
					break;
					
				case 2:
					$c = 6;
					usleep( 2000 );
					break;
					
				case 3:
					$c = 6;
					usleep( 2500 );	
					break;
					
				case 4:
					$c = 14;
					usleep( 3000 );
					break;
			}
			
			while( strlen( $tmpS ) < $c )
			{
				$tmpS .= substr( $id, mt_rand( 0, strlen( $id ) ), 1 );
			}
			
			$stringId .= $tmpS . '-';
			$c ++;
		}
		
		$stringId = substr_replace( $stringId, '', -1 );
		
		return $stringId;
	}
	
	/**
	* Do some checks for security reason
	*
	* - timeout check (expire)
	* - ip-fixiation
	* - browser-fixiation
	*
	* If one check failed, session data has to be cleaned.
	*
	* @access private
	* @param boolean $restart reactivate session
	* @return boolean $result true on success
	* @see http://shiflett.org/articles/the-truth-about-sessions
	*/
	private function __validate()
	{
		
		// record proxy forwarded for in the session in case we need it later
		if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) 
		{
			$this->set( 'session', 'client.forwarded', $_SERVER['HTTP_X_FORWARDED_FOR']);
		}

		// check for client adress
		if( in_array( self::SECURITY_FIXED_ADDRESS, $this->__security ) && isset( $_SERVER['REMOTE_ADDR'] ) )
		{
			$ip	= $this->get( 'session', 'client.address');

			if( $ip === NULL ) 
			{
				$this->set( 'session', 'client.address', $_SERVER['REMOTE_ADDR'] );
			}
			else if( $_SERVER['REMOTE_ADDR'] !== $ip )
			{
				$this->_state = self::STATE_ERROR;
				$this->__errorMessage = 'REMOTE_ADDRESS invalid at CSession::__validate()';
				log_message( 'error', $this->__errorMessage );
				
				return FALSE;
			}
		}

		// check for clients browser
		if( in_array( self::SECURITY_FIXED_BROWSER, $this->__security ) && isset( $_SERVER['HTTP_USER_AGENT'] ) )
		{
			$browser = $this->get( 'session', 'client.browser' );

			if( $browser === NULL ) 
			{
				$this->set( 'session', 'client.browser', $_SERVER['HTTP_USER_AGENT']);
			}
			else if( $_SERVER['HTTP_USER_AGENT'] !== $browser )
			{
				$this->_state = self::STATE_ERROR;
				$this->__errorMessage = 'HTTP_USER_AGENT invalid at CSession::__validate()';
				log_message( 'error', $this->__errorMessage );
				
			    return FALSE;
			}
		}

		return TRUE;
	}

}
?>