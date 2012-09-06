<?php if ( ! defined('BASEPATH')) die();

require_once 'system/application/vos/FileVo.php';

class File
{
	protected $_path;
	
	const SAME_DIR_REL = '.';
	const PARENT_DIR_REL = '..';
	
	const FOLDER_INFO_INDEX = 'FOLDER_INFO';
	
	const TYPE_DIR = 1;
	const TYPE_FILE = 2;
	
	const FILE_TYPE_FILE = 3;
	const FILE_TYPE_LINK = 4;
	const FILE_TYPE_EXECUTABLE = 5;
	
	public static function read_fle( $path )
	{
	
		if ( ! file_exists( $path ) )
		{
			return FALSE;
		}
		
	
		if ( function_exists('file_get_contents') )
		{
			return file_get_contents( $path  );		
		}

		if ( ! $fp = @fopen( $path, FOPEN_READ ) )
		{
			return FALSE;
		}
		
		flock($fp, LOCK_SH);
	
		$data = '';
		if ( filesize( $path ) > 0 )
		{
			$data =& fread( $fp, filesize( $path ) );
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		return $data;
		
	}
	
	public static function write_file( $path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE )
	{
		$fp = fopen( $path, $mode );
		
		if(  $fp == FALSE )
		{
			return FALSE;
		}
		
		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);	

		return TRUE;
		
	}
	
	public static function read_dir( $path, $include_rel = FALSE, $recursive = FALSE )
	{		
		
		$dirs = array();
			
		// Open a known directory, and proceed to read its contents
		if ( ! is_dir( $path ) ) 
		{
			return NULL;
		}
		
		    if( $dh = opendir( $path ) ) 
		    {
		        while( ( $file = readdir( $dh ) ) !== false ) 
		        {
		        	$f = new FileVo();
		        	
		        	if( $file == self::PARENT_DIR_REL || $file == self::SAME_DIR_REL )
		        	{
		        		if( ! $include_rel )
		        			continue;
		        	}
		        	else 
		        	{
		        		$f->path = $path . $file;
		        		$f->octal_permisions = fileperms( $f->path );
		        		$f->size = filesize( $f->path );
		        		$f->date_modified = filemtime( $f->path );
		        	}
		        	
		        	
		        	$f->name = $file;
		        	
		        	$f->full_path = realpath( $f->path );
		        	
		        	if( is_dir( $f->path ) )
		        	{
		        		$f->type = self::TYPE_DIR;
		        	}
		        	else
		        	{
		        		$f->type = self::TYPE_FILE;
		        		
		        		if( is_link( $f->path ) )
			        	{
			        		$f->file_type = self::FILE_TYPE_LINK;
			        	}
			        	else if( is_executable( $f->path ) )
			        	{
			        		$f->file_type = self::FILE_TYPE_EXECUTABLE;
			        	}
			        	else if( is_file( $f->path ) )
			        	{
			        		$f->file_type = self::FILE_TYPE_FILE;
			        	}
			        	
		        		if( is_readable( $f->path ) )
		        		{
		        			$f->readable = TRUE;
		        		}
		        		else
		        		{
		        			$f->readable = FALSE;
		        		}
		        	}
		 
		        	
		        	if( $f->type == self::TYPE_DIR )
		        	{
		        		if( $f->type == self::PARENT_DIR_REL && $f->type == self::SAME_DIR_REL )
		        		{
		        			array_push( $dirs, $f );
		        		}
		        		else if( $recursive )
		        		{
		        			
		        			$a = array();
		        			$a[self::FOLDER_INFO_INDEX] = $f;
		        			
		        			$r = File::read_dir( $f->path . '/', $include_rel, TRUE );
		        			
		        			foreach( $r as $k => $v )
		        			{
		        				$a[ $k ] = $v;
		        			}
		        			
		        			$dirs[] = $a; 
		        		}
		        	}
		        	else
		        	{
		        		$dirs[] = $f;
		        		 
		        	}
		        	
		        }
		        
		        
		        closedir( $dh );
		    }
		    
		    
		return $dirs;    
	}	
}

?>