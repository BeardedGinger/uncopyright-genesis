<?php
/**
 * Plugin Name: Uncopyright Genesis Website
 * Plugin URI: http://github.com/BeardedGinger/Uncopyright-Genesis
 * Description: Removes traditional "copyright" text from a Genesis site and replaces with an uncopyright link with uncopyright info in a modal window
 * Version: 1.0.0
 * Author: Josh Mallard
 * Author URI: http://joshmallard.com
 * License: Do whatever the f*** you want (in the spirit of uncopyright)
 * GitHub Plugin URI: https://github.com/BeardedGinger/Uncopyright-Genesis
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
        die;
}

class Uncopyright_Genesis {
	
	/**
	 * Set plugin version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';
	
	/**
	 * Instance of the class
	 *
	 * @since 1.0.0
	 */
	protected static $instance = null;
	
	/**
	 * Initialize the plugin
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		
		// Load public-facing style sheet and JavaScript.
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
    	add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    	
    	// Filter the footer text
    	add_filter( 'genesis_footer_creds_text', array( $this, 'uncopyright_genesis_footer' ) );
    	
    	// Add the modal content
    	add_action( 'genesis_after_footer', array( $this, 'uncopyright_genesis_content' ) );
	
	}
	
	/**
   	 * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
        }

		return self::$instance;
	}
	
	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
    public function enqueue_styles() {
		wp_enqueue_style( 'uncopyright_genesis_style', plugins_url( 'public/css/uncopyright-genesis.css', __FILE__ ), array(), self::VERSION );
	}
	
	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'uncopyright_genesis_lean_modal', plugins_url( 'public/js/jquery.leanModal.min.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}
	
	/**
	 * Footer content filter
	 *
	 * NOTE:	You can update this section to any footer
	 *			content that you would like
	 *
	 *			RESOURCES
	 *			http://my.studiopress.com/snippets/footer/
	 *			
	 *
	 * @since 1.0.0
	 */
	public function uncopyright_genesis_footer() { ?>
		<div class="creds">
			<p>This site is <a href="#uncopyright-info" rel="leanModal">Uncopyrighted</a> &middot; <a href="<?php echo get_bloginfo('url'); ?>" title="<?php echo get_bloginfo('name') ?>"><?php echo get_bloginfo('name'); ?></a></p>
		</div>
	<?php
	}
	
	/** 
	 * Modal content
	 *
	 * NOTE:	You can update this section to any wording of the 
	 *			Uncopyright philos that you like
	 *
	 *			RESOURCES
	 *			http://zenhabits.net/uncopyright/
	 *			http://www.briangardner.com/uncopyright
	 *			
	 * @since 1.0.0
	 */
	public function uncopyright_genesis_content() { ?>
		<div id="uncopyright-info">
			<a class="modal_close">x</a>
			<h3>This site is Uncopyrighted</h3>
			<p>All claims to copyright have been released and all content is now in the public domain. No permission is needed to copy, distribute, or modify any of the content found on this website (unless otherwise noted on third-party content within posts).</p><p>Crediting me for my content would be swell but is not required.</p>
		</div>
	<?php
	}
}

add_action( 'plugins_loaded', array( 'Uncopyright_Genesis', 'get_instance' ) );