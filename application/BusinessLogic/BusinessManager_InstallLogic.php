<?php if ( ! defined('BASEPATH') ) die();

require_once 'system/application/libraries/BusinessLogicBase.php';
require_once 'system/application/Interfaces/BusinessLogic/IInstallLogic.php';
require_once 'system/application/libraries/ModuleCreator.php';

class BusinessManager_InstallLogic extends BusinessLogicBase implements IInstallLogic
{
	protected $_client_logic;
	
	protected $_module_creator;
	protected $_table;
	
	public function __construct()
	{
		parent::__construct();
	}

	public function init()
	{
		parent::init();
	}

	public function initTable()
	{
		$this->_table = $this->_table_factory->TABLE_UTIL_GATEWAY();
		
	}

	public function initSpecification()
	{
		
	}
	
	public function &install( InstallVo $install )
	{
		// check if application is already installed
		$installation = $this->checkInstallation(); 
		
		if( $installation  === TRUE )
		{
			$this->_data_holder->metadata()->setStatus( self::STATUS_OK );
			$this->_data_holder->metadata()->setErrorCode(0);
			$this->_data_holder->metadata()->setMessage( "Application already installed!" );
			
			return $this->_data_holder;
				
		}
		else if( $installation === FALSE )
		{
			$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
			$this->_data_holder->metadata()->setErrorCode( ErrorCodes::APP_PARTIALLY_INSTALL_ERROR);
			$this->_data_holder->metadata()->setMessage( "Application partially installed. Please check the status." );
			
			return $this->_data_holder;
		}
		else // free to install application
		{
			$client_available = false;
			$client_template = '';
			
			foreach( $install->modules as $m )
			{
				if( $m->name == 'CLIENTS' ) 
				{
					$client_available = true;
					$client_template  =& $m->template;
				}
			}
			
			
			if( ! $client_available )
			{
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( ErrorCodes::APP_ERROR );
				$this->_data_holder->metadata()->setMessage( "This install logic requires CLIENTS module!" );
				
				return $this->_data_holder;
			}
			
			// check input
			if( $install->post_key == $install->key && is_array( $install->modules ) && count( $install->modules ) > 0 )
			{

				$app_db = $this->_table->createDatabase( new DatabaseCreateVo( $this->_database_config->app_database_name ) );
				
				if( $app_db->status === BaseTableGateway::STATUS_OK )
				{
					
					$db = clone $this->_database_config;
					$db->database = $this->_database_config->app_database_name;
					
					
					$this->app_module_creator = new ModuleCreator( 
					
																	$install->module_install_path, 
																	$install->key, 
																	clone $this->_app_config, 
																	$db 
															     );
															   
					$installed =  array();
					$failed = array();
					$installed_tables = array();
					
					$client_modules = array();
					
					
					foreach( $install->modules as $m )
					{
						if( in_array( $m->name, $this->__app_modules ) )
						{
							$module = $this->app_module_creator->getInitializatorClass( $m->name, $m->template );
							$r = $module->create();
			
							if( $r !== TRUE )
							{
								array_push( $failed, $m );
							}
							else
							{
								$installed_tables[ $m->name ] = $module->getInstalledTables();
								$installed[ $m->name ] = $m->template; 
							}	
						}
						else 
						{
							array_push( $client_modules, $m );
						}	
					}	
					
					
					$this->_client_logic = $this->_logic_factory->CLIENTS_LOGIC( $client_template );
					
					$db = clone $this->_database_config;
					$db->database = $db->app_database_name;
					
					
					$this->_client_logic->overrideDatabaseConfig( $db );					
					$this->_client_logic->init();
					
					$client_result 			= $this->_client_logic->create( $client );
					
					$key = $client_result->data()->getRawData(); 
					$key = $key['key_id'];
					
					$client->key_id = $key;
					$client->modules = $client_modules;
					$client_modules_result 	= $this->_client_logic->saveclienTModules( $client, $install );
					
					$client_user_result = $this->_client_logic->createClientUser( new CreateClientUserVo( $key, $user ) );

					
					// build install log
					if( count( $failed ) == 0 )
					{
						$str = "<?php if( ! defined( 'BASEPATH' ) ) die();\n\n";
						$str .= '$installation_template = ' . '"'.$install->template .'";' ."\n";
						$str .= '$installation_time = ' . time() . ";\n";
						$str .= '$installed_modules = array();' . "\n\n";
						
						foreach( $installed as $k => $v )
						{
							$str .= '$installed_modules["'.$k.'"] = "'.$v.'";' . "\n\n";
						}
						
						
						$str .= '$installed_tables = array();' . "\n\n";
						
						foreach( $installed_tables as $k => $v )
						{
							$str .= '$installed_tables["'.$k.'"] = array(' . "\n\t";
						
							foreach( $v as $table )
							{
								 $str .= "\t\t\t\t\t\t\t\t" . '"'.$table.'",' . "\n";
							}
							
							$str = substr_replace( $str, '', -2 );
							
							$str .= ");\n";
						}
						
						$str .= "?>";
						
						
						// write install log
						if( File::write_file( 'INSTALLATION_LOG.php', $str ) == TRUE )
						{
							$this->_data_holder->metadata()->setStatus( self::STATUS_OK );
							$this->_data_holder->metadata()->setErrorCode( 0 );
							$this->_data_holder->metadata()->setMessage( 'Application Successfully installed!' );
						}
						else
						{
							$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
							$this->_data_holder->metadata()->setErrorCode( ErrorCodes::APP_ERROR );
							$this->_data_holder->metadata()->setMessage( 'Failed to write INSTALLATION_LOG file!' );
						}
						
					}
					else 
					{
						$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
						$this->_data_holder->metadata()->setErrorCode( ErrorCodes::DATABASE_ERROR );
						$this->_data_holder->metadata()->setMessage( 'Module creation failed. Number of failures: ' . count( $failed ) . '<br /> Failed modules: <pre>' . print_r( $failed,true) . '</pre>' );
						
					}
					
					
					if( $this->_data_holder->metadata()->getStatus() != self::STATUS_OK )
					{
						$this->_table->dropDatabase( $this->_database_config->app_database_name );
						$this->_table->dropDatabase( $install->key );
					}
				
				}
				else
				{
					$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
					$this->_data_holder->metadata()->setErrorCode( ErrorCodes::DATABASE_ERROR );
					$this->_data_holder->metadata()->setMessage( "Error creating database!");
				}
			}
			else
			{
				$this->_data_holder->metadata()->setStatus( self::STATUS_ERROR );
				$this->_data_holder->metadata()->setErrorCode( ErrorCodes::INVALID_INPUT );
				$this->_data_holder->metadata()->setMessage( "Error: Invalid Input! Please provide valid install key and select at least one module.");
				
			}
		}
		
		
		return $this->_data_holder;
		
	}
	
