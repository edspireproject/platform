<?php 

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'rel_canonical');

// disable the admin bar
add_filter( 'show_admin_bar', '__return_false' );

// post-thumbnail support
add_theme_support( 'post-thumbnails' );

// search fields
global $field_names, $field_qargs, $field_options, $field_meta_key;
$field_names = array(
	"freetext" => "Freetext",
	"subject" => "Subject",
	"style" => "Learning style", // I don't want to use this, see: http://steinhardtapps.es.its.nyu.edu/create/courses/2174/reading/Pashler_et_al_PSPI_9_3.pdf
	"price" => "Price",
	"language" => "Language",
	"availability" => "Available",
	"platform" => "Platform",
	"university" => "University",
	"teacher" => "Teacher",
	"provider" => "Provider",
	"echelon" => "Level",
);

$field_args = array(
	"freetext" => "s-ft",
	"subject" => "s-ps",
	"style" => "s-s", // I don't want to use this, see: http://steinhardtapps.es.its.nyu.edu/create/courses/2174/reading/Pashler_et_al_PSPI_9_3.pdf
	"price" => "s-c",
	"language" => "s-l",
	"availability" => "s-a",
	"platform" => "s-m",
	"university" => "s-u",
	"teacher" => "s-t",
	"provider" => "s-v",
	"echelon" => "s-e",
);

$field_meta_key = array(
	"freetext" => "",
	"subject" => "",
	"style" => "style", // I don't want to use this, see: http://steinhardtapps.es.its.nyu.edu/create/courses/2174/reading/Pashler_et_al_PSPI_9_3.pdf
	"price" => "",
	"language" => "language",
	"availability" => "",
	"platform" => "platform",
	"university" => "university",
	"teacher" => "teacher",
	"provider" => "provider",
	"echelon" => "echelon",
);

global $style_grid, $style_singular, $style_plural, $style_format;
$style_grid = array(
		"blended" => array(
				"course",
				"mooc",
				"tutorial",
				"presentation",
		),
		"video" => array(
				"video-lecture-series",
				"video-lecture",
				"short-video",
				"bitesize-video",
		),
		"text" => array(
				"course-outline",
				"reading-list",
				"study-notes",
				"fact-sheet",
		),
);
$style_format = array(
		"course" => "blended",
		"mooc" => "blended",
		"tutorial" => "blended",
		"presentation" => "blended",
		"video-lecture-series" => "video",
		"video-lecture" => "video",
		"short-video" => "video",
		"bitesize-video" => "video",
		"course-outline" => "text",
		"reading-list" => "text",
		"study-notes" => "text",
		"fact-sheet" => "text",
);

$style_singular = array(
		"course" => "Course",
		"mooc" => "MOOC",
		"tutorial" => "Tutorial",
		"presentation" => "Presentation",
		"video-lecture-series" => "Lecture series",
		"video-lecture" => "Single lecture",
		"short-video" => "Short film",
		"bitesize-video" => "Bitesize",
		"course-outline" => "Course outline",
		"reading-list" => "Reading list",
		"study-notes" => "Study notes",
		"fact-sheet" => "Fact sheet",
);
$style_plural = array(
		"course" => "Courses",
		"mooc" => "MOOCs",
		"tutorial" => "Tutorials",
		"presentation" => "Presentations",
		"video-lecture-series" => "Lecture series",
		"video-lecture" => "Single lectures",
		"short-video" => "Short films",
		"bitesize-video" => "Bitesize",
		"course-outline" => "Course outlines",
		"reading-list" => "Reading lists",
		"study-notes" => "Study notes",
		"fact-sheet" => "Fact sheets",
);
$style_meta = array(
		"course" => "online course",
		"mooc" => "MOOC",
		"tutorial" => "tutorial",
		"presentation" => "presentation",
		"video-lecture-series" => "video lecture series",
		"video-lecture" => "video lecture",
		"short-video" => "short film",
		"bitesize-video" => "bitesize video",
		"course-outline" => "course outline",
		"reading-list" => "reading list",
		"study-notes" => "study notes",
		"fact-sheet" => "fact sheet",
);

global $subject_grid, $subject_singular;
$subject_grid = array(
		"humanities" => array(
				"history",
				"linguistics",
				"literature",
				"theatre-music-dance",
				"philosophy",
				"religion",
				"archaeology",
				"anthropology",
		),
		"social-sciences" => array(
				"geography",
				"military",
				"environment",
				"politics",
				"psychology",
				"sociology",
				"cultural-ethnic-studies",
				"gender-sexuality",
				"library-museum-studies",
		),
		"professional" => array(
				"agriculture",
				"business",
				"education",
				"economics",
				"transportation",
				"journalism-media",
				"law",
				"finance-accountancy",
		),
		"science" => array(
				"architecture-design",
				"chemistry",
				"biology",
				"physics",
				"computing",
				"mathematics",
				"statistics",
				"earth-sciences",
				"space-astronomy",
				"engineering",
		),
		"lifestyle" => array(
				"cooking",
				"sport",
				"health",
				"arts-crafts",
				"hobbies",
		)
);
$subject_singular = array(
		"history" => "History",
		"linguistics" => "Linguistics",
		"literature" => "Literature",
		"theatre-music-dance" => "Theatre, music &amp; dance",
		"philosophy" => "Philosophy",
		"religion" => "Religion",
		"archaeology" => "Archaeology",
		"anthropology" => "Anthropology",
		"geography" => "Geography",
		"military" => "Military",
		"environment" => "Environment",
		"politics" => "Politics",
		"psychology" => "Psychology",
		"sociology" => "Sociology",
		"cultural-ethnic-studies" => "Cultural &amp; ethnic studies",
		"gender-sexuality" => "Gender & sexuality",
		"library-museum-studies" => "Library &amp; museum studies",
		"agriculture" => "Agriculture",
		"business" => "Business",
		"education" => "Education",
		"economics" => "Economics",
		"transportation" => "Transportation",
		"journalism-media" => "Journalism &amp; media",
		"law" => "Law",
		"finance-accountancy" => "Finance &amp; Accountancy",
		"architecture-design" => "Architecture and design",
		"chemistry" => "Chemistry",
		"biology" => "Biology",
		"physics" => "Physics",
		"computing" => "Computing",
		"mathematics" => "Mathematics",
		"statistics" => "Statistics",
		"earth-sciences" => "Earth sciences",
		"space-astronomy" => "Space &amp; astronomy",
		"engineering" => "Engineering",
		"cooking" => "Cooking",
		"sport" => "Sport",
		"health" => "Health",
		"arts-crafts" => "Arts and crafts",
		"hobbies" => "Hobbies",
);

$subject_short = array(
		"history" => "History",
		"linguistics" => "Linguistics",
		"literature" => "Literature",
		"theatre-music-dance" => "Theatre/music/dance",
		"philosophy" => "Philosophy",
		"religion" => "Religion",
		"archaeology" => "Archaeology",
		"anthropology" => "Anthropology",
		"geography" => "Geography",
		"military" => "Military",
		"environment" => "Environment",
		"politics" => "Politics",
		"psychology" => "Psychology",
		"sociology" => "Sociology",
		"cultural-ethnic-studies" => "Cultural/ethnic",
		"gender-sexuality" => "Gender & sexuality",
		"library-museum-studies" => "Library/museums",
		"agriculture" => "Agriculture",
		"business" => "Business",
		"education" => "Education",
		"economics" => "Economics",
		"transportation" => "Transportation",
		"journalism-media" => "Journalism &amp; media",
		"law" => "Law",
		"finance-accountancy" => "Finance/Accountancy",
		"architecture-design" => "Architecture/design",
		"chemistry" => "Chemistry",
		"biology" => "Biology",
		"physics" => "Physics",
		"computing" => "Computing",
		"mathematics" => "Mathematics",
		"statistics" => "Statistics",
		"earth-sciences" => "Earth sciences",
		"space-astronomy" => "Space/astronomy",
		"engineering" => "Engineering",
		"cooking" => "Cooking",
		"sport" => "Sport",
		"health" => "Health",
		"arts-crafts" => "Arts &amp; crafts",
		"hobbies" => "Hobbies",
);

