<?php
/**
 * WARNING: DO NOT edit
 * this file under any circumstances. Please do all modifications
 * in the form of a child theme.
 *
 * @package GPP Theme Updates
 *
 **/
 
 /**
 * Add submenu on Appearance tab for the Updates page only if it's a gpp theme
 */

 
 
$theme_data = get_theme_data(get_stylesheet_directory().'/style.css');
$theme_author = $theme_data['AuthorURI'];

if ( $theme_author == 'http://graphpaperpress.com' || $theme_author == 'http://graphpaperpress.com/' || $theme_author == 'http://thadallender.com' ) add_action( 'admin_menu', 'gpp_theme_updates_menu' );
function gpp_theme_updates_menu() {
	add_submenu_page( 'themes.php', 'Theme Updates', 'Theme Updates', 'manage_options', 'gpp-theme-updates', 'gpp_theme_updates_page' );
}

 
/* The theme update page */
function gpp_theme_updates_page() {
	global $wp_version, $apikey;
	//$auto_update_url = wp_nonce_url('update.php?action=upgrade-theme&amp;theme='.GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME, 'upgrade-theme_'.GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME);
	
	$auto_update_url = GPP_THEME_UPDATES_PLUGIN_URL."gpp-theme-backup.php?backup=true";
	
	$download_url = 'http://graphpaperpress.com/members/member.php';
	$dev_blog_url = 'http://demo.graphpaperpress.com/wp-content/themes/'.GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME.'/changelog.txt?TB_iframe=true;height=500&width=950';		
	
	echo '<div class="gpp_update gpp_message gpp_update_page">';
		echo '<div class="wrap">';
			echo '<h4 class="loader">Checking for updates</h4>';
		echo '</div>';		
	echo '</div>';
	
	
	$doc_ready_script = '	
	<script type="text/javascript">
		jQuery(document).ready(function(){	
		
		';

		$doc_ready_script .= '						
			jQuery.ajax({
				dataType: "json",
				type: "POST",
				url: "'.GPP_THEME_UPDATES_PLUGIN_URL.'gpp-theme-updates-check.php",
				data: "wpversion='.$wp_version.'&nicename='.GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME.'&key='.GPP_THEME_UPDATES_KEY.'&endpoint='.GPP_THEME_UPDATES_ENDPOINT.'",
				success: function( data ) {			
				if ( data == "uptodate" ) {
					jQuery(".gpp_update_page .wrap").html("<h4>Congratulations! You have the latest version of '.get_current_theme().'.</h4>");
				} else if ( data == "dberror" ) {
					jQuery(".gpp_update_page .wrap").html("<h4>Unable to connect to server! Please try after a while or <a href=\"themes.php?page=gpp-theme-updates\">refresh this page now</a>.</h4>");
				} else {
					var exten = data.package.slice(-3);					
					if ( exten != "php" ) {
						jQuery(".gpp_update_page .wrap").html("<h2>'.get_current_theme().' "+data.new_version+" is available - <span><a href=\"'.$dev_blog_url.'\" class=\"thickbox thickbox-preview\">View Changelog</a></span></h2>");
					} else {
						jQuery(".gpp_update_page .wrap").html("<h2>'.get_current_theme().' "+data.new_version+" is available - <span><a href=\"'.$dev_blog_url.'\" class=\"thickbox thickbox-preview\">View Changelog</a></span></h2>"+
							"<p>Your license key is not valid. Please signup for a paid GPP account to receive a license key and enter it in the field below and save to enable automatic theme updates. Your License Key is displayed on your <a href=\"http://graphpaperpress.com/members/member.php\" target=\"_blank\" title=\"Visit Graph Paper Press in a new window\">Member Dashboard</a> if you have an active, paid account.  If you have an expired or free account, you will need to download the theme update manually and replace the outdated theme via FTP or  <a href=\"http://graphpaperpress.com/members/member.php?tab=add_renew\" target=\"_blank\" title=\"Visit Graph Paper Press in a new window\">upgrade</a> to receive automatic theme updates.</p><form id=\"apisave\" action=\"#\" method=\"POST\">"+
							"<h4>API key:</h4> <input type=\"text\" id=\"apikey\" name=\"apikey\" value=\"'.$apikey.'\">"+
							"<input type=\"submit\" id=\"keysubmit\" class=\"button-secondary\" name=\"keysubmit\" value=\"Save\">"+
							"</form>");
					}
					if ( exten != "php" ) {
						jQuery(".gpp_update_page .wrap").append("<h4><strong>Before you update</strong>, you should know that:</h4>"+
							"<ul><li>If you modified your theme files in any way, and you update, all modifications will be lost.</li>"+
							"<li>A backup copy of your existing theme will be created in your themes folder.</li>"+
							"<li>Updating your theme will not effect your content or your existing theme option settings.</li></ul>"+
							"<h4><strong>Updating a child theme?</strong> - Please follow these instructions:</h4>"+											
							"<ol><li><a href=\"themes.php\">Switch</a> to the parent theme and if an update is available for it, <a href=\"themes.php?page=gpp-theme-updates\">update it</a></li>"+
							"<li><a href=\"themes.php\">Switch</a> back to your child theme and <a href=\"themes.php?page=gpp-theme-updates\">update it</a></li></ol>"+
							"<p><a class=\"button-primary\" href=\"'.$auto_update_url.'\" onclick=\"return confirm(\'Warning: If you have customized your template files in any way, all modifications will be lost.  You have been warned!\');\">Update Now &raquo;</a></p>"+
							"<form id=\"apisave\" action=\"#\" method=\"POST\">"+
							"<h4>API key:</h4> <input type=\"text\" id=\"apikey\" name=\"apikey\" value=\"'.$apikey.'\">"+
							"<input type=\"submit\" id=\"keysubmit\" class=\"button-primary\" name=\"keysubmit\" value=\"Save\">"+
							"</form>");
					}
				} 
			   				
				

				}
			 });';
	$doc_ready_script .= '			 
			});
		</script>
		';
	echo $doc_ready_script;	
	
}


