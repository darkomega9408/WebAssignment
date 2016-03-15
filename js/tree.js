$(document).ready(function(){
    var leaf = $(".membercard").size();
    $(".tree").width(leaf*270);

    $(".edit-icon-title").attr("title", "Edit");
    $(".add-icon-title").attr("title", "Add relative");
    $(".delete-icon-title").attr("title", "Delete");
});
