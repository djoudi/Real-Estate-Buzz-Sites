<?php
/*
Plugin Name: SLO Real Estate Buzz, Master Plugin
Description: This is a master plugin that allows hacks, and additions for RE-BUZZ websites. It also allows for optimization of plugin structure in addition to WP Core Plugin functionality
Version: A1
Plugin URI: http://www.sanluisrealestatebuzz.com
Author: Eric Willis
Author URI: http://www.envigiomedia.com
*/

define( 'SLORE_BASE', WP_PLUGIN_DIR."/slore-plugin/");

// Gather the Config's
include(SLORE_BASE."/plugin-conf.php");


// Load the class
$base_class = new slore_base_class();

//Go

$base_class->go();