(function ($) {
	$('.pw-gallery').each(function() {
		var instance = this;
		var imgIdInput = $('.pw-gallary-value', instance);
		$('button', instance).click(function(event){
			event.preventDefault();
			var idList = imgIdInput.val();
			var gallerysc = '[gallery ids="' +idList+ '"]';
  			wp.media.gallery.edit(gallerysc).on('update', function(g){
				var id_array = [];
				$.each(g.models, function(id, img) { id_array.push(img.id); });
				imgIdInput.val(id_array.join(","));
			});

  			if(idList==' ' || idList=='' ){
  				$('.media-frame-menu .media-menu-item').eq(2).click();
  			}
		});
	});
}(jQuery));