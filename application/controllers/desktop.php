<?php if ( !defined('BASEPATH')) die();

require_once 'application/controllers/BaseController.php';
require_once 'application/vos/ModelVos/DesktopAppearanceVo.php'; 

class Desktop extends BaseController 
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model( 'Desktop_model', 'desktop_model' );
		$this->desktop_model->loadDatabase();
		
		$this->load->model( 'User_model', 'um' );
		$this->um->loadDatabase();
	}
	
	public function createDesktopAppearance( DesktopAppearanceVo $appearance = null )
	{
		if( ! $appearance )
			$appearance = $this->getDesktopAppearanceFromInput();
			
		$this->setDataHolderFromModelOperationVo( $this->desktop_model->createDesktopAppearance( $appearance ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readDesktopAppearances( ReadTableVo $readVo = NULL )
	{
		if( ! $readVo )
			$readVo = $this->getTableReadVo();
			
		$this->setDataHolderFromModelOperationVo( $this->desktop_model->readDesktopAppearances( $readVo ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function readDefaultDesktopAppearance()
	{
		$this->setDataHolderFromModelOperationVo( $this->desktop_model->readDefaultDesktopAppearance() );
		$this->_data_holder->dispatchAll();
	}
	
	public function updateDesktopAppearance( DesktopAppearanceVo $appearance = null  )
	{
		if( ! $appearance )
			$appearance = $this->getDesktopAppearanceFromInput();
			
		$this->setDataHolderFromModelOperationVo( $this->desktop_model->updateDesktopAppearance( $appearance ) );
		$this->_data_holder->dispatchAll();
	}
	
	public function getDesktopAppearanceFromInput()
	{
		$appearance = new DesktopAppearanceVo();
		
		$appearance->desktop_appearance_id = $this->input->post( 'desktop_appearance_id' );
		$appearance->desktop_appearance_user_id = $this->um->currentUser()->user_id;
		$appearance->desktop_appearance_name = $this->input->post( 'desktop_appearance_name' );
		
		$appearance->desktop_appearance_default = $this->input->post( 'desktop_appearance_default' );
		$appearance->desktop_appearance_icon_size = $this->input->post( 'desktop_appearance_icon_size' );
		$appearance->desktop_appearance_font_size = $this->input->post( 'desktop_appearance_font_size' );
		$appearance->desktop_appearance_controll_button_size = $this->input->post( 'desktop_appearance_controll_button_size' );
		$appearance->desktop_appearance_wallpaper_type = $this->input->post( 'desktop_appearance_wallpaper_type' );
		$appearance->desktop_appearance_wallpaper_url = $this->input->post( 'desktop_appearance_wallpaper_url' );
		$appearance->desktop_appearance_wallpaper_color = $this->input->post( 'desktop_appearance_wallpaper_color' );
		
		
		$appearance->desktop_appearance_window_background_color = $this->input->post( 'desktop_appearance_window_background_color' );
		$appearance->desktop_appearance_window_background_alpha = $this->input->post( 'desktop_appearance_window_background_alpha' );
		$appearance->desktop_appearance_window_border_color = $this->input->post( 'desktop_appearance_window_border_color' );
		$appearance->desktop_appearance_window_border_alpha = $this->input->post( 'desktop_appearance_window_border_alpha' );
		
		$appearance->desktop_appearance_taskbar_position = $this->input->post( 'desktop_appearance_taskbar_position' );
		$appearance->desktop_appearance_taskbar_label_visible = $this->input->post( 'desktop_appearance_taskbar_label_visible' );
		$appearance->desktop_appearance_taskbar_color = $this->input->post( 'desktop_appearance_taskbar_color' );
		$appearance->desktop_appearance_taskbar_thickness = $this->input->post( 'desktop_appearance_taskbar_thickness' );
		$appearance->desktop_appearance_taskbar_alpha = $this->input->post( 'desktop_appearance_taskbar_alpha' );
			
		return $appearance;
	}

}

/* End of file desktop.php */
/* Location: ./system/application/controllers/desktop.php */