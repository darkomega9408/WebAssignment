<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require("lib/vendor/firebase/php-jwt/src/JWT.php");
use Firebase\JWT\JWT;
if (isset($_COOKIE['token'])) {
  $token = $_COOKIE['token'];
  $data = (array) JWT::decode($token, Token::$jwt_key, ['alg' => 'HS512']);
  $personData = (array) $data['data'];
  if ($personData['role'] == 'admin') header('Location: admin-page.php');
  else header('Location: tree.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-2.2.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/cookie-management.js" type="text/javascript"></script>
    <script src="js/index.js" type="text/javascript"></script>
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
                <div class="login-form">
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
</body>
</html>
