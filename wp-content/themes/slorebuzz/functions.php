<?
require_once(TEMPLATEPATH . '/lib/settings/db_logins.inc.php');
require_once(TEMPLATEPATH . '/lib/db/DBFactory.inc.php');
require_once(TEMPLATEPATH . '/lib/db/DBRepository.inc.php');
require_once(TEMPLATEPATH . '/lib/db/QueryBuilder.inc.php');

require_once(TEMPLATEPATH . '/lib/mls/ParseLogic.inc.php');

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;


add_filter('excerpt_more', '_slore_excerpt_more');

function _slore_excerpt_more($mo)
{
	global $post;
	return '<br/><a href="'. get_permalink($post->ID) . '">Read More &raquo;</a>';
}

if ( function_exists('register_sidebar') )
{
    register_sidebar(array(
		'name'          => 'SidNavSideBar',
		'id'            => 'sidebar-$i',
		'before_widget' => '<div class="sibebar-content %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="main-heading" style="font-size:20px;font-family:Georgia;color:#043d55;margin-left:11px;margin-bottom:7px;margin-right:12px;border-bottom:1px solid #bdb7a0;line-height:27px;">',
		'after_title' => '</h3>',
    ));
}

// [res_query bed="3" bath="2" cost="200000" city="San Luis Obispo"]
function buzz_ResQuery( $atts ) {
   extract ( shortcode_atts( array(
      'bed' => 0,
      'bath' => 0,
      'cost' => 0,
      'city' => 'San Luis Obispo'
   ), $atts ) );

   $mdl = new ResidentialModel();
   $listings = $mdl->HomeSearch($bed, $bath, $cost, $city);
   $str = '';

   foreach ($listings as $home) {
      $str .= "\n<div><h3>{$home['num_bedrooms']}BR / " .
         "{$home['num_bathrooms']}Bath" . "</h3>";

      $str .= "<h4>$" . number_format($home['listing_price']) . '</h4>';

      $str .= "<h4>" . number_format($home['sq_footage']) . ' sqFt. / ' .
         $home['story_type_lvl'];
      if ($home['year_built'])
         $str .= ' / built ' . $home['year_built'];
      $str .= '</h4>';

      $str .= "<p>" . nl2br(htmlspecialchars($home['marketing_remarks'])) . '</p>';

      if ($home['virtual_tour_url']) {
         $url = htmlspecialchars($home['virtual_tour_url']);
         $str .= "\n<p><a href=\"$url\">Virtual Tour" .
            '</a></p>';
      }

      if ($home['pictures_count'] > 0) {
         $str .= "\n<div style=\"float: left; width: 49%;\">";
         $str .= "<a href=\"\">";
         $str .= "<img src=\"/images-mls/{$home['ml_id']}.jpg\" alt=\"\" style=\"width: 100%;\" />";
         $str .= "</a></div>";
      }

      if ($home['show_addr_to_public'] == 'Y') {
         $str .= "\n<div style=\"float: right; width: 50%;\">";
         $str .= "\n<h4>Address</h4>";
         $str .= '<p>' . $home['street_num'] . ' ' .
            $home['street_direction'] . ' ' .
            $home['street_name'] . ' ' .
            $home['street_suffix'];

         if ($home['unit'])
            $str .= ' Unit ' . $home['unit'];

         $str .= '<br/>' . $home['city'] . ' ' . $home['state'] . ' ' .
            $home['zip'];
         $str .= "\n</p></div>";
      }

      $str .= "\n<p>Contact {$home['agent_name']} of {$home['office_name']} at {$home['listing_office_phone']}.</p>";

      $str .= "\n</div><hr style=\"clear: both; color: #666; background-color: #666; border-top: 1px dashed #666; width: 80%;\" />";
   }

   return $str;
}

add_shortcode( 'res_query', 'buzz_ResQuery');
