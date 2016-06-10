<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require("lib/vendor/firebase/php-jwt/src/JWT.php");
require("i18n/i18n.php");
use Firebase\JWT\JWT;
if (isset($_COOKIE['token'])) {
  $token = $_COOKIE['token'];
  $data = (array) JWT::decode($token, Token::$jwt_key, ['alg' => 'HS512']);
  $personData = (array) $data['data'];
  $id = $personData['id'];
  $role = $personData['role'];
  if ($role == 'admin') header('Location: management');
  else header('Location: tree');
}
if (!isset($_COOKIE['lang'])) {
  setcookie('lang', 'en');
  $i18n = new i18n("en");
}
else {
  $i18n = new i18n($_COOKIE['lang']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $i18n->homepage(); ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="js/jquery-2.2.1.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/cookie-management.js" type="text/javascript"></script>
    <script src="js/index.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/lang.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
	<link rel="stylesheet" href="css/index.css"/>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/lang.css" rel="stylesheet">
</head>
<body>
    <ul class="language show">
        <li class="lang <?php if ($_COOKIE['lang'] == 'en') echo 'active'; ?>" data-lang="en">
            <img src="images/lang/uk-flag.png" title="English">
        </li>
        <li class="lang <?php if ($_COOKIE['lang'] == 'vi') echo 'active'; ?>" data-lang="vi">
            <img src="images/lang/vi-flag.jpg" title="Vietnamese">
        </li>
    </ul>
    <div class="container-fluid">
        <div class="jumbotron flexcenter">
            <div id="index_content" class="text-center">
                <h1><?php echo $i18n->web_name(); ?></h1>
                <p><?php echo $i18n->slogan(); ?></p>
                <div class="login-form">
                    <form role="form" method="post" action="" id="formLogin">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control input-lg"
                                   placeholder="<?php echo $i18n->username(); ?>"
                                   id="inputUsername"
                                   name="username" required/>
                        </div>
                        <div class="form-group">
                            <input type="password"
                                   class="form-control input-lg"
                                   placeholder="<?php echo $i18n->password(); ?>"
                                   id="inputPassword"
                                   name="password" required/>
                        </div>
                        <label id="warning"></label>
                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-primary form-control input-lg">
                                <?php echo mb_strtoupper($i18n->login()); ?>
                            </button>
                        </div>

<!--           SIGN UP BUTTON             -->
                        <hr><p><?php echo mb_strtoupper($i18n->str_or()); ?></p>
                        <div class="form-group">
                            <button type="button" id="btnSignUp"
                                    class="btn btn-danger form-control input-lg" data-title="Sign Up" data-toggle="modal" data-target="#signUp">
                                <?php echo mb_strtoupper($i18n->signup()); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid text-center">
        <div class="row" id="service_row">
            <h2 id="service_header"><?php echo mb_strtoupper($i18n->services()); ?></h2>
            <h4><?php echo $i18n->what_we_offer(); ?></h4>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-plus logo"></span></span>
                    <h4><?php echo mb_strtoupper($i18n->create()); ?></h4>
                    <p><?php echo $i18n->create_family_tree(); ?></p>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-pencil logo"></span>
                    <h4><?php echo mb_strtoupper($i18n->modify()); ?></h4>
                    <p><?php echo $i18n->modify_family_tree(); ?></p>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-search logo"></span>
                    <h4><?php echo mb_strtoupper($i18n->search()); ?></h4>
                    <p><?php echo $i18n->search_family_tree(); ?></p>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-globe logo"></span>
                    <h4><?php echo mb_strtoupper($i18n->globe()); ?></h4>
                    <p><?php echo $i18n->globe_member(); ?></p>
                </div>
                <div class="col-sm-4">
                    <span class="glyphicon glyphicon-user logo"></span>
                    <h4><?php echo mb_strtoupper($i18n->avatar()); ?></h4>
                    <p><?php echo $i18n->upload_avatar(); ?></p>
                </div>
                <div class="col-sm-4">
                    <span class="	glyphicon glyphicon-paperclip logo"></span>
                    <h4><?php echo mb_strtoupper($i18n->export()); ?></h4>
                    <p><?php echo $i18n->export_family_tree(); ?></p>
                </div>
            </div>
        </div>
        <div class="row" id="about_row">
            <div class="col-sm-7">
                <div class="pull-right">
                    <h1 id="about_header"><?php echo $i18n->about_us(); ?></h1>
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
                <h4 class="modal-title custom_align Heading" ><?php echo $i18n->signup(); ?></h4>
            </div>

            <form class="form-horizontal">
                <div class="modal-body">
                    <p class="error-msg"></p>
                    <div class="form-group">
                        <label> <span class="requiredField">*</span><?php echo $i18n->username(); ?>: </label>
                        <input class="form-control userName" type="text" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span><?php echo $i18n->password(); ?>: </label>
                        <input class="form-control userPassword" type="password" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span><?php echo $i18n->confirm_password(); ?>: </label>
                        <input class="form-control userRePassword" type="password" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Email: </label>
                        <input class="form-control userEmail" type="email"
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo $i18n->member_name(); ?>: </label>
                        <input class="form-control name" type="text">
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" id="modal-sign-up-btn" class="btn btn-warning btn-lg" style="width: 100%;">
                        <span class="glyphicon glyphicon-ok-circle"></span> <?php echo $i18n->signup(); ?>
                    </button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Add User Detail -->

<!-- Modal Uploading  -->
<div class="modal fade" id="modal-uploading" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img class="center-block" id="imgUploading" src="http://www.bis.org/img/uploading.gif" alt="Uploading..."
                     width="100em"
                     height="100em">
            </div>
        </div>
    </div>
</div>
<!-- ~~ Modal Uploading -->

</body>
</html>
