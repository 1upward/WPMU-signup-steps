<?php 
if ($active_signup_type == "none") 	return;

$step = $last_stage;

if("default" == $last_stage){
	
	if ( $user_logged_in && ( $active_signup_type == 'all' || $active_signup_type == 'blog' ) ) {
		$step = "get_another_site";
	} elseif ( is_user_logged_in() == false && ( $active_signup_type == 'all' || $active_signup_type == 'user' ) ) {
		$step = "get_new_user";
	}
	
}
// get_another_site > gimmeanotherblog validation
// get_new_user 					> success: 	validate-user-signup (suscribe site)
//												> error: 		validate-user-signup (get_new_user)
// > validate-user-signup > success: 	validate-user-signup (suscribe site)
//												> error: 		validate-user-signup (get_new_user)
// > validate-blog-signup > success : link validation email
// 												> error : 	validate-blog-signup
?>

<div id="wp-signup-steps">
	<ol>
<?php if ("get_another_site" == $step || "gimmeanotherblog" == $step): ?>
		<li class="step <?php echo "get_another_site" == $step ? "active" : ""; ?>">Get another site</li>
		<li class="step <?php echo "gimmeanotherblog" == $step ? "active" : ""; ?>">Enjoy</li>
<?php else: ?>
		<li class="step <?php echo "get_new_user" == $step ? "active" : ""; ?>">Register your new user</li>
		<li class="step <?php echo "validate-user-signup" == $step ? "active" : ""; ?>">Register your new site</li>
		<li class="step <?php echo "validate-blog-signup" == $step ? "active" : ""; ?>">Check your mail and Enjoy</li>
<?php endif; ?>
	</ol>
</div>

<div class="debug">
	<p><?= $step ?> || <?= $last_stage ?></p>
	<p><?php echo $has_user_signup_errors ? "With user signup errors": ""; ?></p>
	<p><?php echo $has_blog_signup_errors ? "With blog signup errors": ""; ?></p>
</div>