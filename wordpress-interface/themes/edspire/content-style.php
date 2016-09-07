<?php

  $qargs = ed_query_args('style');

  ?>
  
<div class="w0">
  <article class="pt-style">

    <h1><?php the_title(); ?></h1>
  
    <?php the_content(); ?>
  
    <?php ed_subject_grid( $qargs['style'] ); ?>
    
  </article>
</div>