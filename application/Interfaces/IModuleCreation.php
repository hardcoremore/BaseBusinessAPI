<?php if ( !defined('BASEPATH') ) die();

require_once 'application/vos/ApplicationConfigVo.php';
require_once 'application/vos/DatabaseConfigVo.php';

interface IModuleCreation
{
	function create();
	function isTemplateInstalled( $template );
	function getInstalledTables();
	function getFailedTables();
	function destroy();
	function copyDataFromTemplateToTemplate( $from_template, $to_template );
}
?>