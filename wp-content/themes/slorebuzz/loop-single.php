<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
	</div><!-- #nav-above -->
<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
<?php while ( have_posts() ) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="post-entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<div class="post-entry-meta">
				<?php twentyten_posted_on(); ?>
			</div><!-- .entry-meta -->
			
			<div class="post-entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
			
			<div style="margin-top:14px;overflow:hidden;">
				<h4>Did You Like this Article? Share it!</h4>
				<div id="facebook" style="float:left;margin-right:12px;width:47px;overflow:hidden;">
					<iframe src="http://www.facebook.com/plugins/like.php?app_id=249908208354495&amp;href&amp;send=false&amp;layout=box_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=tahoma&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:90px;" allowTransparency="true"></iframe>
				</div>
				<div id="twitter-share" style="float:left;margin-right:12px;width:57px;overflow:hidden;">
					<a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="slorebuzz">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				</div>
				<div id="google-share" style="float:left;margin-right:12px;width:50px;overflow:hidden;">
				<g:plusone size="tall"></g:plusone>
				</div>
				<div id="linkedin-share" style="float:left;margin-right:12px;width:61px;overflow:hidden;">
				<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-counter="top"></script>
				</div>
				<div id="stumbleupon-share" style="float:left;margin-right:12px;width:61px;overflow:hidden;">
				<script src="http://www.stumbleupon.com/hostedbadge.php?s=5"></script>
				</div>
			</div>
			
			<div id="author-box">
				<? /* <div class="post-author-avatar" style="width:110px;"><?=get_avatar(get_the_author_meta('ID'), '110');?><img src="/wp-content/themes/slorebuzz/images/pb-logo.jpg" /></div>*/?>
				<div style="margin-right:124px;">
				<h4><span style="font-size:16px;color:#797979;font-weight:normal;">This post was written by</span> <?php the_author_posts_link(); ?></h4>
				<? /*<div class="contact-box" style="margin-top:3px;border-top:1px solid #dadada;padding-top:7px;">
					<span class="contact-label" style="font-weight:bold;margin-right:18px;">Contact <?=the_author_meta('first-name');?>:</span>
					<a href="#" style="text-decoration:none;margin-right:7px;"><img src="/wp-content/themes/slorebuzz/images/twitter.png" style="vertical-align:middle;"/> Twitter</a>
					<a href="#" style="text-decoration:none;margin-right:7px;"><img src="/wp-content/themes/slorebuzz/images/facebook.png" style="vertical-align:middle;"/> Facebook</a>
					<a href="#" style="text-decoration:none;margin-right:7px;"><img src="/wp-content/themes/slorebuzz/images/email.png" style="vertical-align:middle;"/> Email</a>
				</div>
				<p>Author short bio information would go here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis gravida orci ac dolor venenatis tempor. Nam porttitor hendrerit metus, sed vehicula ligula ornare quis. Proin sit amet egestas libero. Nunc eu felis leo. </p>
				<p><a href="<?=get_author_posts_url(get_the_author_meta('ID'));?>">Learn More &raquo;</a></p>
				</div> */ ?>
			</div>
			
			<?php comments_template( '', true ); ?>
</div>
<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
				</div><!-- #nav-below -->
<?php endif; ?>
