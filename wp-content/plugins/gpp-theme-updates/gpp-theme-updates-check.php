<?php
require( '../../../wp-load.php' );
$wp_version = $_POST['wpversion'];
$themename = $_POST['nicename'];
$apikey = $_POST['key'];
$endpoint = $_POST['endpoint'];				
		// Start checking for an update
		$options = array(
					'timeout' => 10,
					'body' => array(			 
						'themename' => $themename,
						'apikey' => $apikey,
						'user-agent' => "WordPress/$wp_version;" . get_bloginfo( 'url' )
					) 
				); 		
		$response = wp_remote_post( $endpoint, $options ); 	
		$gpp_theme_update = wp_remote_retrieve_body( $response );
		
		// If an error occurred, return error message.
		if ( $gpp_theme_update == 'error' || is_wp_error( $gpp_theme_update ) || !is_serialized( $gpp_theme_update ) ) {			
			echo json_encode( array( "dberror" ) );		
		} else {
			// Else, unserialize
			$gpp_theme_update = maybe_unserialize( $gpp_theme_update );				
			if( version_compare( GPP_THEME_UPDATES_ACTIVE_THEME_VERSION, $gpp_theme_update['new_version'], '>=' ) ) {
				echo json_encode( array( "uptodate" ) );
			} else {
				echo json_encode( $gpp_theme_update );
			}
		}