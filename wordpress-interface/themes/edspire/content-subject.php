<?php

  $qargs = ed_query_args('subject');
  $equery = ed_query($qargs);

  $subject = $qargs['subject'];
  
  global $subject_banner_credit, $subject_banner_licence, $subject_banner_link;
  ?>
<section title="Licence: <?php echo $subject_banner_licence[$subject]; ?>; Credit: <?php echo $subject_banner_credit[$subject]; ?>; Link: <?php echo $subject_banner_link[$subject]; ?>" class="isCC ssh b-<?php echo $subject ?>"></section>
  
<div class="w0">
  <article class="pt-subject">
  
    <h1><?php 
  	  the_title();
  	  if( $qargs['style'] ) {
		global $style_plural, $style_format;
		echo ' &middot; ' . $style_plural[$qargs['style']];
      } 
    ?></h1>

    <?php 
  
    if( ! $qargs['style'] && $equery->max_num_pages > 1) {
	  echo '<div class="sg">';
	  ed_style_grid( $qargs['subject'] );
	  echo '</div>';
	  the_content();
    } else {
	  ed_filters( $qargs );
	  ed_search_results( $equery, $qargs );
    }
  
  ?>
  
  </article>
</div>