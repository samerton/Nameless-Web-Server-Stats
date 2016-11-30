<?php
/*
 *	Made by Samerton
 *  https://github.com/NamelessMC/Nameless/
 *  NamelessMC version 2.0.0-dev
 *
 *  License: MIT
 *
 *  Admin server stats page
 */

// Can the user view the AdminCP?
if($user->isLoggedIn()){
	if(!$user->canViewACP()){
		// No
		Redirect::to(URL::build('/'));
		die();
	} else {
		// Check the user has re-authenticated
		if(!$user->isAdmLoggedIn()){
			// They haven't, do so now
			Redirect::to(URL::build('/admin/auth'));
			die();
		}
	}
} else {
	// Not logged in
	Redirect::to(URL::build('/login'));
	die();
}
 
 
$page = 'admin';
$admin_page = 'server';

?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	<?php 
	$title = $language->get('admin', 'admin_cp');
	require('core/templates/admin_header.php'); 
	?>
  
  </head>
  <body>
    <?php require('modules/Core/pages/admin/navbar.php'); ?>
	<div class="container">
	  <div class="row">
	    <div class="col-md-3">
		  <?php require('modules/Core/pages/admin/sidebar.php'); ?>
		</div>
		<div class="col-md-9">
		  <div class="card">
		    <div class="card-block">
			  <h3><?php echo $ss_language->get('language', 'server_stats'); ?></h3>
			  
			  <?php
			  // Get load information
			  $free = shell_exec('free');
			  $free = (string)trim($free);
			  $free_arr = explode("\n", $free);
			  
			  if(!count($free_arr) || (count($free_arr) && !isset($free_arr[1]))){
				  // Can't obtain info
				  echo '<div class="alert alert-danger">' . $ss_language->get('language', 'unable_to_obtain_info') . '</div>';
				  
			  } else {
				  $mem = explode(" ", $free_arr[1]);
				  $mem = array_filter($mem);
				  $mem = array_merge($mem);
				  $memory_usage = number_format((float)($mem[2]/$mem[1]*100), 2, '.', '');
				  
				  $load = sys_getloadavg();
				  $load = number_format((float)$load[0], 2, '.', '');
				  
				  $users_online = $queries->getWhere('users', array('last_online', '>', strtotime('-10 minutes')));
				  $users_online = count($users_online);
			  ?>
			  <hr />
			  <div class="row">
			    <div class="col-md-4">
				  <div class="card card-inverse card-primary text-xs-center">
					<div class="card-block">
					  <h3 class="card-title"><?php echo $ss_language->get('language', 'users_online'); ?></h3>
					  <p class="card-text"><?php echo $users_online; ?></p>
					</div>
				  </div>
				</div>
				<div class="col-md-4">
				  <div class="card card-inverse card-<?php
				  if($memory_usage < 50){
					  // Under 50%
					  echo 'success';
				  } else if($memory_usage >= 50 && $memory_usage < 75){
					  // 50-75%
					  echo 'warning';
				  } else {
					  // Over 75%
					  echo 'danger';
				  }
				  ?> text-xs-center">
					<div class="card-block">
					  <h3 class="card-title"><?php echo $ss_language->get('language', 'memory_usage'); ?></h3>
					  <p class="card-text"><?php echo $memory_usage; ?>%</p>
					</div>
				  </div>
				</div>
				<div class="col-md-4">
				  <div class="card card-inverse card-<?php
				  if($load < 50){
					  // Under 50%
					  echo 'success';
				  } else if($load >= 30 && $load < 75){
					  // 50-75%
					  echo 'warning';
				  } else {
					  // Over 75%
					  echo 'danger';
				  }
				  ?> text-xs-center">
				    <div class="card-block">
					  <h3 class="card-title"><?php echo $ss_language->get('language', 'cpu_usage'); ?></h3>
					  <p class="card-text"><?php echo $load; ?>%</p>
					</div>
				  </div>
				</div>
			  </div>
			  <?php } ?>
		    </div>
		  </div>
		</div>
	  </div>
    </div>
	
	<?php require('modules/Core/pages/admin/footer.php'); ?>

    <?php require('modules/Core/pages/admin/scripts.php'); ?>
	
  </body>
</html>