$(document).ready(function() {
    $('#hrefLogOut').click(function() {
        deleteCookie('token');
        window.location="/";
    });

    // Change logo relative path
    $(".navbar-brand>img").attr("src","images/family-tree-logo.png");

    // Change role & append new caret
    $("#navbar-user-name").prepend("Hi, ");
});
