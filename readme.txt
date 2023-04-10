=== Private Twitter Embeds with Nitter ===
Contributors: nico23
Tags: twitter, nitter, embed, private
Donate link: https://nextgenthemes.com/donate/
Requires at least: 5.0
Tested up to: 6.2
Requires PHP: 7.2
Stable tag: 0.5.0
License: GPL-3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Private Twitter embeds that become YOUR content, that you can style.

== Description ==

There are many benefits of using this plugin over the default Twitter embeds. Works only for `/status/x` urls, no timelines or others.

1. You do not have to worry about compromising your users privacy. No need to even think about GDPR ...
1. You even get server privacy because your server will no longer call Twitters oEmbed service to get the embed codes for `/status/` urls.
1. The embeds become *your* content. The tweets are injected into your HTML. No `<iframe>`s. No stupid JavaScript. They are are actually technically many not even "embeds" anymore.
1. This means that you can style them the way you like. I included the Twitter light theme and the Pleroma dark theme from Nitter by default.
1. Your embeds will stay up for as long as WP transients last, meaning deleted tweets will be stored on your site. This could be made permanent in theory.

No options yet, but you can use the `nextgenthemes/nitter-embeds/nitter-instance` filter to change to your preferred Nitter instance.

== Changelog ==

##### 2023-04-11 - 0.5.0

* Initial release
