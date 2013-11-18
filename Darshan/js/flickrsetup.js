$(document).ready(function(){

	$('#fbox').jflickrfeed({
		limit: 9,
		qstrings: {
			id: '52617155@N08'
		},
		itemTemplate: '<li>'+
						'<a rel="photo_gallery" href="{{image}}" title="{{title}}">' +
							'<img src="{{image_s}}" alt="{{title}}" />' +
						'</a>' +
					  '</li>'
	}, function(data) {
		$('#fbox a').fancybox();
	});	
	
});