$(document).ready(function(){

    function layoutMember(value, fatherName, hasChild) {
        if (hasChild)
            $("#childOf" + fatherName).append("<li><div id='" + "contentOf" + value.MemberID  + "'></div>" + "<ul id='childOf" + value.MemberID + "'></ul></li>");
        else
            $("#childOf" + fatherName).append("<li><div id='" + "contentOf" + value.MemberID  + "'></div>" + "</li>");

        $("#contentOf" + value.MemberID).load("../card-demo/membercard-demo.html .membercard", function() {
            var membercard = document.getElementById("contentOf" + value.MemberID);
            membercard.getElementsByClassName("memberName")[0].innerHTML = value.Name;
            membercard.getElementsByClassName("memberBirthDate")[0].innerHTML = value.BirthDate;
            membercard.getElementsByClassName("memberBirthPlace")[0].innerHTML = value.BirthPlace;
        });


    }

    $.ajax({
        url: 'GetListMember.php',
        type: 'GET',
        dataType: "json"
    }).done(function(data){
        $(".tree").width((data.length * 30) + "em");
        var fatherArray = Array();
        $.each(data, function(key,value) {
            if (value.Father != null)
                fatherArray.push(value.Father);
        });
        $.each(data, function(key,value){
            var hasChild = (fatherArray.indexOf(value.MemberID) != -1);
            if (value.Father == null)
                layoutMember(value, "Tree",hasChild);
            else
                layoutMember(value, value.Father, hasChild);
        });
    });
});
