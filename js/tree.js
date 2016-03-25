$(document).ready(function(){

    // Some variables
    var memberCardObj = "";
    var member = "mem";
    var currMemberID ;

    //$('.modal-wrapper').load('../card-demo/membercard-demo.html .member-modal-wrapper');

    // Load header - navbar from file
    $("header").load("templates/nav-bar-demo/nav-bar.html .navbar", function () {
        // Change logo relative path
        $(".navbar-brand>img").attr("src","images/family-tree-logo.png");
    });
    // ~~

    // Load member card from another file and assign to '@memberCardObj'
    $('.tree').load('templates/card-demo/membercard-demo.html .membercard', function () {
        memberCardObj = $(this).clone();
        $(this).html('');
    });
    // ~~


    // Load tree first
    $.ajax({
        url: 'php-controller/ServerHandler.php',
        type: 'GET',
        dataType: "json",
        data: {
            role: "user",
            UserID : 2
        }
    }).done(function(data){
		if (data.length == 0)
			$("#btnAddMember").show();
		else
			$("#btnAddMember").hide();
        createTree(data);
		search(data);
    }).fail(function (err) {
        console.log(err);
        console.log("Create tree failed");
    });
    // ~~


    // Change member info displayed based on DB
    function setInfoForMember(data) {
        var memberCard = $("#"+member + data.MemberID);

        // Set avatar if any or leave default
        if(data.Alive == 0){
          console.log(data);
          memberCard.css('background-image','url(images/watermark.png)');
          memberCard.css('background-repeat','no-repeat');
        
        }
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
        $(".tree").width((data.length * 30) + "em");

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
		if ($(".tree").has(".membercard").length == 0)
			$("#btnAddMember").show();
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
            $(this).attr("data-memid", currMemberID);
        } catch (err) {
			currMemberID = 0;
            var $trigger = $(e.relatedTarget);
            var modalFather = $trigger.parents().eq(4);
            $(this).find("#btnUploadAvatar").attr("data-memid", modalFather.attr("data-memid"));
			return;
        }


        // Don't automatically add data for modal ADD RELATIVE
        if( $(this).attr("id") == "modal-add-user" ) {
			if (currMemberID == 0) {
				$(".modal-title").html("New member");
			}
			else {
            $(".modal-title").html("New child of " + $("#"+member+currMemberID).data("memberinfo").Name);
			}
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
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                role: "user",
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
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                role: "user",
                operation: "add",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
			if (currMemberID == 0)
				window.location.reload();
			$(".tree").width( ($(".tree").width() + 30) + "em" );
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
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                role: "user",
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


    //Handle Image upload
    var imgUrl = "";
    var memberUploadAvatarId;

    $('#file-input').change(function(e) {

        var file = e.target.files[0];
        imageType = /image.*/;

        if (!file.type.match(imageType)) {
            console.log("File didn't match");
            return;
        }

        var reader = new FileReader();
        reader.onload = function fileOnLoad(e) {
            var $img = $('<img>', {src: e.target.result});
            $("#imgNewAvatar").attr("src", $img.attr("src"));
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');

            $img.load(function() {
                canvas.width = this.width;
                canvas.height = this.height;
                context.drawImage(this, 0, 0);
                imgUrl = canvas.toDataURL().replace(/^data:image\/(png|jpg);base64,/, "");
            })
        }
        reader.readAsDataURL(file);
    })

    var clientId = "ae6e3c4095f9247";

    function showMeError(err) {
        console.log(err);
    }
    function updateAvatarForDB(data) {
        var imgLink = data.data.link;
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                role: "user",
                operation: "changeAvatar",
                sentData: {
					role: "user",
                    Avatar : data.data.link,
                    UserID : 2,
                    MemberID : memberUploadAvatarId
                }
            },
            dataType: 'json'
        }).done(function (data) {
            $("#mem" + memberUploadAvatarId).find(".memberAvatar").attr("src", imgLink);
            $("#modal-edit-user .memberModalAvatar").attr("src", imgLink);
            $("#mem" + memberUploadAvatarId).data("memberinfo", data);
            $('#modal-uploading').modal('hide');
        }).fail(function () {
            console.log("Failed to upload avatar !")
        });
    }


    $("#btnUploadAvatar").click(function(){
        memberUploadAvatarId = $(this).attr("data-memid");
        $.ajax({
            url: "https://api.imgur.com/3/upload",
            type: "POST",
            datatype: "json",
            data: {image: imgUrl},
            success: updateAvatarForDB,
            error: showMeError,
            beforeSend: function (xhr) {
                $('#modal-uploading').modal('show');
                xhr.setRequestHeader("Authorization", "Client-ID " + clientId);
            }
        });
    })

    // ~~~


    // Search function for navbar
    function search(data) {
        var dropdown = true;
        var search, $search;
        $search = $('#search').selectize({
            maxItems: 1,
            scrollDuration: 1000,
            selectOnTab: 'true',
            valueField: 'MemberID',
            labelField: 'Name',
            searchField: ['Name', "Gender", 'Adress', 'BirthDate', 'BirthPlace'],
            options: data,
            onChange: function(value){
                $('.membercard').removeClass('border-effect');
                $('body').scrollTop($('#mem'+ value).offset().top - $( window ).height()/2);
                $('body').scrollLeft($('#mem'+ value).offset().left -  $( window ).width()/2 + 160);
                $('#mem' + value).addClass('border-effect');
            },
            onDropdownOpen: function($dropdown){
                $('.membercard').removeClass('border-effect');
            },
            onType: function(str){
                $('.membercard').removeClass('border-effect');
                if(str){
                  $('.selectize-dropdown .selectize-dropdown-content div').each( function(){
                    $('#mem' + $(this).attr('data-value')).addClass('border-effect');
                  });
                }
            },
            render: {
                item: function(item, escape) {
                    console.log(item);
                    return '<div><strong>' + escape(item.Name) + '</strong></div>';
                },
                option: function(item, escape) {
                    return '<div data-id="' + escape(item.MemberID) + '"><strong>' + escape(item.Name) +
                        '</strong><br><span style="opacity:0.8;">' + escape(item.BirthDate) +
                        '</span><br><small style="font-style: italic; opacity:0.8;">' + escape(item.Address) + '</small><br></div>';
                }
            }
        });
        search = $search[0].selectize;
    }
    // ~~

});
