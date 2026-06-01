<?php

/**
 * Common functions class
 *
 * @author ISK
 */

class common {

	/**
	* @desc rediraction function using javaScript
	* @param url adress we redirect to
	*/
	public static function redirect($url) {
		echo "<script type='text/javascript'>document.location.href='" . $url . "';</script>";
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $url . '">';
	}
	
	/**
	* @desc  Message display function using JS
	* @param output  array of values for printing
	*/
	public static function logToConsole($output) {
		$js_code = '';
		foreach($output as $val) {
			$js_code .= 'console.log("' . $val . '");';
		}

		$js_code = '<script>' . $js_code . '</script>';
		
		echo $js_code;
	}
}

?>