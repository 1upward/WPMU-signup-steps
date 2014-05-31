/**
 * @package   wpmu-signup-steps
 * @author    jossemarGT <hello [at] jossemargt [dot] com>
 * @license   GPL-2.0+
 * @link      http://jossemargt.com
 * @copyright 5-29-2014 jossemarGT
 */

(function ($) {
	"use strict";
	$(function () {
		
		// Fixing steps behavior
		var $activeStep = null;
		
		console.log(steps_fixes);
		
		if (steps_fixes.user_signup_has_errors === "1" || steps_fixes.blog_signup_has_errors === "1") {
			$activeStep = $("#wp-signup-steps .active");
			$activeStep.removeClass("active").prev().addClass("error");
		}

	});
}(jQuery));