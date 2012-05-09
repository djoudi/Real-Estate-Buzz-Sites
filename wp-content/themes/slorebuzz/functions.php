<?
require_once(TEMPLATEPATH . '/lib/settings/db_logins.inc.php');
require_once(TEMPLATEPATH . '/lib/db/DBFactory.inc.php');
require_once(TEMPLATEPATH . '/lib/db/DBRepository.inc.php');
require_once(TEMPLATEPATH . '/lib/db/QueryBuilder.inc.php');

require_once(TEMPLATEPATH . '/lib/mls/ParseLogic.inc.php');
require_once(TEMPLATEPATH . '/lib/mls/MLS_views.inc.php');

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

// [mls_residential_list bed="3" bath="2" price="400000" city="San Luis Obispo"]
/**
 * Query our MLS listings for given attributes.
 *
 * @param array   An associative array, passed in from a shortcode, which may
 *                contain any of the following. Any not present will be
 *                ignored.
 *                At least one must be present.
 *
 *                'bed' - min # of bedrooms in the listing
 *                'bath' - min # of bathrooms
 *                'sq_ft' - min # of square feet
 *
 *                'price' - approximate price of the listing, +/- 10%
 *                'price_min' - minimum price
 *                'price_max' - maximum price
 *
 *                'city' - city it appears in
 *                'zip' - zip it resides in
 *
 * @return string HTML result of the listings, which WP includes in place
 *                of the shortcode tag.
 **/
function buzz_ResQuery( $atts ) {
   $params = shortcode_atts( array(
      'bed' => 0,
      'bath' => 0,
      'price' => 0,
      'price_min' => 0,
      'price_max' => 0,
      'city' => 'San Luis Obispo',
      'zip' => null
   ), $atts );

   $mdl = new ResidentialModel();
   $view = new MLSResidentialView();

   $listings = $mdl->HomeSearch($params);
   $str = $view->ListResults($listings);

   return $str;
}

add_shortcode( 'mls_residential_list', 'buzz_ResQuery');