global $subject_banner_licence, $subject_banner_credit, $subject_banner_link;

$subject_banner_licence = array(
		"humanities" => "",
		"history" => "",
		"linguistics" => "",
		"literature" => "",
		"theatre-music-dance" => "",
		"philosophy" => "",
		"religion" => "",
		"archaeology" => "",
		"anthropology" => "",
		"social-sciences" => "",
		"geography" => "",
		"military" => "",
		"environment" => "",
		"politics" => "",
		"psychology" => "",
		"sociology" => "",
		"cultural-ethnic-studies" => "",
		"gender-sexuality" => "",
		"library-museum-studies" => "",
		"professional" => "",
		"agriculture" => "",
		"business" => "",
		"education" => "",
		"economics" => "",
		"transportation" => "",
		"journalism-media" => "",
		"law" => "",
		"finance-accountancy" => "",
		"science" => "",
		"architecture-design" => "",
		"chemistry" => "",
		"biology" => "",
		"physics" => "",
		"computing" => "",
		"mathematics" => "",
		"statistics" => "",
		"earth-sciences" => "",
		"space-astronomy" => "",
		"engineering" => "",
		"lifestyle" => "",
		"cooking" => "",
		"sport" => "",
		"health" => "",
		"arts-crafts" => "",
		"hobbies" => "",
);

$subject_banner_credit = array(
		"humanities" => "",
		"history" => "",
		"linguistics" => "",
		"literature" => "",
		"theatre-music-dance" => "",
		"philosophy" => "",
		"religion" => "",
		"archaeology" => "",
		"anthropology" => "",
		"social-sciences" => "",
		"geography" => "",
		"military" => "",
		"environment" => "",
		"politics" => "",
		"psychology" => "",
		"sociology" => "",
		"cultural-ethnic-studies" => "",
		"gender-sexuality" => "",
		"library-museum-studies" => "",
		"professional" => "",
		"agriculture" => "",
		"business" => "",
		"education" => "",
		"economics" => "",
		"transportation" => "",
		"journalism-media" => "",
		"law" => "",
		"finance-accountancy" => "",
		"science" => "",
		"architecture-design" => "",
		"chemistry" => "",
		"biology" => "",
		"physics" => "",
		"computing" => "",
		"mathematics" => "",
		"statistics" => "",
		"earth-sciences" => "",
		"space-astronomy" => "",
		"engineering" => "",
		"lifestyle" => "",
		"cooking" => "",
		"sport" => "",
		"health" => "",
		"arts-crafts" => "",
		"hobbies" => "",
);

$subject_banner_link = array(
		"humanities" => "",
		"history" => "",
		"linguistics" => "",
		"literature" => "",
		"theatre-music-dance" => "",
		"philosophy" => "",
		"religion" => "",
		"archaeology" => "",
		"anthropology" => "",
		"social-sciences" => "",
		"geography" => "",
		"military" => "",
		"environment" => "",
		"politics" => "",
		"psychology" => "",
		"sociology" => "",
		"cultural-ethnic-studies" => "",
		"gender-sexuality" => "",
		"library-museum-studies" => "",
		"professional" => "",
		"agriculture" => "",
		"business" => "",
		"education" => "",
		"economics" => "",
		"transportation" => "",
		"journalism-media" => "",
		"law" => "",
		"finance-accountancy" => "",
		"science" => "",
		"architecture-design" => "",
		"chemistry" => "",
		"biology" => "",
		"physics" => "",
		"computing" => "",
		"mathematics" => "",
		"statistics" => "",
		"earth-sciences" => "",
		"space-astronomy" => "",
		"engineering" => "",
		"lifestyle" => "",
		"cooking" => "",
		"sport" => "",
		"health" => "",
		"arts-crafts" => "",
		"hobbies" => "",
);

$subject_all = $subject_singular;
$subject_all["humanities"] = "Arts/Humanities";
$subject_all["social-sciences"] = "Social sciences";
$subject_all["professional"] = "Business/Professional";
$subject_all["science"] = "Science/Technology";
$subject_all["lifestyle"] = "Lifestyle";

global $price_labels, $availability_labels;
$price_labels = array(
		"1" => "Free",
		"2" => "Up to $50",
		"3" => "More than $50",
		"4" => "Subscription"
);

$availability_labels = array(
		"1" => "On demand",
		"2" => "Recently",
		"3" => "Starting soon",
		"4" => "Upcoming",
		"5" => "In the future",
		"6" => "In the past");

$field_options = array(
		"freetext" => "",
		"subject" => $subject_singular,
		"style" => $style_singular,
		"price" => $price_labels,
		"language" => "multi",
		"availability" => $availability_labels,
		"platform" => "",
		"university" => "",
		"teacher" => "",
		"provider" => "",
		"echelon" => "",
);

// allow custom querystring variables
add_filter('query_vars', 'edspire_queryvars' );

function edspire_queryvars( $qvars ) {
	global $field_args;
	// Current
	foreach($field_args as $key => $value) {
		$qvars[] = $value;
	}

	$qvars[] = 's-id';
	$qvars[] = 'pth';	
	$qvars[] = 'unset';
	$qvars[] = 'mnth';
	$qvars[] = 'yr';
	$qvars[] = 'wizard_id';
	$qvars[] = 'profile_id';
	$qvars[] = 'sitemap';
	
	// TODO explicitly sanitize the vars against a whitelist instead of relying on resulting no-op in search function
	foreach($_GET as $query_string_variable => $value) {
		if(substr($query_string_variable, 0, 5) === 'wpcf-' ) {
			$qvars[] = $query_string_variable;
		} elseif(substr($query_string_variable, 0, 5) === 'crfp-' ) {
			$qvars[] = $query_string_variable;
		}
	}
	$qvars[] = 'use-wpcf';
	$qvars[] = 'meta-sort';
	
	return $qvars;
}

// return up to 40 words in the excerpt
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_length() {
	global $customLength;
	if($customLength) {
		return $customLength;
	} else {
		return 40;
	}
}

// remove incorrect semantic markup from post classes
function add_post_class($classes) {
	if (($key = array_search('hentry', $classes)) !== false) {
		unset($classes[$key]);
	}
	return $classes;
}
add_filter('post_class', 'add_post_class');

// format the "read more" link for excerpts 
add_filter('excerpt_more', 'new_excerpt_more');

function new_excerpt_more($more) {
	if(is_home())
		return '&hellip; <a class="heavier" href="' . get_permalink().'">[read more]</a>';
	else
		return '&hellip; <a class="heavier" href="' . get_permalink().'">[full details]</a>';
}

/**
 * Remove the text - 'You may use these <abbr title="HyperText Markup
 * Language">HTML</abbr> tags ...'
 * from below the comment entry box.
 */

add_filter('comment_form_defaults', 'remove_comment_styling_prompt');

function remove_comment_styling_prompt($defaults) {
	$defaults['comment_notes_after'] = '';
	return $defaults;
}


// redirect users to /profile after they register / login
add_filter( 'registration_redirect', 'le_registration_redirect' );
add_filter( 'login_redirect', 'le_registration_redirect' );

function le_registration_redirect()
{
	return home_url( '/profile/' );
}

// to show author as vcard

