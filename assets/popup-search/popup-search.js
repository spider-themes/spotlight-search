document.addEventListener('DOMContentLoaded', function () {

	document.addEventListener('keydown', function (e) {
		let x, y;
		y = document.getElementById('spotlight_popup_search_wrapper');
		if (e.ctrlKey) {
			x = e.key;

			if (x === '/') {
				if (y.style.display === 'block') {
					y.style.display = 'none';
				} else {
					y.style.display = 'block';
					let searchInput = document.getElementById('wp-spotlight-chat-search-global');
					searchInput.focus();
				}
			}
		}

		if (e.key === "Escape") {
			y.style.display = 'none';
		}
	});
});
