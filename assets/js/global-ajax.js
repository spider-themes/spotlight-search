(function ($) {
	'use strict'

	$(document).ready(
		function () {
			$('#spotlight_popup_search .chatbox-header .search-box .cancel-search-box').click(
				function () {
					$('#spotlight_popup_search_wrapper').css('display', 'none');
				}
			);

			let hsearch = $('#spotlight-search-chat-search-global')
			let noresult = ''

			hsearch.on(
				'keyup',
				function () {
					let keyword = $('#spotlight-search-chat-search-global').val()
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
								url: spotlight_search_search_global.global_ajax_url,
								method: 'post',
								data: {
									action: 'spotlight_search_search_result_global',
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

			// The input field
			let widsearch = $('#spotlight-search-widget-search input')

			// Change on every keypress
			widsearch.on(
				'keyup',
				function () {
					$('#spotlight-search-widget-result').css('display', 'block');
					let keyword = $('#spotlight-search-widget-search input').val()
					
					if (keyword == '') {
						
						// $('.chatbox-body').removeClass('global-result-loading');
						// $('#spotlight_popup_search').removeClass('has-global-result');

						$('#spotlight-search-widget-result').html('')
					} else {
						$.ajax(
							{
								url: spotlight_search_search_global.global_ajax_url,
								method: 'post',
								data: {
									action: 'spotlight_search_search_result_global',
									keyword: keyword,
								},
								beforeSend: function () {

									$('#spotlight-search-widget-result').addClass('global-result-loading');

									$('#spotlight-search-widget-result').html(
										'<?xml version="1.0" encoding="utf-8"?>\n' +
										'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">\n' +
										'<circle cx="50" cy="50" r="18" stroke-width="2" stroke="#4c4cf1" stroke-dasharray="28.274333882308138 28.274333882308138" fill="none" stroke-linecap="round">\n' +
										'  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>\n' +
										'</circle>\n' +
										'</svg>',
									)
								},
								success: function (response) {
									$('#spotlight-search-widget-result').html(response)
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
