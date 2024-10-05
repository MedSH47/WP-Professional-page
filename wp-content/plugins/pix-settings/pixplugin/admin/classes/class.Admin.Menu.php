<?php

class PixAdminMenu extends PixAdmin {
	
	public $setup_function = 'add_menu_page'; // WP function to register the page

	public function add_admin_menu() {
		
		call_user_func( 
			$this->setup_function, 
			$this->title,
			$this->menu_title, 
			$this->capability, 
			$this->id, 
			array( $this, 'display_admin_menu' ),
			$this->icon,
			$this->position
		);
	}
}
