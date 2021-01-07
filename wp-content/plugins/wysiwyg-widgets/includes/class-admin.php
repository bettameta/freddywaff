<?php

class WYSIWYG_Widgets_Admin {

	public function __construct() {
		//add_action('init', array($this, 'add_caps') );
		add_action( 'add_meta_boxes', array($this, 'add_meta_box'), 20 );
	}

	/**
	 * Add Capability to edit widget block
	 */
	public function add_caps() {
		$caps_version = '1.1';

		// did we add the caps already?
		$db_version = get_option( 'wywi_caps_version', 0 );
		if( version_compare( $db_version, $caps_version, '>=' ) ) {
			return;
		}
		
		$role = get_role( 'administrator' );
		$role->add_cap( 'edit_widget_block' );
		//update_option('wywi_caps_version', $caps_version);
	}

	/**
	 * Add meta box to "edit" screen
	 */
	public function add_meta_box() {
		add_meta_box( 
            'wysiwyg-widget-donate-box',
	        __( 'More..', 'wysiwyg-widgets' ),
	        array( $this, 'meta_donate_box' ),
	        'wysiwyg-widget',
	        'side',
            'low'
	    );
	}

	/**
	 * Render the meta box on the "edit screen"
	 *
	 * @param $post
	 */
	public function meta_donate_box( $post ) {
		?>
			<div>
				<h4><?php _e('How do I use this?', 'wysiwyg-widgets'); ?></h4>
				<p><?php printf(__('Show this widget block by going to your %swidgets page%s and then dragging the <strong>WYSIWYG Widget</strong> to one of your widget areas.', 'wysiwyg-widgets'), '<a href="'. admin_url('widgets.php') .'">', '</a>'); ?></p>
			</div>

			<div style="margin-top: 30px;">
				<h4><?php _e( 'Help promote this plugin', 'wysiwyg-widgets' ); ?></h4>
				<ul class="ul-square">
					<li><a href="https://wordpress.org/support/view/plugin-reviews/wysiwyg-widgets?rate=5#postform" target="_blank"><?php _e('Leave a &#9733;&#9733;&#9733;&#9733;&#9733; review on WordPress.org', 'wysiwyg-widgets'); ?></a></li>
            		<li><a href="https://wordpress.org/plugins/wysiwyg-widgets/#compatibility"><?php _e('Vote "works" on the WordPress.org plugin page', 'wysiwyg-widgets'); ?></a></li>
				</ul>
			</div>

			<div style="margin-top: 30px;">
				<h4><?php _e('Our other plugins', 'wysiwyg-widgets'); ?></h4>
				<ul class="ul-square">
					<li><a href="https://wordpress.org/plugins/mailchimp-for-wp/">Mailchimp for Wordpress</a></li>
                    <li><a href="https://wordpress.org/plugins/koko-analytics/">Koko Analytics</a></li>
                    <li><a href="https://wordpress.org/plugins/html-forms/">HTML Forms</a></li>
                    <li><a href="https://wordpress.org/plugins/boxzilla/">Boxzilla Pop-Ups</a></li>
					<li><a href="https://wordpress.org/plugins/mailchimp-top-bar/">MailChimp Top Bar</a></li>
				</ul>
			</div>

		<?php
	}
}