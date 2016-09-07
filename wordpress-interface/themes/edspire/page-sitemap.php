<?php 

global $wpdb;

function show_header() {
	header( 'HTTP/1.1 200 OK', true, 200 );
	// Prevent the search engines from indexing the XML Sitemap.
	header( 'X-Robots-Tag: noindex, follow', true );
	header( 'Content-Type: text/xml' );
	echo '<?xml version="1.0" encoding="' . get_bloginfo( 'charset' ) . '"?>';
}

function write_sitemap( $post_type, $page, $rows ) {

	global $wpdb;
	
	$status = ( $post_type == 'attachment' ) ? 'inherit' : 'publish';
	
	$offset = $page * $rows;

	$query = $wpdb->prepare( "SELECT ID, post_modified
			 FROM $wpdb->posts
	WHERE post_status = '%s'
	AND	post_password = ''
	AND post_type = '%s'
	AND NOT ( post_type = 'page' and post_author = 5 )
	ORDER BY ID ASC
	LIMIT %d OFFSET %d", $status, $post_type, $rows, $offset );
	
	$posts = $wpdb->get_results( $query );

	show_header();
	
	echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	
	foreach( $posts as $p ) {
		
		echo '<url>';
		echo '<loc>' . get_permalink( $p->ID ) . '</loc>';
		echo '<lastmod>' . date( 'c', strtotime( $p->post_modified ) ) . '</lastmod>';
		echo '<changefreq>weekly</changefreq>';
		echo '<priority>0.8</priority>';
		echo '</url>';
		
		if( $post_type == 'subject' ) {
			global $style_format;
			// do sub pages
			foreach($style_format as $key => $value) {
				echo '<url>';
				echo '<loc>' . get_permalink( $p->ID ) . $key . '/</loc>';
				echo '<lastmod>' . date( 'c', strtotime( $p->post_modified ) ) . '</lastmod>';
				echo '<changefreq>weekly</changefreq>';
				echo '<priority>0.8</priority>';
				echo '</url>';
			}
		}
		
	}
	
	echo '</urlset>';
	
}

function get_last_modified( $post_type, $page, $rows ) {
	
	global $wpdb;
	
	$status = ( $post_type == 'attachment' ) ? 'inherit' : 'publish';
	
	$offset = $page * $rows;
	
	$query = $wpdb->prepare( "SELECT max(post_modified) 
			FROM ( SELECT post_modified FROM $wpdb->posts 
			WHERE post_status = %s 
			AND post_password = '' AND post_type = %s 
			AND NOT ( post_type = 'page' and post_author = 5 )
			ORDER BY ID ASC
			LIMIT %d OFFSET %d ) a ", $status, $post_type, $rows, $offset );
		
	$modified = date( 'c', strtotime( $wpdb->get_var( $query ) ) );
	
	return $modified;
}

$types = array('page','post','resource','subject'); // 'institution', 'teacher', 'attachment'

$sitemap = get_query_var('sitemap');

if($sitemap == '' || $sitemap == '_index'):
	
	show_header();
	echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	
	foreach($types as $type) {
		echo '<sitemap>';
		echo '<loc>http://edspire.com/sitemap_' . $type . '.xml</loc>';
		echo '<lastmod>' . get_last_modified( $type, 0, 100000) . '</lastmod>';
		echo '</sitemap>';
	}
	
	echo '</sitemapindex>';

else:

	$bits = explode('_', $sitemap);
	
	if( in_array( $bits[1], $types ) ) {
		
		if( count($bits) == 2 ) {
		
			$query = $wpdb->prepare( "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_status IN ('publish','inherit') AND post_password = '' AND post_type = %s AND NOT ( post_type = 'page' and post_author = 5 )", $bits[1] );
			
			$count = intval($wpdb->get_var( $query ) );
			if( $count > 50 ) {
				
				show_header();
				echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
				
				for($ix = 0; $ix < intval($count/50); $ix++) {
					
					echo '<sitemap>';
					echo '<loc>http://edspire.com/sitemap_' . $bits[1] . '_' . $ix . '.xml</loc>';
					echo '<lastmod>' . get_last_modified( $bits[1], $ix, 50) . '</lastmod>';
					echo '</sitemap>';
					
				}
				
				echo '</sitemapindex>';
				
			} else {
				
				write_sitemap( $bits[1], 0, 50 );
				
			}
			
		} elseif( count($bits) == 3 ) {
		
			$ix = intval($bits[2]);
			
			write_sitemap( $bits[1], $ix, 50 );
			
		}		
	}

	
endif;

exit();
?>