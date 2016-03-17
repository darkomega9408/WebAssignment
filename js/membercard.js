/**
 * Created by VINH on 3/17/2016.
 */
$(document).ready(function(){

    /*  Add tooltip when hover icon */
    //
    // General
    $('.effect-winston p a').attr({
        'data-toggle':'tooltip',
        'data-placement' : 'bottom'
    });
    // Edit tooltip
    $('.effect-winston p a:nth-child(1)').attr('title','Edit');

    // Add Relative tooltip
    $('.effect-winston p a:nth-child(2)').attr('title','Add Relative');

    // Delete tooltip
    $('.effect-winston p a:nth-child(3)').attr('title','Delete');
    /* ~~~ */

    // Enable tooltip
    $('[data-toggle="tooltip"]').tooltip();
});