//  the update
function gpp_theme_updates_check() {
	global $wp_version;	
	
	$gpp_theme_update = get_transient('gpp-theme-updates');	
	if ( !$gpp_theme_update ) {			
		// Start checking for an update
		$options = array(
					'body' => array(			 
						'themename' => GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME,
						'apikey' => GPP_THEME_UPDATES_KEY,
						'user-agent' => "WordPress/$wp_version;" . get_bloginfo( 'url' )
					)
				);	
		$response = wp_remote_post( GPP_THEME_UPDATES_ENDPOINT, $options );		
		$gpp_theme_update = wp_remote_retrieve_body( $response );				
		// If an error occurred, return error message.
		if ( $gpp_theme_update == 'error' || is_wp_error( $gpp_theme_update ) || !is_serialized( $gpp_theme_update ) ) {
			return "Unable to connect to server! Please try after a while.";			
		}
			
		// Else, unserialize
			$gpp_theme_update = maybe_unserialize( $gpp_theme_update );	
			
		// And store in transient	
			set_transient( 'gpp-theme-updates', $gpp_theme_update, 5 ); 
	}	
	
	// If we're already using the latest version, return FALSE
	 if ( version_compare( GPP_THEME_UPDATES_ACTIVE_THEME_VERSION, $gpp_theme_update['new_version'], '>=' ) )
		return FALSE; 	
	
	return $gpp_theme_update;
}

