<?php if ( !defined('BASEPATH') ) die();
 
require_once 'application/vos/DatabaseConfigVo.php';
require_once 'application/vos/TableGatewayVos/PageVo.php';
require_once 'application/vos/TableGatewayVos/TableLimitVo.php';
require_once 'application/vos/TableGatewayVos/TableWhereReadVo.php';
require_once 'application/vos/TableGatewayVos/TableUpdateVo.php';
require_once 'application/vos/TableGatewayVos/TableWhereGroupVo.php';
require_once 'application/vos/TableGatewayVos/TableOrderByVo.php';
require_once 'application/vos/TableGatewayVos/SaveColumnVo.php';;
require_once 'application/vos/TableGatewayVos/CreateTableVo.php';
require_once 'application/vos/TableGatewayVos/ColumnVo.php';
require_once 'application/vos/DatabaseCreateVo.php';
require_once 'application/libraries/database/utility/DatabaseEngineTypes.php';
require_once 'application/libraries/database/utility/DatabaseAttributes.php';
require_once 'application/libraries/database/utility/DatabaseDatatypes.php';


interface IActiveRecord
{

	
	 function setDatabaseConfig( DatabaseConfigVo $config );
	
	 function getDatabaseConfig();
	
	 function getStatus();
	 
	 function setTableName( $name );
	 
	 function transStrictmode( $mode );
	 
	 function startTrans();
	 
	 function commitTrans();
	 
	 function getTransStatus();
	 
	 /**
	  * Allows for manually runing queries
	  * 
	  *  @param $sql string sql to be executed
	  */
	 function &run( $sql = NULL );
	 
	 /**
	  * 
	  * @return string Returns current sql string
	  */
	 function getSql();
	 
	 function loadDriver();

	 function reloadDriver( DatabaseConfigVo $config = null );
	 
	 function getTableName();
	 
	 function &totalNumRows();
	 
	 function &numRows();
	 
	 function &lastInsertedId();
	 
	 function &affectedRows();
	 
	  /**
	   * 
	   * Read specified columns from table
	   * 
	   *  @param array $columns Array of ColumnVo objects
	   *  
	   *  @param bool $distinct If columns are distinct
	   *  
	   */
	 function &read( $columns, $distinct = FALSE );

	 
	 function &simpleJoin( TableJoinVo $join );
	 
	 /**
	  * Read all columns from the table
	  */
	 function &readAll();
	 
	 /**
	  * 
	  * Read from table by using TableGatewayReadVo
	  * 
	  * @param TableGatewayReadVo $read
	  * 
	  * @return $this
	  * 
	  */
	 function &readFromVo( TableGatewayReadVo $read );
	  
	 /**
	  * Check if table name or database name is valid
	  * If valid returns true otherwise false
	  * 
	  *  @param string name of the database or table
	  */
	 function checkDatabaseOrTableName( $name );
	 
	 /**
	  * Create new database in table
	  * 
	  * @param DatabaseCreateVo $database
	  * 
	  * @return TRUE on success, NULL on error
	  * 
	  */
	 function &createDatabase( DatabaseCreateVo $database );
	 
	 /**
	  * Create new table in database
	  * 
	  * @param string $name name of database
	  * 
	  * @return TRUE on success, NULL on error
	  * 
	  */
	 function &createTable( CreateTableVo $table );

	 /**
	  * Drops the database
	  * 
	  * @param string $name name of database
	  * 
	  * @return TRUE on success, NULL on error
	  * 
	  */
	 function &dropDatabase( $name );
	 
	 /**
	  * Drops the table
	  * 
	  * @param string $name name of table
	  * 
	  * @return TRUE on success, NULL on error
	  * 
	  */
	 function &dropTable( $name );
	 
	 /**
	  * Drops the view table
	  * 
	  * @param string $name name of view
	  * 
	  * @return TRUE on success, NULL on error
	  * 
	  */
	 function &dropView( $name );

	 /**
	  * Creates row in table
	  * 
	  *  @param array $columns Array of ColumnVo objects
	  */
	 function &create(  $columns );
	
	 /**
	  * Check if value exists in table column
	  * 
	  *  @param ColumnVo $column
	  *  
	  *  @return int number of rows found in that columns on success, NULL on error
	  *  
	  *  @note this function may also return 0
	  *  
	  */
	 function &checkValueExists( ColumnVo $column );
	 
	 
	 /**
	  * 
	  * Checks if database already exists
	  * 
	  * @param string $name name of database
	  * 
	  * @return TRUE if does exists, NULL if not exists and FALSE on error
	  * 
	  */
	 function &checkDatabaseExists( $name );
	 
	 /**
	  * Returns all tables in database
	  * 
	  * @return TRUE on success, NULL on empty set and FALSE on error
	  */
	 function &getTables();
	 
	  /**
	   *  @param array $tableUpdateVo Array of TableUpdateVo objects
	   */
	 function &update( $tableUpdateVos );
	
	 /**
	  * Delete rows from table
	  */
	 function &delete();
	
	 /**
	  *  @param TableWhereReadVo $tableWhereReadVo
	  */
	 function &whereSimple( TableWhereReadVo $tableWhereReadVo );
		
	 /**
	  * @param array $tableWhereReadVos Array of TableWereGroupVo objects
	  */
	 function &whereComplex( $tableWhereGroupVos );
	 
	 function &whereIn( $operator, $column, $values );
	 
	 function &whereNotIn( $operator, $column, $values );
	 
	 function &whereMatch( TableWhereMatchVo $match );
	 
	 /**
	  *  @param array $columns  Array of ColumnVo objects. Table columns to be grouped by
	  */
	 function &groupBy( $columns );
	 
	  /** 
	   * @param array $tableOrderByVos Array of TableOrderByVo objects
	   */
	 function &orderBy( $tableOrderByVos );
	 
	 /**
	  *
	  * Limits number of row reads from the table
	  *  
	  * @param PageVo $page  
	  *  
	  * @param TableLimitVo $lmit 
	  * 
	  */
	 function limit( PageVo $page = NULL, TableLimitVo $lmit = NULL );
	 
	 
	  
	 /**
	  *  Returns errror message 
	  *
	  */
	 function getErrorMessage();
	 
	 
	  /**
	   * 
	   * @param string $s  value to be escaped for database to prevent sql injection
	   * 
	   */
	 function &escape( $s );
	 
	  /**
	   * 
	   * @param int $pageNumber  number of page
	   * 
	   * @param int $limit  rows per page
	   * 
	   */
	 function calculateOffset( $pageNumber, $limit );
	 
	 /**
	  * 
	  * Gets result as associative array
	  */
	 function &getResultAsArray();
	 
	 /**
	  * 
	  * Gets result as object
	  */
	 function &getResultAsObject();
	 
}


?>