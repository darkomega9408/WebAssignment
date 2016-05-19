console.log("Load navbar.js");
$(document).ready(function() {
    $('#hrefLogOut').click(function() {
        deleteCookie('token');
        window.location="/";
    });

    $('#hrefExport').click(function() {
        clone();
    });

    // Change logo relative path
    $(".navbar-brand>img").attr("src","images/family-tree-logo.png");

    // Change role & append new caret
    $("#navbar-user-name").prepend("Hi, ");

    // As default, we choose family tree tab when user logon successfully
    //$("nav.navbar-findcond ul.navbar-nav a.active").css("border-color", "#7ECC00");
    chooseFamilyTreeTab();



});

function navbarAdminPage() {
    console.log("Navbar admin page");
    $("nav.navbar-findcond ul.navbar-nav .family-tree-tab a").hide();
    $("nav.navbar-findcond ul.navbar-nav .guests-man-tab a").hide();
}

function navbarGuestPage() {
    chooseGuestsManagementTab();
}

// Change tab
function chooseFamilyTreeTab() {
    $("nav.navbar-findcond ul.navbar-nav a.active").prop("class", "");
    $("nav.navbar-findcond ul.navbar-nav .family-tree-tab a").prop("class", "active");
}

function chooseGuestsManagementTab() {
    $("nav.navbar-findcond ul.navbar-nav a.active").prop("class", "");
    $("nav.navbar-findcond ul.navbar-nav .guests-man-tab a").prop("class", "active");
}

function clone(){
    $('#modal-uploading').modal('show');
    var target = document.getElementsByClassName('tree')[0];
    var widthRate = $('.tree-container').width() / $('.tree').width();
    var heightRate = $('.tree-container').height() / $('.tree').height();
    var scaleRate;
    if (Math.abs(widthRate-1) > Math.abs(heightRate-1)) scaleRate = heightRate;
    else scaleRate = widthRate;

    // scale the tree to fit container
    target.style.webkitTransform = target.style.transform = 'scale(' + String(scaleRate) + ', ' + String(scaleRate) + ') '
        + 'translate(0px, 0px) ';

    var x = (parseFloat(target.getAttribute('data-x')) || 0);
    var y = (parseFloat(target.getAttribute('data-y')) || 0);

    var role = $('head').attr('data-role');
    if (role != 'guest')
        $('ul [data-toggle="modal"]').hide();
    html2canvas(target, {
        onrendered: function(canvas) {
            var a = document.createElement('a');
            a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
            a.download = name + ' - Family Tree.jpg' ;
            a.click();

            $('ul [data-toggle="modal"]').show();
            //translate the element to former position
            target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px, ' + y + 'px) '
                + 'scale(1, 1) ';
            $('#modal-uploading').modal('hide');
        },
        useCORS: true,
        background: 'white',
        width: $('.tree').width()*scaleRate,
        height: $('.tree').height()*scaleRate
    });
}
