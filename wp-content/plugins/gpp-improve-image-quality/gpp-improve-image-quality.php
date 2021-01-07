<?php

/*
Plugin Name: GPP Improve Image Quality
Plugin URI: http://graphpaperpress.com/plugins/gpp-improve-image-quality/
Description: Improves WordPress' default image quality from 60 to 100
Author: Thad Allender, Chandra Maharzan
Version: 1.0
Author URI: http://graphpaperpress.com
*/

function gpp_jpeg_quality_callback($arg) {
	return (int)100; // change 100 to whatever you prefer, but don't go below 60
}

add_filter('jpeg_quality', 'gpp_jpeg_quality_callback');

?>
