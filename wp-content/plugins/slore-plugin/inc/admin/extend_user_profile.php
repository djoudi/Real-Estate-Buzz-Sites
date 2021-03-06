<?

class extend_user_profile {
	
	function __construct()
	{
		// Let's set ourselves some actions!
		add_action('show_user_profile', array(&$this,'show_user_profile'));
		add_action('edit_user_profile', array(&$this,'edit_user_profile'));
		// Need to handle this action!
		add_action('personal_options_update', array(&$this, 'personal_options_update'));
		add_action('edit_user_profile_update', array(&$this, 'edit_user_profile_update'));
	}
	
	function extend_user_profile()
	{
		self::__construct();
	}
	
	function show_user_profile()
	{
		// Get the expando Vars...
		global $current_user;
		$expanded_profile = get_user_meta($current_user->data->ID,'_slore_expanded_profile', true);
		$user_type = get_user_meta($current_user->data->ID,'_slore_user_type', true);
		
		$shoDebug = false;
		
		if(isset($_GET['debug']))
		{
			$shoDebug = true;
			$debug = array();
			
			global $wpdb;
			
			$uId = $current_user->data->ID;
			
			$meta = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE user_id = $uId",ARRAY_A);
			
			$debug['meta'] = $meta;
			
		}
		
		include(SLORE_ADMIN_VIEWS.'show_user_profile.php');
	}
	
	function edit_user_profile()
	{
		// Get the expando Vars...
		global $user_id;
		$expanded_profile = get_user_meta($user_id,'_slore_expanded_profile', true);
		$user_type = get_user_meta($user_id,'_slore_user_type', true);
		
		include(SLORE_ADMIN_VIEWS.'show_user_profile.php');
	}
	
	function personal_options_update()
	{
		if(isset($_POST['expanded_profile']))
		{
			global $current_user;
			//print_r($current_user);
			
			$new_meta = $_POST['expanded_profile'];
			
			update_user_meta($current_user->data->ID,'_slore_expanded_profile',$new_meta);
			update_user_meta($current_user->data->ID,'_slore_user_type',$_POST['user_profile_type']);
		}
	}
	
	function edit_user_profile_update()
	{
		if(isset($_POST['expanded_profile']))
		{
			global $user_id;
			//print_r($current_user);
			
			$new_meta = $_POST['expanded_profile'];
			
			update_user_meta($user_id,'_slore_expanded_profile',$new_meta);
			update_user_meta($user_id,'_slore_user_type',$_POST['user_profile_type']);
		}
	}
	
}