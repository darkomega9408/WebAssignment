
$(document).ready(function () {
    var user = "user";

    
    /**
     * Load header
     */
    $("header").load("templates/nav-bar-demo/nav-bar.html .navbar", function () {
        // Change logo relative path
        $(".navbar-brand>img").attr("src","images/family-tree-logo.png");

        // Change role in navbar
        $("#navbar-user-name").prepend("Hi, Admin");
    });
    // ~~


    /**
     * Load all users
     */
    $.ajax({
        url: 'https://tamrestfultest.herokuapp.com/webservice/giapha/getmembers',
        type: 'POST',
        dataType: 'json',
        contentType: "application/json",
        data: JSON.stringify( {
            role : "admin",
            adminId: 1
        }),
        beforeSend: function(request) {
			$('#modal-uploading').modal('show');
            var authstring = getCookie("giaphaauth");
            if (authstring != "")
                request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
            else
                document.location.href = "../index.html";
        }
    }).done(function(data){
		$('#modal-uploading').modal('hide');
        createTable(data);
        search(data);
    }).fail(function () {
		$('#modal-uploading').modal('hide');
        console.log("Load users failed");
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
            valueField: 'id',
            labelField: 'username',
            searchField: ['username', "name", 'email'],
            options: data,
            onDropdownOpen: function($dropdown){
                $(".border-effect1").removeClass("border-effect1");
            },
            onBlur: function(){
                console.log("Search On Blur");
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
                    return '<div><strong>' + escape(item.username) + '</strong></div>';
                },
                option: function(item, escape) {
                    return '<div data-id="' + escape(item.id) + '"><strong>' + escape(item.username) +
                        '</strong><br><small style=" opacity:0.8;">' + escape(item.email) + '</small><br></div>';
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
            "<td>" + data.id + "</td> " +
            "<td>" + data.username + "</td> " +
            "<td>" + data.email + "</td> " +
            "<td>" + data.name + "</td> " +
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
        $("#" + user + data.id).data(user, data);

        // Force reload page is the fastest way
        //location.reload();
    }
    // ~~


    /**
     * Delete user
     * @Author Vinh
     */
    function deleteUser() {
        $("#" + user + currUserID).remove();
        // Force reload page is the fastest way
        //location.reload();
    }
    // ~~

    /**
     * Update user
     */
    function updateUser(data) {
        console.log("Updated data: "+ data);
        var userObj = $("#" + user + data.id + " td");
        userObj.eq(1).html(data.id);
        userObj.eq(2).html(data.username);
        userObj.eq(3).html(data.email);
        userObj.eq(4).html(data.name);

        // Cache user info
        $("#" + user + data.ID).data(user, data);
    }


    /**
     * Delete user
     */
    $('#btnDelete').click(function () {
        console.log("Delete");
        $.ajax({
            url: 'https://tamrestfultest.herokuapp.com/webservice/giapha/deletemember',
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify({
                operation: "delete",
                role : "admin",
                sentData : {
                    id : currUserID
                }
            }),
            beforeSend: function(request) {
				$('#modal-uploading').modal('show');
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "../index.html";
            }
        }).done(function () {
			$('#modal-uploading').modal('hide');
            console.log("Delete member successfully");
            deleteUser();
            $("#delete").modal('hide');
        }).fail(function () {
			$('#modal-uploading').modal('hide');
            console.log("Failed to delete member");
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
        if( !validateEmail(userEmail) || userName == "" || userID=="" || userPassword== "" || userEmail == "" ) {
            $("#add .error-msg").html("Some fields are invalid. Please try again!");
            return;
        }else $("#modal-edit-user .error-msg").html();

        var name = $("#add .name").val();


        var sentData = {
            id: userID,
            username:userName,
            password: userPassword,
            name: name,
            email: userEmail,
            role: "user" // default role
        };
        console.log(sentData);
        $.ajax({
            url: 'https://tamrestfultest.herokuapp.com/webservice/giapha/addmember',
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify({
                operation: "add",
                role : "admin",
                sentData: sentData
            }),
            dataType: 'json',
            beforeSend: function(request) {
				$('#modal-uploading').modal('show');
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "../index.html";
            }
        }).done(function (data) {
			$('#modal-uploading').modal('hide');
            addUser($("#mytable tbody"),data);
            $("#add").modal('hide');
            console.log("Add new user successfully");
        }).fail(function () {
			$('#modal-uploading').modal('hide');
            console.log("Failed to add new user!")
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
        if( !validateEmail(userEmail) || userID == "" || userName == "") {
            $("#edit .error-msg").html("Some fields are invalid. Please try again!");
            return;
        }else $("#edit .error-msg").html();


        var sentData = {
            id: userID,
            username:userName,
            name: name,
            email: userEmail
        };

        $.ajax({
            url: 'https://tamrestfultest.herokuapp.com/webservice/giapha/updatemember',
            type: 'POST',
            contentType: "application/json",
            data: JSON.stringify({
                operation: "update",
                role : "admin",
                sentData:  sentData
            }),
            dataType: 'json',
            beforeSend: function(request) {
				$('#modal-uploading').modal('show');
                var authstring = getCookie("giaphaauth");
                if (authstring != "")
                    request.setRequestHeader("Authorization", "Basic " + getCookie("giaphaauth"));
                else
                    document.location.href = "../index.html";
            }
        }).done(function (data) {
			$('#modal-uploading').modal('hide');
            updateUser(data);
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


    var currUserID = -1;


    /**
     * Open modal trigger this event
     */
    $('.modal').on('show.bs.modal', function (e) {
        // Get memberID of current shown member
        try {
            var $trigger = $(e.relatedTarget);
            console.log("trigger " + $trigger.html());
            var $userID = $trigger.parents().eq(2).attr('id');
            currUserID = $userID.substr(user.length);
        }catch(e){}
        // Don't automatically add data for modal ADD RELATIVE
        if( $(this).attr("id") == "add" ) {
            return;
        }

        // Assign some basic info to modal before display to user
        var userObj = $("#" + user + currUserID + " td");
        //console.log("UserObj: \n" + userObj);
        $("#edit .userID").val(userObj.eq(1).html());
        $("#edit .userName").val(userObj.eq(2).html());
        $("#edit .userEmail").val(userObj.eq(3).html());
        $("#edit .name").val(userObj.eq(4).html());

    });
    // ~~

    /**
     * Validate email
     * @param $email
     * @returns {boolean}
     */
    function validateEmail($email) {
        var emailReg = /^([\w_]+@([\w]+\.)+[\w]{2,4})$/;
        return emailReg.test( $email );
    }

    /**
     * Log out func
     */
    $(document).on("click", "#hrefLogOut", function() {
        deleteCookie("giaphaauth");
        document.location.href = "../index.html";
    })
});
