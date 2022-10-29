(function ($) {
	'use strict'

	$( document ).ready(
		function () {
			let hsearch  = jQuery( '#wp-spotlight-chat-search' )
			let noresult = ''

			hsearch.on(
				'keyup',
				function () {
					let keyword = jQuery( '#wp-spotlight-chat-search' ).val()
					if (keyword == '') {
						jQuery( '#chatbox-search-results' ).html(
							'<div class="chatbox-posts" tab-data="post">\n' +
							'<div class="post-item keyword-alert">' +
							'<p>Please type a keyword to search for contents.</p>' +
							'</div>' +
							'</div>'
						)
					} else {
						$.ajax(
							{
								url: wp_spotlight_search.ajax_url,
								method: 'post',
								data: {
									action: 'wp_spotlight_search_result',
									keyword: keyword,
								},
								beforeSend: function () {
									$( '#chatbox-search-results' ).html(
										'<?xml version="1.0" encoding="utf-8"?>\n' +
										'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">\n' +
										'<circle cx="50" cy="50" r="18" stroke-width="2" stroke="#4c4cf1" stroke-dasharray="28.274333882308138 28.274333882308138" fill="none" stroke-linecap="round">\n' +
										'  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>\n' +
										'</circle>\n' +
										'</svg>',
									)
								},
								success: function (response) {
									$( '#chatbox-search-results' ).html( response )
								},
								error: function () {
									console.log( 'Oops! Something wrong, try again!' )
								},
							}
						)
					}
				}
			)
		}
	)
})( jQuery )
