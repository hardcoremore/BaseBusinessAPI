<?php

class PageVo
{
	public function __construct( $pageNumber = 1,  $rowsPerPage = 5 )
	{
		$this->pageNumber = $pageNumber;
		$this->rowsPerPage = $rowsPerPage;
	}
	
	public $rowsPerPage;
	public $pageNumber;
	
}
?>