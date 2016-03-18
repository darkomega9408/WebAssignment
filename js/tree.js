$(document).ready(function(){

    // Some variables
    var memberCardObj = "";
    var member = "mem";
    var currMemberID ;

    // Load tree first
    $.ajax({
        url: 'GetListMember.php',
        type: 'GET',
        dataType: "json"
    }).done(function(data){
        createTree(data);
    }).fail(function () {
        console.log("Create tree failed");
    });
    // ~~

    // Load member card from another file and assign to '@memberCardObj'
    $('.tree').load('../card-demo/membercard-demo.html .membercard', function () {
        memberCardObj = $(this).clone();
        $(this).html('');
    });
    // ~~

    // Set information for each member based on DB
    var setInfoMemberCard = function (data, memberCardObj) {
        $(memberCardObj).find('.membercard').attr('id', member + data.MemberID);
        $(memberCardObj).find('.memberName').html(data.Name);
        $(memberCardObj).find('.memberBirthDate').html(data.BirthDate);
        $(memberCardObj).find('.memberBirthPlace').html(data.BirthPlace);
        return $(memberCardObj).html();
    };
    // ~~

    // Use to create tree html
    // data: server 's response , get from DB
    var createTree = function (data) {
        var nbrNode = data.length;

        // Set width for tree
        $(".tree").width((data.length * 30) + "em");

        // Add Root node ( if any )
        if( nbrNode <= 0 ) return;
        else $('.tree').append("<ul><li>"+ setInfoMemberCard(data[0],memberCardObj) +"</li></ul>");

        // Add Child node
        for(i = 1 ; i< nbrNode ; ++i)
            addMember(data[i]);
    };

    // Add member
    function addMember(data) {
        var content = "<li>" + setInfoMemberCard(data, memberCardObj) + "</li>";
        if( $('#' + member + data.Father + '+ul').length <= 0 )
            $('#' + member + data.Father).after("<ul>" + content + "</ul>");
        else
            $('#' + member + data.Father + '+ul').append(content);
    }
    // ~~

    // Delete member
    function deleteMember() {
        var node = $("#" + member + currMemberID).parent();
        console.log(node.contents().length);
        if( node.parent().contents().length <= 1 )
            node.parent().remove();
        else node.remove();
    }
    // ~~

    // Modal event listener
    $('.modal').on('show.bs.modal', function (e) {
        var $trigger = $(e.relatedTarget);
        var $memberID = $trigger.parents().eq(3).attr('id');
        currMemberID = $memberID.substr(member.length);
    });

    // Delete user triggered by btnDelete onclick()
    $('#btnDelete').click(function () {
        console.log("Delete");
        $.ajax({
            url: 'GetListMember.php',
            type: 'GET',
            data: {
                operation: "delete",
                memberID: currMemberID
            }
        }).done(function (data) {
            console.log("Delete member successfully");
            deleteMember();
        }).fail(function () {
            console.log("Failed to delete member");
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
                operation: "add",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            addMember(data[0]);
            console.log(data[0].MemberID);
        }).fail(function () {
        });


    });
});
