<?php
/**
 * Plugin Name:       MCQ Question
 * Description:        Multiple-choice question(MCQ) system using the latest version of WordPress
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            devshagor
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mcq-question
 *
 * @package           create-block
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'QUIZ_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'QUIZ_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'QUIZ_PLUGIN_VERSION', '1.0.0' );


// register custom post type
require_once QUIZ_PLUGIN_PATH . 'inc/cpt.php';

function render_template( $settings ) {
	ob_start();
	require_once QUIZ_PLUGIN_PATH . 'inc/template.php';
	return ob_get_clean();
}

function dynamic_content_for_quiz() {
    // automatically load dependencies and version
    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

    wp_register_script(
        'load-editor-script',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );

	$args = array(
		'post_type' => 'quizzes',
		'posts_per_page' => 10,
		'orderby' => 'date',
		'order' => 'ASC'
	);
	$quizzes = new WP_Query( $args );

	wp_localize_script( 'load-editor-script', 'frontend_quiz',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'quizes' => $quizzes
		)
	);

    register_block_type( 'gutenberg-block/mcqapp', array(
        'api_version' => 2,
		"title" => "MCQ Block",
        'editor_script' => 'load-editor-script',
//        'render_callback' => 'render_template',
		'attributes' => array(
			'total_quizes' => array(
				'type' => 'integer',
				'default'	=> 0
			),
		)
    ) );
}
add_action( 'init', 'dynamic_content_for_quiz' );


/*
 * Rest API for quizzes with custom field
 * */
add_action( 'rest_api_init', 'adding_user_meta_rest' );
function adding_user_meta_rest() {
	register_rest_field( 'quizzes',
		'quizzes_meta',
		array(
			'get_callback'      => 'user_meta_callback',
			'update_callback'   => null,
			'schema'            => null,
		)
	);
}
function user_meta_callback( $quiz, $field_name, $request) {
	return get_post_meta( $quiz['id'] );
}