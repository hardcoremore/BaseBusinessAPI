<?php if ( !defined('BASEPATH') ) die();

require_once 'application/libraries/database/BaseActiveRecord.php';

class MysqliActiveRecord extends BaseActiveRecord
{
	
	private $__dbResource;
	
	const ASC_ORDER_NAME = 'ASC';
	const DESC_ORDER_NAME = 'DESC';
 	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function transStrictmode( $mode )
	{
		$this->_error_message = NULL;
		
		if( $this->_driver )
		{
			$this->_driver->trans_strict( $mode );
		}
		else
		{
			$this->_error_message = 'INVALID driver at MysqliBaseTableGateway::transStrictmode()';
			$this->_setStatus( self::STATUS_ERROR );
		}
	}

	public function startTrans()
	{
		$this->_error_message = NULL;
		
		if( $this->_driver )
		{
			$this->_driver->trans_start();
		}
		else
		{
			$this->_error_message = 'INVALID driver at MysqliBaseTableGateway::startTrans()';
			$this->_setStatus( self::STATUS_ERROR );
		}
	}
	 
	public function commitTrans()
	{
		$this->_error_message = NULL;
		
		if( $this->_driver )
		{
			$this->_driver->trans_complete();
		}
		else
		{
			$this->_error_message = 'INVALID driver at MysqliBaseTableGateway::commitTrans()';
			$this->_setStatus( self::STATUS_ERROR );
		}
	}
	 
	public function getTransStatus()
	{
		$this->_error_message = NULL;
		
		if( $this->_driver )
		{
			return $this->_driver->trans_status();
		}
		else
		{
			$this->_error_message = 'INVALID driver at MysqliBaseTableGateway::getTransStatus()';
			$this->_setStatus( self::STATUS_ERROR );
		}
	}
	
