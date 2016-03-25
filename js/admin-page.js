
$(document).ready(function () {
    var user = "user";

    // Load header
    $("header").load("templates/nav-bar-demo/nav-bar.html .navbar", function () {
        // Change logo relative path
        $(".navbar-brand>img").attr("src","images/family-tree-logo.png");
        $.ajax({
            url: 'php-controller/GetAllUser.php',
            type: 'GET',
            dataType: 'json',
            data:{
              role : "admin",
              AdminId: 1
            },
        }).done(function(data){
            console.log(data);
            search(data);
        }).fail(function () {
            console.log("failed");
        });
    });

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
                $dropdown.css('visibility','hidden');
            },
            onChange: function(value){
              $('#mytable tbody tr').css('display','none');
              $('#mem' + value).addClass('border-effect');
              $('#user' + value).css('display','');
            },
            onType: function(str){
              if(str){
                $('#mytable tbody tr').css('display','none');
                $('.selectize-dropdown .selectize-dropdown-content div').each( function(){
                  $('#user' + $(this).attr('data-value')).css('display','');
                });
              }
            },
            render: {
                item: function(item, escape) {
                    console.log(item);
                    return '<div><strong style="text-transform: capitalize">' + escape(item.Name) + '</strong></div>';
                },
                option: function(item, escape) {
                    return '<div data-id="' + escape(item.Name) + '"><strong style="text-transform: capitalize">' + escape(item.Name) +
                        '</strong><br><small style=" opacity:0.8;">' + escape(item.Email) + '</small><br></div>';
                }
            }
        });
        search = $search[0].selectize;
    }

    /*// Load table first
    $.ajax({
        url: 'php-controller/ServerHandler.php',
        type: 'GET',
        data:{
          role : "admin"
        },
        dataType: 'json'
    }).done(function(data){
        createTable(data);
    }).fail(function () {
        console.log("Create tree failed");
    });
    // ~~

    // Create table
    function createTable(data) {
        /!*$.each(data, function (index, val) {
            addUser($("#mytable tbody"), val)
        });*!/
        //console.log(data);


        $("#mytable tbody").html(data.tbody);
        $("#pagination").html(data.pagination);
    }
    // ~~*/

    /*$(document).on("click", ".pagination>li>a" ,function (e) {
        e.preventDefault();
        var shownPage = $(this).html();
        var pageTitle = $(this).attr("href");
        console.log(pageTitle);
        //location.hash = "page="+$(this).html();
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data:{
                role : "admin",
                page : $(this).html()
            },
            dataType: 'json'
        }).done(function(data){
            createTable(data);
            document.title = pageTitle;
            window.history.pushState({"html":data,"pageTitle":pageTitle},pageTitle, pageTitle);
        }).fail(function () {
            console.log("Create tree failed");
        });

        //window.history.replaceState($(this).html(), "Title", $(this).attr("href"));
    });*/



    // Add member
    function addUser(root,data) {
        /*root.append("<tr id='"+user+data.id+"'> " +
            "<td><input type='checkbox' class='checkthis' /> </td> " +
            "<td>" + data.id + "</td> " +
            "<td>" + data.name + "</td> " +
            "<td>" + data.year + "</td> " +
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
*/
        // Cache user info
        //$("#" + user + data.id).data(user, data);
        // Force reload page is the fastest way
        location.reload();
    }
    // ~~


    /**
     * Delete user
     * @Author Vinh
     */
    function deleteUser() {
        //$("#" + user + currUserID).remove();
        // Force reload page is the fastest way
        location.reload();
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

    // Delete user triggered by btnDelete onclick()
    $('#btnDelete').click(function () {
        console.log("Delete");
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                operation: "delete",
                role : "admin",
                sentData : {
                    ID : currUserID
                }
            }
        }).done(function () {
            console.log("Delete member successfully");
            deleteUser();
        }).fail(function () {
            console.log("Failed to delete member");
        });
    });
    // ~~


    // Add new relative
    $('#btnAdd').click(function () {

        var userName = $("#add .userName").val();
        var userID = $("#add .userID").val();
        var userEmail = $("#add .userEmail").val();
        var name = $("#add .name").val();

        // Validate input
        /*if ( userName.length < 5 || userName.length > 40 || !isNormalInteger(userEmail) || parseInt(userEmail) < 1990 || parseInt(userEmail) > 2015)
            return;*/

        var sentData = {
            ID: userID,
            UserName:userName,
            Name: name,
            Email: userEmail
        };
        console.log(sentData);
        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                operation: "add",
                role : "admin",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            addUser($("#mytable tbody"),data[0]);
            console.log("Add new user successfully");
        }).fail(function () {
            console.log("Failed to add new user!")
        });
    });
    // ~~


    // Update member info
    $('#btnUpdate').click(function () {

        var userName = $("#edit .userName").val();
        var userID = $("#edit .userID").val();
        var userEmail = $("#edit .userEmail").val();
        var name = $("#edit .name").val();

        // Validate input
        /*if ( userName.length < 5 || userName.length > 40 || !isNormalInteger(userEmail) || parseInt(userEmail) < 1990 || parseInt(userEmail) > 2015)
            return;*/

        var sentData = {
            ID: userID,
            UserName:userName,
            Name: name,
            Email: userEmail
        };

        $.ajax({
            url: 'php-controller/ServerHandler.php',
            type: 'GET',
            data: {
                operation: "update",
                role : "admin",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            updateUser(data[0]);
        }).fail(function () {
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

    // Open modal trigger this event
    $('.modal').on('show.bs.modal', function (e) {
        // Get memberID of current shown member
        var $trigger = $(e.relatedTarget);
        var $userID = $trigger.parents().eq(2).attr('id');
        currUserID = $userID.substr(user.length);

        // Don't automatically add data for modal ADD RELATIVE
        if( $(this).attr("id") == "add" ) {
            return;
        }

        // Assign some basic info to modal before display to user
        try {
            var userInfo = $("#" + user + currUserID).data(user);
            //console.log("UserInfo: \n" + userInfo);
            $("#edit .userID").val(userInfo.ID);
            $("#edit .userName").val(userInfo.Username);
            $("#edit .userEmail").val(userInfo.Email);
            $("#edit .name").val(userInfo.Name);
        }
        catch(err) {
            var userObj = $("#" + user + currUserID + " td");
            //console.log("UserObj: \n" + userObj);
            $("#edit .userID").val(userObj.eq(1).html());
            $("#edit .userName").val(userObj.eq(2).html());
            $("#edit .userEmail").val(userObj.eq(3).html());
            $("#edit .name").val(userObj.eq(4).html());
        }
    });
    // ~~

});
