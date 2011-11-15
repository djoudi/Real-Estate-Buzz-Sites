<div id="sidebar">
	
	<div id="search-box">
		<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
			<div><label class="screen-reader-text" for="s">Search for:</label>
				<input type="text" value="" name="s" id="s" class="input-text" />
				<input type="image" src="/wp-content/themes/slorebuzz/images/search_go.jpg" id="searchsubmit" value="Search" style="vertical-align:middle;" />
			</div>
		</form>
		<div class="sb-footer"></div>
	</div>
	
	<div id="google-widget">
		<div id="recc-text">Recomend Us on Google</div>
		<g:plusone href="<?=site_url();?>"></g:plusone>
	</div>
	
	<div class="add-unit">
	<script type="text/javascript"><!--
		google_ad_client = "ca-pub-5432668712223216";
		/* SLORE Side */
		google_ad_slot = "5640299085";
		google_ad_width = 300;
		google_ad_height = 250;
		//-->
	</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
	</div>
	
	<div id="sidebar-main">
		<div class="sibebar-content">
				<h3 class="main-heading" style="font-size:20px;font-family:Georgia;color:#043d55;margin-left:11px;margin-bottom:7px;margin-right:12px;border-bottom:1px solid #bdb7a0;line-height:27px;">
					Thank You for Visiting!
				</h3>
				
				<div class="" style="margin:0px 12px;">
					<p>We are really glad that you are here, and we want to make your visit as clean and smooth as possible. If you have any comments or suggestions please feel free to <a href="/contact">contact us</a> and let us know.<br/><strong>Come Back Soon!</strong></p>
				</div>
		
		</div>
		
		<?php if ( !dynamic_sidebar('SidNavSideBar') ) : ?>
		<?php endif; ?>
		
		<div class="sb-footer"></div>
	</div>

</div>