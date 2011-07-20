<?php get_header();  
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$expandedProfile = get_user_meta($curauth->ID, '_slore_expanded_profile', true);
?>
			<div id="leader-board">
				<? get_template_part('adspot','leader'); ?>
			</div>
			
		<div id="container">
			<div id="content" role="main">
				<div id="content-inner">
				
				<h1><?=$curauth->display_name; ?></h1>
				<?if(isset($expandedProfile['company']) && $expandedProfile['company'] != ''):?><div class="profile-company"><a href="<?=$curauth->user_url;?>" target="_blank" rel="nofollow"><?=$expandedProfile['company']?></a></div><?endif;?>
				<div class="profile-image"></div>
				
				<div class="profile-contact">
					<p style="margin-bottom:7px;">
						<a href="#" style="text-decoration:none;margin-right:7px;"><img src="/wp-content/themes/slorebuzz/images/twitter.png" style="vertical-align:middle;"/> Twitter</a>
						<a href="#" style="text-decoration:none;margin-right:7px;"><img src="/wp-content/themes/slorebuzz/images/facebook.png" style="vertical-align:middle;"/> Facebook</a>
						<a href="#" style="text-decoration:none;margin-right:7px;"><img src="/wp-content/themes/slorebuzz/images/email.png" style="vertical-align:middle;"/> Email</a>
					</p>
					<? if(isset($expandedProfile['phone']) && $expandedProfile['phone'] != ''): ?><p><label>Phone Number:</label> <strong class="proflie-phone"><?=$expandedProfile['phone']; ?></strong></p><?endif;?>
					<? if(isset($expandedProfile['cell']) && $expandedProfile['cell'] != ''): ?><p><label>Cell Phone Number:</label> <strong><?=$expandedProfile['cell']; ?></strong></p><?endif;?>
					<? if(isset($expandedProfile['fax']) && $expandedProfile['fax'] != ''): ?><p><label>Fax Number:</label> <strong><?=$expandedProfile['fax']; ?></strong></p><?endif;?>
				</div>
				
				<div class="profile-description">
					<?=wpautop($curauth->description); ?>
				</div>
				<pre><? print_r($curauth); ?></pre>
				<div class="main-heading-wrapper" style="display:block;height:67px;background:url(/wp-content/themes/slorebuzz/images/banner_left.png) no-repeat top left;margin-left:-18px;">
				<h2 class="main-heading" style="margin-bottom:0px;display:block;height:67px;background:url(/wp-content/themes/slorebuzz/images/banner_right.jpg) no-repeat top right;padding-right:16px;float:left;font-size:24px;line-height:54px;font-family:Georgia;color:#043d55;">
					<span style="float:left;height:67px;background:url(/wp-content/themes/slorebuzz/images/banner_bg.png) repeat-x top left;margin-left:12px;"><?=$curauth->display_name; ?>&rsquo;s Articles</span>
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