	public function &status()
	{
		
	}
	
	public function authenticateAdmin( AuthenticationVo $auth )
	{
		$data = array( 
						'username' => $auth->username, 
						'password' => $auth->password, 
						'key' => $auth->key
				);
				

		$params = array('http' => array( 'method' => 'POST', 'content' => $this->buildPostString( $data ) ) );
				
		$ctx = stream_context_create($params);
		$fp = @fopen( 'http://127.1.0.0/BiznisMenadzerOs/index.php/users/authenticate', 'rb', false, $ctx);
		$response = @stream_get_contents($fp);
		
		$xml = @simplexml_load_string( $response );
		
		if( $xml && $xml->metadata && $xml->metadata[0]->errorCode == 0 && $xml->metadata[0]->status == 'ok' )
		{
			$this->_ci->load->view( 'install_response', array( 'response' => $response, 'action'=>'http://localhost/BiznisMenadzerOs/index.php/install/authenticateAdmin') );
		}
		else
		{
			//$this->_ci->load->view( '' );
		}
	
	}
	
	
	protected function _checkInstallation()
	{
		$database_exists = $this->_table->checkDatabaseExists( $this->_database_config->app_database_name );
		
		if( $database_exists->status === self::STATUS_OK )
		{
			//$tables = $this->_table->getTables()->result;
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}

}
?>