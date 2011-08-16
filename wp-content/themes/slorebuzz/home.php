<?php get_header(); ?>

		
			
			<div id="leader-board" style="overflow:hidden;">
					<? get_template_part('adspot','leader'); ?>
			</div>
			
		<div id="container">
			<div id="content" role="main">
				<div id="content-inner">
				<!-- Home Page Special -->
				<div id="featured-block" style="overflow:hidden;margin-bottom:7px;">
					<div id="main-featured-post" style="float:left;height:280px;width:634px;background:#000;margin-right:15px;position:relative;">
						<img src="/images-main/introwelcome.jpg"/>
						<span style="display:block;text-align:right;background:#990000;font-size:18px;Font-family:Georgia;color:#FFF;position:absolute;top:170px;right:0px;padding:7px 10px;font-weight:bold;">Welcome to San Luis Real Estate Buzz</span>
						<span style="display:block;text-align:right;background:rgba(0, 0, 0, 0.7);font-size:12px;Font-family:Georgia;color:#FFF;position:absolute;bottom:20px;right:0px;padding:7px 10px;">We have just launched a new type of real estate site that is dedicated to helping you become informed.<br/><a href="/about" style="color:#FFF;">Read More &raquo;</a></span>
						
					</div>
					<? /*
					--- SAVE THESE FOR LATER
					<h2 style="font-size:22px;margin-bottom:10px;">Top Headlines</h2>
					<h3 style="margin-bottom:0.7em;"><a href="#">Title Goes Here</a></h3>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit <br/><a href="#">Read More &raquo;</a></p>
					<h3 style="margin-bottom:0.7em;"><a href="#">Title Goes Here</a></h3>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit <br/><a href="#">Read More &raquo;</a></p>
					<h3 style="margin-bottom:0.7em;"><a href="#">Title Goes Here</a></h3>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit <br/><a href="#">Read More &raquo;</a></p>*/?>
				</div>
				<div class="main-heading-wrapper" style="display:block;height:67px;background:url(/wp-content/themes/slorebuzz/images/banner_left.png) no-repeat top left;margin-left:-18px;">
				<h2 class="main-heading" style="margin-bottom:0px;display:block;height:67px;background:url(/wp-content/themes/slorebuzz/images/banner_right.jpg) no-repeat top right;padding-right:16px;float:left;font-size:32px;line-height:54px;font-family:Georgia;color:#043d55;">
					<span style="float:left;height:67px;background:url(/wp-content/themes/slorebuzz/images/banner_bg.png) repeat-x top left;margin-left:12px;">Latest News</span>
				</h2>
				</div>
				
				<?php
					get_template_part( 'loop', 'home' );
				?>
				</div><!-- #content-inner -->
				<div id="content-footer">&nbsp;</div>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
