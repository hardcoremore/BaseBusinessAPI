<?php if ( ! defined('BASEPATH')) die();

require_once 'application/vos/DatabaseConfigVo.php';
require_once 'application/vos/ApplicationConfigVo.php';
require_once 'application/libraries/BusinessLogicBase.php';
require_once 'application/vos/SessionVo.php';
require_once 'application/vos/OutputBuilderVo.php';
require_once 'application/vos/InstallConfigVo.php';

class ConfigFactory
{	
	const CONFIG_SESSION_NAME = '_CONFIG_SESSION_NAMESPACE_';
	const SESS_DATABASE_KEY_NAME   =  '__DATABASE_KEY__';
	
	public static function &DATABASE_CONFIG()
	{

		$db 						= new DatabaseConfigVo();
		$db->hostname 				= '127.0.0.1';
		$db->username 				= 'root';
		$db->password 				= 'chaky87300';
		$db->database				= 'appdata';
		$db->dbdriver 				= 'mysqli';
		$db->dbprefix 				= '';
		$db->pconnect 				= FALSE;
		$db->db_debug 				= FALSE;
		$db->cache_on 				= FALSE;
		$db->cachedir 				= '';
		$db->char_set 				= 'utf8';
		$db->dbcollat 				= 'utf8_unicode_ci';
		$db->prefix_delimiter 		= '_';
		$db->table_path				= '';
		
		return $db;
	}
	
	public static function &TABLE_GATEWAY_CONFIG()
	{
		
	}
	
	public static function &APPLICATION_CONFIG()
	{
	
		$app_config 							= new ApplicationConfigVo();
		$app_config->domain						= 'http://127.0.0.1/';
		$app_config->app_root_folder			= 'BiznisMenadzerOs/';
		$app_config->controller_root_uri		= $app_config->domain . $app_config->app_root_folder . 'index.php/';
		$app_config->name 						= '__BIZNIS_MENADZER__';
		$app_config->salt 						= '2b0b23e9-8af4-102d-b872-911ee00a8fb1__754d3b148df7a597947f5556cbe06628';	
		$app_config->post_array_delimiter		= '_A_';
		$app_config->specifications_path		= 'application/Specifications/';
		$app_config->logic_path					= 'application/BusinessLogic/';
		$app_config->require_authentication		= true;
		
		return $app_config;    
	}
	
	public static function &INSTALLATION_CONFIG()
	{
		static  $i = NULL;
		
		if( $i == NULL )
		{
			$i 							= new InstallConfigVo();
			$i->key						= '24d299b9-7136-102e-8945-a5392c337dda'; 
			$i->template				= 'default';
			$i->module_install_path		= 'application/InstallModules/';
		}
		
		return $i;
	}
	
	public static function &SESSION_CONFIG()
	{
		$s 				= new SessionVo();	
		
		$s->expire 					= 10000;
		$s->fix_adress 				= FALSE;
		$s->fix_browser				= TRUE;
		$s->force_ssl 				= FALSE;
		$s->name 					= '__BIZNIS_MENADZER_SESSION_NAME__';
		$s->session_id_name 		= 'sess_id';
		$s->extend_session 			= '__0f59986ae5c05f89f60cd826bebf36ac';
		
		return $s;
	}
	
	public static function &OUTPUT_BUILDER_CONFIG()
	{
		$o = new OutputBuilderVo();
		$o->default_name = 'row';
		$o->include_empty_values = true;
		$o->numeric_name_namespace = '_';
		$o->preserve_numeric_names = false;
		
		return $o;
		
	}

}

?>