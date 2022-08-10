//jquery function
jQuery(document).ready(function($) {
    //wpbannerman-close-btn
    $('.wpbannerman-close-btn').click(function(){
        let node = $(this).data('node');
        $('.'+node).addClass('hide');
        $('.'+node).hide();
    });
});  