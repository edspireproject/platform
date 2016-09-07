<?php 
$post_type = get_post_type();
?>
<div class="w0">
  <article class="pt-<?php echo $post_type; ?>">

  <?php if(get_query_var('name') == 'search'): ?>

  <h1><?php the_title(); ?></h1>
  
  <?php 
  
  $qargs = ed_query_args('search');
  ed_filters( $qargs );
  ed_search_results( ed_query( $qargs ), $qargs );
  
  ?>
    
  <?php else: ?>

  <h1><?php the_title(); ?></h1>
  
  <?php the_content(); ?>
  
  <?php endif; ?>

  </article>
</div>