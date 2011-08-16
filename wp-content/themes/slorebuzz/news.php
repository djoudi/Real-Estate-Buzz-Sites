<?php
/*Template Name: News Page Template*/

get_header(); ?>

		
			
			<div id="leader-board">
				<? get_template_part('adspot','leader'); ?>
			</div>
			
		<div id="container">
			<div id="content" role="main">
				<div id="content-inner">
				<?
					wp_reset_query();
					query_posts( 'posts_per_page=10' );
				?>
				<?php
					get_template_part( 'loop', 'home' );
				?>
				</div><!-- #content-inner -->
				<div id="content-footer">&nbsp;</div>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>