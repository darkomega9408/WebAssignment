$(document).ready(function(){

    // Some variables
    var memberCardObj = "";
    var member = "mem";
    var currMemberID ;
    var token = getCookie('token');

    /********************************************************
     *
     * LOAD SOME COMMON FILE : NAVBAR , MEMBERCARD
     */

    

    /**
     *  Load header - navbar from file
     */
    $("header").load("templates/nav-bar-demo/nav-bar.html .navbar", function () {
        // Change logo relative path
        $(".navbar-brand>img").attr("src","images/family-tree-logo.png");

        // Change role & append new caret
        $("#navbar-user-name").prepend("Hi, User "+$("header").attr("data-id"));
        /*var authStr = atob(getCookie("giaphaauth"));
         var userName = authStr.split(":")[0];
         $("#navbar-user-name").prepend("Hi, "+ userName);*/

        // Expire token until ...
        $(document).on('click', 'a[href="#exit"]', function() {
            document.cookie = 'token=; expires=Thu, 01 Jan 1970 00:00:00 UTC';
            window.location = '/';
        })
    });
    // ~~


    // Load member card from another file and assign to '@memberCardObj'
    $('.tree').load('templates/membercard/membercard.html .membercard', function () {
        memberCardObj = $(this).clone();
        $(this).html('');
    });
    // ~~

    /********************************************************
     *
     * AJAX CALL
     */


    /**
     * Set info for EDIT modal when opening
     * @Type : Modal event listener
     * @Author: TÂM
     */
    $('.modal').on('show.bs.modal', function (e) {
        // Get memberID of current shown member : in EDIT modal
        try {
            var $trigger = $(e.relatedTarget);
            var $memberID = $trigger.parents().eq(3).attr('id');
            currMemberID = $memberID.substr(member.length);
            $(this).attr("data-memid", currMemberID);
        } catch (err) {
            if ($(this).attr("id") == "modal-add-user")
                currMemberID = 0;
            var $trigger = $(e.relatedTarget);
            var modalFather = $trigger.parents().eq(5);
            if (modalFather.attr("id") == "modal-add-user")
                $(this).find("#btnUploadAvatar").attr("data-addmem", 1);
            else {
                $(this).find("#btnUploadAvatar").attr("data-addmem", 0);
            }
            $(this).find("#btnUploadAvatar").attr("data-memid", modalFather.attr("data-memid"));
            return;
        }

        // Hide error msg
        $(".error-msg").html("");


        // Don't automatically add data for modal ADD RELATIVE
        if( $(this).attr("id") == "modal-add-user" ) {
            if (currMemberID == 0)
                $(".modal-title").html("New member");
            else $(".modal-title").html("New child of " + $("#"+member+currMemberID).data("memberinfo").Name);
            return;
        }
        // Change title of UPLOAD AVATAR modal
        else if(  $(this).attr("id") != "modal-upload-avatar"){
            $("#modal-upload-avatar .modal-title").html("Change Avatar");
        }

        // Assign some basic info to modal before display to user
        var memberinfo = $("#"+member + currMemberID).data("memberinfo");
        console.log(memberinfo);
        $("#modal-edit-user .modal-title").html(memberinfo.Name + " Information");
        $("#modal-edit-user .memberModalAvatar").attr("src", memberinfo.Avatar);
        $("#modal-edit-user .memberModalName").val( memberinfo.Name);
        $("#modal-edit-user .memberModalGender").val(memberinfo.Gender);
        $("#modal-edit-user .memberModalBirthDate").val( memberinfo.BirthDate.substring(0, 10));
        $("#modal-edit-user .memberModalAddress").val( memberinfo.Address);
        $("#modal-edit-user .memberModalBirthPlace").val(memberinfo.BirthPlace);
        if( memberinfo.Alive == "1" )
            $("#edit-radio-alive").prop("checked", true);
        else $("#edit-radio-dead").prop("checked", true);
    });
    // ~~


    /**
     * Delete user triggered by btnDelete onclick()
     */
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
        }).done(function () {
            $('#modal-uploading').modal('hide');
            console.log("Delete member successfully");
            deleteMember();
        }).fail(function () {
            $('#modal-uploading').modal('hide');
            console.log("Failed to delete member");
        });
    });
    // ~~



    /**
     * Add new relative
     */
    $('#btnAdd').click(function () {
        // Validate
        var name = $("#modal-add-user .memberModalName").val();
        var birthPlace = $("#modal-add-user .memberModalBirthPlace").val();
        var birthDate = $("#modal-add-user .memberModalBirthDate").val();
        var gender = $("#modal-add-user .memberModalGender").val();
        var avatar = setDefaultAvatar($("#modal-add-user .memberModalAvatar").attr("src"),gender);

        // Validate
        if( !validateModal("add",name,birthPlace,birthDate) )
            return;

        // Otherwise continue send data to server
        var sentData = {
            UserID: 2,
            Name: name,
            BirthDate : birthDate,
            BirthPlace : birthPlace,
            Gender : gender,
            Avatar : avatar,
            Alive : $("#modal-edit-user input[name='radioStatus']:checked").val()=="Alive" ? 1 : 0,
            Address : $("#modal-add-user .memberModalAddress").val(),
            Father : currMemberID
        };

        // Ajax POST
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'POST',
            data: {
                role: "user",
                operation: "add",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            $('#modal-uploading').modal('hide')
            $("#modal-add-user").modal('hide');

            // If tree has only one child => do reload page
            if (currMemberID == 0)
                window.location.reload();

            // Set width for tree
            $(".tree").width( ($(".tree").width() + 30) + "em" );

            // Add new member into tree and hide modal 'add'
            addMember(data[0]);
            $("#modal-add-user").modal('hide');

        }).fail(function () {
            $('#modal-uploading').modal('hide');
            console.log("Failed to add new member!")
        });
    });
    // ~~


    /**
     * Update member info
     */
    $('#btnUpdate').click(function () {
        // Validate
        var name = $("#modal-edit-user .memberModalName").val();
        var birthPlace = $("#modal-edit-user .memberModalBirthPlace").val();
        var birthDate = $("#modal-edit-user .memberModalBirthDate").val();
        var gender = $("#modal-edit-user .memberModalGender").val();
        var avatar = setDefaultAvatar($("#modal-edit-user .memberModalAvatar").attr("src"), gender);

        if( !validateModal("edit",name,birthPlace, birthDate) )
            return;

        var sentData = {
            UserID: 2, // default
            MemberID: currMemberID,
            Name: name,
            BirthDate : birthDate,
            BirthPlace : birthPlace,
            Gender : gender ,
            Avatar : avatar,
            Alive : $("#modal-edit-user input[name='radioStatus']:checked").val()=="Alive" ? 1 : 0,
            Address : $("#modal-edit-user .memberModalAddress").val()
        };

        /**
         * Ajax POST
         */
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'POST',
            data: {
                role: "user",
                operation: "update",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            $('#modal-uploading').modal('hide');
            // Hide 'edit' modal and update member info
            $("#modal-edit-user").modal('hide');
            setInfoForMember(data[0]);
        }).fail(function () {
            $('#modal-uploading').modal('hide');
            console.log("Failed to update info member !")
        });
    });


    /**
     * Load tree
     */
    $.ajax({
        url: 'php-controller/ServerHandler.php',
        type: 'GET',
        dataType: "json"
    }).done(function(data){
        if (data.length == 0)
            $("#btnAddMember").show();
        else
            $("#btnAddMember").hide();
        createTree(data);
        search(data);
    }).fail(function (err) {
        $('#modal-uploading').modal('hide');
        console.log(err);
        console.log("Create tree failed");
    });
    // ~~

    /********************************************************
     *
     * HELPER FUNCTIONS TO CREATE TREE , MODIFY OR DELETE NODE
     */


    /**
     * Change member info displayed based on DB
     * @param data : member info stored as JSON
     */
    function setInfoForMember(data) {
        var memberCard = $("#"+member + data.MemberID);

        // Set avatar if any or leave default
        if(data.Alive == 0){
            memberCard.css('background-image','url(images/watermark.png)');
            memberCard.css('background-repeat','no-repeat');
        }
        else{
            memberCard.css('background-image','');
            memberCard.css('background-repeat','no-repeat');
        }

        // Set default avatar
        if( data.Avatar != null )
            memberCard.find(".memberAvatar").attr("src", data.Avatar);
        memberCard.find('.memberName').html(data.Name);
        memberCard.find('.memberBirthDate').html(data.BirthDate);
        memberCard.find('.memberBirthPlace').html(data.BirthPlace);

        // Store all data
        memberCard.data("memberinfo", data);

    }
    // ~~


    /**
     * Set HTML layout for each member
     * @param data
     * @param memberCardObj
     * @returns {*|jQuery}
     */
    var layoutMember = function (data, memberCardObj) {
        $(memberCardObj).find('.membercard').attr('id', member + data.MemberID);
        return $(memberCardObj).html();
    };
    // ~~


    /**
     * Use to create tree html
     * @param data: server 's response , get from DB
     */
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


    /**
     * Add member
     * @param data data to be added
     */
    function addMember(data) {
        var content = "<li>" + layoutMember(data, memberCardObj) + "</li>";

        if( $('#' + member + data.Father + '+ul').length <= 0 )
            $('#' + member + data.Father).after("<ul>" + content + "</ul>");
        else
            $('#' + member + data.Father + '+ul').append(content);

        setInfoForMember(data);
    }
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
    }
    // ~~


    /********************************************************
     *
     * VALIDATE MODAL - VINH
     */


    /**
     * Validate modal add and edit member
     */
    function validateModal(modal , name, birthPlace, birthDate) {
        // Validate
        var isValid = true;
        var errMsg = "";
        if( name == "" ){
            errMsg = ("Please fill in 'Name' field");
            isValid = false;
        }
        else if ( birthPlace == "" ){
            errMsg= ("Please fill in 'BirthPlace' field");
            isValid = false;
        }
        else if( currMemberID != 0 ){
            if( !checkChildBirthDate(modal,currMemberID,birthDate) ) {
                errMsg= ("Child can't be older than parent");
                isValid = false;
            }

        }
        else $("#modal-add-user .error-msg").html();

        // Log error msg and return immediately if any
        if( modal == "add" )
            $("#modal-add-user .error-msg").html(errMsg);
        else if( modal == "edit" )
            $("#modal-edit-user .error-msg").html(errMsg);

        return isValid;
    }
    // ~~

    /**
     * Set default avatar if needed based on gender
     */
    function setDefaultAvatar(avatar ,gender) {
        if( avatar == "" || avatar == "images/avatar-default.png" || avatar == "images/avatar-female-default.jpg") {
            if (gender == "female")
                avatar = "images/avatar-female-default.jpg";
            else avatar = "images/avatar-default.png";
        }

        return avatar;
    }
    // ~~

    /**
     * Check whether child 's birthdate is smaller than father's one or not
     * @param modal
     * @param childId
     * @param childBirthDate
     * @returns {boolean}
     */
    function checkChildBirthDate(modal,childId,childBirthDate) {

        var isValid = true;

        var parentBirthDate = "";
        if (modal == "edit") {
            try {
                // First off , check if child must be older than all its grandchildren
                isValid = checkParentOlderThanAllChildren(childId, childBirthDate);

                var parentIdSelector = $("#" + member + childId).parents().eq(1).siblings(".membercard").attr("id");

                parentBirthDate = $("#" + parentIdSelector).data("memberinfo").BirthDate.substr(0, 10);
            } catch (e) {
                // It occurred when we modify the root member
            }
        }
        else if (modal == "add")
            parentBirthDate = $("#" + member + currMemberID).data("memberinfo").BirthDate.substr(0, 10);
        else console.log("Invalid modal");

        // Second check
        // If ( child older parent ||  )=> return false
        isValid = isValid && (childBirthDate > parentBirthDate);

        if (!isValid)
            console.log("Parent must be older than child  ");

        return isValid;
    }
    // ~~

    /**
     * Loop through all children to check birthdate of them smaller than parent or not
     * @param parentId
     * @param parentBirthDate
     * @returns {boolean}
     */
    function checkParentOlderThanAllChildren(parentId,parentBirthDate) {
        var isValid = true;
        $("#" + member + parentId).siblings("ul").children("li").each(function () {
            var childBirthDate = $(this).children(".membercard").find(".memberBirthDate").html();
            if (childBirthDate <= parentBirthDate) // Invalid case
            {
                isValid = false; // child can't be older than parent => so invalid
                return; // break each function
            }
        });
        return isValid;
    }



    /********************************************************
     *
     * HANDLE IMAGE UPLOAD - TÂM
     */


    /**
     *  Some var
     */
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
                console.log("DATAURL: " + canvas.toDataURL());
                imgUrl = canvas.toDataURL().replace(/^data:image\/(png|jpg);base64,/, "");
            })
        }
        reader.readAsDataURL(file);
    });

    var clientId = "ae6e3c4095f9247";

    /**
     * Show err
     * @param err
     */
    function showMeError(err) {
        console.log(err);
    }


    /**
     * Update avatar to DB
     * @param data
     * @param isAddMem
     */
    function updateAvatarForDB(data, isAddMem) {
        var imgLink = data.data.link;
        if (isAddMem == 1) {
            $("#modal-add-user .memberModalAvatar").attr("src", imgLink);
            $('#modal-uploading').modal('hide');
        }
        else {
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
    }


    /**
     * Button upload on click
     */
    $("#btnUploadAvatar").click(function(){
        memberUploadAvatarId = $(this).attr("data-memid");
        var isAddMem = $(this).attr("data-addmem");
        $.ajax({
            url: "https://api.imgur.com/3/upload",
            type: "POST",
            dataType: "json",
            data: {image: imgUrl},
            success: function(data) {
                updateAvatarForDB(data, isAddMem);

            },
            error: showMeError,
            beforeSend: function (xhr) {
                $('#modal-uploading').modal('show');
                xhr.setRequestHeader("Authorization", "Client-ID " + clientId);
            }
        });
    });

    // ~~~


    /********************************************************
     *
     * SEARCH - QUÍ
     */


    /**
     * Search function for navbar
     * @param data
     */
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

            },
            onBlur: function(){
                $('.selectize-input input').val(text);
            },
            onType: function(str){
                console.log(str);
                text = str;
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
