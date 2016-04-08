var map;
var geocoder;
var address = "1083 Lạc Long Quân, phường 11, Tân Bình, Hồ Chí Minh";
function loadGoogleMapAPI()
{
    address = $(".memberModalAddress").val();
    var script = document.createElement("script");
    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyAZbQ6_Knt-SazBiokwXG0QQhLUiv-21Yg&callback=initMap";
    script.type = "text/javascript";
    document.getElementsByTagName("head")[0].appendChild(script);
}
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
        zoom: 16,
        center: latlng
    }
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
}
function initMap() {
    initialize();
    geocoder.geocode({'address': address}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}


$(document).ready(function(){

    // Some variables
    var memberCardObj = "";
    var member = "mem";
    var currMemberID ;

    /**
     *  Load header - navbar from file
     */
    $("header").load("templates/nav-bar-demo/nav-bar.html .navbar", function () {
        // Change logo relative path
        $(".navbar-brand>img").attr("src","images/family-tree-logo.png");

        // Change role & append new caret
        var authStr = atob(getCookie("giaphaauth"));
        var userName = authStr.split(":")[0];
        $("#navbar-user-name").prepend("Hi, "+ userName);

        // Expire token until ...
        $(document).on('click', 'a[href="#exit"]', function() {
            document.cookie = 'token=; expires=Thu, 01 Jan 1970 00:00:00 UTC';
            window.location = '/';
        })
    });
    // ~~

    /**
     * Log out
     */
    $(document).on("click", "#hrefLogOut", function() {
        deleteCookie("giaphaauth");
        document.location.href = "../index.php";
    })

    // Load member card from another file and assign to '@memberCardObj'
    $('.tree').load('templates/card-demo/membercard-demo.html .membercard', function () {
        memberCardObj = $(this).clone();

        $(this).html('');
    });
    // ~~


    /**
     * Load tree
     */
    $.ajax({
        url: 'https://tamrestful2.herokuapp.com/webservice/giapha/getmembers',
        type: 'POST',
        dataType: "json",
        beforeSend: function(request) {
			$('#modal-uploading').modal('show');
            var authstring = getCookie("giaphaauth");
            if (authstring != "")
                request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
            else
                document.location.href = "../index.php";
        }
    }).done(function(data){
$('#modal-uploading').modal('hide');
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


    /**
     * Change member info displayed based on DB
     * @param data : member info stored as JSON
     */
    function setInfoForMember(data) {
        var memberCard = $("#"+member + data.memberID);
        // Set avatar if any or leave default

        if(data.alive == 0){
            memberCard.css('background-image','url(images/watermark.png)');
            memberCard.css('background-repeat','no-repeat');
        }
        else{
            memberCard.css('background-image','');
            memberCard.css('background-repeat','no-repeat');
        }

        // Set default avatar
        if( data.avatar != null )
            memberCard.find(".memberAvatar").attr("src", data.avatar);
        memberCard.find('.memberName').html(data.name);
        memberCard.find('.memberBirthDate').html(data.birthDate.substring(0, 10));
        memberCard.find('.memberBirthPlace').html(data.birthPlace);

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
        $(memberCardObj).find('.membercard').attr('id', member + data.memberID);
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

        if( $('#' + member + data.father + '+ul').length <= 0 )
            $('#' + member + data.father).after("<ul>" + content + "</ul>");
        else
            $('#' + member + data.father + '+ul').append(content);

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


    /**
     * Set map modal
     */
    $('#modal-map').on('shown.bs.modal', function(){
        var center = map.getCenter();
        google.maps.event.trigger(map, 'resize');
        map.setCenter(center);
    });
    // ~~


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


        // Don't automatically add data for modal ADD RELATIVE
        if( $(this).attr("id") == "modal-add-user" ) {
			if (currMemberID == 0)
				$(".modal-title").html("New member");
			else $(".modal-title").html("New child of " + $("#"+member+currMemberID).data("memberinfo").name);
            return;
        }
            // Change title of UPLOAD AVATAR modal
        else if(  $(this).attr("id") != "modal-upload-avatar"){
            $("#modal-upload-avatar .modal-title").html("Change Avatar");
        }

        // Assign some basic info to modal before display to user
        var memberinfo = $("#"+member + currMemberID).data("memberinfo");

        $("#modal-edit-user .modal-title").html(memberinfo.name + " Information");
        $("#modal-edit-user .memberModalAvatar").attr("src", memberinfo.avatar);
        $("#modal-edit-user .memberModalName").val( memberinfo.name);
        $("#modal-edit-user .memberModalGender").val(memberinfo.gender);
        $("#modal-edit-user .memberModalBirthDate").val( memberinfo.birthDate.substring(0, 10));
        $("#modal-edit-user .memberModalAddress").val( memberinfo.address);
        $("#modal-edit-user .memberModalBirthPlace").val(memberinfo.birthPlace);
        if( memberinfo.alive )
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
            url: 'https://tamrestful2.herokuapp.com/webservice/giapha/deletemember',
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify({
                sentData : {
                    MemberID: currMemberID
                }
            }),
            beforeSend: function(request) {
				$('#modal-uploading').modal('show');
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "../index.php";
            }
        }).done(function (data) {
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
            userID: 2,
            name: name,
            birthDate : birthDate,
            birthPlace : birthPlace,
            gender : gender,
            avatar : avatar,
            alive : $("#modal-add-user input[name='radioStatus']:checked").val()=="Alive" ? 1 : 0,
            address : $("#modal-add-user .memberModalAddress").val(),
            father : currMemberID
        };

        // Ajax POST
        $.ajax({
            url: 'https://tamrestful2.herokuapp.com/webservice/giapha/addmember',
            type: 'POST',
            contentType: 'application/json',
            dataType: "json",
            data: JSON.stringify({
                sentData: sentData
            }),
            beforeSend: function(request) {
				$('#modal-uploading').modal('show');
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "../index.php";
            }
        }).done(function (data) {
			$('#modal-uploading').modal('hide');
            // If tree has only one child => do reload page
            if (currMemberID == 0)
                window.location.reload();

            // Set width for tree
            $(".tree").width( ($(".tree").width() + 30) + "em" );

            // Add new member into tree and hide modal 'add'
            addMember(data);
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
            userID: 2, // default
            memberID: currMemberID,
            name: name,
            birthDate : birthDate,
            birthPlace : birthPlace,
            gender : gender ,
            avatar : avatar,
            alive : $("#modal-edit-user input[name='radioStatus']:checked").val()=="Alive" ? 1 : 0,
            address : $("#modal-edit-user .memberModalAddress").val()
        };

        /**
         * Ajax POST
         */
        $.ajax({
            url: 'https://tamrestful2.herokuapp.com/webservice/giapha/updatemember',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                sentData: sentData
            }),
            dataType: 'json',
            beforeSend: function(request) {
				$('#modal-uploading').modal('show');
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "../index.php";
            }
        }).done(function (data) {
			$('#modal-uploading').modal('hide');
            // Hide 'edit' modal and update member info
            $("#modal-edit-user").modal('hide');
            setInfoForMember(data);
        }).fail(function () {
			$('#modal-uploading').modal('hide');
            console.log("Failed to update info member !")
        });
    });


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

    /********************************************************
     *
     * Handle Image upload
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
                url: 'https://tamrestful2.herokuapp.com/webservice/giapha/changeavatar',
                type: 'POST',
                contentType: "application/json",
                data: JSON.stringify({
                    sentData: {
                        avatar: data.data.link,
                        memberID: memberUploadAvatarId
                    }
                }),
                dataType: 'json',
                beforeSend: function (request) {
                    var authstring = getCookie("giaphaauth");
                    if (authstring != "")
                        request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                    else
                        document.location.href = "../index.php";
                }
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
            datatype: "json",
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
        if( modal == "edit" ) {
            try {
                var parentIdSelector = $("#" + member + childId).parents().eq(1).siblings(".membercard").attr("id");

                parentBirthDate = $("#" + parentIdSelector).data("memberinfo").birthDate.substr(0, 10);
            } catch (e) {
                // It occurred when we modify the root member
            }
        }
        else if ( modal == "add" ){
            parentBirthDate = $("#" + member + currMemberID).data("memberinfo").birthDate.substr(0, 10);
        }

        // Compare
        // If ( child older parent || child smaller than one of each grandchildren )=> return false
        if (childBirthDate <= parentBirthDate || !checkParentOlderThanAllChildren(childId,childBirthDate)) // Invalid case
        {
            console.log("Parent must be older than child  ");
            isValid =  false;
        }

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
            valueField: 'memberID',
            labelField: 'name',
            searchField: ['name', "gender", 'address', 'birthDate', 'birthPlace'],
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
                    return '<div><strong>' + escape(item.name) + '</strong></div>';
                },
                option: function(item, escape) {
                    return '<div data-id="' + escape(item.memberID) + '"><strong>' + escape(item.name) +
                        '</strong><br><span style="opacity:0.8;">' + escape(item.birthDate) +
                        '</span><br><small style="font-style: italic; opacity:0.8;">' + escape(item.address) + '</small><br></div>';
                }
            }
        });
        search = $search[0].selectize;
    }
    // ~~

})
