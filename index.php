<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-2.2.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link rel="stylesheet" href="css/index.css"/>
</head>
<body>
<div class="container-fluid">
    <div class="jumbotron flexcenter">
        <div id="index_content" class="text-center">
            <h1>GENEALOGY WEBSITE</h1>
            <p>Connect Generations</p>
            <div class="well">
                <form role="form" method="post" action="">
                    <div class="form-group">
                        <input type="text"
                               class="form-control input-lg"
                               placeholder="Username"
                               id="inputUsername"
                               name="username" required/>
                    </div>
                    <div class="form-group">
                        <input type="password"
                               class="form-control input-lg"
                               placeholder="Password"
                               id="inputPassword"
                               name="password" required/>
                    </div>
                    <div class="form-group">
                        <button type="button"
                                class="btn btn-primary form-control input-lg">
                            LOGIN
                        </button>
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $conn = new PDO("mysql:host=localhost;dbname=webassignment", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                        $numRows = $conn->query("SELECT count(*) FROM `person` WHERE Username = '$username' AND Password = '$password'")->fetchColumn();
                        if ($numRows == 0) {
                            echo "Incorrect username or password";
                        }
                        else if ($numRows == 1) {
                            header("Location: tree.php");
                        }
                    }
                    ?>
                    <hr><p>OR</p>
                    <div class="form-group">
                        <button type="submit" id="btnSignUp"
                                class="btn btn-danger form-control input-lg" data-title="Sign Up" data-toggle="modal" data-target="#signUp">
                            SIGN UP
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<div class="container-fluid text-center">
    <div class="row" id="service_row">
        <h2 id="service_header">SERVICES</h2>
        <h4>What we offer</h4>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-plus logo"></span></span>
                <h4>CREATE</h4>
                <p>Create your own family tree</p>
            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-pencil logo"></span>
                <h4>MODIFY</h4>
                <p>Modify your family tree</p>
            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-search logo"></span>
                <h4>SEARCH</h4>
                <p>Search member in your family</p>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-globe logo"></span>
                <h4>GLOBE</h4>
                <p>Find member address on map</p>
            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-user logo"></span>
                <h4>AVATAR</h4>
                <p>Upload member avatar</p>
            </div>
            <div class="col-sm-4">
                <span class="	glyphicon glyphicon-paperclip logo"></span>
                <h4>EXPORT</h4>
                <p>Export your family tree</p>
            </div>
        </div>
    </div>
    <div class="row" id="about_row">
        <div class="col-sm-7">
            <div class="pull-right">
                <h1 id="about_header">About Us</h1>
                <div class="col-sm-3">
                    <div class="thumbnail">
                        <img src="images/AboutUs/Thai.jpg"
                             alt="Thai"
                             class="img-circle img-responsive"/>
                        <h4><strong>Nguyễn Xuân Thái</strong></h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="thumbnail">
                        <img src="images/AboutUs/Tam.jpg"
                             alt="Thai"
                             class="img-circle img-responsive"/>
                        <h4><strong>Nguyễn Thành Tâm</strong></h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="thumbnail">
                        <img src="images/AboutUs/Vinh.jpg"
                             alt="Thai"
                             class="img-circle img-responsive"/>
                        <h4><strong>Bùi Quang Vinh</strong></h4>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="thumbnail">
                        <img src="images/AboutUs/Qui.jpg"
                             alt="Thai"
                             class="img-circle img-responsive"/>
                        <h4><strong>Lê Đức Quí</strong></h4>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-5">
            <span class="glyphicon glyphicon-signal logo_large"></span>
        </div>
    </div>
</div>


<!-- Modal Add User Detail -->
<div class="modal fade" id="signUp" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align Heading" >Sign Up Form</h4>
            </div>

                <div class="modal-body">
                    <p class="error-msg" style="color:red"></p>
                    <div class="form-group">
                        <label> <span class="requiredField">*</span>UserName: </label>
                        <input class="form-control userName" type="text" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Password: </label>
                        <input class="form-control userPassword" type="password" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Re-enter Password: </label>
                        <input class="form-control userRePassword" type="password" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Email: </label>
                        <input class="form-control userEmail" type="email"
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                    <div class="form-group">
                        <label>Full Name: </label>
                        <input class="form-control name" type="text">
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" id="modal-sign-up-btn" class="btn btn-warning btn-lg" style="width: 100%;"  ><span class="glyphicon glyphicon-ok-circle"></span> Submit </button>
                </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Add User Detail -->

<script>
    function validateEmail($email) {
        var emailReg = /^([\w_]+@([\w]+\.)+[\w]{2,4})$/;
        return emailReg.test( $email );
    }

    $("#modal-sign-up-btn").click(function (e) {
        //$("#signUp .form-horizontal").preventDefault();
        var userName = $("#signUp .userName").val();
        var userID = $("#signUp .userID").val();
        var userPassword = $("#signUp .userPassword").val();
        var userRePassword = $("#signUp .userRePassword").val();
        var userEmail = $("#signUp .userEmail").val();
        if( userName == "" || userPassword== "" ||  userPassword != userRePassword || !validateEmail(userEmail) || userEmail == "") {
            $("#signUp .error-msg").html("Some fields are invalid. Please try again!");
            return;
        }
        else $("#signUp .error-msg").html("");

        var name = $("#signUp .name").val();

        var sentData = {
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
                operation: "add",
                role : "admin",
                sentData: sentData
            },
            dataType: 'json'
        }).done(function (data) {
            alert("Sign up successfully. Now you can login and enjoy the rest !")
            console.log("Add new user successfully");
        }).fail(function () {
            console.log("Failed to add new user!")
        });
    });
</script>
</body>
</html>