if ( ! function_exists( 'show_posted_on' ) ) :

	function show_posted_on( $gplus = '' ) {
		if($gplus == '')
			$gplus = '<span class="author vcard"><span class="fn">' . get_the_author() . '</span></span>';
		else
			$gplus = '<a rel="author" href="https://plus.google.com/u/0/' . $gplus . '?rel=author" class="author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name" class="fn">' . get_the_author() . '</span></a>';
		printf( __( '<div class="post-meta"><time class="entry-date" itemprop="datePublished" datetime="%1$s">%2$s</time> by %3$s</div>', 'learningengineone' ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		$gplus
		);
	}
	
endif;

// hook add_rewrite_rules function into rewrite_rules_array to map custom URLs for SEO
add_filter('rewrite_rules_array', 'add_rewrite_rules');

function add_rewrite_rules($aRules) {
	$aNewRules = array( 
			'search/(.+)/page/?([0-9]{1,})/?$' => 'index.php?pagename=search&s-ft=$matches[1]&paged=$matches[2]',
			'search/page/?([0-9]{1,})/?$' => 'index.php?pagename=search&paged=$matches[1]',
			'blog/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&orderby=date&order=DESC&paged=$matches[1]',
			'blog/?$' => 'index.php?post_type=post&orderby=date&order=DESC&paged=',
			'search/(.+)/?$' => 'index.php?pagename=search&s-ft=$matches[1]',
			'discover/(.+)/?$' => 'index.php?pagename=discover&pth=$matches[1]',
			'superuser/?([0-9]{1,})/?$' => 'index.php?pagename=superuser&s-id=$matches[1]',
			'superuser/(.+)/?$' => 'index.php?pagename=superuser&s-ft=$matches[1]',
			'teacher/(.+)/?$' => 'index.php?pagename=$matches[1]',
			'profile/([^/]+)/?$' => 'index.php?pagename=profile&profile_id=$matches[1]',
			'wizard/(\d*)/?$' => 'index.php?pagename=search&wizard_id=$matches[1]',
			'wizard/(\d*)/page/?([0-9]{1,})/?$' => 'index.php?pagename=search&wizard_id=$matches[1]&paged=$matches[2]',
			'calendar/(\d*)/(\d*)/?$' => 'index.php?pagename=calendar&yr=$matches[1]&mnth=$matches[2]',
			'url/([^/]+)/([^/]+)/?$' => 'index.php?pagename=url&code=$matches[1]&url=$matches[2]',
			'sitemap(.*)\.xml$' => 'index.php?pagename=sitemap&sitemap=$matches[1]',
			'([a-zA-Z0-9-]+)/' . ed_styles_match() . '/?$' => 'index.php?name=$matches[1]&paged=&s-s=$matches[2]',
			'([a-zA-Z0-9-]+)/' . ed_styles_match() . '/page/?([0-9]{1,})/?$' => 'index.php?name=$matches[1]&paged=$matches[3]&s-s=$matches[2]',
			'([a-zA-Z0-9-]+)/page/?([0-9]{1,})/?$' => 'index.php?name=$matches[1]&paged=$matches[2]&s-s=all',
	);
	$aRules = $aNewRules + $aRules;
	return $aRules;
}

// Cancel the shortlink feature
add_filter('get_shortlink','ed_get_shortlink');

function ed_get_shortlink($shortlink, $id, $context, $allow_slugs) {
	return '';
}

// Alter the canonical
add_action( 'wp_head', 'ed_rel_canonical' );

function ed_rel_canonical() {
	
	global $post, $override_canonical;
	if($override_canonical) {
		$link = $override_canonical;
	} elseif($post->post_type == 'resource') {
		$link = get_permalink($post);
	} else {
		$qargs = ed_query_args();
		
		$link = ed_canonical( $qargs['paged'], $qargs );
	}
	
	// do not index /search
	if(strpos($link, '/search/') === 0)
		echo '<meta name="robots" content="noindex">';
	
	echo "<link rel='canonical' href='$link' />\n";
}

// handle user's locale
function ed_locale() {
	
	if($_SESSION['locale'])
		return $_SESSION['locale'];
	else
		return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
}

// handle 301 redirection to canonical URLs
add_filter('redirect_canonical', 'ed_redirect_canonical');

function ed_redirect_canonical($redirect_url, $requested_url = '')
{
	if( get_query_var('pagename') == 'url' )
		return false;

	if( get_query_var('pagename') == 'redirect' )
		return false;
	
	// Cancel the redirection for our sitemap
	$sitemap = get_query_var('sitemap');
	if (!empty($sitemap))
		return false;

	$qargs = ed_query_args('name');
	
	$link = site_url() . ed_canonical( $qargs['paged'], $qargs );
	
	return $link;
}

// send mail from a different email address than wp default
add_filter( 'wp_mail_from', 'le_wp_mail_from' );

function le_wp_mail_from( $email_address )
{
	return 'website@edspire.com';
}

// send mail from a different name than wp default 
add_filter( 'wp_mail_from_name', 'le_wp_mail_from_name' );

function le_wp_mail_from_name( $email_from )
{
	return 'edspire';
}

// to serve CSS etc. from the right place
function get_themeroot() {
	//return str_replace( 'http://edspire.int', 'http://md.muko.co', get_bloginfo('stylesheet_directory') );
	return str_replace( 'http://edspire.com', WP_HOME, get_bloginfo('stylesheet_directory') );
}

// Handy to have as a function because you may use this a lot.
// The important logic here is: Dnt can be on (1), off (0), or
// unset. You want to make sure you account for unset so you do
// not de-reference a null pointer somewhere in your code.
// returns TRUE if Dnt is on and is equal to 1,
// returns FALSE if Dnt is unset or not equal to 1.
function get_dnt_status() {
	db_log('dnt', isset($_SERVER['HTTP_DNT']) ? ($_SERVER['HTTP_DNT'] == 1 ? 'DNT' : 'TRACK') : 'UNSET' );
	return (isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == 1);
}

// log message to the database
function db_log($table, $message) {
	global $wpdb;
	$wpdb->insert(
			$wpdb->prefix . $table . '_log',
			array(
					'message' => $message,
					'ip' => $_SERVER["REMOTE_ADDR"],
					'user_id' => is_user_logged_in() ? wp_get_current_user()->ID : 0
			),
			array('%s','%s','%d')
	);
}

// write the javascript to send AB testing info to Google analytics
function write_ab_vars() {
	// extension point for 3rd party integration of AB testing
}

// write metas
function write_metas() {
	
	if(is_home()):
		echo '<meta name="description" content="edspire is a search engine for online educational resources such as MOOCs, courseware, tutorials, videos, books, screencasts and podcasts."/>';
	else:
		global $post;
		if($post->post_type == "resource"):
			global $style_meta, $subject_singular;

			$cost_cur = strval(get_post_meta($post->ID, 'wpcf-cost-cur', true));
			$cost_val = strval(get_post_meta($post->ID, 'wpcf-cost-val', true));
			$cost_sub = strval(get_post_meta($post->ID, 'wpcf-cost-sub', true));

			$duration = strval(get_post_meta($post->ID, 'wpcf-duration', true));
			$length = get_post_meta($post->ID, 'wpcf-video-length', true);
			
			$workload = strval(get_post_meta($post->ID, 'wpcf-workload', true));
			$workload_min = strval(get_post_meta($post->ID, 'wpcf-workload-min', true));
			$workload_max = strval(get_post_meta($post->ID, 'wpcf-workload-max', true));

			$next_start = strval(get_post_meta($post->ID, 'wpcf-next-start', true));
			$schedule = strval(get_post_meta($post->ID, 'wpcf-schedule', true));
			
			$subject = $subject_singular[strval(get_post_meta($post->ID, 'edspire-primary-subject', true))];
			$style = $style_meta[strval(get_post_meta($post->ID, 'edspire-style', true))];
			$provider = get_post_meta($post->ID, 'wpcf-provider', true);
			$university = strval(get_post_meta($post->ID, 'wpcf-university', true));
				
			$meta = '<meta name="description" content="';
			if($duration)
				$meta .= str_replace('weeks', 'week', $duration) . ' ';
			elseif($length)
				$meta .= $length . ' ';
			$meta .= $subject . ' ' . $style . ' from ' . $provider;
			if($university && $university != $provider)
				$meta .= ' and ' . $university;
			$taught = "taught";
			if($style == 'video')
				$taught = "presented";
			$teachers = get_post_meta($post->ID, 'wpcf-teacher', false);
			if( $teachers ) {
				$meta .= '; ' . $taught . ' by ';
				$comma = false;
				foreach ( $teachers as $key => $teacher ) {
					$meta .= ($comma ? ', ' : '')  . $teacher;
					$comma = true;
				}
			}
			$meta .= format_meta_start( $schedule, $next_start );
			$meta .= format_meta_workload( $workload, $workload_min, $workload_max );
			$meta .= '. ' . format_cost( $cost_cur, $cost_val, $cost_sub ) . '." />';
			echo $meta;
		endif;
	endif;
	
}

// remove comments feed
function remove_comments_rss( $for_comments ) {
	return;
}
add_filter('post_comments_feed_link','remove_comments_rss');

// register custom post types
add_action( 'init', 'create_posttype' );
function create_posttype() {
	register_post_type( 'resource',
		array(
			'labels' => array(
				'name' => __( 'Resources' ),
				'singular_name' => __( 'Resource' )
			),
			'public' => true,
			'has_archive' => false,
			'taxonomies' => array(
				'category', 'post_tag'
			),
			'rewrite' => array('slug' => false, 'ep_mask', '/%postname%/', 'pages' => false, 'feeds' => false),
		)
	);
	register_post_type( 'teacher',
		array(
			'labels' => array(
				'name' => __( 'Teachers' ),
				'singular_name' => __( 'Teacher' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'teacher', 'pages' => false, 'feeds' => false),
		)
	);
	register_post_type( 'subject',
		array(
			'labels' => array(
				'name' => __( 'Subjects' ),
				'singular_name' => __( 'Subject' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => false, 'ep_mask', '/%postname%/'),
		)
	);
	register_post_type( 'style',
		array(
			'labels' => array(
				'name' => __( 'Styles' ),
				'singular_name' => __( 'Style' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => false, 'ep_mask', '/%postname%/', 'pages' => false, 'feeds' => false),
		)
	);
}

// Fix slugged URLs
function edspire_remove_cpt_slug( $post_link, $post, $leavename ) {

	if ( 'publish' != $post->post_status || (! ('resource' == $post->post_type || 'subject' == $post->post_type || 'style' == $post->post_type) ) ) {
		return $post_link;
	}

	$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

	return $post_link;
}
add_filter( 'post_type_link', 'edspire_remove_cpt_slug', 10, 3 );

function edspire_parse_request_tricksy( $query ) {

	// SANITIZE ALL INPUTS! No, seriously, sanitize using whitelist and not just with the php fns!
	
	// Only noop the main query
	if ( ! $query->is_main_query() )
		return;

	session_start();

	// convert some querystring params to session vars instead
	// BUT when should we unset these? at the moment it tries to do it on a new search but not on pagination or post
	// and perhaps it should
	global $field_args;
	$fields = array('freetext', 'subject','style','price','platform','availability','university','teacher','provider','echelon');
	$unset = true;
	foreach($fields as $field) :
		if($_POST[$field_args[$field]]) {
			unset( $query->query[$field_args[$field]] );
			$_SESSION[$field] = sanitize_text_field( $_POST[$field_args[$field]] );
			$unset = false;
		}
	endforeach;

	if($_POST['unset']) {
		$unset = false;
		unset( $_SESSION[$_POST['unset']] );
	}
	
	// if it's a paginated request OR it's the filters page
	if(get_query_var("paged") || get_query_var('pagename') == 'filters')
		$unset = false;
	
	// if it's a get for /search/ then don't reset	
	if ($_SERVER['REQUEST_METHOD'] === 'GET' && get_query_var('pagename') == 'search') {
		$unset = false;
	}

	if($unset) {
		foreach($fields as $field) :
			unset( $_SESSION[$field] );
		endforeach;
	}
	
	unset( $query->query['s-ft'] );
	unset( $query->query['s-s'] );
	unset( $query->query['s-ps'] );
	
	// 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
	if ( ! empty( $query->query['name'] ) ) {
		$query->set( 'post_type', array( 'post', 'resource', 'page', 'subject', 'style', 'teacher' ) );
	}
}
add_action( 'pre_get_posts', 'edspire_parse_request_tricksy' );

// parse query args
function ed_query_args() {
	$qargs = array();
	$qargs['paged'] = max( 1, get_query_var('paged') );
	$style = get_query_var('s-s');
	if($style == 'all')
		$style = false;
	$qargs['style'] = $style;
	$qargs['freetext'] = get_query_var('s-ft');
	
	if( get_query_var('s-ps') != '' )
		$qargs['subject'] = get_query_var('s-ps'); 

	if( get_query_var('s-f') != '' )
		$qargs['format'] = get_query_var('s-f');

	if( get_query_var('wizard_id') != '' )
		$qargs['wizard'] = intval(get_query_var('wizard_id'));
		
	$qargs['language'] = substr(ed_locale(), 0, 2);

	session_start();
	
	$fields = array('freetext','price','platform','availability','university','teacher','provider','echelon');
	foreach($fields as $field) :
		if($_SESSION[$field])
			$qargs[$field] = $_SESSION[$field];
	endforeach;
	
	if(get_query_var('unset'))
		unset($qargs[get_query_var('unset')]);
	
	global $post;
	
	$qargs[$post->post_type] = get_query_var('name');
	$qargs['type'] = $post->post_type;
	
	return $qargs;
}

function ed_styles_match() {
	global $style_singular;
	$preg = '';
	foreach( $style_singular as $key => $style ) {
		$preg .= ($preg == '' ? '' : '|') . $key;
	}
	return '(' . $preg . ')';
}

// function to generate grid of resource styles
function ed_style_grid($subject) {
	global $style_grid, $style_singular, $style_plural, $subject_singular;
	$style_counts = get_style_counts($subject);
	foreach( $style_grid as $format => $value ) {
		$local_count = 0;
		foreach( $value as $style )
			$local_count += $style_counts[$style];
		echo '<div class="sg0 ' . $format . '">';
		if($local_count > 0)
			echo '<a href="/search/?s-f=' . $format . '&s-ps=' . $subject . '"><h3>' . ucfirst($format) . ' <span>' . $local_count . '</span></h3></a>';
		else 
			echo '<h3 class="cn0">' . ucfirst($format) . ' <span>none</span></h3>';
		foreach( $value as $style ) {
			if($style_counts[$style] > 0)
				echo '<a title="' . $style_plural[$style] . ' in ' . $subject_singular[$subject] . '" href="/' . $subject . '/' . $style . '/"><h4>' . $style_singular[$style] . ' <span>' . $style_counts[$style] . '</span></h4></a>';
			else
				echo '<h4 class="cn0">' . $style_singular[$style] . ' <span>none</span></h4>';
		}
		echo '</div>';
	}
}

function get_style_counts($subject) {
	global $wpdb, $style_singular;
	$counts = $style_singular;
	foreach( $counts as $key => $value )
		$counts[$key] = 0;
	$sql = "SELECT meta_value, count(distinct post_id) as cnt FROM ed_postmeta where post_id IN (select post_id from ed_postmeta where " . exclude_del() . " meta_key = 'edspire-primary-subject' and meta_value = '" . $subject . "') and meta_key = 'edspire-style' GROUP BY meta_value";
	foreach ( $wpdb->get_results( $sql ) as $count_row )
		$counts[$count_row->meta_value] = $count_row->cnt;
	return $counts;
}

function exclude_del() {
	session_start();
	if($_SESSION['del']) {
		return "post_id NOT IN ( " . implode(',', $_SESSION['del']) . " ) AND ";
	}
}

// function to generate grid of resource subjects
function ed_subject_grid($style) {
	global $subject_grid, $subject_singular, $style_plural;
	$subject_counts = get_subject_counts($style);
	foreach( $subject_grid as $area => $value ) {
		$local_count = 0;
		foreach( $value as $subject )
			$local_count += $subject_counts[$subject];
		echo '<div class="sg1"><h3>' . ucfirst($area) . ' <span>' . $local_count . '</span></h3>';
		foreach( $value as $subject ) {
			if($subject_counts[$subject] > 0)
				echo '<h4><a title="' . $style_plural[$style] . ' in ' . $subject_singular[$subject] . '" href="/' . $subject . '/' . $style . '/">' . $subject_singular[$subject] . '</a> <span>' . $subject_counts[$subject] . '</span></h4>';
			else
				echo '<h4>' . $subject_singular[$subject] . ' <span>none</span></h4>';
		}
		echo '</div>';
	}
} 

function get_subject_counts($style) {
	global $wpdb, $subject_singular;
	$counts = $subject_singular;
	foreach( $counts as $key => $value )
		$counts[$key] = 0;
	$sql = "SELECT meta_value, count(distinct post_id) as cnt FROM ed_postmeta where post_id IN (select post_id from ed_postmeta where meta_key = 'edspire-style' and meta_value = '" . $style . "') and meta_key = 'edspire-primary-subject' GROUP BY meta_value";
	foreach ( $wpdb->get_results( $sql ) as $count_row )
		$counts[$count_row->meta_value] = $count_row->cnt;
	return $counts;
}

// function to generate search results
function ed_query($qargs, $showposts = 15) {

	// 'subject','style','price','platform','availability','university','teacher','provider','echelon')
	$paged = $qargs['paged'];
	$freetext = $qargs['freetext'];
	$subject = $qargs['subject'];
	$format = $qargs['format'];
	$style = $qargs['style'];
	$price = $qargs['price'];
	$platform = $qargs['platform'];
	$availability = $qargs['availability'];
	$university = $qargs['university'];
	$teacher = $qargs['teacher'];
	$provider = $qargs['provider'];
	$echelon = $qargs['echelon'];
	
	$offset = $showposts * ($paged - 1);
	
	$meta = array();
	
	$args = array(
			'post_type' => 'resource',
			'post_status' => 'publish',
			'meta_key' => 'edspire-score',
			'orderby' => 'meta_value_num',
			'order' => 'DESC'
	);
	
	if($showposts > 0) {
		$args['showposts'] = $showposts;
		$args['offset'] = $offset;
	}
	
	// TODO convert to stemmed meta search
	if($freetext)
		$args['s'] = $freetext;
	
	if($subject)
		$meta[] = array(
			'key' => 'edspire-primary-subject',
			'value' => $subject,
			'compare' => '='
		);

	if($format)
		$meta[] = array(
				'key' => 'wpcf-format',
				'value' => $format,
				'compare' => '='
		);
	
	if($style)
		$meta[] = array(
				'key' => 'edspire-style',
				'value' => $style,
				'compare' => '='
		);
	
	if($price) {
		if($price == 1) {
			$meta[] = array(
					'key' => 'wpcf-cost-val',
					'value' => 0,
					'compare' => '=',
					'type' => 'numeric'
			);
		} elseif($price == 2) {
			$meta[] = array(
					'key' => 'wpcf-cost-val',
					'value' => array( 0.01, 50 ),
					'compare' => 'BETWEEN',
					'type' => 'numeric'
			);
		} elseif($price == 3) {
			$meta[] = array(
					'key' => 'wpcf-cost-val',
					'value' => 50,
					'compare' => '>',
					'type' => 'numeric'
			);
		} else {
			$meta[] = array(
					'key' => 'wpcf-cost-sub',
					'value' => 'm',
					'compare' => '='
			);								
		}
	}
	
	if($platform)
		$meta[] = array(
				'key' => 'wpcf-platform',
				'value' => $platform,
				'compare' => '='
		);
	
	if($university)
		$meta[] = array(
				'key' => 'wpcf-university',
				'value' => $university,
				'compare' => '='
		);
	
	if($teacher)
		$meta[] = array(
				'key' => 'wpcf-teacher',
				'value' => $teacher,
				'compare' => '='
		);
	
	if($provider)
		$meta[] = array(
				'key' => 'wpcf-provider',
				'value' => $provider,
				'compare' => '='
		);

	if($availability) {
		if($availability == 1) { // all the time
			$meta[] = array(
					'key' => 'wpcf-schedule',
					'value' => 'a',
					'compare' => '='
			);
		} elseif($availability == 2) { // started in the last 2 weeks
			$meta[] = array(
					'key' => 'wpcf-schedule',
					'value' => 's',
					'compare' => '='
			);
			$meta[] = array(
					'key' => 'wpcf-next-start',
					'value' => date("Y-m-d", time() - (14*60*60*24)),
					'compare' => '>'
			);
			$meta[] = array(
					'key' => 'wpcf-next-start',
					'value' => date("Y-m-d", time() + (60*60*24)),
					'compare' => '<'
			);
		} elseif($availability == 3) { // starting soon
			$meta[] = array(
					'key' => 'wpcf-schedule',
					'value' => 's',
					'compare' => '='
			);
			$meta[] = array(
					'key' => 'wpcf-next-start',
					'value' => date("Y-m-d", time() - (60*60*24)),
					'compare' => '>'
			);
			$meta[] = array(
					'key' => 'wpcf-next-start',
					'value' => date("Y-m-d", time() + (14*60*60*24)),
					'compare' => '<'
			);
		} elseif($availability == 4) { // starting in over two weeks time
			$meta[] = array(
					'key' => 'wpcf-schedule',
					'value' => 's',
					'compare' => '='
			);
			$meta[] = array(
					'key' => 'wpcf-next-start',
					'value' => date("Y-m-d", time() + (14*60*60*24)),
					'compare' => '>'
			);
		} elseif($availability == 5) {
			$meta[] = array(
					'key' => 'wpcf-schedule',
					'value' => 'w',
					'compare' => '='
			);
		}
	}

		
	if($meta) {
		$meta[] = array(
				'key' => 'edspire-score',
				'value' => 0,
				'compare' => '>='
		); 
		$args['meta_query'] = $meta;
	}
	
	session_start();
	if($_SESSION['del']) {
		$args['post__not_in'] = $_SESSION['del']; 
	}
	
	return new WP_Query( $args );
	
}

function ed_search_results($results_query, $qargs) {
	
	$paged = $qargs['paged'];
	$freetext = $qargs['freetext'];
	$subject = $qargs['subject'];
	$format = $qargs['format'];
	$style = $qargs['style'];
	
	if ( $results_query->have_posts() ) :
		echo '<ul class="ru0">';
		while ( $results_query->have_posts()) : 
			$results_query->the_post();
			ed_search_result();
		endwhile;
		echo '</ul>';
		if($results_query->max_num_pages > 1) :
			echo '<nav class="pagn0"><ol class="pago0">';
			if($paged > 1)
				echo '<li class="pagl paglprev"><a href="' . ed_canonical($paged-1, $qargs) . '">Previous</a></li>';
			for($ixPage = 1; $ixPage <= $results_query->max_num_pages; $ixPage++ ) {
				if($ixPage == $paged)
					echo '<li class="pagl paglactive"><span>' . $ixPage . '</span></li>';
				elseif($ixPage < $paged && $ixPage > $paged - 5)
					echo '<li class="pagl"><a href="' . ed_canonical($ixPage, $qargs) . '">' . $ixPage . '</a></li>';
				elseif($ixPage > $paged && $ixPage < $paged + 5)
					echo '<li class="pagl"><a href="' . ed_canonical($ixPage, $qargs) . '">' . $ixPage . '</a></li>';
				elseif($ixPage == 1)
					echo '<li class="pagl pagl0"><a href="' . ed_canonical($ixPage, $qargs) . '">' . $ixPage . '</a> &hellip;</li>';
				elseif($ixPage == $results_query->max_num_pages)
					echo '<li class="pagl pagln">&hellip; <a href="' . ed_canonical($ixPage, $qargs) . '">' . $ixPage . '</a></li>';
			}
			if($paged < $results_query->max_num_pages)
				echo '<li class="pagl paglnext"><a href="' . ed_canonical($paged+1, $qargs) . '">Next</a></li>';
			echo '</ol></nav>';
		endif;
	endif;
}

// filters
function ed_filters( $qargs ) {
	global $field_args, $field_names, $field_options;
	
	$fields = array("freetext", "price", "language", "subject", "style", "availability", "university", "teacher", "provider", "platform");
	
	$qargs = ed_query_args();

	echo '<form id="ffi" method="POST" action="/search/">';
	echo '<h4>Your search</h4><div id="ys0">';
	
	$br = '';
	foreach($fields as $field):
		if($qargs[$field]) {
			echo $br . '<span>';
			if( is_array($field_options[$field]) ) {
				echo $field_options[$field][$qargs[$field]];
			} else {
				echo $qargs[$field];
			}
			echo '<input type="hidden" name="' . $field_args[$field] . '" value="' . $qargs[$field] . '" />';
			echo '<button name="unset" value="' . $field . '" title="Remove ' . $field . '">Remove</button></span>';
			$br = '<br/>';
		}
	endforeach;

	// @Deprecated: 
	// echo '<form id="ffi" method="POST" action="' . ed_canonical( 1, $qargs ) . '">';
	// It does work running it through the same page BUT when the users tries to remove a filter that's specified in the URL, e.g. on /literature/mooc/ they
	// try and remove the "Literature" bit or the "MOOC" bit it doesn't like it because the URL puts it back in.
	
	echo '</div><h4>Refine your search</h4><div id="rys0">';
	
	foreach($fields as $field):
	
		if($field != 'freetext' && ! $qargs[$field]) {
		
			echo '<div id="f' . $field . '"><label for="i' . $field . '">' . $field_names[$field] . '</label>';
				if( is_array($field_options[$field]) ) {
					echo '<select id="i' . $field . '" name="' . $field_args[$field] . '">';
					echo '<option value="">--select--</option>';
					foreach($field_options[$field] as $key => $value) {
						echo '<option value="' . $key . '">' . $value . '</option>';
					}
					echo '</select>';
				} else {
					echo '<input id="i' . $field . '" type="text" name="' . $field_args[$field] . '"/>';
				}
			echo '</div>';
		}
	
	endforeach;
	
	echo '</div><input type="submit" value="Apply filters" />';
	
	echo '</form>';
}

function ed_title() {
	
	$title = '';
	
	$qargs = ed_query_args();
	
	$freetext = $qargs['freetext'];
	$subject = $qargs['subject'];
	$format = $qargs['format'];
	$style = $qargs['style'];
	$post = $qargs['post'];
	$page = $qargs['page'];
	$teacher = $qargs['teacher'];
	$resource = $qargs['resource'];
	
	if($page || $post || $resource || $teacher) {
		$title = get_the_title();
	} elseif (is_front_page()) {
		$title = "The search engine for online learning - edspire";
	} elseif (is_home()) {
		$title = "The edspire blog - news about online learning and the future of education";
	} else {
		global $subject_singular, $style_plural;
		if( $style )
			$title = $style_plural[$style];
		if( $subject )
			$title .= ($title == '' ? '' : ' in ') . $subject_singular[$subject];
	}
	
	if($title == '') {
		// maybe the qargs haven't parsed properly, check for a post
		$title = get_the_title();
	}
	
	echo $title;
}

// canonical search links from args
function ed_canonical($paged, $qargs) {
	
	// TODO resolve technical debt by splitting up and refactoring: too many things rely on it to work (e.g. rel=canonical and pagination)
	
	$freetext = $qargs['freetext'];
	$subject = $qargs['subject'];
	$format = $qargs['format'];
	$style = $qargs['style'];
	$post = $qargs['post'];
	$page = $qargs['page'];
	$teacher = $qargs['teacher'];
	$resource = $qargs['resource'];
	$type = $qargs['type'];
	
	$url = '/';
	if(is_front_page()) {
		
	} else if(is_home()) {
		$url = '/blog/';
	} elseif($page || $post || $resource) {
		if($page)
			$url =  '/' . $page . $url;
		if($post)
			$url =  '/' . $post . $url;
		if($teacher)
			$url =  '/' . $teacher . $url;
		if($resource)
			$url =  '/' . $resource . $url;
		if($paged > 1)
			$url .= 'page/' . $paged . '/';
	} elseif($type == 'teacher') {
		$url =  '/' . $teacher . $url;
	} else {
		if($paged > 1)
			$url = '/page/' . $paged . $url;
		if($freetext || $format) {
			$connective = '?';
			$url = '/search' . $url;
			if($freetext) {
				$url .= $connective . 's-ft=' . $freetext;
				$connective = '&';
			}
			if($format) {
				$url .= $connective . 's-f=' . $format;
				$connective = '&';
			} 
			if($style) {
				$url .= $connective . 's-s=' . $style;
				$connective = '&';
			}
			if($subject) {
				$url .= $connective . 's-ps=' . $subject;
				$connective = '&';
			}
		} else {
			if($style)
				$url = '/' . $style . $url;
			if($subject)
				$url = '/' . $subject . $url;
		}
	}
	return $url;	
}

function ed_search_result() {
	
	global $post, $style_singular;
	//setup_postdata($post);
	$provider = get_post_meta($post->ID, 'wpcf-provider', true);
	$format = get_post_meta($post->ID, 'wpcf-format', true);
	$style = $style_singular[strval(get_post_meta($post->ID, 'edspire-style', true))];
	$university = get_post_meta($post->ID, 'wpcf-university', true);
	$posttags = get_the_tags($post->ID);
	$provider_link = get_post_meta($post->ID, 'wpcf-provider-link', true);
	$cost_cur = strval(get_post_meta($post->ID, 'wpcf-cost-cur', true));
	$cost_val = strval(get_post_meta($post->ID, 'wpcf-cost-val', true));
	$cost_sub = strval(get_post_meta($post->ID, 'wpcf-cost-sub', true));
	$availability = strval(get_post_meta($post->ID, 'wpcf-availability', true));
	$next_start = strval(get_post_meta($post->ID, 'wpcf-next-start', true));
	$schedule = strval(get_post_meta($post->ID, 'wpcf-schedule', true));
	$duration = strval(get_post_meta($post->ID, 'wpcf-duration', true));
	$workload = strval(get_post_meta($post->ID, 'wpcf-workload', true));
	$workload_min = strval(get_post_meta($post->ID, 'wpcf-workload-min', true));
	$workload_max = strval(get_post_meta($post->ID, 'wpcf-workload-max', true));
	$cost = format_cost( $cost_cur, $cost_val, $cost_sub );
	$work = format_workload( $workload, $workload_min, $workload_max );
	$next = format_next_start( $schedule, $next_start );
	$nextarr = explode('-', $next_start);
	?>
	<li class="rl0">

	    <article id="resource<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/ScholarlyArticle">
		
		<div class="rd0">
	      <header>
			<ul class="search-result-options"><li><?php echo ed_fav_link($post->ID); ?></li><li><?php echo ed_del_link($post->ID); ?></li></ul>
			<h2><a href="<?php echo get_permalink($post); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'espire' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php if ($posttags) {
				echo '<!-- <div class="sj0">'; // Don't show tags for now to user, but useful for debugging "why this results appeared in the search"
												foreach($posttags as $tag) {
													echo "<span itemprop=\"about\">" . $tag->name . "</span>";
												}
				echo '</div> -->';
											} ?>
		  </header>
		  <?php the_excerpt($post) ?>
		</div>
		
		<div class="rd1">
		  <a href="<?php the_permalink(); ?>">
			<ul class="ru1">
			  <li class="header <?php echo $format; ?>"><span itemprop="learningResourceType"><?php echo $style; ?></span></li>
			  <li><?php echo $cost; ?></li>
			  <?php if($provider != ""): ?>
			  <li><?php echo $provider; ?></li>
			  <?php endif; ?>
			  <?php if($next != ""): ?>
			  <li><?php echo $next; ?></li>
			  <?php endif; ?>
			  <?php if($work != ""): ?>
			  <li><?php echo $work; ?></li>
			  <?php endif; ?>
			  <?php if($duration != ""): ?>
			  <li><?php echo $duration; ?></li>
			  <?php endif; ?>
			  <?php if($university != ""): ?>
			  <li itemscope itemtype ="http://schema.org/EducationalOrganization"><span itemprop="name"><?php echo $university; ?></span></li>
			  <?php endif; ?>
	
			  <?php
											$mykey_values = get_post_custom_values('wpcf-teacher');
											if( $mykey_values ) {
												echo "<li>Taught by ";
												$comma = false;
	  											foreach ( $mykey_values as $key => $value ) {
		    										echo ($comma ? ', ' : '') . '<span itemscope itemtype="http://schema.org/Person"><span itemprop="name">' . $value . '</span></span>';
		    										$comma = true;
	  											}
	  											echo "</li>";
	  										}
										?>
	        </ul>
		  </a>
		</div>
	  </article>
	</li>	
	<?php	
}

// links
function hashUrl($url) {
	$computed = urldecode($url);
	for($ix = 0; $ix < 100; $ix++) {
		$computed = md5('u7SC.eWd_/C4m' . $computed . '*(7)>JIaT}@4F');
	}
	$evenoutput = '';
	for ($counter = 0; $counter < strlen($computed); $counter++) {
		if ($counter % 2 == 0) {
			$evenoutput .= $computed[$counter];
		}
	}
	return $evenoutput;
}

function externalLink($url) {
	return '/index.php?pagename=url&code=' . hashUrl($url) . '&url=' . urlencode($url);
}

// similar resources
function get_similar_to( $post_id, $format = '' ) {
	global $wpdb;
	$sql = "select ts.object_id from ed_term_relationships tr ";
	$sql .= " inner join ed_term_taxonomy trt on tr.term_taxonomy_id = trt.term_taxonomy_id inner join ed_term_relationships ts on tr.term_taxonomy_id = ts.term_taxonomy_id and tr.object_id != ts.object_id ";
	if( $format != '')
		$sql .= " inner join ed_postmeta m on ts.object_id = m.post_id and m.meta_key = 'wpcf-format' and m.meta_value = '$format' ";
	$sql .= " inner join ed_posts p on ts.object_id = p.ID and p.post_status = 'publish' ";
	$sql .= " inner join ed_term_taxonomy tst on ts.term_taxonomy_id = tst.term_taxonomy_id where trt.taxonomy = 'post_tag' and tst.taxonomy = 'post_tag' and tr.object_id = " . $post_id . " group by ts.object_id order by count(*) desc limit 3";
	return $wpdb->get_results( $sql );
}

function show_also_like( $post_id, $format ) {
	$ids = get_similar_to( $post_id, $format );
	if( $ids ) {
		//		echo '<h3>You May Also Like</h3>';
		echo '<ul class="ure0">';
		foreach( $ids as $id ) {
			echo '<li rel="' . $id->object_id . '">';
			echo '<a href="'. get_permalink( $id->object_id ).'"><h5>' . get_the_title( $id->object_id ) . ' <span class="h5m">&nbsp;from ' . get_post_meta($id->object_id, 'wpcf-provider', true) . '</span></h5></a>';
			echo '</li>';
		}
		echo '</ul>';
	}
}

// video
function show_video( $url ) {
	if( substr($url, 0, 4) === 'http' ) {
		if(strpos( $url, 'youtube.com')) {
			if( !strpos( $url, '/embed/')) {
				$bits = explode('?', $url);
				if($bits[1]) {
					foreach( explode('&', $bits[1]) as $paramvalue ) {
						$pv = explode('=', $paramvalue);
						if( $pv[1] && $pv[0] == 'v') {
							$url = 'http://www.youtube.com/embed/' . $pv[1];
						}
					}
				}
			}
			echo '<div class="video-preview"><iframe width="560" height="315" src="' . $url . '" frameborder="0" allowfullscreen></iframe></div>';
		} elseif(strpos( $url, 'vimeo.com')) {
			if(! strpos( $url, 'player' ) ) {
				$url = str_replace( 'http://vimeo.com/', 'http://player.vimeo.com/video/',  $url);
			}
			echo '<div class="video-preview"><iframe src="' . $url . '" width="500" height="375" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
		}
	}
}

// DB log
function dblog($table, $message) {
	global $wpdb;
	$wpdb->insert(
			$wpdb->prefix . $table . '_log',
			array(
					'message' => $message,
					'ip' => $_SERVER["REMOTE_ADDR"],
					'user_id' => is_user_logged_in() ? wp_get_current_user()->ID : 0
			),
			array('%s','%s','%d')
	);
}

// 404
function go404() {
	global $wp_query;
	remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
	$wp_query->set_404();
	status_header( 404 );
	get_template_part( 404 );
	exit();
}

// formatting
function format_cost( $cur, $val, $sub ) {
	if( 0 == $val )
		return "Free";
	else {
		if($sub == 'm')
			return $cur . $val . 'pcm';
		else
			return $cur . $val . $sub;
	}
}

function format_workload( $text, $min, $max ) {
	if( $min > 0 && $max > 0 ) {
		if( $min == $max )
			return $min . ' hour' . ($min > 1 ? 's' : '') . '/week';
		return $min . '-' . $max . ' hour' . ($max > 1 ? 's' : '') . '/week';
	} elseif( $min > 0 ) {
		return 'At least ' . $min . ' hour' . ($min > 1 ? 's' : '') . '/week';
	}
	return $text;
}

function format_meta_workload( $text, $min, $max ) {
	if( $min > 0 && $max > 0 ) {
		if( $min == $max )
			return $min . ' hour' . ($min > 1 ? 's' : '') . '/week';
		return '. Requires ' . $min . '-' . $max . ' hour' . ($max > 1 ? 's' : '') . ' per week';
	} elseif( $min > 0 ) {
		return '. Requires at least ' . $min . ' hour' . ($min > 1 ? 's' : '') . ' per week';
	} elseif( $text )
		return '. ' . $text;
	return '';
}


function format_next_start( $schedule, $start ) {
	// expects $start as ####-##-##
	if( $schedule == 'd' )
		return 'Unavailable';
	elseif( $schedule == 'a' )
	return 'Available on demand';
	elseif( $schedule == 'w' )
	return 'Coming soon';
	elseif( $schedule == 's' ) {
		$bits = explode('-', $start);
		if( 0 == intval($bits[2]) )
			return '<time itemprop="date" datetime="' . $bits[0] . '-' . $bits[1] . '-01">' . format_month( $bits[1] ) . ' ' . $bits[0] . '</time>';
		else
			return '<time itemprop="date" datetime="' . $bits[0] . '-' . $bits[1] . '-' . $bits[2] . '">' . format_day($bits[2]) . ' ' . format_month( $bits[1] ) . ' ' . $bits[0] . '</time>';
	}
	return "";
}

function format_meta_start( $schedule, $start ) {
	// expects $start as ####-##-##
	if( $schedule == 'd' )
		return '. No longer Unavailable';
	elseif( $schedule == 'a' )
	return '. Available on demand';
	elseif( $schedule == 'w' )
	return '. Coming soon';
	elseif( $schedule == 's' ) {
		$bits = explode('-', $start);
		if( 0 == intval($bits[2]) )
			return '. Starting ' . format_month( $bits[1] ) . ' ' . $bits[0];
		else
			return '. Starting ' . format_day($bits[2]) . ' ' . format_month( $bits[1] ) . ' ' . $bits[0];
	}
	return "";
}


function format_day( $day ) {
	return intval($day);
}

function format_month( $month ) {
	switch(intval($month)) {
		case 1: return 'January';
		case 2: return 'February';
		case 3: return 'March';
		case 4: return 'April';
		case 5: return 'May';
		case 6: return 'June';
		case 7: return 'July';
		case 8: return 'August';
		case 9: return 'September';
		case 10: return 'October';
		case 11: return 'November';
		case 12: return 'December';
		default: return '';
	}
}


// wizard arrays
global $wiz_learners, $wiz_materials, $wiz_matters;

$wiz_learners = array(
		array('val' => 'education', 'label' => 'Support my school, college or university studies', 'subs' => array(
			array('val' => 'k1-5', 'label' => 'K1 - K5'),
			array('val' => 'k6-10', 'label' => 'K6 - K10'),
			array('val' => 'k11-12', 'label' => 'K11 & K12'),
			array('val' => 'undergrad', 'label' => 'Undergraduate'),
			array('val' => 'postgrad', 'label' => 'Postgraduate'),
			array('val' => 'postdoc', 'label' => 'Postdoctoral'),
		)),
		array('val' => 'enjoy', 'label' => 'Learning for fun', 'subs' => array()),
		array('val' => 'professional', 'label' => 'Improve my professional skills', 'subs' => array()),
		array('val' => 'hobbies', 'label' => 'Discover a new hobby or interest', 'subs' => array()),
);
$wiz_materials = array(
		array('val' => 'books', 'label' => 'Words'),
		array('val' => 'videos', 'label' => 'Visual'),
		array('val' => 'audio', 'label' => 'Audio'),
		array('val' => 'tutorials', 'label' => 'Interactive'),
		array('val' => 'lwo', 'label' => 'Structured learning with others'),
		array('val' => 'laop', 'label' => 'Learning at my own pace'),
		array('val' => 'blended', 'label' => 'Blended'),
);

$wiz_matters = array(
		array('val' => 'everything', 'label' => 'Show me everything'),
		array('val' => 'fifty', 'label' => "I don't want to spend more than $50"),
		array('val' => 'free', 'label' => 'I only want free resources')
);

$wiz_time = array(
		array('val' => '4', 'label' => 'Up to 4 hours per week'),
		array('val' => '8', 'label' => "4-8 hours per week"),
		array('val' => '12', 'label' => '8-12 hours per week'),
	    array('val' => '13', 'label' => 'More than 12 hours per week'),
);

function subarray_intersect( $array1, $array2 ) {
	if(!is_array($array1))
		$array1 = array($array1);
	$subarray2 = array();
	foreach($array2 as $arr2) {
		$subarray2[] = $arr2[$array2key];
	}
	return array_intersect( $array1, $subarray2 );
}

function IsNullOrEmptyString($question){
	return (!isset($question) || trim($question)==='');
}


// admin redirect
function restrict_admin()
{
	if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
		wp_redirect( site_url() );
	}
}
add_action( 'admin_init', 'restrict_admin', 1 );

add_filter( 'lostpassword_url', 'ed_lostpassword_url');

function ed_lostpassword_url( $lostpassword_url, $redirect = '' ) {
	
	$args = array( 'action' => 'lostpassword' );
	if ( !empty($redirect) ) {
		$args['redirect_to'] = $redirect;
	}

	$lostpassword_url = add_query_arg( $args, network_site_url('login/', 'login') );

	return $lostpassword_url;
}

add_filter( 'register_url', 'ed_register_url');

function ed_register_url( $register_url ) {
	return site_url( 'login/?action=register', 'login' );
}

add_filter( 'logout_url', 'ed_logout_url');

function ed_logout_url($logout_url, $redirect = '') {
	$args = array( 'action' => 'logout' );
	if ( !empty($redirect) ) {
		$args['redirect_to'] = urlencode( $redirect );
	}

	$logout_url = add_query_arg($args, site_url('login/', 'login'));
	$logout_url = wp_nonce_url( $logout_url, 'log-out' );

	return $logout_url;
}

add_filter( 'login_url', 'ed_login_url');

function ed_login_url($login_url, $redirect = '') {
	$login_url = site_url('login/', 'login');

	if ( !empty($redirect) )
		$login_url = add_query_arg('redirect_to', urlencode($redirect), $login_url);

	if ( $force_reauth )
		$login_url = add_query_arg('reauth', '1', $login_url);

	return $login_url;
}

function show_privacy( $field, $privacy ) {
	echo '<div class="privacy">' . "\n";
	echo '<label><input type="radio" name="' . $field . '" value="private" ' . ($privacy <> 'public' ? ' checked ' : '') . '/> Private</label>' . "\n";
	echo '<label><input type="radio" name="' . $field . '" value="public" ' . ($privacy == 'public' ? ' checked ' : '') . ' /> Public</label>' . "\n";
	echo '</div>' . "\n";
}

function show_alerting( $wizard_id, $alerting ) {
	echo '<div id="walerting" class="edit alerting" rel="' . $wizard_id . '">Email alert:' . "\n";
	echo '<span>' . $alerting . '</span>' . "\n";
	echo '</div>' . "\n";
}

// TODO reimplement pins (aka bookmarks)
function upb_get_user_meta($user_id) {
	return get_user_option('upb_read_posts', $user_id);
}

function ed_fav_link($post_id) {
	if($_SESSION['fav'] && in_array($post_id, $_SESSION['fav'])) {
		$nonce = wp_create_nonce("ed_un_fav");
		return '<a class="unfav as_ajax_post" title="Remove this from favourites" href="/ajax/?action=unfav&post_id=' . $post_id . '&nonce=' . $nonce . '">Remove from favourites</a>';
	} else {
		$nonce = wp_create_nonce("ed_fav");
		return '<a class="fav as_ajax_post" title="Save this to favourites" href="/ajax/?action=fav&post_id=' . $post_id . '&nonce=' . $nonce . '">Add to favourites</a>';
	}
}

function ed_del_link($post_id) {
	$nonce = wp_create_nonce("ed_del");
	return '<a class="del as_ajax_post" title="Remove this search result, it\'s not relevant" href="/ajax/?action=del&post_id=' . $post_id . '&nonce=' . $nonce . '">Exclude this resource</a>';
}

add_action('wp_login', 'ed_user_meta_to_session');

function ed_user_meta_to_session($user_login, $user) {
	$id = get_userdatabylogin( $user_login )->ID;
	load_session_from_meta($id, 'del');
	load_session_from_meta($id, 'fav');
}

function load_session_from_meta($id, $fn) {
	$arr = array_values(get_user_meta( $id, $fn, true));
	if( ! $arr )
		$arr = array();
	session_start();
	if($_SESSION[$fn]) {
		$_SESSION[$fn] = array_values(array_unique(array_merge( array_values($_SESSION[$fn]), $arr ), SORT_REGULAR));
		sync_session_user_meta($id, $fn);
	} else {
		$_SESSION[$fn] = $arr;
	}
}

function sync_session_user_meta($id, $var) {
	update_user_meta( $id, $var, $_SESSION[$var]);
}
?>
