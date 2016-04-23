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
    html2canvas(document.getElementsByClassName("tree")[0], {
        onrendered: function(canvas) {
            var a = document.createElement('a');
            a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
            a.download = name + ' - Family Tree.jpg' ;
            a.click();
        },
        useCORS: true,
        background: 'white'
    });
}
