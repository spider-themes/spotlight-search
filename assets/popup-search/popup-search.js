document.addEventListener('DOMContentLoaded', function () {
	document.addEventListener('keydown', function (e) {
		let x, y;
		y = document.getElementById('spotlight_popup_search_wrapper');
		if (e.shiftKey) {
			x = e.key;

			if (x === '?') {
				if (y.style.display === 'block') {
					y.style.display = 'none';
				} else {
					y.style.display = 'block';
				}
			}
		}

		if (e.key === "Escape") {
			y.style.display = 'none';
		}
	});

	let widSearch = document.getElementById('wp-shoplight-widget-search');
	widSearch.addEventListener('click', function(e) {
		searchBox = document.getElementById('spotlight_popup_search_wrapper');
		searchBox.style.display = 'block';

		document.addEventListener('keydown', function(e){
			if (e.key === "Escape") {
				searchBox.style.display = 'none';
			}
		});
	});
});
