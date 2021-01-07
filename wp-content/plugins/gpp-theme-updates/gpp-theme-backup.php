<?php 

/**
Backups existing theme with version number appended at the back.
*/
//required to use native wordpress functions outside wordpress files.
require( '../../../wp-load.php' );

// Get theme information from style.css file
$theme_data = get_theme_data(get_stylesheet_directory().'/style.css');
   
if( $_GET['backup'] ) {	
	// copy the existing theme with the new name as a backup 
	copy_directory( get_theme_root() . "/".GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME, get_theme_root() . "/".GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME."_" . $theme_data['Version'] );	
	
	// redirect the process to update the theme after the backup of the existing theme.
	header( 'Location:' . htmlspecialchars_decode( wp_nonce_url( site_url() . '/wp-admin/update.php?action=upgrade-theme&amp;theme=' . GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME, 'upgrade-theme_' . GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME ) ) );
}

/**
Recursive function to copy the nested folder from one place to another.
**/
function copy_directory( $source, $destination ) {
	if ( is_dir( $source ) ) {
		@mkdir( $destination );
		$directory = dir( $source );
		while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
			if ( $readdirectory == '.' || $readdirectory == '..' ) {
				continue;
			}
			$PathDir = $source . '/' . $readdirectory; 
			if ( is_dir( $PathDir ) ) {
				copy_directory( $PathDir, $destination . '/' . $readdirectory );
				continue;
			}
			copy( $PathDir, $destination . '/' . $readdirectory );
		}
 
		$directory->close();
	} else {
		copy( $source, $destination );
	}
}
?>