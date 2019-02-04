/**
 * Infinite Scroll + Masonry + ImagesLoaded
 */
(function() {

	// Main content container
	

	// Masonry + ImagesLoaded
	var $grid = $('.gallery').masonry({
		itemSelector: '.grid-item',
	});

	var msnry = $grid.data('masonry');

	$grid.InfiniteScroll({
		append: '.grid-item',
		outlayer: msnry,
	});
/*
		function getUrlVars() {
	    var vars = {};
	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	        vars[key] = value;
	    });
	    return vars;
	}
	var slug = getUrlVars()["slug"];
	// Infinite Scroll
	var elem = document.querySelector('.gallery');
	var infScroll = new InfiniteScroll( elem, {
	  // options
	  path: '/gallery/categories/viewalt?slug=weddings&page={{#}}',
	  append: '.grid-item',

	});
*/
	// element argument can be a selector string
	//   for an individual element

})();