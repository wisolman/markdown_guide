// Translation

Symphony.Language.add({
	'Hide Markdown Guide': false,
	'Show Markdown Guide': false
});

// Actual Code

jQuery(document).ready(function() {
	// Insert anchor that will act as toggle to show and hide the markdown guide
	jQuery('.markdown_guide').before('<a class="toggleguide">' + Symphony.Language.get('Show Markdown Guide') + '</a>');
	
	jQuery("a.toggleguide").each(function () {
		jQuery(this).next('label').hide();
	});
	
	jQuery("a.toggleguide").click(
		function () {
			// Toggle guide
			jQuery(this).next('label').slideToggle();
			jQuery(this).text(jQuery(this).text() 
				== Symphony.Language.get('Hide Markdown Guide') ? Symphony.Language.get('Show Markdown Guide') : Symphony.Language.get('Hide Markdown Guide'));
		}
	);

});
