$(document).ready(function(){

    // Some variables
    var memberCardObj = "";
    var member = "mem";
    var currMemberID ;

    //$('.modal-wrapper').load('../card-demo/membercard-demo.html .member-modal-wrapper');

    // Load member card from another file and assign to '@memberCardObj'
    $('.tree').load('../card-demo/membercard-demo.html .membercard', function () {
        memberCardObj = $(this).clone();
        $(this).html('');
    });
    // ~~

    // Load tree first
    $.ajax({
        url: 'GetListMember.php',
        type: 'GET',
        dataType: "json",
        data: {
            UserID : 2
        }
    }).done(function(data){
        createTree(data);
    }).fail(function (err) {
        console.log(err);
        console.log("Create tree failed");
    });
    // ~~


    // Change member info displayed based on DB
    function setInfoForMember(data) {
        var memberCard = $("#"+member + data.MemberID);

        // Set avatar if any or leave default
        if( data.Avatar != null )
            memberCard.find(".memberAvatar").attr("src", data.Avatar);
        memberCard.find('.memberName').html(data.Name);
        memberCard.find('.memberBirthDate').html(data.BirthDate);
        memberCard.find('.memberBirthPlace').html(data.BirthPlace);

        // Store all data
        memberCard.data("memberinfo", data);
    }
    // ~~


    // Set HTML layout for each member
    var layoutMember = function (data, memberCardObj) {
        $(memberCardObj).find('.membercard').attr('id', member + data.MemberID);
        return $(memberCardObj).html();
    };
    // ~~


    // Use to create tree html
    // data: server 's response , get from DB
    var createTree = function (data) {
        var nbrNode = data.length;

        // Set width for tree
        $(".tree").width((data.length * 15) + "em");

        // Add Root node ( if any )
        if( nbrNode <= 0 ) return;
        else {
            $('.tree').append("<ul><li>" + layoutMember(data[0], memberCardObj) + "</li></ul>");
            setInfoForMember(data[0]);
        }

        // Add Child node
        for(i = 1 ; i< nbrNode ; ++i)
            addMember(data[i]);
    };
    // ~~


    // Add member
    function addMember(data) {
        var content = "<li>" + layoutMember(data, memberCardObj) + "</li>";

        if( $('#' + member + data.Father + '+ul').length <= 0 )
            $('#' + member + data.Father).after("<ul>" + content + "</ul>");
        else
            $('#' + member + data.Father + '+ul').append(content);

        setInfoForMember(data);
    };
    // ~~


    /**
     * Delete member
     * @Author Vinh
     */
    function deleteMember() {
        var node = $("#" + member + currMemberID).parent();
        //console.log(node.contents().length);
        if( node.parent().contents().length <= 1 )
            node.parent().remove();
        else node.remove();
    };
    // ~~


    /**
     * Set info for EDIT modal when opening
     * @Type : Modal event listener
     * @Author: TÂM
     */
    $('.modal').on('show.bs.modal', function (e) {
        // Get memberID of current shown member
        try {
            var $trigger = $(e.relatedTarget);
            var $memberID = $trigger.parents().eq(3).attr('id');
            currMemberID = $memberID.substr(member.length);
        }
        catch (err){}

        // Don't automatically add data for modal ADD RELATIVE
        if( $(this).attr("id") == "modal-add-user" ) {
            $(".modal-title").html("New child of " + $("#"+member+currMemberID).data("memberinfo").Name);
            return;
        }

        // Assign some basic info to modal before display to user
        var memberinfo = $("#"+member + currMemberID).data("memberinfo");
        $("#modal-edit-user .modal-title").html(memberinfo.Name + " Information");
        $("#modal-edit-user .memberModalAvatar").attr("src", memberinfo.Avatar);
        $("#modal-edit-user .memberModalName").attr("value", memberinfo.Name);
        $("#modal-edit-user .memberModalGender").val(memberinfo.Gender);
        $("#modal-edit-user .memberModalBirthDate").attr("value", memberinfo.BirthDate);
        $("#modal-edit-user .memberModalAddress").attr("value", memberinfo.Address);
        $("#modal-edit-user .memberModalBirthPlace").attr("value", memberinfo.BirthPlace);
    });
    // ~~


    // Delete user triggered by btnDelete onclick()
    $('#btnDelete').click(function () {
        console.log("Delete");
        $.ajax({
            url: 'GetListMember.php',
            type: 'GET',
            data: {
                operation: "delete",
                sentData : {
                    UserID : 2,
                    MemberID: currMemberID
                }
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
            UserID: 2,
            Name: $("#modal-add-user .memberModalName").val(),
            BirthDate : $("#modal-add-user .memberModalBirthDate").val(),
            BirthPlace : $("#modal-add-user .memberModalBirthPlace").val(),
            Gender : $("#modal-add-user .memberModalGender").val(),
            Avatar : $("#modal-add-user .memberModalAvatar").attr("src"),
            Status : $("#modal-add-user input[name='radioStatus']:checked").val(),
            Address : $("#modal-add-user .memberModalAddress").val(),
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
            console.log("Failed to add new member!")
        });
    });
    // ~~


    // Update member info
    $('#btnUpdate').click(function () {
        var sentData = {
            UserID: 2,
            MemberID: currMemberID,
            Name: $("#modal-edit-user .memberModalName").val(),
            BirthDate : $("#modal-edit-user .memberModalBirthDate").val(),
            BirthPlace : $("#modal-edit-user .memberModalBirthPlace").val(),
            Gender : $("#modal-edit-user .memberModalGender").val(),
            Avatar : $("#modal-edit-user .memberModalAvatar").attr("src"),
            Status : $("#modal-edit-user input[name='radioStatus']:checked").val(),
            Address : $("#modal-edit-user .memberModalAddress").val()
            //,
            //Father : currMemberID
        };

        $.ajax({
            url: 'GetListMember.php',
            type: 'GET',
            data: {
                operation: "update",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            setInfoForMember(data[0]);
            console.log(data[0].MemberID);
        }).fail(function () {
            console.log("Failed to update info member !")
        });
    });
    // ~~~
});
