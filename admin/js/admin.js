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
		
					jQuery(".wpbannerman-box-image").append(`<div class="wpbannerman-image wpbannerman-image-${id}" data-node="${nodeid}" data-id="${id}"></div>`);
					jQuery(`.wpbannerman-image-${id}`).append(`<img src="${url}" alt="">`);
					jQuery(`.wpbannerman-image-${id}`).append(`<input class="wpbannerman-media-id" name="wpbannerman[media]" value="${id}" type="hidden">`);
					jQuery(`.wpbannerman-image-${id}`).append(`<div class="wpbannerman-delete-btn"> <span class="dashicons dashicons-dismiss"></span> </div>`);
					jQuery(".wpbannerman-main-upload").addClass('has-image');
				});
				// galleryFrame.close();
			});

			// Remove
			jQuery(document).on('click', '.wpbannerman-delete-btn', function() {
				jQuery(".wpbannerman-image").remove();
				jQuery(".wpbannerman-media-id").val('');
				jQuery('.wpbannerman-media-url').val('');
				jQuery(".wpbannerman-main-upload").removeClass('has-image');
			});

		}
		//end frame
		
		// Remove
		jQuery(document).on('click', '.wpbannerman-reset-statistic', function() {
			if (confirm("Reset all data in database ?") == true) {
				jQuery('.wpbannerman-reset-statistic').html('Wait..');
				let idpost  = jQuery(this).data('id');
				$.ajax({
					method: "POST",
					url: wpbannermanager_ajax.ajaxurl,
					data: { action: "wpbannermanreset", idpost: idpost }
				}).done(function( data ) {
					jQuery('.wpbannerman-reset-statistic').html('Reset');
					jQuery('#myBannerChart').hide(500);
				});
			}
		});

	});
})( jQuery );
