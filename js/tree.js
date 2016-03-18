$(document).ready(function(){

    var currMemberID;
    var prefixDivMemberID = "contentOf";
    var prefixUlMemberID = "childOf";

    function layoutMember(value, fatherName, hasChild) {
        if (hasChild)
            $("#" + prefixUlMemberID + fatherName).append("<li><div id='" + prefixDivMemberID + value.MemberID  + "'></div>" + "<ul id='"+ prefixUlMemberID + value.MemberID + "'></ul></li>");
        else
            $("#" + prefixUlMemberID + fatherName).append("<li><div id='" + prefixDivMemberID + value.MemberID  + "'></div>" + "</li>");

        $("#" + prefixDivMemberID + value.MemberID).load("../card-demo/membercard-demo.html .membercard", function() {
            var membercard = document.getElementById(prefixDivMemberID + value.MemberID);
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

    // Modal event listener
    $('.modal').on('show.bs.modal', function (e) {
        var $trigger = $(e.relatedTarget);
        var $memberID = $trigger.parents().eq(4).attr('id');
        currMemberID = $memberID.substr(9);
        // console.log(currMemberID);
    });

    // Delete user triggered by btnDelete onclick()
    $('#btnDelete').click(function () {
        $.ajax({
            url: 'GetListMember.php',
            type: 'GET',
            data: {
                operation: "delete",
                memberID : currMemberID
            },
            dataType: 'json',
            success: function (data) {
                // Make tree null first
                $("#childOfTree").html("");

                // Set width again
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
            },
            fail: function (data) {
                console.log(data);
            }
        });
    });
        // ~~

    // Add new relative
    $('#btnAdd').click(function () {
        var sentData = {
            Username: "tam",
            Name: "tâm gay chúa",
            BirthDate : '2016-03-09',
            BirthPlace : 'bình hưng hòa',
            Gender : 'sao hỏa',
            Father : currMemberID
        };

        $.ajax({
            url: 'GetListMember.php',
            type: 'GET',
            data: {
                // INSERT INTO `member`
                // (`Username`, `MemberID`, `Name`, `BirthDate`, `Address`, `BirthPlace`, `Gender`, `Father`, `Level`)
                // VALUES ('tam', NULL, 'tâm gay chúa', '2016-03-09', 'bình hưng hòa', 'sao hỏa', 'male', '1', '0')
                operation: "add",
                sentData : sentData
            },
            dataType: 'json',
            success: function (data) {
                // Make tree null first
                $("#childOfTree").html("");

                // Set width again
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
            },
            fail: function (data) {
                console.log(data);
            }
        });
    });
});
