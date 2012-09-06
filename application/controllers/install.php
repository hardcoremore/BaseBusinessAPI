<?php if ( !defined('BASEPATH')) die();

require_once 'system/application/controllers/base.php';
require_once 'system/application/libraries/CSession.php';
require_once 'system/application/vos/InstallConfigVo.php';
require_once 'system/application/vos/ControllersVos/AuthenticationVo.php';
require_once 'system/application/vos/UserVo.php';
require_once 'system/application/BusinessLogic/default/InstallLogic.php';
require_once 'system/application/libraries/File.php';
require_once 'system/application/vos/ModuleVo.php';

class Install extends Base 
{	

	protected $_session;
	
	protected $_logic;
	
	protected $_auth_url;
	
	protected $_install_config;
	
	protected $_auth_message;
	
	protected $_authenticated = FALSE;
	
	protected $_install_menu_view_data;
	
	const INSTALL_MODULES_POST_NAME = '_INSTALL_MODULES_';
	
	
	const __SESS_USERNAME 		= 'INSTALL_AUTH_USERNAME';
	const __SESS_ADMIN_KEY 		= 'INSTALL_AUTH_KEY';
	
	public function Install()
	{
		parent::Base();
		
		
		$this->_install_config = ConfigFactory::INSTALLATION_CONFIG();
		
		$this->_logic = $this->_logic_factory->INSTALL_LOGIC( $this->_install_config->template );
		$this->_logic->init();
		
		
		$this->_install_menu_view_data = array();
		$links = array();
		
		$links[] = array( 'link' => $this->_config->controller_root_uri . 'install/appStatus/',
							'name' => 'Application Status'
					   );
	
					   
		if( ! $this->_logic->isInstalled() )
		{
			$links[] = array( 'link' => $this->_config->controller_root_uri . 'install/installApp/',
							   'name' => 'Install Application'
							);
		}

	
		$this->_install_menu_view_data['links'] = $links;
	}
	
	public function index()
	{
		$view = $this->load->view( 'install_menu', $this->_install_menu_view_data );
	}
	
	public function installApp( InstallConfigVo $install = NULL, $return = FALSE )
	{	
		$this->_logic->init();		
		
		if( $install == NULL )
		{
				$install = ConfigFactory::INSTALLATION_CONFIG();
		}
			
		if( $this->input->post( 'install' ) == 'Install Application' )
		{
			
			$install->post_key = $this->input->post( 'install_key' );
//			
//			// parse array from post
//			$post_modules =& $this->postArrayParser();
//			
//			
//			//get modules from post
//			if( is_array( $post_modules ) && count( $post_modules ) > 0 )
//				$post_modules =  $post_modules[ self::INSTALL_MODULES_POST_NAME ];
//			
//			$modules = array();
//			foreach( $post_modules as $v )
//			{
//				$m = new ModuleVo();
//				$m->template 	= $v["template"];
//				$m->name 		= $v["name"];
//				$m->action		= $v["action"];
//				$m->active		= true;
//				$modules[] 		= $m;
//			}
//			
//			$install->modules = $modules;
//			
//			
//			if( $client == NULL )
//			{
//				$client = new ClientsVo();
//				$client->admin_key = $this->_session->get( $this->_config->name, InstallLogic::__SESS_ADMIN_KEY ); 
//				$client->name  = 'SUPER ADMINISTRATOR';
//				$client->email =  'client@email.com';
//				$client->note  = 'This is the first client that is created upon application installation and it serves to administer all other clients. DO NOT DELETE THIS CLIENT!';
//			}
//			
//			if( ! $user )
//			{
//					$user = new UserVo();
//					$user->acg 			= 1;
//					$user->email 		= $this->input->post('email');
//					$user->gender		= $this->input->post('gender');
//					$user->last_name 	= $this->input->post('last_name');
//					$user->name 		= $this->input->post('name');
//					$user->password 	= $this->input->post('password');
//					$user->username 	= $this->input->post('username');
//					
//					$user->user_type 	= 'SuperAdministrator';
//					$user->gender 		= 'm';
//					$user->acg			= 1;
//			}
//			
//			

			
			$r = $this->_logic->install( $install );
		
			if( $return == TRUE )
			{
				return $r;
			}
			else
			{		
				if( $r->metadata()->getStatus() == BusinessLogicBase::STATUS_OK )
				{
				
					$this->load->view( 'install_status', array( 'install_data' => $r ) );	
				}
				else
				{
					//$data = array$this->_getInstallViewData( $install );
					//$data["error"] = $r->metadata()->getMessage();
					
					//$this->load->view('install_application', $data );
				}	
			}
		}
		else
		{
			$this->load->view('install_application' );
		}		
	}
	
	public function appStatus( $return = FALSE )
	{
		$r = $this->_logic->status();
		
		if( $return === TRUE )
		{
			return $r;
		}
		else 
		{
			$this->load->view('install_status', array( 'data' => $r ));
			return 0;
		}
	}
	
	protected function _getInstallViewData( InstallConfigVo $install )
	{
		
			// read InstallModules directory to collect available modules for installation
		    $dirs = File::read_dir( $install->module_install_path, false, true );
			
			$modules = array();
			
			foreach( $dirs as $k => $logic )
			{
				if( ! is_array( $logic ) )
					continue;
	
				// loop through available database drivers for installing modules	
				foreach( $logic as $k2 => $driver )
				{
					$a = array();
					
					// select the database driver for which we are installing application
					if( is_array( $driver ) && $driver[File::FOLDER_INFO_INDEX]->name == ConfigFactory::DATABASE_CONFIG()->dbdriver )
					{
						foreach( $driver as $k3 => $module )
						{
							if( $module->type == File::TYPE_FILE )
							{
								$a[] = $module->name;
							}	
						}   
					}
					
					$modules[ $logic[File::FOLDER_INFO_INDEX]->name ] = $a;
				}
			}
			
			$available_modules = array();
			
			// parse modules array to form names
			foreach( $modules as $k => $v )
			{
				$m_files;
				
				foreach ( $v as $m_file )
				{	
					if( $k != 'default' )
					{
						$module_name = substr( $m_file, strlen( $k ) + 1, strlen('_creationInitialization' . EXT ) * -1 );
					}
					else
					{
						$module_name = substr( $m_file,0, strlen('_creationInitialization' . EXT ) * -1 );
					}
					
					if( array_key_exists( $module_name, $available_modules ) )
					{
						array_push( $available_modules[ $module_name ], $k );
					}
					else
					{
						$available_modules[ $module_name ] = array( $k );
					}
					
				}
			}
		
			$data = array( 
							'post_array_delimiter' => $this->_config->post_array_delimiter,
							'module_post_name'     => self::INSTALL_MODULES_POST_NAME
						 );
			
			if( $available_modules )
			{
				$data['modules'] = $available_modules;
			}
			
			$data['action']	= $this->_config->domain . $this->_config->app_root_folder . 'index.php/install/installApp/';
			
			
			return $data;
	}
} 

/* End of file install.php */
/* Location: ./system/application/controllers/install.php */