function gpp_theme_update_check_only() {
	global $wp_version;	
	
	$gpp_theme_check = get_transient( 'gpp-theme-check' );	
	if ( !$gpp_theme_check ) {			
		// Start checking for an update
		
			$options = array(
						'body' => array(			 
							'themename' => GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME,
							'onlycheck' => "onlycheck",
							'user-agent' => "WordPress/$wp_version;" . get_bloginfo( 'url' )
						)
					);		
		
		$response = wp_remote_post( GPP_THEME_UPDATES_ENDPOINT, $options );
		$gpp_theme_check = wp_remote_retrieve_body( $response );				
		// If an error occurred, return error message.
		if ( $gpp_theme_check == 'error' || is_wp_error( $gpp_theme_check ) || !is_serialized( $gpp_theme_check ) ) {
			set_transient( 'gpp-theme-check', array( 'new_version' => GPP_THEME_UPDATES_ACTIVE_THEME_VERSION ), 60*60 ); 	// 60*60	
		}
			
		// Else, unserialize
			$gpp_theme_check = maybe_unserialize( $gpp_theme_check );
	
		// And store in transient	
			set_transient( 'gpp-theme-check', $gpp_theme_check, 60*60*24 ); //60*60*24
			// If we're already using the latest version, return FALSE
		 if ( version_compare( GPP_THEME_UPDATES_ACTIVE_THEME_VERSION, $gpp_theme_check['new_version'], '>=' ) )
			return FALSE; 	
		
		return $gpp_theme_check;
	} else {
		return FALSE; 
	}	
	
	
}

// Only show update message on the theme options page for GPP Themes
//if ( is_admin() && $pagenow == "update-core.php" ) {
if ( is_admin() && ( isset( $_GET['page'] ) ) && ( $_GET['page'] == "gppthemes") ) {
	add_action( 'admin_notices', 'gpp_theme_updates_admin_notice' );
}

// Add Thickbox
if ( is_admin() && ( isset( $_GET['page'] ) ) && ( $_GET['page'] == "gpp-theme-updates" ) ) {
	add_action( 'init', 'gpp_theme_thickbox' );
}

// add thickbox to update-core.php page
function gpp_theme_thickbox() {
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_style( 'thickbox' );           
}    

// The update message
function gpp_theme_updates_admin_notice() {
	$gpp_theme_check = gpp_theme_update_check_only();	
	if ( !$gpp_theme_check ) {		
		return false;
	} else { 		
		$dev_blog_url = 'http://demo.graphpaperpress.com/wp-content/themes/'.GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME.'/readme.txt?TB_iframe=true;height=500&width=950';			
		echo '<div class="updated fade gpp_update gpp_message"><h4>';
		printf( __( '<h4><strong>%s</strong> %s is available.  <a href="%s" class="button-primary">Update Now</a>' ), get_current_theme(), esc_html( $gpp_theme_check['new_version'] ), 'themes.php?page=gpp-theme-updates' );
		echo '</h4></div>'; 
	}
} 


// Checks if new theme is available and if yes adds the proper array to $value
//if((isset($_GET['page']) && ($_GET['page'] == "gppthemes-updates")) || (isset($_GET['action']) && $_GET['action']=='upgrade-theme')){
if( ( isset( $_GET['action'] ) && $_GET['action'] == 'upgrade-theme' ) ) {
	add_filter( 'site_transient_update_themes', 'gpp_theme_updates_push' );
	add_filter( 'transient_update_themes', 'gpp_theme_updates_push' );
}
function gpp_theme_updates_push( $value ) {	
	$gpp_theme_update = gpp_theme_updates_check();	
	if ( $gpp_theme_update ) {
		$value->response[GPP_THEME_UPDATES_ACTIVE_THEME_NICENAME] = $gpp_theme_update;
	}	
	return $value;	
}

// Runs once the new theme is updated
add_action( 'load-update.php', 'gpp_theme_updates_clear_update_transient' );
add_action( 'load-themes.php', 'gpp_theme_updates_clear_update_transient' );
function gpp_theme_updates_clear_update_transient() {	
	delete_transient( 'gpp-theme-updates' );		
}