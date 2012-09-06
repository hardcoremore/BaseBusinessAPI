<?php if ( ! defined('BASEPATH')) die();

require_once 'application/vos/controllersVos/PartneriVo.php';

interface IPartneriSpecification
{
	function read( PartneriVo $partner, $numRows = null );
	function create( PartneriVo $partner );
	function update( PartneriVo $partner );
	function delete( PartneriVo $partner );
	function search( PartneriVo $partner );
	
}

?>