<?php

$this_day = intval(date('j'));
$this_year = intval(date('Y'));
$this_month = intval(date('n'));

$year = get_query_var('yr') ? intval(get_query_var('yr')) : 0;
$month = get_query_var('mnth') ? intval(get_query_var('mnth')) : 0;

if($year == 0 || $month == 0) {
	// use current date
	$clause = " and coalesce(next.meta_value, '2099-12-31') >= '" . $this_year . "-" . str_pad($this_month, 2, "0", STR_PAD_LEFT) . "-" . str_pad(($this_day-1), 2, "0", STR_PAD_LEFT) . "' and coalesce(next.meta_value, '2099-12-31') <= '" . ($this_month == 12 ? ($this_year + 1) . "-01" : $this_year . "-" . str_pad(($this_month+1), 2, "0", STR_PAD_LEFT)) . "-32' ";
	$title = "Upcoming courses";
	$year = $this_year;
	$month = $this_month;
} else {
	// show the specific month
	$clause = " and coalesce(next.meta_value, '2099-12-31') like '" . $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-%' ";
	$title = format_month($month) . ' ' . $year;
}

$last_month = $month - 1;
$next_month = $month + 1;
$last_year = $year;
$next_year = $year;
if($last_month == 0) {
	$last_month = 12;
	$last_year = $last_year - 1; 
}
if($next_month == 13) {
	$next_month = 1;
	$next_year = $last_year + 1;
}

$sql = "select p.id " .
		"from ed_posts p " .
		"inner join ed_postmeta f on p.id = f.post_id and f.meta_key = 'wpcf-format' and f.meta_value = 'course' " .
		"inner join ed_postmeta next on p.id = next.post_id and next.meta_key = 'wpcf-next-start' " .
		"where p.id != 0 " . $clause . " order by coalesce(next.meta_value, '2099-12-31') ";

global $wpdb;

$posts = array(0);

$results = $wpdb->get_results( $sql );

foreach ( $results as $row ) {
	$posts[] = $row->id;
}

$args = array('post__in' => $posts, 'post_type' => 'resource', 'nopaging' => true, 'meta_key' => 'wpcf-next-start', 'orderby' => 'meta_value', 'order' => 'ASC');

$query = new WP_Query( $args );

$qargs = ed_query_args('calendar');

get_header();
?>

<div class="headfaker"> </div>

<div class="w0">

  <nav>
  <ul class="pgn2">
    <li><a title="Learning resources starting in <?php echo format_month($last_month) . ' ' . $last_year; ?>" href="/calendar/<?php echo $last_year; ?>/<?php echo str_pad($last_month, 2, "0", STR_PAD_LEFT); ?>/">« <?php echo format_month($last_month) . ' ' . $last_year; ?></a></li>
    <li class="active">
    <?php 
    	if($this_year == $year && $this_month == $month)
    		echo 'Upcoming';
    	else
    		echo format_month($month) . ' ' . $year;
    ?></li>
    <li><a title="Learning resources starting in <?php echo format_month($next_month) . ' ' . $next_year; ?>" href="/calendar/<?php echo $next_year; ?>/<?php echo str_pad($next_month, 2, "0", STR_PAD_LEFT); ?>/"><?php echo format_month($next_month) . ' ' . $next_year; ?> »</a></li>
  </ul>
  </nav>
  
  <article class="pt-calendar">
  
  <h1>Calendar - <?php echo $title; ?></h1>
  
  <?php ed_search_results( $query, $qargs ); ?>

  </article>
  
  <nav>
  <ul class="pgn2">
    <li><a title="Learning resources starting in <?php echo format_month($last_month) . ' ' . $last_year; ?>" href="/calendar/<?php echo $last_year; ?>/<?php echo str_pad($last_month, 2, "0", STR_PAD_LEFT); ?>/">« <?php echo format_month($last_month) . ' ' . $last_year; ?></a></li>
    <li class="active">
    <?php 
    	if($this_year == $year && $this_month == $month)
    		echo 'Upcoming';
    	else
    		echo format_month($month) . ' ' . $year;
    ?></li>
    <li><a title="Learning resources starting in <?php echo format_month($next_month) . ' ' . $next_year; ?>" href="/calendar/<?php echo $next_year; ?>/<?php echo str_pad($next_month, 2, "0", STR_PAD_LEFT); ?>/"><?php echo format_month($next_month) . ' ' . $next_year; ?> »</a></li>
  </ul>
  </nav>
  
</div>

<?php 
get_footer();
?>