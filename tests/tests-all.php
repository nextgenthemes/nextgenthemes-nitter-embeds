<?php
use function \Nextgenthemes\ARVE\shortcode;
use function \Nextgenthemes\ARVE\get_host_properties;

// phpcs:disable Squiz.PHP.CommentedOutCode.Found, Squiz.Classes.ClassFileName.NoMatch, Squiz.PHP.Classes.ValidClassName.NotCamelCaps, WordPress.PHP.DevelopmentFunctions.error_log_print_r, WordPress.PHP.DevelopmentFunctions.error_log_error_log
class Tests_All extends WP_UnitTestCase {

	public function test_basic_status_url() {

		if ( getenv( 'GITHUB_ACTION' ) ) {
			$this->markTestSkipped('this fails on Github Action, nitter instance give 403 http response code');
			return;
		}

		$text = '

		https://twitter.com/mtaibbi/status/1636729166631432195

		';

		$html = apply_filters( 'the_content', $text );

		$this->assertStringNotContainsString( 'Error', $html );
		$this->assertStringContainsString( 'nitter', $html );
	}

	public function test_fake_instance() {

		add_filter(
			'nextgenthemes/nitter-embeds/nitter-instance',
			function() {
				return 'https://pooooop.test';
			}
		);

		$text = '

		https://twitter.com/mtaibbi/status/1636729166631432195

		';

		$html = apply_filters( 'the_content', $text );

		$this->assertStringContainsString( 'Error', $html );
	}
}
