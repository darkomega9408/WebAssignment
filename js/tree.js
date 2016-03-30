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

/*    var myLatLng = {lat: 10.7889289, lng: 106.6517366};

    // Create a map object and specify the DOM element for display.
    map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        scrollwheel: true,
        zoom: 17
    });

    // Create a marker and set its position.
    var marker = new google.maps.Marker({
        map: map,
        position: myLatLng,
        title: 'Hello World!'
    });*/

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

    $(document).on("click", "#hrefLogOut", function() {
        deleteCookie("giaphaauth");
        document.location.href = "index.php";
    })

    // Load member card from another file and assign to '@memberCardObj'
    $('.tree').load('templates/card-demo/membercard-demo.html .membercard', function () {
        memberCardObj = $(this).clone();
        $(this).html('');
    });
    // ~~


    // Load tree first
/*    $.ajax({
        url: 'php-controller/ServerHandler.php',
        type: 'GET',
        dataType: "json"
    }).done(function(data){
        if (data.length == 0)
            $("#btnAddMember").show();
        else
            $("#btnAddMember").hide();

        // Tree
        createTree(data);
        search(data);
    }).fail(function (err) {
        console.log(err);
        console.log("Create tree failed");
    });*/

    $.ajax({
        url: 'http://localhost:8080/hello-restful/webservice/giapha/getmembers',
        type: 'POST',
        dataType: "json",
        beforeSend: function(request) {
            var authstring = getCookie("giaphaauth");
            if (authstring != "")
                request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
            else
                document.location.href = "index.php";
        }
    }).done(function(data){
        console.log(data);
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
        var memberCard = $("#"+member + data.memberID);
        // Set avatar if any or leave default

        if(data.alive == 0){
            console.log(data);
            memberCard.css('background-image','url(images/watermark.png)');
            memberCard.css('background-repeat','no-repeat');
        }
        else{
            memberCard.css('background-image','');
            memberCard.css('background-repeat','no-repeat');
        }

        // Set default avatar
        console.log(data.avatar);
        if( data.avatar != null )
            memberCard.find(".memberAvatar").attr("src", data.avatar);
        memberCard.find('.memberName').html(data.name);
        memberCard.find('.memberBirthDate').html(data.birthDate.substring(0, 10));
        memberCard.find('.memberBirthPlace').html(data.birthPlace);

        // Store all data
        memberCard.data("memberinfo", data);
        console.log(memberCard.data("memberinfo"));
    }
    // ~~


    // Set HTML layout for each member
    var layoutMember = function (data, memberCardObj) {
        $(memberCardObj).find('.membercard').attr('id', member + data.memberID);
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


    // Set map modal
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
        // Get memberID of current shown member
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
			if (currMemberID == 0) {
				$(".modal-title").html("New member");
			}
			else {
            $(".modal-title").html("New child of " + $("#"+member+currMemberID).data("memberinfo").name);
			}
            return;
        }

        // Assign some basic info to modal before display to user
        var memberinfo = $("#"+member + currMemberID).data("memberinfo");

        $("#modal-edit-user .modal-title").html(memberinfo.name + " Information");
        $("#modal-edit-user .memberModalAvatar").attr("src", memberinfo.avatar);
        $("#modal-edit-user .memberModalName").attr("value", memberinfo.name);
        $("#modal-edit-user .memberModalGender").val(memberinfo.gender);
        $("#modal-edit-user .memberModalBirthDate").attr("value", memberinfo.birthDate.substring(0, 10));
        $("#modal-edit-user .memberModalAddress").attr("value", memberinfo.address);
        $("#modal-edit-user .memberModalBirthPlace").attr("value", memberinfo.birthPlace);
        if( memberinfo.alive )
            $("#edit-radio-alive").attr("checked", true);
        else $("#edit-radio-dead").attr("checked", true);
    });
    // ~~


    // Delete user triggered by btnDelete onclick()
    $('#btnDelete').click(function () {
        console.log("Delete");
/*        $.ajax({
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
        });*/

        $.ajax({
            url: 'http://localhost:8080/hello-restful/webservice/giapha/deletemember',
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify({
                sentData : {
                    MemberID: currMemberID
                }
            }),
            beforeSend: function(request) {
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "index.php";
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
        // Validate
        var name = $("#modal-add-user .memberModalName").val();
        var birthPlace = $("#modal-add-user .memberModalBirthPlace").val();
        if( name == "" || birthPlace == "" ){
            $("#modal-add-user .error-msg").html("Some fields are invalid. Please try again!");
            return;
        }
        else $("#modal-add-user .error-msg").html();

        var sentData = {
            userID: 2,
            name: $("#modal-add-user .memberModalName").val(),
            birthDate : $("#modal-add-user .memberModalBirthDate").val(),
            birthPlace : $("#modal-add-user .memberModalBirthPlace").val(),
            gender : $("#modal-add-user .memberModalGender").val(),
            avatar : $("#modal-add-user .memberModalAvatar").attr("src")==""?"images/avatar-default.png":$("#modal-add-user .memberModalAvatar").attr("src"),
            alive : $("#modal-add-user input[name='radioStatus']:checked").val()=="Alive" ? 1 : 0,
            address : $("#modal-add-user .memberModalAddress").val(),
            father : currMemberID
        };

/*        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'POST',
            data: {
                role: "user",
                operation: "add",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            if (currMemberID == 0)
                window.location.reload();
            $("#modal-add-user").modal('hide');
            $(".tree").width( ($(".tree").width() + 30) + "em" );
            addMember(data[0]);
            console.log(data[0].memberID);
        }).fail(function () {
            console.log("Failed to add new member!")
        });*/

        $.ajax({
            url: 'http://localhost:8080/hello-restful/webservice/giapha/addmember',
            type: 'POST',
            contentType: 'application/json',
            dataType: "json",
            data: JSON.stringify({
                sentData: sentData
            }),
            beforeSend: function(request) {
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "index.php";
            }
        }).done(function (data) {
            if (currMemberID == 0)
                window.location.reload();
            $(".tree").width( ($(".tree").width() + 30) + "em" );
            addMember(data);
            console.log(data.memberID);
        }).fail(function () {
            console.log("Failed to add new member!")
        });
    });
    // ~~


    // Update member info
    $('#btnUpdate').click(function () {
        // Validate
        var name = $("#modal-edit-user .memberModalName").val();
        var birthPlace = $("#modal-edit-user .memberModalBirthPlace").val();
        if( name == "" || birthPlace == "" ){
            $("#modal-edit-user .error-msg").html("Some fields are invalid. Please try again!");
            return;
        }
        else $("#modal-edit-user .error-msg").html();

        var sentData = {
/*            UserID: 2,
            MemberID: currMemberID,
            Name: $("#modal-edit-user .memberModalName").val(),
            BirthDate : $("#modal-edit-user .memberModalBirthDate").val(),
            BirthPlace : $("#modal-edit-user .memberModalBirthPlace").val(),
            Gender : $("#modal-edit-user .memberModalGender").val(),
            Avatar : $("#modal-edit-user .memberModalAvatar").attr("src"),

            Status : $("#modal-edit-user input[name='radioStatus']:checked").val()=="Alive" ? 1 : 0,
            Address : $("#modal-edit-user .memberModalAddress").val()
            */
            userID: 2,
            memberID: currMemberID,
            name: $("#modal-edit-user .memberModalName").val(),
            birthDate : $("#modal-edit-user .memberModalBirthDate").val(),
            birthPlace : $("#modal-edit-user .memberModalBirthPlace").val(),
            gender : $("#modal-edit-user .memberModalGender").val(),
            avatar : $("#modal-edit-user .memberModalAvatar").attr("src"),
            alive : $("#modal-edit-user input[name='radioStatus']:checked").val()=="Alive" ? 1 : 0,
            address : $("#modal-edit-user .memberModalAddress").val()
        };

/*        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'POST',
            data: {
                role: "user",
                operation: "update",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            setInfoForMember(data[0]);
            console.log(data[0].memberID);
        }).fail(function () {
            console.log("Failed to update info member !")
        });*/

        $.ajax({
            url: 'http://localhost:8080/hello-restful/webservice/giapha/updatemember',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                sentData: sentData
            }),
            dataType: 'json',
            beforeSend: function(request) {
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "index.php";
            }
        }).done(function (data) {
            $("#modal-edit-user").modal('hide');
            setInfoForMember(data);
            console.log(data.memberID);
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
    });

    var clientId = "ae6e3c4095f9247";

    function showMeError(err) {
        console.log(err);
    }
    function updateAvatarForDB(data, isAddMem) {
        var imgLink = data.data.link;
        if (isAddMem == 1) {
            $("#modal-add-user .memberModalAvatar").attr("src", imgLink);
            $('#modal-uploading').modal('hide');
        }
        else {
            $.ajax({
                url: 'http://localhost:8080/hello-restful/webservice/giapha/changeavatar',
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
                        document.location.href = "index.php";
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


    // Search function for navbar
    function search(data) {
        var dropdown = true;
        var search, $search;
        $search = $('#search').selectize({
            maxItems: 1,
            scrollDuration: 1000,
            selectOnTab: 'true',
            valueField: 'memberID',
            labelField: 'name',
            searchField: ['name', "gender", 'adress', 'birthDate', 'birthPlace'],
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
