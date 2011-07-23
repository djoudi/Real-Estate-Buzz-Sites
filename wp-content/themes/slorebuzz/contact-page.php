<?php
/*Template Name: Contact Template*/

get_header(); ?>

		
			
			<div id="leader-board">
				<? get_template_part('adspot','leader'); ?>
			</div>
			
		<div id="container">
			<div id="content" role="main">
				<div id="content-inner">
				<?php
					get_template_part( 'loop', 'page' );
				?>
				<?
					global $show_message;
					
					if($show_message):
				?>
				<p style="background-color: #FFFFE0;border:1px solid #E6DB55;padding:10px;margin-bottom:15px;border-radius:3px;">Your Message has been sent. Thank you for contacting us!</p>
				<?endif;?>
				<form action="/contact/" method="post">
				<p><label>Your Name</label><input type="text" name="_form_name" value="" /></p>
				<p><label>Email</label><input type="text" name="_form_email" value="" /></p>
				<p><label>Message</label><textarea rows="5" cols="35" name="_form_message"></textarea></p>
				<p><label>&nbsp;</label><input type="checkbox" name="_form_emaillist" value="yes" checked="checked"  /> Yes I would like to be added to the weekly newsletter list.</p>
				<p><label>&nbsp;</label><input type="submit" name="_form_submit" value="Submit"/></p>
				<input type="hidden" name="send-form-trigger" value="true" />
				</form>
				
				</div><!-- #content-inner -->
				
				
				
				<div id="content-footer">&nbsp;</div>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>