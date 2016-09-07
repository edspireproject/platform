<?php

// extra check that user is administrator
if (! current_user_can( 'manage_options' ))
 	go404();

?>

<!DOCTYPE html>
<head>
	<title>The search engine for online learning - edspire</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
	<link href="http://fonts.googleapis.com/css?family=Lato:400,300" rel="stylesheet" type="text/css"/>
	<style>
	/* above the fold css */
	html{font-size:16px;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}html,body,button,input,select,textarea {font-weight: 300;font-family: 'Lato', 'Helvetica Neue', helvetica, sans-serif;}
	body {margin:0;padding:0;background-color: #DDD;}p,pre{margin:1em 0}a{text-decoration: none;}a:focus{outline:thin dotted}a:active, a:hover{ outline:0 }b, strong { font-weight:bold }
	h1, h2 { margin: 0; }
	.i0 { width: 80%; font-size: 2em; padding: 0.2em 0.6em; border-radius: 20px; border: 1px solid #999; }
	.t0 { width: 40em; float: left; clear: left; min-height: 40em; font-size: 1.2em; line-height: 1.5em; padding: 1em; border-radius: 20px; }
	h3 { margin: 2px; text-align: center; }
	.su0 { width: 60em; float: right; background-color: #fff; padding: 10px; border-radius: 20px; }
	.su1 { width: 11em; float: left; border-radius: 16px; padding: 5px; margin-right: 5px; }
	.su1.s0 { background-color: #A8FE80; }
	.su1.s1 { background-color: #E5BC4F; }
	.su1.s2 { background-color: #FC6F5F; }
	.su1.s3 { background-color: #914BE5; }
	.su1.s4 { background-color: #53DBFE; }
	.su1 a { color: #000; text-align: center; display: block; padding: 3px 6px; margin: 2px; background-color: #EEE; }
	.su1.s0 a { background-color: #D8FEC1; }
	.su1.s1 a { background-color: #E5CA8A; }
	.su1.s2 a { background-color: #FCA7A0; }
	.su1.s3 a { background-color: #AD86E5; }
	.su1.s4 a { background-color: #94EDFE; }
 	.su1 a.su { background-color: #666; color: #FFFF00  } .su1 a.ps { background-color: #000; color: #FFFF00 }	
	.su1 a:first-child { border-radius: 8px 8px 0 0; }
	.su1 a:last-child { border-radius: 0 0 8px 8px; }
	.st0 { width: 40em; float: left; font-size: 120%; color: #fff; background-color: #fff; padding: 10px; border-radius: 20px; } 
	.st1 { width: 11em; float: left; border-radius: 16px; padding: 5px; margin-right: 5px; }
	.st1 a { text-align: center; color: #fff; display: block; padding: 4px 10px; margin: 2px; background-color: #EEE; }
	.st1.y0 { background-color: #005a8c; }
	.st1.y0 a { background-color: #297ca4; }
	.st1.y1 { background-color: #9b2408; }
	.st1.y1 a { background-color: #bf4b30; }
	.st1.y2 { background-color: #a68d2a; }
	.st1.y2 a { background-color: #d3b335; }
	.st1 a:first-child { border-radius: 8px 8px 0 0; }
	.st1 a:last-child { border-radius: 0 0 8px 8px; }
	.su1 a:hover { background-color: #000; color: #fff; }
	.st1 a:hover { background-color: #000; color: #fff; }
	.st1 a.st { background-color: #000; color: #FFFF00  }
	.h0 { padding: 0.5em; width: 98%; }
	.h1 { margin-bottom: 0.5em; }
	.m0 { float: right; clear: right; width: 60em; background-color: #fff; padding: 10px; border-radius: 20px; margin-top: 20px; }
	.m0 input { font-size: 1.2em; padding: 0.2em 0.6em; border-radius: 20px; border: 1px solid #999; } 
	.i1 { width: 700px; }
	.i2 { width: 200px; }
	.i3 { width: 300px; }
	.i4 { width: 100px; }
	.t2 { width: 300px; height: 100px; }
	.back { float: right; font-size: 1.2em; padding: 0.8em 1.1em; border-radius: 20px; border: 1px solid #999; margin-left: 2em; }
	.next { float: right; font-size: 1.2em; padding: 0.8em 1.1em; border-radius: 20px; border: 1px solid #999; margin-left: 1em; }
	.link { float: right; font-size: 1.2em; padding: 0.8em 1.1em; border-radius: 20px; border: 1px solid #999; }
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
	<div class="h0">
<?php

$id = get_query_var('s-id');
$data = get_query_var('s-ft');

if(empty($id) && empty($data)) :
	// if no params then show menu	
	echo 'No params';

elseif($id) :
	// if we have a number, show the record
	
	$args = array('p' => intval($id), 'post_type' => 'resource');

	$post_query = new WP_Query($args);
	if($post_query->have_posts()): 
		$post_query->the_post();
	
		// get next and last posts
	
	?>
	<script>
	window.postId = <?php echo $post->ID; ?>;
	</script>
	
	<div class="h1">

   		<a href="/superuser/<?php echo get_next_record($post->ID); ?>/" class="next">Next</a>
		<a href="/superuser/<?php echo get_back_record($post->ID); ?>/" class="back">Back</a>
		<a href="<?php echo the_permalink(); ?>" class="link">Link</a>
		<input id="inpt" name="inp-post-title" type="text" class="i0" value="<?php echo esc_attr(get_the_title()); ?>" />
		
		
   	</div>

   	<div class="st0">
   	<?php 
   	$st = get_post_meta($post->ID, 'edspire-style', true);
   	$ix = 0;
   	foreach( $style_grid as $format => $value ) {
   		echo '<div class="st1 y' . $ix . '">';
		echo '<h3 class="cn0">' . ucfirst($format) . '</h3><div>';
   		foreach( $value as $style ) {
			echo '<a id="style-' . $style . '" href="/' . $style . '/" class="dummy ' . ($st == $style ? 'st' : '') . '">' . $style_singular[$style] . '</a>';
   		}
   		echo '</div></div>';
   		$ix++;
   	}
   	
   	?>
   	</div>
   	
   	
   	<div class="su0">
   	<?php
   	$ps = get_post_meta($post->ID, 'edspire-primary-subject', true);
	$posttags = get_the_tags($post->ID);
	$su = array();
	foreach($posttags as $tag) {
		$su[] = $tag->slug;
	}
   	$ix = 0;
   	$slocal = array("science", "social-sciences", "humanities", "professional", "lifestyle");

   	foreach( $slocal as $area ) {
		$value = $subject_grid[$area];
   		echo '<div class="su1 s' . $ix . '"><h3>' . ucfirst($area) . '</h3><div>';
   		foreach( $value as $subject ) {
			echo '<a id="subject-' . $subject . '" href="/' . $subject . '/' . $style . '/" class="dummy ';
			if($ps == $subject)
				echo 'ps ';
			if(in_array($subject, $su))
				echo 'su ';
			echo '">' . $subject_short[$subject] . '</a>';
   		}
   		echo '</div></div>';
   		$ix++;
   	}
   	?>
   	</div>
   	
   	<textarea id="txtc" class="t0" name="inp-post-content">
   	<?php echo $post->post_content; ?>
   	</textarea>
   	
   	<?php
   	
   	$provider = get_post_meta($post->ID, 'wpcf-provider', true);
   	$format = get_post_meta($post->ID, 'wpcf-format', true);
   	$style = strval(get_post_meta($post->ID, 'wpcf-style', true));
   	$university = get_post_meta($post->ID, 'wpcf-university', true);
   	$provider_link = get_post_meta($post->ID, 'wpcf-provider-link', true);
   	$cost = strval(get_post_meta($post->ID, 'wpcf-cost', true));
   	$cost_cur = strval(get_post_meta($post->ID, 'wpcf-cost-cur', true));
   	$cost_val = strval(get_post_meta($post->ID, 'wpcf-cost-val', true));
   	$cost_sub = strval(get_post_meta($post->ID, 'wpcf-cost-sub', true));
   	$availability = strval(get_post_meta($post->ID, 'wpcf-availability', true));
   	$language = strval(get_post_meta($post->ID, 'wpcf-language', true));
   	$next_start = strval(get_post_meta($post->ID, 'wpcf-next-start', true));
   	$schedule = strval(get_post_meta($post->ID, 'wpcf-schedule', true));
   	$duration = strval(get_post_meta($post->ID, 'wpcf-duration', true));
   	$licence = strval(get_post_meta($post->ID, 'wpcf-licence', true));
   	$workload = strval(get_post_meta($post->ID, 'wpcf-workload', true));
   	$workload_min = strval(get_post_meta($post->ID, 'wpcf-workload-min', true));
   	$workload_max = strval(get_post_meta($post->ID, 'wpcf-workload-max', true));
   	$video_url = get_post_meta($post->ID, 'wpcf-video-intro', true);
   	$length = get_post_meta($post->ID, 'wpcf-video-length', true);
   	$teachers = get_post_meta($post->ID, 'wpcf-teacher', false);
   	?>
   	
   	<div class="m0">
   		<table>
   		  <tr>
   		    <td>Link</td>
   		    <td><input type="text" class="i1" name="wpcf-provider-link" value="<?php echo esc_attr( $provider_link ); ?>"/></td>
   		    <td><a href="<?php echo $provider_link; ?>">Link</a></td>
   		  </tr>
   		  <tr>
   		    <td>Provider</td>
   		    <td><input type="text" class="i1" name="wpcf-provider" value="<?php echo esc_attr( $provider ); ?>"/></td>
   		    <td><button id="blank-wpcf-provider-link">X</button></td>
   		  </tr>
   		  <tr>
   		    <td>University</td>
   		    <td><input type="text" class="i1" name="wpcf-university" value="<?php echo esc_attr( $university ); ?>"/></td>
   		    <td><button id="blank-wpcf-university">X</button></td>
   		  </tr>
   		  <tr>
   		    <td>Licence</td>
   		    <td><input type="text" class="i1" name="wpcf-licence" value="<?php echo esc_attr( $licence ); ?>"/></td>
   		    <td><button id="blank-wpcf-licence">X</button></td>
   		  </tr>
   		  <tr>
   		    <td>Language</td>
   		    <td><input type="text" class="i1" name="wpcf-language" value="<?php echo esc_attr( $language ); ?>"/></td>
   		    <td><button id="blank-wpcf-licence">X</button></td>
   		  </tr>
   		  <tr>
   		    <td>Cost</td>
   		    <td><input type="text" class="i2" name="wpcf-cost" value="<?php echo esc_attr( $cost ); ?>"/>
   		    (cur) <input type="text" class="i4" name="wpcf-cost-cur" value="<?php echo esc_attr( $cost_cur ); ?>"/>
   		    (val) <input type="text" class="i4" name="wpcf-cost-val" value="<?php echo esc_attr( $cost_val ); ?>"/>
   		    (sub) <input type="text" class="i4" name="wpcf-cost-sub" value="<?php echo esc_attr( $cost_sub ); ?>"/>
   		    </td>
   		    <td> </td>
   		  </tr>
   		  <tr>
   		    <td>Workload</td>
   		    <td><input type="text" class="i3" name="wpcf-workload" value="<?php echo esc_attr( $workload ); ?>"/>
   		    (min) <input type="text" class="i4" name="wpcf-workload-min" value="<?php echo esc_attr( $workload_min ); ?>"/>
   		    (max) <input type="text" class="i4" name="wpcf-workload-max" value="<?php echo esc_attr( $workload_max ); ?>"/>
   		    </td>
   		    <td> </td>
   		  </tr>
   		  <tr>
   		    <td>Duration</td>
   		    <td><input type="text" class="i3" name="wpcf-duration" value="<?php echo esc_attr( $duration ); ?>"/>
   		    (video) <input type="text" class="i4" name="wpcf-workload-min" value="<?php echo esc_attr( $length ); ?>"/>
   		    </td>
   		    <td> </td>
   		  </tr>
   		  <tr>
   		    <td>Schedule</td>
   		    <td><input type="text" class="i4" name="wpcf-schedule" value="<?php echo esc_attr( $schedule ); ?>"/>
   		    <input type="text" class="i3" name="wpcf-next-start" value="<?php echo esc_attr( $next_start ); ?>"/>
   		    </td>
   		    <td> </td>
   		  </tr>
   		  <tr>
   		    <td>Preview</td>
   		    <td><input type="text" class="i1" name="wpcf-schedule" value="<?php echo esc_attr( $video_url ); ?>"/></td>
   		    <td><a href="<?php echo $video_url; ?>">Link</a></td>
   		  </tr>
   		  <tr>
   		    <td>Teachers</td>
   		    <td><textarea id="txtt" class="t2" name="wpcf-teachers"><?php if($teachers) { foreach($teachers as $teacher ) { echo $teacher . "\n"; } } ?></textarea>
   		    </td>
   		    <td><button id="blank-wpcf-licence">X</button></td>
   		  </tr>
   		  
   		</table>
   	</div>
   	
   	<?php 
   	else:
   		echo 'Post not found';
	endif;

else :
	// otherwise parse the action
	echo 'Action';


endif;

?>
	</div>
	<script>
	$(function() {
		$('.su1 a').click(function(e) {
			e.preventDefault();
			var $a = $(this);
			if(!window.clickT)
				window.clickT = setTimeout(function() {
					clickIt($a);
				}, 300);
		}).dblclick(function(e) {
			e.preventDefault();
			var $a = $(this);
			clearTimeout(window.clickT);
			window.clickT = setTimeout(function() {
				dblclickIt($a);
			}, 300);
		});
		$('.st1 a').click(function(e) {
			e.preventDefault();
			var $a = $(this);
			var style = $a.attr('id').substring(6);
			$('.st1 a').not($a).removeClass('st');
			doUpdateMeta(window.postId, 'edspire-style', style);
			$a.addClass('st');
		});
		$('.m0 input').add('#inpt').add('#txtc').add('#txtt').each(function(ix, inp) {
			var $inp = $(inp);
			$inp.blur(function(e) {
				doUpdateMeta(window.postId, $inp.attr('name'), $inp.val());
			});
		});
	});

	function clickIt($a) {
		var slug = $a.attr('id').substring(8);
		if($a.hasClass('ps')) {
			doUpdateMeta(window.postId, 'edspire-primary-subject', '');
			doUpdateSubject(window.postId, slug, 'remove');
			$a.removeClass('ps').removeClass('su');
		} else if($a.hasClass('su')) {
			doUpdateSubject(window.postId, slug, 'remove');
			$a.removeClass('su');
		} else {
			doUpdateSubject(window.postId, slug, 'add');
			$a.addClass('su');
		}
		window.clickT = false;
		$a.blur();
	};

	function dblclickIt($a) {
		var slug = $a.attr('id').substring(8);
		if($a.hasClass('ps')) {
			doUpdateMeta(window.postId, 'edspire-primary-subject', '');
			doUpdateSubject(window.postId, slug, 'remove');
			$a.removeClass('ps').removeClass('su');
		} else if($a.hasClass('su')) {
			doUpdateMeta(window.postId, 'edspire-primary-subject', slug);
			$a.addClass('ps');
		} else {
			$('.su1 a').not($a).removeClass('ps');
			doUpdateMeta(window.postId, 'edspire-primary-subject', slug);
			doUpdateSubject(window.postId, slug, 'add');
			$a.addClass('ps').addClass('su');
		}
		window.clickT = false;
		$a.blur();
	};
	
	function doUpdateMeta(id, key, value) {
		$.post('/superuser-crud/update_meta.php', {
	    	post_id: id,
	    	meta_key: key,
	    	meta_value: value
	  	}, function(data) {
			console.log(data);
	  	});
	};

	function doUpdateSubject(id, subject, addRemove) {
		$.post('/superuser-crud/update_subject.php', {
	    	post_id: id,
	    	slug: subject,
	    	todo: addRemove
	  	}, function(data) {
			console.log(data);
	  	});
	};
	
	</script>
</body>
</html>
<?php 

function get_next_record($id) {
	global $wpdb;
	$sql = "SELECT min(ID) as id FROM ed_posts where ID > " . $id . " and post_type = 'resource' and post_status = 'publish' ";
	foreach ( $wpdb->get_results( $sql ) as $count_row )
		return intval($count_row->id);
	$sql = "SELECT min(ID) as id FROM ed_posts where post_type = 'resource' and post_status = 'publish' ";
	foreach ( $wpdb->get_results( $sql ) as $count_row )
		return intval($count_row->id);
}

function get_back_record($id) {
	global $wpdb;
	$sql = "SELECT max(ID) as id FROM ed_posts where ID < " . $id . " and post_type = 'resource' and post_status = 'publish' ";
	foreach ( $wpdb->get_results( $sql ) as $count_row )
		return intval($count_row->id);
	$sql = "SELECT max(ID) as id FROM ed_posts where post_type = 'resource' and post_status = 'publish' ";
	foreach ( $wpdb->get_results( $sql ) as $count_row )
		return intval($count_row->id);
}


?>