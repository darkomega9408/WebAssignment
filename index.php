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

	<link rel="stylesheet" href="css/index.css"/>
</head>
<body>
    <div class="container-fluid">
        <div class="jumbotron flexcenter">
            <div id="index_content" class="text-center">
                <h1>Gia Phả Web</h1>
                <p>Chết là hết</p>
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
                            <button type="submit"
                                    class="btn btn-primary form-control input-lg">
                                Login
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
                    <span class="glyphicon glyphicon-off logo"></span>
                    <h4>POWER</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-heart logo"></span>
                    <h4>LOVE</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-lock logo"></span>
                    <h4>JOB DONE</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-leaf logo"></span>
                    <h4>GREEN</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-certificate logo"></span>
                    <h4>CERTIFIED</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-wrench logo"></span>
                    <h4>HARD WORK</h4>
                    <p>Lorem ipsum dolor sit amet..</p>
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
</body>
</html>
