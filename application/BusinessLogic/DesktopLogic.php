<?php if ( !defined('BASEPATH') ) die();

require_once 'system/application/libraries/BusinessLogicBase.php';
require_once 'system/application/Interfaces/BusinessLogic/IDesktopLogic.php.php';

class DesktopLogic extends BusinessLogicBase implements IDesktopLogic
{
	private $__authSpec;
	protected $_iconTableGateway;
	protected $_iconSpecification;
	
	public function __construct( ApplicationConfigVo $appConfig = NULL )
	{
		parent::__construct( $appConfig );
		
		$this->_tableGateway = TableGatewayFactory::DESKTOP_TABLE_GATEWAY( ConfigFactory::DATABASE_CONFIG() );
		$this->_iconTableGateway = TableGatewayFactory::ICON_TABLE_GATEWAY( ConfigFactory::DATABASE_CONFIG() );
		
		$this->_specification = SpecificationFactory::DESKTOP_SPEC( $this->_appConfig );
		$this->__authSpec = SpecificationFactory::AUTHENTICATION_SPEC( $this->_appConfig );
		$this->_iconSpecification = SpecificationFactory::ICON_SPEC( $this->_appConfig );
	}
	
	function &createIcon( SaveIconVo $saveIconVo )
	{
		if( $this->_iconSpecification->saveIcon( $saveIconVo ) )
		{
			$this->_iconTableGateway->loadDriver();
			$r = $this->_iconTableGateway->createIcon( $saveIconVo );
			
			if( $r !== FALSE  )
			{
				if( $r->errorCode === 0 )
				{
				
				}
				else
				{
					return $this->returnErrorFromErrorCode( $r->errorCode );
				}
			}
		}
		else
		{
			return $this->returnInvalidInputError();
		}
	}
	
	function &updateIcon( SaveIconVo $saveIconVo )
	{	
		if( $this->_iconSpecification->updateIcon( $saveIconVo ) )
		{
			$this->_iconTableGateway->loadDriver();
			$r = $this->_iconTableGateway->updateIcon( $saveIconVo );
			
			if( $r !== FALSE  )
			{
				if( $r->errorCode === 0 )
				{
				
				}
				else
				{
					return $this->returnErrorFromErrorCode( $r->errorCode );
				}
			}
		}
		else
		{
			return $this->returnInvalidInputError();
		}
	}
	
	function &loadIcon( UpdateIconVo $updateIconVo )
	{
		$this->_iconTableGateway->loadDriver();
	}
	
	function &deleteIcon( UpdateIconVo $updateIconVo )
	{
		$this->_iconTableGateway->loadDriver();	
	}
	
	function &createDesktop( SaveDesktopVo $saveDesktopVo )
	{
		$this->_tableGateway->loadDriver();
	}
	
	function &updateDesktopState( SaveDesktopVo $saveDesktopVo )
	{
		$this->_tableGateway->loadDriver();
	}
	
	function &loadDesktop( UpdateDesktopVo $updateDesktopVo )
	{
		$this->_tableGateway->loadDriver();
	}
	
	function &deleteDesktop( UpdateDesktopVo $updateDesktopVo )
	{
		$this->_tableGateway->loadDriver();
	}
	
	function &changeBackground( ChangeBackgroundVo $changeBckVo )
	{
		$this->_tableGateway->loadDriver();
	}
	
}