<?php

$pth = get_query_var("pth");

$path = explode('/', $pth);

// defaults
$motivation = $wiz_learners;
$sub_motivation = array();
$subject_area = array();
$subject = array();

$time = array();
$cost = array();
$style = array();

// check the first path element
if(count($path) > 0) {

	$m = $path[0];
	
	foreach($wiz_learners as $learner){
		if($learner["val"] == $m) {
			$motivation["val"] = $learner["val"];
			$motivation["label"] = $learner["label"];
			if($learner["subs"])
				$sub_motivation = $learner["subs"];
			else
				$subject_area = $subject_grid;
			break;
		} else {
			foreach($learner["subs"] as $sub) {
				if($sub["val"] == $m) {
					$motivation["val"] = $learner["val"];
					$motivation["label"] = $learner["label"];
					$sub_motivation["val"] = $sub["val"];
					$sub_motivation["label"] = $sub["label"];
					$subject_area = $subject_grid;
					break;
				}
			}
		}
	}
	
	// check the second path element
	if(count($path) > 1) {
		$s = $path[1];
		// this should be some sort of subject
		foreach($subject_grid as $sj => $more) {
			if($sj == $s) {
				$subject_area["val"] = $sj;
				$subject_area["label"] = $subject_all[$sj];
				$subject = $more;
			} else {
				foreach($more as $ssj) {
					if($ssj == $s) {
						$subject_area["val"] = $sj;
						$subject_area["label"] = $subject_all[$sj];
						$subject["val"] = $ssj;
						$subject["label"] = $subject_all[$ssj];
						$time = $wiz_time;
						break;
					}
				}
			}
		}
		
		if(count($path) > 2) {
			$t = $path[2];
			foreach($wiz_time as $wt) {
				if($wt["val"] == $t) {
					$time["val"] = $wt["val"];
					$time["label"] = $wt["label"];
					$cost = $wiz_matters;
					break;
				}
			}
			
			if(count($path) > 3) {
				$c = $path[3];
				foreach($wiz_matters as $wm) {
					if($wm["val"] == $c) {
						$cost["val"] = $wm["val"];
						$cost["label"] = $wm["label"];
						break;
					}
				}
			}
		}
	}
}

$override_canonical = '/discover/';

if(array_key_exists( "val" , $sub_motivation ))
	$override_canonical .= $sub_motivation["val"] . '/';
elseif(array_key_exists( "val" , $motivation ))
	$override_canonical .= $motivation["val"] . '/';

if(array_key_exists( "val" , $subject ))
	$override_canonical .= $subject["val"] . '/';
elseif(array_key_exists( "val" , $subject_area ))
	$override_canonical .= $subject_area["val"] . '/';

if(array_key_exists( "val" , $time ))
	$override_canonical .= $time["val"] . '/';

if(array_key_exists( "val" , $cost ))
	$override_canonical .= $cost["val"] . '/';

get_header();
?>

<div class="headfaker"> </div>

	<?php if($motivation && (!array_key_exists( "val" , $motivation ))) : ?>
	<div class="w0 slabs">
	<?php else: ?>
	<div class="w0">
	<?php endif; ?>
		
		<h1 class="not-front">Discover online learning resources</h1>
		
		<?php if(array_key_exists( "val" , $cost )) : ?> 
			<div class="dc0">
			<?php ed_style_grid( $subject["val"] ); ?>
			<hr class="hr" />
			</div>
		<?php endif; ?>
			
		<?php if($cost) : ?>
		
			<?php if(array_key_exists( "val" , $cost )) : ?>
				<div>
					<h3><?php echo $cost["label"]; ?></h3>
				</div>
			<?php else: ?>
				<div class="dc0">
					<?php foreach($cost as $c): ?>
						<a href="/discover/<?php echo $sub_motivation ? $sub_motivation["val"] : $motivation["val"]; ?>/<?php echo $subject ? $subject["val"] : $subject_area["val"]; ?>/<?php echo $time["val"]; ?>/<?php echo $c["val"]; ?>/" title="Discover resources for <?php echo $c["label"]; ?>"><?php echo $c["label"]; ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
				
		<?php endif; ?>
		
		<?php if($time) : ?>
		
			<?php if(array_key_exists( "val" , $time )) : ?>
				<div>
					<h3><?php echo $time["label"]; ?></h3>
				</div>
			<?php else: ?>
				<div class="dc0">
					<?php foreach($time as $t): ?>
						<a href="/discover/<?php echo $sub_motivation ? $sub_motivation["val"] : $motivation["val"]; ?>/<?php echo $subject ? $subject["val"] : $subject_area["val"]; ?>/<?php echo $t["val"]; ?>/" title="Discover resources for <?php echo $t["label"]; ?>"><?php echo $t["label"]; ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
				
		<?php endif; ?>
		
		<?php if($subject) : ?>
		
			<?php if(array_key_exists( "val" , $subject )) : ?>
				<div>
					<h3><?php echo $subject["label"]; ?></h3>
				</div>
			<?php else: ?>
				<div class="dc0">
					<?php foreach($subject as $ssj): ?>
						<a href="/discover/<?php echo $sub_motivation ? $sub_motivation["val"] : $motivation["val"]; ?>/<?php echo $ssj; ?>/" title="Discover resources for <?php echo $subject_all[$ssj]; ?>"><?php echo $subject_all[$ssj]; ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
				
		<?php endif; ?>
		
		<?php if($subject_area) : ?>
		
			<?php if(array_key_exists( "val" , $subject_area )) : ?>
				<div>
					<h3><?php echo $subject_area["label"]; ?></h3>
				</div>
			<?php else: ?>
				<div class="dc0">
					<?php foreach($subject_area as $sj => $more): ?>
						<a href="/discover/<?php echo $sub_motivation ? $sub_motivation["val"] : $motivation["val"]; ?>/<?php echo $sj; ?>/" title="Discover resources for <?php echo $subject_all[$sj]; ?>"><?php echo $subject_all[$sj]; ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
				
		<?php endif; ?>
		
		<?php if($sub_motivation) : ?>
		
			<?php if(array_key_exists( "val" , $sub_motivation )) : ?>
				<div>
					<h3><?php echo $sub_motivation["label"]; ?></h3>
				</div>
			<?php else: ?>
				<div class="dc0">
					<?php foreach($sub_motivation as $sub): ?>
						<a href="/discover/<?php echo $sub["val"]; ?>/" title="Discover resources for <?php echo $sub["label"]; ?>"><?php echo $sub["label"]; ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
				
		<?php endif; ?>


		<?php if($motivation) : ?>
			<?php if(array_key_exists( "val" , $motivation )) : ?>
				<div>
					<h3><?php echo $motivation["label"]; ?></h3>
				</div>
			<?php else: ?>
				<div>
					<h3>Choose your reason for studying:</h3>
					<?php foreach($motivation as $learner): ?>
						<a href="/discover/<?php echo $learner["val"]; ?>/" title="<?php echo $learner["label"]; ?>"><?php echo $learner["label"]; ?></a> &middot;
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
	</div>

<?php 

get_footer();

?>