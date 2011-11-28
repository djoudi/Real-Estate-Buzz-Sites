<?php

class splash_page {
	
	function __construct()
	{
		add_action('wp_loaded', array(&$this, 'ShowSplash'));
	}
	
	public function ShowSplash()
	{
		if(defined('SHOW_SPLASH') && SHOW_SPLASH == true)
		{
			$dir = get_template_directory();
			
			include($dir."/splash.php");
			exit;
			//die('And here we are');
		}
		
	}
}