(function( $ ) {
	jQuery(document).ready(function($) {
		var galleryFrame;
		var gallerySelection = [];

		//frame
		if (typeof wp.media !== 'undefined') {
    
			galleryFrame = wp.media.frames.mysite_gallery_frame = wp.media({
				title: 'Select Image',
				button: {
					text: 'Insert Image'
				},
				library: {
					type: 'image'
				},
				multiple: false,
			});
		
			// Add
			jQuery('.wpbannerman-upload-btn').click(function(e) {
				e.preventDefault();
				galleryFrame.open();
			});
		
			galleryFrame.on('open', function() {
			  var arrayImages = [];
			  jQuery('.wpbannerman-image').each(function(index, element) {
				var idd = jQuery(this).data('id');
				if(idd) {
				  arrayImages.push(idd);
				  galleryFrame.state().get('selection').add(wp.media.attachment(idd));
				}      
			  });
			});
		
			galleryFrame.on('select', function() {
				gallerySelection = galleryFrame.state().get('selection');
		
				jQuery(".wpbannerman-main-upload").removeClass('has-image');
				jQuery(".wpbannerman-image").remove();
		
				gallerySelection.map(function(attachment) {
					// console.log(attachment);
					var nodeid 	= Math.random().toString(36).substring(7);
					var id 		= attachment.id;
					var url 	= attachment.attributes.sizes.full?attachment.attributes.sizes.full.url:attachment.attributes.url;
		
					jQuery(".wpbannerman-main").append(`<div class="wpbannerman-image wpbannerman-image-${id}" data-node="${nodeid}" data-id="${id}"></div>`);
					jQuery(`.wpbannerman-image-${id}`).append(`<img src="${url}" alt="">`);
					jQuery(`.wpbannerman-main`).find('.wpbannerman-media-id').val(id);
					jQuery(`.wpbannerman-main`).find('.wpbannerman-media-url').val(url);
					jQuery(".wpbannerman-main-upload").addClass('has-image');
				});
				// galleryFrame.close();
			});

			// Remove
			jQuery('.wpbannerman-main-upload').on('click', '.wpbannerman-delete-btn', function() {
				jQuery(".wpbannerman-image").remove();
				jQuery(`.wpbannerman-main`).find('.wpbannerman-media-id').val('');
				jQuery(`.wpbannerman-main`).find('.wpbannerman-media-url').val('');
				jQuery(".wpbannerman-main-upload").removeClass('has-image');
			});

		}
		//end frame
	});
})( jQuery );
