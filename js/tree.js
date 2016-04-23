$(document).ready(function(){

    // Some variables
    var memberCardObj = "";
    var member = "mem";
    var currMemberID ;
    var token = getCookie('token');
    var role = $("head").data("role");
    var managedUserID = $("head").data("managedUserID");
    var guestID = $("head").data("guestID");


    // Determine whether current user is guest or not -> choose appropriate navbar for them
    // Default is navbar of normal user
    if (  role == 'guest' )
        navbarAdminPage();
    // ~~


    /********************************************************
     *
     * LOAD SOME COMMON FILE : NAVBAR , MEMBERCARD
     */

    // Load member card from another file and assign to '@memberCardObj'
    $('.tree').load('templates/membercard/membercard.html .membercard', function () {
        memberCardObj = $(this).clone();

        // Turn on SEE ONLY mode for guest
        if ( role == 'guest' ){
            $(memberCardObj).find('.effect-winston p').hide();
            $(memberCardObj).find('.membercard').removeClass('effect-winston');

            $(memberCardObj).find('.membercard').attr('data-toggle','modal');
            $(memberCardObj).find('.membercard').attr('data-target','#modal-see-info-guest');
        }

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
            var modalFather = $trigger.parents().eq(8);
            if (modalFather.attr("id") == "modal-add-user") {
                console.log("WWWTTFFFF");
                $(this).find("#btnUploadAvatar").attr("data-addmem", 1);
            }
            else {
                $(this).find("#btnUploadAvatar").attr("data-addmem", 0);
            }

            if ($(this).attr("id") == "modal-upload-avatar") {
                if (modalFather.attr("id") == "modal-edit-user") {
                    var avatarID = $trigger.children().eq(0).attr("class").split(" ")[3].substr(-1);
                    $(this).find("#btnUploadAvatar").attr("data-avatarid", avatarID);
                }
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
            $("#modal-upload-avatar .modal-title").html("Upload Image");
        }

        // Assign some basic info to modal before display to user
        populateDataIntoModal("modal-edit-user");
    });
    // ~~


    $('#modal-see-info-guest').on('show.bs.modal', function (e) {
        currMemberID = $(e.relatedTarget).attr('id').substr(member.length);
        populateDataIntoModal("modal-see-info-guest");
    });


    function populateDataIntoModal (modalName) {
        var memberinfo = $("#"+member + currMemberID).data("memberinfo");
        console.log(memberinfo);
        $("#"+modalName+" .modal-title").html(memberinfo.Name + " Information");
        //$("#"+modalName+" .memberModalAvatar").attr("src", memberinfo.Avatar);
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                role: role,
                operation: "loadAvatar",
                sentData: {
                    MemberID: currMemberID
                }
            }
        }).done(function(xmldata) {
            var avatars = $(xmldata).find("avatar");
            $(avatars).each(function (index, val) {
                if (val.childNodes[0].data != "empty")
                    $("#"+modalName+" .memberModalAvatar" + index).attr("src", val.childNodes[0].data);
            })

        }).fail(function(err) {
            console.log(err);
        });
        $("#"+modalName+" .memberModalName").val( memberinfo.Name);
        $("#"+modalName+" .memberModalGender").val(memberinfo.Gender);
        $("#"+modalName+" .memberModalBirthDate").val( memberinfo.BirthDate.substr(0, 10));
        $("#"+modalName+" .memberModalAddress").val( memberinfo.Address);
        $("#"+modalName+" .memberModalBirthPlace").val(memberinfo.BirthPlace);
        if( memberinfo.Alive == "1" ) {
            $("#edit-radio-alive").prop("checked", true);
            $("#see-radio-alive").prop("checked", true);
        }
        else {
            $("#edit-radio-dead").prop("checked", true);
            $("#see-radio-dead").prop("checked", true);
        }
    }



    /**
     * Delete user triggered by btnDelete onclick()
     */
    $('#btnDelete').click(function () {
        console.log("Delete");

        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                role: role,
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
            Alive : $("#modal-add-user input[name='radioStatus']:checked").val()=="Alive" ? 1 : 0,
            Address : $("#modal-add-user .memberModalAddress").val(),
            Father : currMemberID
        };

        // Ajax POST
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'POST',
            data: {
                role: role,
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
                role: role,
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
            //memberCard.css('background-image','url(images/watermark.png)');
            memberCard.css('background-repeat','no-repeat');
            memberCard.css('background-color', '#9E9E9E');
        }
        else{
            if ( data.Gender == 'female' )
                memberCard.css('background-color', '#F06292');
            else memberCard.css('background-color', '#64B5F6');
            memberCard.css('background-image','');
            memberCard.css('background-repeat','no-repeat');
        }

        // Set default avatar
/*        if( data.Avatar != null )
            memberCard.find(".memberAvatar").attr("src", data.Avatar);*/

        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                role: role,
                operation: "loadAvatar",
                sentData: {
                    MemberID: data.MemberID
                }
            }
        }).done(function(xmldata) {
            //console.log($(data).find("avatar")[0].childNodes[0]);
            var avatars = $(xmldata).find("avatar");
            if (avatars.length > 0 && avatars[0].childNodes[0].data != "empty")
                memberCard.find(".memberAvatar").attr("src", avatars[0].childNodes[0].data);
            else
                memberCard.find(".memberAvatar").attr("src", data.Avatar);


        }).fail(function(err) {
            console.log(err);
        });

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


        // Add Root node ( if any )
        if( nbrNode <= 0 ) return;
        else {
            $('.tree').append("<ul><li>" + layoutMember(data[0], memberCardObj) + "</li></ul>");
            setInfoForMember(data[0]);
        }

        // Add Child node
        for(i = 1 ; i< nbrNode ; ++i)
            addMember(data[i]);


        // Set width for tree
        var numOfLeaf = $('.tree').find('li:not(:has(ul))').length;
        console.log(numOfLeaf);
        $(".tree").width((numOfLeaf * 170) + "px");
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
    var avatarId;

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
                    role: role,
                    operation: "changeAvatar",
                    sentData: {
                        role: role,
                        Avatar : data.data.link,
                        UserID : 2,
                        MemberID : memberUploadAvatarId,
                        AvatarID: avatarId
                    }
                },
                dataType: 'json'
            }).done(function (data) {
                if (avatarId == 0)
                    $("#mem" + memberUploadAvatarId).find(".memberAvatar").attr("src", imgLink);
                $("#modal-edit-user .memberModalAvatar" + avatarId).attr("src", imgLink);
                $("#mem" + memberUploadAvatarId).data("memberinfo", data);
                $('#modal-uploading').modal('hide');
            }).fail(function (err) {
                console.log(err);
            });
        }
    }


    /**
     * Button upload on click
     */
    $("#btnUploadAvatar").click(function(){
        memberUploadAvatarId = $(this).attr("data-memid");
        avatarId = $(this).attr("data-avatarid");
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

    // target elements with the "draggable" class
    var heightOffset = 1 - $('.tree-container').height() / $('.tree').height();
    if (heightOffset <= 0) heightOffset = 0;

    var widthOffset = 1 - $('.tree-container').width() / $('.tree').width();
    if (widthOffset <= 0) widthOffset = 0;
    interact('.tree').draggable({
        // enable inertial throwing
        inertia: true,
        // keep the element within the area of it's parent
        restrict: {
          restriction: "parent",
          endOnly: true,
          elementRect: { top: 0 + heightOffset, left: 0 + widthOffset, bottom: 1 - heightOffset, right: 1- widthOffset }
        },
        // enable autoScroll
        autoScroll: true,

        // call this function on every dragmove event
        onmove: function (event) {
            var target = event.target,
                // keep the dragged position in the data-x/data-y attributes
                x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

            // translate the element
            target.style.webkitTransform =
            target.style.transform =
              'translate(' + x + 'px, ' + y + 'px)';

            // update the posiion attributes
            target.setAttribute('data-x', x);
            target.setAttribute('data-y', y);
        }
    });


});
