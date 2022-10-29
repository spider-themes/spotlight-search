(function ($) {
	'use strict'

	$( document ).ready(
		function () {
			const searchBar = $( '#helper-chat-search' )

			// chatbox tabs
			function chatbox_tabs () {
				const searchResult  = $( '#chatbox-search-results' )
				const kbButton      = $( '[tab-link=kbase]' )
				const contactButton = $( '[tab-link=contact]' )

				const kbData      = $( '[tab-data=post]' )
				const contactData = $( '[tab-data=contact]' )

				contactData.hide()

				kbButton.click(
					function (e) {
						e.preventDefault()
						contactButton.removeClass( 'active' )
						contactData.hide()

						kbButton.addClass( 'active' )
						kbData.show()
						searchResult.show()

						searchBar.show();
					}
				)

				contactButton.click(
					function (e) {
						e.preventDefault()
						kbButton.removeClass( 'active' )

						kbData.hide()
						searchResult.hide()

						contactButton.addClass( 'active' )
						contactData.show()

						searchBar.hide()
					}
				)
			}

			function chat_toggle () {
				const chat_toggle_btn = $( '.chat-toggle a' )
				const helper_hide     = $( '.wp-spotlight-hide' )
				const helper_chat     = $( '.wp-spotlight-chat' )
				const chatbox         = $( '.chatbox-wrapper' )

				chat_toggle_btn.click(
					function (e) {
						e.preventDefault()
						helper_hide.toggle()
						helper_chat.toggle()
						chatbox.toggleClass( 'show-chatbox' )
					}
				)
			}

			chat_toggle()
			chatbox_tabs()
		}
	)
})( jQuery )
