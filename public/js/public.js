//jquery function
jQuery(document).ready(function($) {
    //wpbannerman-close-btn
    $('.wpbannerman-close-btn').click(function(){
        let node = $(this).data('node');
        $('.'+node).addClass('hide');
        $('.'+node).hide();
    });
    $('.wpbannerman-unready').each(function(){
        let node    = $(this).data('node');
        let idpost  = $(this).data('id');
        let url     = $(this).data('url');
        $.ajax({
            method: "POST",
            url: wpbannermanager_ajax.ajaxurl,
            data: { action: "wpbannermanhits", idpost: idpost, url: url  }
        }).done(function( data ) {
            $('.'+node).removeClass('wpbannerman-unready');
        });
    });
    $('.wpbannerman-object').click(function(){
        let idpost  = $(this).data('id');
        let url     = $(this).data('url');
        $.ajax({
            method: "POST",
            url: wpbannermanager_ajax.ajaxurl,
            data: { action: "wpbannermanclick", idpost: idpost, url: url  }
        }).done(function( data ) {
            console.log(data);
        });
    });
});  