	public function &run( $sql = NULL )
	{
		$this->_error_message = NULL;
		
		if( ! $this->_driver )
		{
			$this->loadDriver();
			
			if( ! $this->_driver )
			{
				$this->_error_message = 'Driver is not valid at MysqliActiveRecord::run()';
				$this->_setStatus( self::STATUS_ERROR );
				return $this;
			}
		}
			
		if( $sql != NULL )
		{
			
			$this->__dbResource =& $this->_driver->query( $sql );
			array_push( $this->_queries, $sql );	
		}
		else if( $this->_sql )
		{		
			$this->__dbResource =& $this->_driver->query( $this->_sql );
			array_push( $this->_queries, $this->_sql );
		}
		
		if( ! $this->getErrorMessage() )
		{
			$this->_setStatus( self::STATUS_OK );
		}
		else
		{
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $this;
	}
	
	public function &groupBy( $columns )
	{
		if( ! $this-> __checkColumns( $columns ) ) 
		{
			$this->_error_message = 'Invalid input at MysqliBaseTableGateway::groupBy()';
			$this->_setStatus( self::STATUS_ERROR );
			return $this;
		}
		
		$this->_sql .= ' GROUP BY ';
		
		foreach( $columns as $c )
			$this->_sql .= $c->name . ',';
			
		$this->_sql = substr_replace( $this->_sql, '', -1 );
		
		return $this;
	}
	 
	public function &orderBy( $tableOrderByVos )
	{
		if( ! is_array( $tableOrderByVos ) || count( $tableOrderByVos ) < 1 )
		{
			$this->_error_message = '$tableOrderByVos is invalid at MysqliBaseTableGateway::groupBy()';
			$this->_setStatus( self::STATUS_ERROR );
			return $this;
		}
		
		$this->_sql .= ' ORDER BY ';
		
		(int) $lastOperatorLength = 0;
		
		foreach( $tableOrderByVos as $v )
		{
			$this->_sql .=  $v->column->name . ' ' . $v->operator . ',';
		}
		
		$this->_sql = substr_replace( $this->_sql, '',  -1 );
		
		return $this;
	}
	 	
	public function &getResultAsArray()
	{
		$r = NULL;
		
		if( $this->__dbResource )
		{
			$r =& $this->__dbResource->result_array();
		}
		else
		{
			$this->_error_message = 'INVALID $dbResource at MysqliActiveRecord::getResultAsArray()';
			$this->_setStatus( self::STATUS_ERROR );
		}

		return $r;
	}
	 
	public function &getResultAsObject()
	{
		$r = NULL;
		
		if( $this->__dbResource )
		{
			$r =& $this->__dbResource->result();
		}
		else
		{
			$this->_error_message = 'INVALID $dbResource at MysqliActiveRecord::getResultAsObject()';
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $r;
	}

	public function &totalNumRows()
	{
		$r = NULL;
		
		// reset error message
		$this->_error_message = NULL;
		
		if( ! $this->_driver )
		{	
			$this->loadDriver();
		}
		
		if( ! $this->_driver )
		{
			$this->_error_message = 'INVALID driver at MysqliActiveRecord::totalNumRows()';
			$this->_setStatus( self::STATUS_ERROR );
		}
		else
		{
			$r =& $this->_driver->count_all( $this->fullTableName() ) ;
		}
		
		return $r;
		
	}

	public function &numRows()
	{
		$r = NULL;
		
		if( $this->__dbResource )
		{
			$r =& $this->__dbResource->num_rows();
		}
		else
		{
			$this->_error_message = 'INVALID $dbResource at MysqliActiveRecord::numRows()';
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $r;
	}
	
	public function &lastInsertedId()
	{
		$r = NULL;
		
		if( $this->_driver )
		{
			$r =& $this->_driver->insert_id();
		}
		else
		{
			$this->_error_message = 'INVALID driver at MysqliActiveRecord::lastInsertedId()';
			$this->_setStatus( self::STATUS_ERROR );
		}

		return $r;	
	}
	
	public function &affectedRows()
	{
		$r = NULL;
		
		if( $this->_driver )
		{
			$r =& $this->_driver->affected_rows();
		}
		else
		{
			$this->_error_message = 'INVALID driver at MysqliActiveRecord::affectedRows()';
			$this->_setStatus( self::STATUS_ERROR );
		}

		return $r;
	}
	
	public function &readAll()
	{
		// reset error message
		$this->_error_message = NULL;
		
		$this->_sql = "SELECT * FROM " . $this->fullTableName();
		
		return $this;
	}
	
	public function &read( $columns, $distinct = FALSE )
	{
		// reset error message
		$this->_error_message = NULL;
		
		(string) $colString = $this->_getColumnsSql( $columns );
		
		if( $colString == NULL || $colString == '' )
		{
			$this->_error_message =  'Columns are INVALID at MysqliActiveRecord::read()';
			$this->_setStatus( self::STATUS_ERROR );
			return $this;
		}
		
		$distinct == TRUE 

		?
		
		$this->_sql  = 'SELECT DISTINCT '
		
		:
		
		$this->_sql  = 'SELECT ';
		
		
		$this->_sql .= $colString . ' FROM ' . $this->fullTableName();
		
		return $this;
	}
	
	public function &simpleJoin( TableJoinVo $join )
	{
		
	}
	
	public function checkDatabaseOrTableName( $name )
	{
		if( ! is_string( $name ) ) return FALSE;
		
		if( preg_match( '/^[0-9A-Za-z-_]{0,64}$/', $name ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function &checkDatabaseExists( $name )
	{
		$r = NULL;
		
		// reset error message
		$this->_error_message = NULL;
		
		if( ! $this->checkDatabaseOrTableName( $name ) )
		{
			$this->_error_message = '$name is  INVALID at MysqliActiveRecord::checkDatabaseExists()';
			$this->_setStatus( self::STATUS_ERROR );
			return $r;
		}
		
		
		$this->run( "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" .$name ."'" );
		
		if( $this->numRows() == 1 )
		{
			$r = TRUE;
			$this->_setStatus( self::STATUS_OK );
		}
		else if( ! $this->getErrorMessage() )
		{
			
			$this->_setStatus( self::STATUS_NOT_FOUND );
		}
		else
		{
			$r = FALSE;
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $r;
		
	}
	
	public function &getTables()
	{
		$this->run( "SHOW TABLES" );
		
		if(  ! $this->getErrorMessage()  )
		{
			if( $this->numRows() > 0 )
			{
				$r = TRUE;
				$this->_setStatus( self::STATUS_OK );
			}
			else 
			{
				$r = NULL;
				$this->_setStatus( self::STATUS_NOT_FOUND );
			}
		}
		else
		{
			$r = FALSE;
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $r;
	}
	
	public function &createDatabase( DatabaseCreateVo $database )
	{
		$r = NULL;
		
		// reset error message
		$this->_error_message = NULL;
		
		if( ! $this->checkDatabaseOrTableName( $database->name ) )
		{
			$this->_error_message = '$name is  invalid at MysqliActiveRecord::createDatabase()';
			$this->_setStatus( self::STATUS_ERROR );
			return $r;
		}
		
		(string) $sql = "CREATE DATABASE `".$database->name ."`";
		  
		if( $database->default_character_set )
			$sql .= " DEFAULT CHARACTER SET " . $database->default_character_set;
			
		if( $database->collate )
				$sql .= " COLLATE " . $database->collate ;

		$this->run( $sql );
		
		if( $this->affectedRows() == 1 )
		{
			$r = TRUE;
			$this->_setStatus( self::STATUS_OK );
		}
		else
		{
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		
		return $r;
	}
	
	public function &createTable( CreateTableVo $table )
	{
		$r = NULL;
		// reset error message
		$this->_error_message = NULL;
		
		//check if valid CreateTableVo object is passed
		if( ! $table || ! $this->checkDatabaseOrTableName( $table->name ) || ! $this->__checkColumns( $table->columns ) )
		{
			$this->_error_message = '$table is  invalid at MysqliActiveRecord::createTable()';
			$this->_setStatus( self::STATUS_ERROR );
			return $r;
		}
		
		(string) $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->fullTableName() . "` \n(\n\t";
		
		$uniques = array();
		$indexes = array();
		$primaryKeys = array();
		$fullTextIndexes = array();
		
		$ai = FALSE;
		
		// for every column as SaveColumnVo 
		foreach( $table->columns as $v )
		{
			if( ($v->type == DatabaseDataTypes::MYSQLI_TEXT || $v->type == DatabaseDataTypes::MYSQLI_LONGTEXT) && ($v->autoIncrement || $v->index || $v->unique) )
			{
				$this->_error_message = "Error in creating table at MysqliActiveRecord::createTable(). Column types of TEXT OR LONGTEXT can't have autoIncrement or index or unique attribute.";
				$this->_setStatus( self::STATUS_ERROR );
				
				return $r;
			}
			
			if( ($v->type == DatabaseDataTypes::MYSQLI_CHAR || $v->type == DatabaseDataTypes::MYSQLI_VARCHAR) && ! $v->length )
			{
				$this->_error_message = 'Error in creating table at MysqliActiveRecord::createTable(). Column types of CHAR OR VARCHAR must have length';
				$this->_setStatus( self::STATUS_ERROR );
				
				return $r;
			}
			
			// $this->__checkColumns will check if values are valid array for enum type
			if( $v->type == DatabaseDataTypes::MYSQLI_ENUM && ! $this->__checkColumns( $v->values ) )
			{
				$this->_error_message = 'Error in creating table at MysqliActiveRecord::createTable(). Column types of ENUM must have values';
				$this->_setStatus( self::STATUS_ERROR );
				
				return $r;
			}
			
			if( $v->autoIncrement && ! $ai )
			{
				array_push( $primaryKeys, $v );
				
				// if column has auto_increment then it must be primary 
				//also so disable adding duplicate primary below
				$v->primary = FALSE; 
				
				$ai = TRUE;
			}
			
			if( $v->fullText && $table->engine != DatabaseEngineTypes::MYSQLI_MyISAM )
			{
				$this->_error_message = 'Error in creating table at MysqliActiveRecord::createTable(). Full text indexes are only supported in MyISAM engines.';
				$this->_setStatus( self::STATUS_ERROR );
				
				return $r;
			}
			else if( $v->fullText )
			{
				array_push( $fullTextIndexes, $v );
			}
			
			if( $v->unique )
				array_push( $uniques, $v );
				
		
			if( $v->primary )
				array_push( $primaryKeys, $v );
				
		
				
			if( $v->index )
				array_push( $indexes, $v );
				
				
			$sql .= '`'.$v->name.'`' . ' ' . $v->type;	
			
			if( $v->type == DatabaseDataTypes::MYSQLI_CHAR || $v->type == DatabaseDataTypes::MYSQLI_VARCHAR )
			{
				$sql .= ' (' . $v->length . ') ';
			}
			else if( $v->type == DatabaseDataTypes::MYSQLI_ENUM )
			{
				$sql .=  ' ( ';
				
				foreach( $v->values as $eValues )
				{
					$sql .= '"'.$eValues.'",';
				}
				
				$sql = substr_replace( $sql, '', -1 );
				$sql .= ' ) ';
				
			}
			
			$sql .= ' ' . $v->attribute . ' ';
			
			if( $v->null )
			{
				$sql .= ' NULL ';
			}
			else
			{
				$sql .= ' NOT NULL ';
			}
			
			if( $v->autoIncrement )
			{
				$sql .= ' AUTO_INCREMENT ';
			}
			
			if( $v->comment )
			{
				$sql .= 'COMMENT "'. $v->comment .'"';
			}
			
			$sql .= ",";
				
		}
		
		if( count( $primaryKeys ) > 0 )
		{
			$sql .= ' PRIMARY KEY ( ';
			foreach( $primaryKeys as $pk )
			{
				$sql .= "`" . $pk->name . "`,";
			}
			
			$sql = substr_replace( $sql, '', -1 );
			$sql .= " ),";
		}
		
		if( count( $indexes ) > 0 )
		{
			$sql .= ' INDEX ( ';
			foreach( $indexes as $ind )
			{
				$sql .= "`" . $ind->name . "`,";
			}
			
			$sql = substr_replace( $sql, '', -1 );
			$sql .= " ),";
		}
		
		if( count( $uniques ) > 0 )
		{
			$sql .= ' UNIQUE  ( ';
			foreach( $uniques as $uniq )
			{
				$sql .= "`" . $uniq->name . "`,";
			}
			
			$sql = substr_replace( $sql, '', -1 );
			$sql .= " ),";
		}
		
		if( count( $fullTextIndexes ) > 0 )
		{
			$sql .= ' FULLTEXT ( ';
			foreach( $fullTextIndexes as $fti )
			{
				$sql .= "`" . $fti->name . "`,";
			}
			
			$sql = substr_replace( $sql, '', -1 );
			$sql .= " ),";
		}
		
		
		// remove comma from the end of the string
		$sql = substr_replace( $sql, " \n", -1 );
		$sql .= ")";
		
		if( $table->engine )
			$sql .= "ENGINE = ". $table->engine . " ";
			
		if( $table->character_set )	
		 	$sql .= " CHARACTER SET ". $table->character_set . ' ';

		if( $table->collate )		
		 	$sql .= " COLLATE ". $table->collate .' ';
		 	
 		if( $table->comment )
		 	$sql .= ' COMMENT = "'. $table->comment . '"';
		
		
		$this->run( $sql );
		
		if( ! $this->getErrorMessage() )
		{
			$r = TRUE;
			$this->_setStatus( self::STATUS_OK );
		}
		else 
		{
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $r;
		
	}

	public function &dropDatabase( $name )
	{
		$r = NULL;
		
		// reset error message before every operation
		$this->_error_message = NULL;
		
		if( ! $this->checkDatabaseOrTableName( $name ) )
		{
			$this->_error_message = '$name is INVALID at MysqliActiveRecord::dropDatabase()';
			$this->_setStatus( self::STATUS_ERROR );
			return $r;
		}
		
		$this->run( "DROP DATABASE `".$name."` " );
		
		if( ! $this->getErrorMessage() )
		{
			$r = TRUE;
			$this->_setStatus( self::STATUS_OK );
		}
		else
		{
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $r;
	}
	
	public function &dropTable( $name )
	{
		$r = NULL;
		
		// reset error message before every operation
		$this->_error_message = NULL;
		
		if( ! $this->checkDatabaseOrTableName( $name ) )
		{
			$this->_error_message = '$name is INVALID at MysqlBaseTableGateway::dropTable()';
			$this->_setStatus( self::STATUS_ERROR );
			return $r;
		}
		
		$this->run( "DROP TABLE `". $this->fullTableName() ."` " );
		
		if( ! $this->getErrorMessage() )
		{
			$r = TRUE;
			$this->_setStatus( self::STATUS_OK );
		}
		else
		{
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $r;
	}
	
	public function &dropView( $name )
	{
		$r = NULL;
		
		// reset error message before every operation
		$this->_error_message = NULL;
		
		if( ! $this->checkDatabaseOrTableName( $name ) )
		{
			$this->_error_message = '$name is  INVALID at MysqliActiveRecord::dropView()';
			$this->_setStatus( self::STATUS_ERROR );
			return $r;
		}
		
		$this->run( "DROP VIEW `".$name."` " );
		
		if( ! $this->getErrorMessage() )
		{
			$r = TRUE;
			$this->_setStatus( self::STATUS_OK );
		}
		else
		{
			
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		return $r;
	}
	
	public function &create( $columns )
	{
		$r = NULL;
		
		// reset error message before every operation
		$this->_error_message = NULL;
		
		if( ! $this-> __checkColumns( $columns ) )
		{
			$this->_error_message = '$columns are INVALID at MysqliActiveRecord::create()';
			$this->_setStatus( self::STATUS_ERROR );
			return $r;
		}
		
		(string) $sql = 'INSERT INTO ' . $this->fullTableName() . ' ';
		
		(string) $cName = '';
		(string) $cValue = '';
		
		
		foreach( $columns as $v )
		{
			// check if value is mysql function
			$p = preg_match('/^[a-zA-Z_]+[0-9_]*\(.*\)$/i', $v->value );
			
			$cName .=  $v->name . ',';
			
			// if its function add it without quotes
			if( $p )
			{
				$cValue .= $v->value . ',';
			}
			else
			{
				$cValue .= '"' . $v->value . '",';
			}
		}
		
		$cName = substr_replace( $cName, '', -1 );
		$cValue = substr_replace( $cValue, '', -1 );
		
		$sql .= '( ' . $cName . ') VALUES (' . $cValue . ')'; 

		$this->_sql =& $sql;
		
		$this->run();
		
		if( $this->affectedRows() == 1 )
		{
			$r = TRUE;
			$this->_setStatus( self::STATUS_OK );
		}
		else if( ! $this->getErrorMessage() )
		{
			$r = FALSE;
			$this->_setStatus( self::STATUS_NOT_CHANGED );
		}
				
		return $r;
	}
	
	public function &update( $tableUpdateVos )
	{
		
		// reset error message before every operation
		$this->_error_message = NULL;
		
		if( ! $this-> __checkColumns( $tableUpdateVos )  )
		{
			$this->_error_message = 'INVALID $tableUpdateVos at MysqliActiveRecord::update()';
			$this->_setStatus( self::STATUS_ERROR );
			return $this;
		}
		
		$this->_sql = 'UPDATE ' . $this->fullTableName() . ' SET ';
		
		(string) $updateStr = '';
		
		foreach( $tableUpdateVos as $v )
		{
			$updateStr .= $v->column->name . ' ';
			 
			switch( $v->operator )
			{
				case DatabaseOperators::MYSQLI_EQUAL:
					$updateStr .= $v->operator . ' "' . $v->column->value . '",';
				break;
					
				case DatabaseOperators::MYSQLI_ADD:
					$updateStr .= '= ' . $v->column->name . ' + "' . $v->column->value . '",';
				break;
				
				case DatabaseOperators::MYSQLI_SUBTRACT:
					$updateStr .= '= ' . $v->column->name . ' - "' . $v->column->value . '",';
				break;
				
				case DatabaseOperators::MYSQLI_MULTIPLY:
					$updateStr .= '= ' . $v->column->name . ' * "' . $v->column->value . '",';
				break;
				
				case DatabaseOperators::MYSQLI_DIVIDE:
					$updateStr .= '= ' . $v->column->name . ' / "' . $v->column->value . '",';
				break;
				
			}
		}
		
		$updateStr = substr_replace( $updateStr, '', -1 );
		
		
		$this->_sql .= $updateStr;
		
		return $this;
	}
	
	public function &whereSimple( TableWhereReadVo $tableWhereReadVo )
	{
		if( 
			! $this->__checkColumns( $tableWhereReadVo->whereVos  ) || 
			( count( $tableWhereReadVo->whereVos ) > 1 && strlen( $tableWhereReadVo->operator ) < 1 ) 
		  )
		{
			$this->_error_message = '$tableWhereReadVos is INVALID at MysqliActiveRecord::whereSimple()';
			$this->_setStatus( self::STATUS_ERROR );
			return $this;
		}
		
		$this->_sql .= ' WHERE ';
		
		foreach( $tableWhereReadVo->whereVos as $v )
		{
			//if( strlen( $v->column->table_name ) )
			
			$this->_sql .= ' ' . $v->column->name . ' ' . $v->operator . ' "' . $v->leftWild . $v->column->value . $v->rightWild . '" ' .  $tableWhereReadVo->operator;
		}
	
		$opLen = strlen( $tableWhereReadVo->operator );
		
		if( $opLen > 1 )		
			$this->_sql = substr_replace( $this->_sql, '', strlen( $tableWhereReadVo->operator ) * -1 );
		
		return $this;
	}
	
	public function &whereComplex( $tableWhereGroupVos )
	{
//		@TODO implement whereComplex part of the query	
	}
	
	public function &whereIn( $column, $values, $operator )
	{
//		@TODO implement whereIn part of the query		
	}
	 
	public function &whereNotIn( $column, $values, $operator )
	{
//		@TODO implement whereNotIn part of the query		
	}
	 
	public function &whereMatch( TableWhereMatchVo $match )
	{
		
	}

	/*
	 *  $page has an advantage here
	 * 
	 */
	public function limit( PageVo $page = NULL, TableLimitVo $limit = NULL )
	{
		if( $page == NULL && $limit == NULL )
		{
			$this->_error_message = 'INVALID input at MysqliActiveRecord::limit()';
			$this->_setStatus( self::STATUS_ERROR );
			return $this;
		}
		
		$this->_sql .= ' LIMIT ';
		
		if( $page )
		{
			$offset = $this->calculateOffset( $page->pageNumber, $page->rowsPerPage );
			$this->_sql .= $offset	. ', ' . $page->limit;
		}
		elseif( $limit )
		{
			if( $limit->limit )
			{
				$this->_sql .= $limit->offset . ', ' . $limit->limit;
			}
			else
			{
				$this->_sql .= $limit->offset;
			}
		}
		
		return $this;
		
	}
	
	public function &delete( )
	{
		// reset error message
		$this->_error_message = NULL;
		
		$this->_sql = 'DELETE FROM ' . $this->fullTableName();
		
		return $this;
	}
	
	public function &escape( $s )
	{
	
		if( ! $this->_driver )
		{
			$this->loadDriver();
		}
		
		if( ! $this->_driver )
		{
			$this->_error_message = 'INVALID driver at MysqliActiveRecord::excape()';
			$this->_setStatus( self::STATUS_ERROR );
		}
		
		$s = $this->_driver->escape( $s );
		
		
// 		because CodeIgniter adds extra single quotes in escape function and i don't need that so i chop it off :) ( Boris the Bullet Dodger :) )

		if( substr( $s, 0, 1 ) == "'")
		{
			$s = substr_replace( $s, '', 0, 1 );
		}
		
		if( substr( $s, -1 ) == "'")
		{
			$s = substr_replace( $s, '', -1 );
		}
		
		return $s;
	}
	
	public function getErrorMessage()
	{
		
		if( $this->_error_message != NULL )
		{
		 	return $this->_error_message;
		}
		else if( $this->_driver )
		{
			return $this->_driver->_error_message();
		}
		 
	}
	
	protected function &_getColumnsSql( &$cols )
	{
		(string) $colString = '';
		
		if( ! $this-> __checkColumns( $cols )  ) 
		{
			$this->_error_message = 'INVALID $cols at MysqliactiveRecord::_getColumnsSql()';
			$this->_setStatus( self::STATUS_ERROR );
			return $colString;
		}	
		
		
		foreach( $cols as $v )
		{
			( $v->asName != NULL && strlen( $v->asName ) > 1 )
			
			?
				$colString .= $v->name . ' AS ' . $v->asName . ','
			:
				$colString .= $v->name . ',';
			;
			
		}

		$colString = substr_replace( $colString, '', -1 ) . ' ';
		
		return $colString;
	}
	
	protected function &_getWhereSql( &$fields, &$operator )
	{
		if( ! $this->__checkColumns( $fields ) || strlen(  trim( $operator ) ) < 1 )
		{
			$this->_error_message = 'INVALID input at MysqliActiveRecord::_getWhereSql()';
			$this->_setStatus( self::STATUS_ERROR );
			return;
		}
		
		(string) $sql = ' WHERE ';
		
		foreach( $fields as $k => $v )
		{
			$sql .= ' ' . $k . ' = "' . $v . '" ' . $operator;			
		}
		
		$opLen = strlen(  trim( $operator ) );
		
		if( $opLen > 0 )
			$sql = substr_replace( $sql, '', $opLen * (-1)  );
		
		return $sql;
	}

	// check if var is array and if array is not empty
	private function __checkColumns( $c )
	{
		if( ! is_array( $c ) || count( $c ) < 1 )
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
			
	}
}

?>