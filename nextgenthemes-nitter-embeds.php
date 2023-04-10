<?php declare(strict_types=1);
/**
 * Plugin Name:  Private Twitter embeds with Nitter
 * Plugin URI:   http://nextgenthemes.com
 * Description:
 * Author:       Nicolas Jonas
 * Author URI:   http://nextgenthemes.com
 * Version:      0.5.0
 * Text Domain:
 * Domain Path:  languages
 */
namespace Nextgenthemes\NitterEmbeds;

const VERSION = '0.5.0';

add_action( 'init', __NAMESPACE__  . '\init' );

function init() {

	require_once __DIR__ . '/functions-remote-get.php';

	wp_oembed_remove_provider( '#https?://(www\.)?twitter\.com/\w{1,15}/status(es)?/.*#i' );
	wp_embed_register_handler(
		'nextgenthemes-nitter-status',
		'#https?://(www\.)?twitter\.com/(?<user_and_status>\w{1,15}/status(es)?/[0-9]+).*#i',
		__NAMESPACE__ . '\handler_callback_status'
	);

	wp_register_style( 'nextgenthemes-nitter', plugins_url( 'build/main.css', __FILE__ ), [], VERSION );
}

add_action(
	'enqueue_block_editor_assets',
	function() {
		wp_enqueue_script( 'nextgenthemes-nitter' );
	}
);

function handler_callback_status( array $matches, array $attr, string $url, array $rawattr ): string {

	$nitter_instance_url = apply_filters( 'nextgenthemes/nitter-embeds/nitter-instance', 'https://nitter.d420.de' );
	$embed_url           = $nitter_instance_url . '/' . $matches['user_and_status'] . '/embed';

	// we actually get the entire HTML here, NOT just whats inside <body>
	$html = remote_get_body_cached( $embed_url, [ 'timeout' => 2 ], 0 );

	if ( is_wp_error( $html ) ) {
		return sprintf(
			'<div class="nextgenthemes-nitter">Nitter Error: %s</div>',
			wp_kses_post( $html->get_error_message() )
		);
	}

	\preg_match( '#(?<=body>).*?(?=</body>)#s', $html, $matches );

	$body_html = $matches[0];
	$body_html = strtr(
		$body_html,
		[
			'src="/'  => sprintf( 'src="%s/', esc_url($nitter_instance_url) ),
			'href="/' => sprintf( 'href="%s/', esc_url($nitter_instance_url) ),
		]
	);

	wp_enqueue_style( 'nextgenthemes-nitter' );

	return sprintf(
		'<div class="nextgenthemes-nitter">%s</div>',
		wp_kses_post( $body_html )
	);
}
