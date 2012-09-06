<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/Interfaces/IBaseTableGateway.php';;
require_once 'system/application/vos/controllersVos/PartneriVo.php';

interface IPartneriTableGateway extends IBaseTableGateway
{
	function create( PartneriVo $partner );
	function update( PartneriVo $partner );
	function delete( PartneriVo $partner );
	function quickSearch( $query  );
	function advancedSearch( PartneriVo $partner );
	
}

?>