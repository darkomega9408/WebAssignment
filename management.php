<?php
require("lib/vendor/firebase/php-jwt/src/JWT.php");
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require("i18n/i18n.php");
use Firebase\JWT\JWT;
if (!isset($_COOKIE['token'])) header('Location: /');
else {
    $token = $_COOKIE['token'];
    $data = (array) JWT::decode($token, Token::$jwt_key, ['alg' => 'HS512']);
    $personData = (array) $data['data'];
    $role = $personData['role'];
    if( $role == 'user' ){

    }
    else if ($role == 'admin'){

    }
    else {
        echo 'You are not allowed here. Role : '.$role;
        exit;
    }
    $name = $personData['name'];
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

<head data-role="<?php echo $personData['role'] ; ?>" data-id="<?php echo $personData['id'] ?>" data-lang="<?php echo $i18n->getLang(); ?>">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        <?php echo $i18n->admin_page(); ?>
    </title>


    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/admin-page.css" rel="stylesheet">

    <!-- JQuery Script -->
    <script src="js/jquery-2.2.1.min.js"></script>

    <!-- Bootstrap Script -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/authrestful.js" type="text/javascript"></script>

    <!-- Font Awesome 4.5 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" >

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/border-effect.css"/>
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/lang.css" rel="stylesheet">

    <!--    <script src="js/admin-page.js"></script>-->
    <script type="text/javascript" src="js/navbar.js"></script>
    <script type="text/javascript" src="bower_components/selectize/dist/js/standalone/selectize.js"></script>
    <script type="text/javascript" src="js/search.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/lang.js"></script>

    <!--  Dynamically load js file corresponding to role , such as : admin or user  -->
    <script>
        var head = document.getElementsByTagName('head')[0];
        var js = document.createElement("script");
        js.type = "text/javascript";
        var role = head.getAttribute("data-role");
        if( role == 'user' )
            js.src = 'js/guests-management.js';
        else if( role == 'admin' )
            js.src = 'js/admin-page.js';
        head.appendChild(js);

        //adminPage();
    </script>
</head>

<body>

<!-- Navigation -->
<header>
    <?php
    include 'templates/nav-bar/nav-bar.php';
    ?>
</header>
<!-- Full Width Image Header -->


<!-- Page Content -->

<main>
    <div class="container" style="margin-top: 3%">

        <div class="row">

            <h1 style="display: inline; padding-left: 1em">
                <?php
                if ($role == 'admin') echo $i18n->list_users();
                else echo $i18n->list_guests();
                ?>
            </h1>

            <button type="button" class="btn btn-info" style="float: right;margin: 0 auto; margin-right: 1em; margin-top: 1em" data-title='Add' data-toggle='modal' data-target='#add'>
                <span class="glyphicon glyphicon-plus-sign"></span>
                <?php
                if ($role == 'admin') echo $i18n->add_user();
                else echo $i18n->add_guest();
                ?>
            </button>

        </div>
        <!-- First Featurette -->
        <div class="featurette" id="about">
            <!------------------------code---------------start---------------->

            <!--List User-->
            <div class="col-md-12">



                <div class="table-responsive" style="height: 45em;">


                    <table id="mytable" class="table table-bordred table-striped" >

                        <thead>

                        <th>
                            <input type="checkbox" id="checkall"  title="checkall"/>
                        </th>
                        <th>ID</th>
                        <th><?php echo $i18n->username(); ?></th>
                        <th>Email</th>
                        <th><?php echo $i18n->member_name(); ?></th>
                        <th></th>
                        <th></th>
                        </thead>

                        <tbody>

                        </tbody>

                    </table>



                    <div class="clearfix"></div>

                </div>

            </div>


            <!-- End List User -->


            <!-- /.modal-content -->
            <!----Code------end----------------------------------->
        </div>

        <!-- /.container -->

    </div>
</main>


<!-- Modal Edit User Detail -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align Heading" ><?php echo $i18n->modal_edit_user(); ?></h4>
            </div>
            <form  class="form-horizontal">
                <div class="modal-body">
                    <p class="error-msg"></p>
                    <div class="form-group" style="display: none;">
                        <label><span class="requiredField">*</span>ID: </label>
                        <label class="form-control userID" type="text" readonly>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span><?php echo $i18n->username(); ?>: </label>
                        <input class="form-control userName" type="text" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Email: </label>
                        <input class="form-control userEmail" type="text" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo $i18n->member_name(); ?>: </label>
                        <input class="form-control name" type="text">
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" id="btnUpdate"
                    ><span class="glyphicon glyphicon-ok-sign"></span> <?php echo $i18n->update(); ?>
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Edit User Detail -->


<!-- Modal Add User Detail -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align Heading" ><?php echo $i18n->modal_add_user() ?></h4>
            </div>
            <form  class="form-horizontal">
                <div class="modal-body">
                    <p class="error-msg"></p>
                    <div class="form-group">
                        <label><span class="requiredField">*</span><?php echo $i18n->username() ?>: </label>
                        <input class="form-control userName" type="text" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span><?php echo $i18n->password() ?>: </label>
                        <input class="form-control userPassword" type="password" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span><?php echo $i18n->confirm_password() ?>: </label>
                        <input class="form-control userRePassword" type="password" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Email: </label>
                        <input class="form-control userEmail" type="email"
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo $i18n->member_name() ?>: </label>
                        <input class="form-control name" type="text">
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" id="btnAdd"
                    ><span class="glyphicon glyphicon-plus-sign"></span> <?php echo $i18n->add() ?>
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- End Modal Add User Detail -->


<!-- Modal Delete user-->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align Heading" ><?php echo $i18n->delete(); ?></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> <?php echo $i18n->delete_prompt(); ?></div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" id="btnDelete" ><span class="glyphicon glyphicon-ok-sign"></span> <?php echo $i18n->yes(); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> <?php echo $i18n->no(); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete user-->

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
