console.log("Load guests-management.js");
$(document).ready(function () {
    // Load navbar of guests management 's page of user
    navbarGuestPage();

    var user = "user";

    /**
     * Load all users
     */
    $.ajax({
        url: 'php-controller/ServerHandler.php',
        type: 'GET',
        dataType: 'json',
        data:{
            role : "user",
            operation: "getAllGuests",
            UserID: $("head").prop('data-id')
        }
    }).done(function(data){
		$('#modal-uploading').modal('hide');
        createTable(data);
        search(data);
        //navbarGuestPage();
        console.log("Load guests successfully");
    }).fail(function () {
		$('#modal-uploading').modal('hide');
        console.log("Load guests failed");
        //navbarGuestPage();
    });
    // ~~


    /**
     * Search function
     * @param data
     */
    function search(data) {
        var dropdown = true;
        var search, $search;

        $search = $('#search').selectize({
            maxItems: 1,
            selectOnTab: 'true',
            valueField: 'ID',
            labelField: 'Username',
            searchField: ['Username', "Name", 'Email'],
            options: data,
            onDropdownOpen: function($dropdown){
                $(".border-effect1").removeClass("border-effect1");
            },
            onBlur: function(){
                // $('.selectize-input input').val(text);

            },
            onChange: function(value){
                $('#mytable tbody tr').css('display','');
                try {
                    var ele = document.getElementById("user" + value);
                    ele.className = ("border-effect1");
                    ele.scrollIntoView({block: "start", behavior: "instant"});
                    console.log("Search On Change " + value);
                }catch(err){
                    $('#mytable tbody tr').css('display','');
                }
            },
            onType: function(str){
                if(str){
                    $('#mytable tbody tr').css('display','none');
                    $('.selectize-dropdown .selectize-dropdown-content div').each( function(){
                        $('#user' + $(this).attr('data-value')).css('display','');
                    });
                }
                else
                    $('#mytable tbody tr').css('display','');
                console.log("Search On Type " + str);
            },
            render: {
                item: function(item, escape) {
                    console.log("item: " + item);
                    return '<div><strong>' + escape(item.Username) + '</strong></div>';
                },
                option: function(item, escape) {
                    return '<div data-id="' + escape(item.ID) + '"><strong>' + escape(item.Username) +
                        '</strong><br><small style=" opacity:0.8;">' + escape(item.Email) + '</small><br></div>';
                }
            }
        });
        search = $search[0].selectize;
    }
    // ~~


    /**
     * Create table with data from DB
     * @param data
     */
    function createTable(data) {
        $.each(data, function (index, val) {
            console.log(val);
            addUser($("#mytable tbody"), val)
        });
    }
    // ~~


    /**
     * Add new user to table
     * @param root
     * @param data
     */
    function addUser(root,data) {
        root.append("<tr id='" + user + data.ID+ "'> " +
            "<td><input type='checkbox' class='checkthis' /> </td> " +
            "<td>" + data.ID + "</td> " +
            "<td>" + data.Username + "</td> " +
            "<td>" + data.Email + "</td> " +
            "<td>" + data.Name + "</td> " +
            "<td> <p data-placement='top' data-toggle='tooltip' title='Edit'>"+
            "<button class='btn btn-primary btn-xs' data-title='Edit' data-toggle='modal' data-target='#edit'><span class='glyphicon glyphicon-pencil'></span></button>"+
            "</p>"+
            "</td>"+
            "<td>"+
            "<p data-placement='top' data-toggle='tooltip' title='Delete'>"+
            "<button class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete'><span class='glyphicon glyphicon-trash'></span></button>"+
            "</p>"+
            "</td>"+
            "</tr>");

        // Cache user info
        $("#" + user + data.ID).data(user, data);

        // Force reload page is the fastest way
        //location.reload();
    }
    // ~~


    /**
     * Delete user
     * @Author Vinh
     */
    function deleteUser() {
        $("#" + user + currGuestID).remove();
        // Force reload page is the fastest way
        //location.reload();
    }
    // ~~

    /**
     * Update user
     */
    function updateUser(data) {
        var userObj = $("#" + user + data.ID + " td");
        userObj.eq(1).html(data.ID);
        userObj.eq(2).html(data.Username);
        userObj.eq(3).html(data.Email);
        userObj.eq(4).html(data.Name);

        // Cache user info
        $("#" + user + data.ID).data(user, data);
    }


    /**
     * Delete user
     */
    $('#btnDelete').click(function () {
        console.log("Delete guest");
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                operation: "deleteGuest",
                role : "user",
                sentData : {
                    ID : currGuestID
                }
            }
        }).done(function () {
			$('#modal-uploading').modal('hide');
            console.log("Delete guest successfully");
            deleteUser();
            $("#delete").modal('hide');
        }).fail(function () {
			$('#modal-uploading').modal('hide');
            console.log("Failed to delete guest");
        });
    });
    // ~~


    /**
     * Add new user
     */
    $('#btnAdd').click(function () {

        var userName = $("#add .userName").val();
        var userID = $("#add .userID").val();
        var userPassword = $("#add .userPassword").val();
        var userEmail = $("#add .userEmail").val();

        // Validate step here
        if ( !validateModal("add",userName,userPassword,userPassword,userEmail) )
            return;

        var name = $("#add .name").val();


        var sentData = {
            ID: userID,
            UserName:userName,
            Password: userPassword,
            Name: name,
            Email: userEmail
        };
        console.log(sentData);
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'POST',
            data: {
                operation: "addGuest",
                role : "user",
                UserID: $("head").prop('data-id') ,
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
			$('#modal-uploading').modal('hide');
            addUser($("#mytable tbody"),data[0]);
            $("#add").modal('hide');
            console.log("Add new guest successfully");
        }).fail(function () {
			$('#modal-uploading').modal('hide');
            console.log("Failed to add new guest!")
        });
    });
    // ~~


    /**
     * Update member info
     */
    $('#btnUpdate').click(function () {

        var userName = $("#edit .userName").val();
        var userID = $("#edit .userID").val();
        var userEmail = $("#edit .userEmail").val();
        var name = $("#edit .name").val();

        // Validate step here
        if ( !validateModal("edit",userName,"","",userEmail) )
            return;

        var sentData = {
            ID: userID,
            UserName:userName,
            Name: name,
            Email: userEmail
        };

        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'POST',
            data: {
                operation: "updateGuest",
                role : "user",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
			$('#modal-uploading').modal('hide');
            updateUser(data[0]);
            $("#edit").modal('hide');
        }).fail(function () {
			$('#modal-uploading').modal('hide');
            console.log("Failed to update info member !")
        });
    });
    // ~~~


    // Check all
    $("#mytable #checkall").click(function () {
        if ($("#mytable #checkall").is(':checked')) {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
    // ~~

    // Toggle tooltip
    $("[data-toggle=tooltip]").tooltip();


    var currGuestID = -1;


    /**
     * Open modal trigger this event
     */
    $('.modal').on('show.bs.modal', function (e) {
        // Get memberID of current shown member
        try {
            var $trigger = $(e.relatedTarget);
            var $userID = $trigger.parents().eq(2).attr('id');
            currGuestID = $userID.substr(user.length);
        }catch(e){}
        // Don't automatically add data for modal ADD RELATIVE
        if( $(this).attr("id") == "add" ) {
            return;
        }

        // Assign some basic info to modal before display to user
        try {
            var userInfo = $("#" + user + currGuestID).data(user);
            //console.log("UserInfo: \n" + userInfo);
            $("#edit .userID").val(userInfo.ID);
            $("#edit .userName").val(userInfo.Username);
            $("#edit .userEmail").val(userInfo.Email);
            $("#edit .name").val(userInfo.Name);
        }
        catch(err) {
            var userObj = $("#" + user + currGuestID + " td");
            //console.log("UserObj: \n" + userObj);
            $("#edit .userID").val(userObj.eq(1).html());
            $("#edit .userName").val(userObj.eq(2).html());
            $("#edit .userEmail").val(userObj.eq(3).html());
            $("#edit .name").val(userObj.eq(4).html());
        }
    });
    // ~~

});
