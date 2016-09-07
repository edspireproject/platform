<?php 

global $subject_singular, $style_singular;

$post_type = get_post_type();
$provider = get_post_meta($post->ID, 'wpcf-provider', true);
$format = get_post_meta($post->ID, 'wpcf-format', true);
$provider_difficulty = get_post_meta($post->ID, 'wpcf-provider-difficulty', true);
$university = get_post_meta($post->ID, 'wpcf-university', true);
$posttags = get_the_tags($post->ID);
$provider_link = get_post_meta($post->ID, 'wpcf-provider-link', true);
$cost_cur = strval(get_post_meta($post->ID, 'wpcf-cost-cur', true));
$cost_val = strval(get_post_meta($post->ID, 'wpcf-cost-val', true));
$cost_sub = strval(get_post_meta($post->ID, 'wpcf-cost-sub', true));
$cost = format_cost( $cost_cur, $cost_val, $cost_sub );
$availability = strval(get_post_meta($post->ID, 'wpcf-availability', true));
$next_start = strval(get_post_meta($post->ID, 'wpcf-next-start', true));
$schedule = strval(get_post_meta($post->ID, 'wpcf-schedule', true));
$duration = strval(get_post_meta($post->ID, 'wpcf-duration', true));
$length = get_post_meta($post->ID, 'wpcf-video-length', true);
$workload = strval(get_post_meta($post->ID, 'wpcf-workload', true));
$workload_min = strval(get_post_meta($post->ID, 'wpcf-workload-min', true));
$workload_max = strval(get_post_meta($post->ID, 'wpcf-workload-max', true));
$work = format_workload( $workload, $workload_min, $workload_max );
$next = format_next_start( $schedule, $next_start );

$subject = $subject_singular[strval(get_post_meta($post->ID, 'edspire-primary-subject', true))];
$style = $style_singular[strval(get_post_meta($post->ID, 'edspire-style', true))];


$itemtype = "http://schema.org/ScholarlyArticle";
$taught = "Taught";
if($format == 'video')
	$taught = "Presented";
