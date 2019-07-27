<?php
/**
 * Plugin Name: Username Check
 * Plugin URI: https://davidvang.com
 * Description: A test plugin to check if a username exists.
 * Version: 1.0.0
 * Author: David Vang
 * Author URI: https://davidvang.com
 */
?>

<?php
/**
 * Target a specific page for this plugin.
 */
$post_target = 1234;

/**
 * Enqueue jQuery.
 */
function username_check_enqueue_script() {  
    if ( is_page( $post_target ) ) { 
        wp_enqueue_script( 'username_check_jquery', plugin_dir_url( __FILE__ ) . 'js/username-check.js', array('jquery'), '1.0' );
    }
}
add_action('wp_enqueue_scripts', 'username_check_enqueue_script');

/**
 * Create the form only on our test page
 */
function username_check_create_form() {
    
    if ( is_page( $post_target ) ) {
    ?>

        <p>
            <input type="text" id="username">
            <button class="button">CHECK USERNAME</button>
        </p>

        <p class="message"></p>

    <?php
    }
}
add_action( 'get_footer', 'username_check_create_form' );

/**
 * Run the function for the ajax response.
 */
function username_check_run() {
    $response = array();
    $username = sanitize_text_field($_POST['user_name']);
    if(username_exists($username)){
        $response['status'] = 'unavailable';
        $response['text'] = __(' is unavailable.');
    }else{
        $response['status'] = 'available';
        $response['text'] = __(' is available.');
    }
    echo json_encode($response);
    die();
}

add_action('wp_ajax_nopriv_check_username', 'username_check_run');
add_action('wp_ajax_check_username', 'username_check_run');