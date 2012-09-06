<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/vos/TableGatewayVos/CreateTableVo.php';

interface ITableUtilGateway
{
	function &createTable( CreateTableVo $table );
	function &checkDatabaseExists( $name );
	function &getTables();
	function &createDatabase( DatabaseCreateVo $database );
	function &truncateTable( $name );
	function &dropTable( $name );
	function &dropView( $name );
	function &dropDatabase( $name );
}

?>