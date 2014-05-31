<?php
/**
 * Static class with utils functions for a better template management and bring a DRY code.
 *
 * @package   wpmu-signup-steps
 * @author    jossemarGT <hello [at] jossemargt [dot] com>
 * @license   GPL-2.0+
 * @link      http://jossemargt.com
 * @copyright 5-29-2014 jossemarGT
 */
if (! class_exists("ViewManager") ){

	class ViewManager {

		/**
		*
		* Partial render a template and returns the template as string.
		*
		* @param $filePath - include path to the template.
		* @param null $viewData - any data to be used within the template.
		* @return string - The template to be rendered.
		*
		*/
		public function partialRender( $filePath, $viewData = null, $from_views_dir = true ) {
			$filePath = $from_views_dir ? plugin_dir_path(__FILE__) . $filePath : $filePath;
			( $viewData ) ? extract( $viewData ) : null;
			ob_start();
			require ( $filePath );
			$template = ob_get_contents();
			ob_end_clean();
			return $template;
		}

		/**
		*
		* Render a template and echoes it.
		*
		* @param $filePath - include path to the template.
		* @param null $viewData - any data to be used within the template.
		*
		*/
		public function render( $filePath, $viewData = null, $from_views_dir = true ) {
			$filePath = $from_views_dir ? plugin_dir_path(__FILE__) . $filePath : $filePath;
			( $viewData ) ? extract( $viewData ) : null;
			include ( $filePath );
		}
	}
	
}
?>