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
			
			<h2 class="post-entry-title single-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			
			<div class="top-avatar">
				<?=get_avatar(get_the_author_meta('ID'), '120');?>
				<p><a href="#author_info"><?php the_author_meta('display_name'); ?></a></p>
			</div>
			
			<div class="post-entry-meta single-meta">
				<?php twentyten_posted_on(); ?>
			</div><!-- .entry-meta -->
			
			<div class="post-entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
			
			<div class="share-wide">
				<h4>Did You Like this Article? Share it!</h4>
				<div id="facebook" style="float:left;margin-right:12px;width:47px;overflow:hidden;">
					<div class="fb-like" data-send="false" data-layout="box_count" data-width="450" data-show-faces="false"></div>
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
				<a name="author_info"></a>
				
				<?
					// Set up Info...
					$expanded_profile = get_user_meta(get_the_author_meta('ID'),'_slore_expanded_profile', true);
					//print_r($expanded_profile);
					
				?>
				<h4>
					<?php the_author_posts_link(); ?><br/>
					<span style="font-size:16px;color:#474747;font-weight:normal;font-style:italic;color:#787878;"><?=$expanded_profile['company'];?></span>
				</h4>
				<div class="contact-box" style="margin-top:3px;border-top:1px solid #dadada;padding-top:7px;">
					<p>
						<span class="contact-label" style="font-weight:bold;margin-right:18px;">Contact:</span>
						<span class="post-phone" style=""><?=$expanded_profile['phone'];?></span>
						<?php if($expanded_profile['twitter'] != ''): ?>
							<a href="http://www.twitter.com/<?=$expanded_profile['twitter']; ?>" class="contact-link" style=""><img src="/wp-content/themes/slorebuzz/images/twitter.png"/> Twitter</a>
						<?php endif; ?>
						<?php if($expanded_profile['facebook'] != ''): ?>
							<a href="http://www.facebook.com/<?=$expanded_profile['facebook']?>" class="contact-link"><img src="/wp-content/themes/slorebuzz/images/facebook.png"/> Facebook</a>
						<?php endif;?>
						<? if($expanded_profile['contact-email-address'] != ''): ?>
							<a href="mailto:<?=$expanded_profile['contact-email-address']; ?>" class="contact-link" >
								<img src="/wp-content/themes/slorebuzz/images/email.png" />
								Email
							</a>
						<?endif;?>
					</p>
				</div>
				<? if($expanded_profile['short-profile'] != ''): ?>
					<p><?=nl2br($expanded_profile['short-profile']); ?></p>
				<? endif;?>
				<p><a href="<?=get_author_posts_url(get_the_author_meta('ID'));?>">View Complete Profile</a></p>
				
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
