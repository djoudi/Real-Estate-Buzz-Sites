<?

// SLO_RE_BASE class, ready to go.


class slore_base_class {
	
	function __construct()
	{
		$this->loader = plugin_loader::get_instance();
	}
	
	function _load_up()
	{
		global $slore_base_config;
		// Let's do the break dance here...
		if(is_admin())
		{
			foreach($slore_base_config['admin_classes'] as $plug)
			{
				$this->loader->_load($plug,'admin');
			}
		}
	}
	
	function go()
	{
		$this->_load_up();
		
		// Do the work here, or not!
	}
	
}