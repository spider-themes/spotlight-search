(function ($) {
	'use strict'

	$(document).ready(
		function () {
			$('#spotlight_popup_search .chatbox-header .search-box .cancel-search-box').click(
				function () {
					$('#spotlight_popup_search_wrapper').css('display', 'none');
				}
			);

			let hsearch = $('#wp-spotlight-chat-search-global')
			let noresult = ''

			hsearch.on(
				'keyup',
				function () {
					let keyword = $('#wp-spotlight-chat-search-global').val()
					if (keyword == '') {

						$('.chatbox-body').removeClass('global-result-loading');
						$('#spotlight_popup_search').removeClass('has-global-result');

						$('#chatbox-search-results-global').html(
							'<div class="chatbox-posts" tab-data="post">\n' +
							'<div class="post-item keyword-alert">' +
							'<p>Please type a keyword to search for contents.</p>' +
							'</div>' +
							'</div>'
						)
					} else {
						$.ajax(
							{
								url: wp_spotlight_search_global.global_ajax_url,
								method: 'post',
								data: {
									action: 'wp_spotlight_search_result_global',
									keyword: keyword,
								},
								beforeSend: function () {

									$('.chatbox-body').addClass('global-result-loading');

									$('#chatbox-search-results-global').html(
										'<?xml version="1.0" encoding="utf-8"?>\n' +
										'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">\n' +
										'<circle cx="50" cy="50" r="18" stroke-width="2" stroke="#4c4cf1" stroke-dasharray="28.274333882308138 28.274333882308138" fill="none" stroke-linecap="round">\n' +
										'  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>\n' +
										'</circle>\n' +
										'</svg>',
									)
								},
								success: function (response) {
									$('#chatbox-search-results-global').html(response)
									$('.chatbox-body').removeClass('global-result-loading');
									$('#spotlight_popup_search').addClass('has-global-result');
								},
								error: function () {
									console.log('Oops! Something wrong, try again!')
								},
							}
						)
					}
				}
			);



			// Widgets.
			$('#cancel-spotlight-search').click(
				function (e) {
					e.preventDefault();
					$('#wp-spotlight-widget-result').css('display', 'none');
				}
			);

			// The input field
			let widsearch = $('#wp-spotlight-widget-search input')

			// Change on every keypress
			widsearch.on(
				'keyup',
				function () {
					$('#wp-spotlight-widget-result').css('display', 'block');
					let keyword = $('#wp-spotlight-widget-search input').val()
					
					console.log(keyword)
					if (keyword == '') {

						// $('.chatbox-body').removeClass('global-result-loading');
						// $('#spotlight_popup_search').removeClass('has-global-result');

						$('#wp-spotlight-widget-result').html(
							'<div class="widgetbox-posts" tab-data="post">\n' +
							'<div class="post-item keyword-alert">' +
							'<p>Please type a keyword to search for contents.</p>' +
							'</div>' +
							'</div>'
						)
					} else {
						$.ajax(
							{
								url: wp_spotlight_search_global.global_ajax_url,
								method: 'post',
								data: {
									action: 'wp_spotlight_search_result_global',
									keyword: keyword,
								},
								beforeSend: function () {

									$('#wp-spotlight-widget-result').addClass('global-result-loading');

									$('#wp-spotlight-widget-result').html(
										'<?xml version="1.0" encoding="utf-8"?>\n' +
										'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">\n' +
										'<circle cx="50" cy="50" r="18" stroke-width="2" stroke="#4c4cf1" stroke-dasharray="28.274333882308138 28.274333882308138" fill="none" stroke-linecap="round">\n' +
										'  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>\n' +
										'</circle>\n' +
										'</svg>',
									)
								},
								success: function (response) {
									$('#wp-spotlight-widget-result').html(response)
									$('.chatbox-body').removeClass('global-result-loading');
									$('#spotlight_popup_search').addClass('has-global-result');
								},
								error: function () {
									console.log('Oops! Something wrong, try again!')
								},
							}
						)
					}
				}
			)
		},
	)
})(jQuery)
