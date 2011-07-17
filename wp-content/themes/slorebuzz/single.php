<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		
			
			<div id="leader-board">
				<script type="text/javascript"><!--
google_ad_client = "ca-pub-5432668712223216";
/* SLORE Leader */
google_ad_slot = "8861053004";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
			</div>
			
		<div id="container">
			<div id="content" role="main">
				<div id="content-inner">
				<?php
					get_template_part( 'loop', 'single' );
				?>
				</div><!-- #content-inner -->
				<div id="content-footer">&nbsp;</div>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>