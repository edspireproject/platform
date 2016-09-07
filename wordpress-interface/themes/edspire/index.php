<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage edspire
 * @since edspire 1.0
 */

if(isset($_REQUEST["json"])) {
	if(get_post_type() == "resource") {
		include_once('json-resource.php');
		exit();
	}
}

get_header(); ?>

	<div class="headfaker"> </div>
	
	<?php if ( have_posts() ) : ?>

		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_type() ); ?>
		<?php endwhile; ?>

	<?php else : ?>
		<?php get_template_part( 'content', 'none' ); ?>
	<?php endif; ?>

<?php get_footer(); ?>