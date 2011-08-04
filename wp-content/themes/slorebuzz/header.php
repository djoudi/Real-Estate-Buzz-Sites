<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
 
global $page, $paged;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '' );?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
</head>

<body <?php body_class(); ?>>
<div id="outer-wrap">
<div id="wrapper" class="hfeed">
	<div id="header">
		<div id="masthead">
			<div id="branding" role="banner">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				</<?php echo $heading_tag; ?>>
			</div><!-- #branding -->
			<div id="access" role="navigation">
				<div id="main-nav-div">
					<ul id="main-header-nav">
						<li id="about-link"><a href="/about">About</a></li>
						<li id="team-link"><a href="/the-team">The Team</a></li>
						<li id="contact-link"><a href="/contact">Contact</a></li>
					</ul>
				</div>
				
				<div id="subnav-div">
					<ul id="sub-header-nav">
						<li id="news-link"><a href="/news">News</a></li>
						<li id="qa-link"><a href="/questions_and_answers">Q &amp; A</a></li>
						<li id="local-link"><a href="/local_resources">Local Resources</a></li>
					</ul>
				</div>
			</div><!-- #access -->
		</div><!-- #masthead -->
	</div><!-- #header -->

	<div id="main">
