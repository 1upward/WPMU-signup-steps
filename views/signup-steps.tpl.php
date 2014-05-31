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
		<li class="step <?php echo "get_another_site" == $step ? "active" : ""; ?>"><?php _e("Get another site", $locale_slug); ?></li>
		<li class="step <?php echo "gimmeanotherblog" == $step ? "active" : ""; ?>"><?php _e("Enjoy", $locale_slug); ?></li>
<?php else: ?>
		<li class="step <?php echo "get_new_user" == $step ? "active" : ""; ?>"><?php _e("Register your user", $locale_slug); ?></li>
		<li class="step <?php echo "validate-user-signup" == $step ? "active" : ""; ?>"><?php _e("Register your site", $locale_slug); ?></li>
		<li class="step <?php echo "validate-blog-signup" == $step ? "active" : ""; ?>"><?php _e("Check your mail and enjoy!", $locale_slug); ?></li>
<?php endif; ?>
	</ol>
</div>

<!--
<div class="debug">
	<p><?= $step ?> || <?= $last_stage ?></p>
	<p><?php echo $has_user_signup_errors ? "With user signup errors": ""; ?></p>
	<p><?php echo $has_blog_signup_errors ? "With blog signup errors": ""; ?></p>
</div>
-->