$(document).ajaxComplete(function () {
    console.log("Run membercard.js");
    /*  Add tooltip when hover icon */
    //
    // General
    $('.effect-winston p a').attr({
        /*'data-toggle':'tooltip',
        'data-placement' : 'right'*/
    });
    
    /*// Edit tooltip
    $('.effect-winston p a:nth-child(1)').attr('title','Edit');

    // Add Relative tooltip
    $('.effect-winston p a:nth-child(2)').attr('title','Add Relative');

    // Delete tooltip
    $('.effect-winston p a:nth-child(3)').attr('title','Delete');
    /!* ~~~ *!/*/

    // Enable tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Lose focus <a> tag after clicking , otherwise tooltip will be shown forever
    $(".effect-winston p a").click(function(){
        $(this).blur();
    });

    /* Click icon EDIT open modal  */
    $('.effect-winston p a:nth-child(1)').attr({
        'data-toggle':'modal',
        'data-target':'#modal-edit-user'
    });

    /* Click icon ADD RELATIVE open modal */
    $('.effect-winston p a:nth-child(2)').attr({
        'data-toggle':'modal',
        'data-target':'#modal-add-user'
    });

    /* Click icon DELETE open modal */
    $('.effect-winston p a:nth-child(3)').attr({
        'data-toggle':'modal',
        'data-target':'#modal-delete-user'
    });
});