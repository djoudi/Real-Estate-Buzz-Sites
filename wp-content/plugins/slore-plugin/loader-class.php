<?


/*
	PLUGIN Loader class, uses configuration arrays to controll the loading of all the plugin hook files
*/

class plugin_loader {
	
	private static $self_instance;
	private static $loaded_plugins;
	
	function get_instance()
	{
		if(!self::$self_instance)
		{
			self::$self_instance = new plugin_loader();
		}
		
		return self::$self_instance;
	}
	
	function _load($plugin_name, $plugin_loc)
	{
		if(!isset(self::$loaded_plugins[$plugin_name]))
		{
			include_once(SLORE_BASE.'inc/'.$plugin_loc.'/'.$plugin_name.'.php');
			
			self::$loaded_plugins[$plugin_name] = new $plugin_name;
		}
		
		return true;
	}
}