?>
<div class="w0">

  <article class="pt-resource" itemscope itemtype="<?php echo itemtype; ?>" id="resource<?php the_ID(); ?>">

    <header class="rp-<?php echo sanitize_title($provider); ?>">
	  <h1><span itemprop="name"><?php the_title(); ?></span> <span class="h1m">&nbsp;from <?php echo $provider; ?></span></h1>
    </header>
  
      <section class="sb0">
      
        <a itemprop="url" rel="nofollow" class="url" href="<?php echo externalLink($provider_link); ?>" target="_blank" title="View this <?php echo $style; ?> on <?php echo $provider; ?> website">Go to this <?php echo $style; ?> on <?php echo $provider; ?> website</a>
      
        <ul class="cu0">
		  <li class="header <?php echo $format; ?>"><span class="l6">Format</span> <span itemprop="learningResourceType"><?php echo $style; ?></span></li>
		  <li><span class="l6">Cost</span> <?php echo $cost; ?></li>
		  <?php if($provider != ""): ?>
		  <li itemprop="provider" itemscope itemtype="http://schema.org/Organization"><span class="l6">From</span> <span itemprop="name"><?php echo $provider; ?></span></li>
		  <?php endif; ?>
		  <?php if($university != ""): ?>
		  <li itemprop="sourceOrganization" itemscope itemtype="http://schema.org/EducationalOrganization"><span class="l6"><?php echo $provider == "" ? 'From' : ' ';  ?></span> <span itemprop="name"><?php echo $university; ?></span></li>
		  <?php endif; ?>
	
		  <?php if($next != ""): ?>
		  <li><span class="l6">Starts</span> <?php echo $next; ?></li>
		  <?php endif; ?>
		  <?php if($work != ""): ?>
		  <li><span class="l6">Workload</span> <?php echo $work; ?></li>
		  <?php endif; ?>
		  <?php if($duration != ""): ?>
		  <li><span class="l6">Duration</span> <?php echo $duration; ?></li>
		  <?php endif; ?>
		  <?php if($length != ""): ?>
		  <li><span class="l6">Length</span> <?php echo $length; ?> minutes long</li>
		  <?php endif; ?>
		  <li><span class="l6">Subject</span> <span itemprop="about"><?php echo $subject; ?></span><?php 
	  			if ($posttags) {
	  				foreach($posttags as $tag) {
						if($subject != $tag->name)
		  					echo ', <span itemprop="about">' . $tag->name . '</span>';
        			}
      			} ?></li>  
  		  <?php
				$mykey_values = get_post_custom_values('wpcf-teacher');
				if( $mykey_values ) {
					echo "<li><span class=\"l7\">" . $taught . " by ";
					$comma = false;
  					foreach ( $mykey_values as $key => $value ) {
	    				echo ($comma ? ', ' : '') . '<span itemprop="creator" itemscope itemtype="http://schema.org/Person"><span itemprop="name">' . $value . '</span></span>';
						$comma = true;
  					}
					echo "</span></li>";
				}
			?>
    	</ul>
    	
      </section>
	  
	  <?php if($format == 'video'): ?>
      <section class="v0" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
	    <?php show_video( $provider_link ); ?>
	  </section>
	  <?php endif; ?>
      
      <section itemprop="description" class="b0 text-body">
		<?php the_content() ?>
		
		<?php
			$books = get_post_custom_values('wpcf-book');
			if( $books ) {
				echo "<h2>Reading list</h2><ul>";
				foreach ( $books as $key => $value ) {
					$book = json_decode( $value, true );
					if($book) {
						if($book["article"]) {
							echo '<li itemscope itemtype="http://schema.org/Article"><span itemprop="headline">' . $book["article"] . '</span> in <cite itemprop="name">' . $book["title"] . '</cite> ';
						} else {
							echo '<li itemscope itemtype="http://schema.org/Book"><span><cite itemprop="name">' . $book["title"] . '</cite> ';
						}
					if($book["authors"])
						echo ' by <span itemprop="author">' . $book["authors"] . '</span>';
					echo '<span class="smallprint">';
					if($book["year"])
						echo ' &middot; <span itemprop="datePublished">' . $book["year"] . '</span>';
					if($book["publishers"]) {
							if (preg_match('/[A-Z]+[a-z]+/', $book["publishers"]) && strlen($book["publishers"]) > 8) {
								echo ' &middot; <span itemprop="publisher">' . $book["publishers"] . '</span>';
							}
						}
						if($book["isbn"])
							echo ' &middot; ISBN <span itemprop="isbn">' . $book["isbn"] . '</span>';
						if($book["links"]) {
							foreach ( $book["links"] as $link ) {
								if(strpos($link, '/') === 0) {
									echo ' &middot; <a rel="nofollow" target="_blank" href="http://ocw.mit.edu' . $link . '" itemprop="url">Link</a>';
								} elseif(strpos($link, 'http://www.amazon') === 0) {
									// don't show this one
								} else {
									echo ' &middot; <a target="_blank" href="' . $link . '" itemprop="url">Link</a>';
								}
							}
						}
						echo '</li>';
					}
				}
				echo "</ul>";
			}
			?>
	  </section>

	  <?php 
	    $videoUrl = get_post_meta($post->ID, 'wpcf-video-intro', true);
	    if( substr($videoUrl, 0, 4) === 'http' ) { 
		    echo '<section class="v1"><h3>Preview</h3><div><div class="video-preview"><iframe class="video" width="560" height="315" src="' . $videoUrl . '" frameborder="0" allowfullscreen title="Click to play the video"></iframe></div></div></section>';		
		}
	  ?>
	  
  </article>
</div>
<div class="gr">
  <div class="w0">
  <nav class="nre0">
    <h2>You might also like...</h2>
	<div class="re0">
	  <h3>Related courses</h3>
	  <?php show_also_like($post->ID, 'course'); ?>
	</div>
	<div class="re0">
	  <h3>Related Videos</h3>
	  <?php show_also_like($post->ID, 'video'); ?>
	</div>
	<div class="re0">
	  <h3>Related OpenCourseWare</h3>
	  <?php show_also_like($post->ID, 'ocw'); ?>
	</div>
	<hr class="hr" />
  </nav>
  </div>
</div>