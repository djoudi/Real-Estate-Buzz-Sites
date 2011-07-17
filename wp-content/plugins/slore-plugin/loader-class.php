<?


/*
	PLUGIN Loader class, uses configuration arrays to controll the loading of all the plugin hook files
*/

class plugin_loader {
	
	private static $self_instance;
	
	function get_instance()
	{
		if(!self::$self_instance)
		{
			self::$self_instance = new plugin_loader();
		}
		
		return self::$self_instance;
	}
}