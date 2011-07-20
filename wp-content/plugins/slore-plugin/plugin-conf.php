<?


// Config the plugin.

define('SLORE_ADMIN_VIEWS', SLORE_BASE.'inc/admin/views/');

global $slore_base_config;

$slore_base_config = array(
	'admin_classes' => array(
		'extend_user_profile'
	)
);


include(SLORE_BASE."loader-class.php");
include(SLORE_BASE."inc/slore_base_class.php");