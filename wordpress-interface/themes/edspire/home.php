<?php
/**
 * This is the page used to serve the blog index on /blog/
 */

get_header(); ?>

	<div class="headfaker"> </div>
	
	<div class="w0">
		<?php if ( have_posts() ) : ?>

		<section itemscope itemtype="http://schema.org/Blog" id="content">
			<header>
				<h1>Blog</h1>
			</header>
		
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : 
				the_post();
				$gplus = '';
				if( $post->post_author == 2 ) {
					$gplus = '+JimMoodie';
				} elseif( $post->post_author == 3 ) {
					$gplus = '102440519698320469636';
				}
			?>
				<article class="blogpost" itemscope itemtype="http://schema.org/BlogPosting">
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail();
					} ?>
					<h2><a itemprop="url" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'learningengineone' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><span itemprop="headline"><?php the_title(); ?></span></a></h2>
					<?php show_posted_on($gplus); ?>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile;
			if($wp_query->max_num_pages > 1) :
				echo '<nav class="pagn0"><ol class="pago0">';
				$paged = max(1, get_query_var("paged"));
				if($paged > 1)
					echo '<li class="pagl paglprev"><a href="/blog/' . ($paged-1 > 1 ? 'page/' . ($paged-1) . '/' : '') . '">Previous</a></li>';
				for($ixPage = 1; $ixPage <= $wp_query->max_num_pages; $ixPage++ ) {
					if($ixPage == $paged)
						echo '<li class="pagl paglactive">' . $ixPage . '</li>';
					elseif($ixPage < $paged && $ixPage > $paged - 5)
						echo '<li class="pagl"><a href="/blog/' . ($ixPage > 1 ? 'page/' . $ixPage . '/' : '') . '">' . $ixPage . '</a></li>';
					elseif($ixPage > $paged && $ixPage < $paged + 5)
						echo '<li class="pagl"><a href="/blog/' . ($ixPage > 1 ? 'page/' . $ixPage . '/' : '') . '">' . $ixPage . '</a></li>';
					elseif($ixPage == 1)
						echo '<li class="pagl pagl0"><a href="/blog/' . ($ixPage > 1 ? 'page/' . $ixPage . '/' : '') . '">' . $ixPage . '</a> &hellip;</li>';
					elseif($ixPage == $results_query->max_num_pages)
						echo '<li class="pagl pagln">&hellip; <a href="/blog/' . ($ixPage > 1 ? 'page/' . $ixPage . '/' : '') . '">' . $ixPage . '</a></li>';
				}
				if($paged < $wp_query->max_num_pages)
					echo '<li class="pagl paglnext"><a href="/blog/page/' . ($paged+1) . '/">Next</a></li>';
				echo '</ol></nav>';
			endif; ?>
		</section>
		
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
	</div>

<?php get_footer(); ?>