<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require("lib/vendor/firebase/php-jwt/src/JWT.php");
require("i18n/i18n.php");
use Firebase\JWT\JWT;

if (!isset($_COOKIE['token'])) header('Location: /');
else {
    $token = $_COOKIE['token'];
    $data = (array) JWT::decode($token, Token::$jwt_key, ['alg' => 'HS512']);
    $personData = (array) $data['data'];
    $name = $personData['name'];
    $id = $personData['id'];
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

<html>
<head data-role="<?php echo $personData['role']; ?>" data-id="<?php echo $personData['id'] ?>" data-lang="<?php echo $i18n->getLang(); ?>">
    <title><?php echo $i18n->tree_owner($name); ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-2.2.1.min.js"></script>

    <link rel="stylesheet" href="css/tree.css"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/member-card.css" rel="stylesheet">
    <link href="css/member-modal.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/border-effect.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/modal.css">
    <link href="css/lang.css" rel="stylesheet">

    <script>var name=<?php echo json_encode($name); ?></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/interact.min.js"></script>
    <script src="js/membercard.js"></script>
    <script src="js/cookie-management.js"></script>
    <script src="js/tree.js"></script>
    <script src="js/navbar.js"></script>
    <script src="bower_components/selectize/dist/js/standalone/selectize.js"></script>
    <script src="js/search.js"></script>
    <script src="js/render/html2canvas.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/lang.js"></script>

</head>
<body>


<header>
    <?php
    include 'templates/nav-bar/nav-bar.php';
    ?>
</header>

<div class="tree-container">
    <button id="btnAddMember" data-toggle="modal" data-target="#modal-add-user" type="button"
            class="btn btn-success center-block">
        <?php echo $i18n->add_member(); ?>
    </button>
    <div class="tree clearfix"></div>
</div>


<!-- Member-see-info-only-modal -->
<div id="modal-see-info-guest" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Someone's Information</h4>
            </div>
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#info2"><?php echo $i18n->information(); ?></a></li>
              <li><a data-toggle="tab" href="#partner2"><?php echo $i18n->partner(); ?></a></li>
            </ul>
            <div class="tab-content">
                <div id="info2" class="info tab-pane fade in active">
                    <form class="form-horizontal">
                        <div class="modal-body">
                            <p class="error-msg"></p>
                            <div class="member-modal-avatar">
                                <div id="myGuestCarousel" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                        <li data-target="#myCarousel" data-slide-to="1"></li>
                                        <li data-target="#myCarousel" data-slide-to="2"></li>
                                        <li data-target="#myCarousel" data-slide-to="3"></li>
                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
                                            <a data-toggle="modal">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block img-responsive memberModalAvatar0"
                                                     width="300px"
                                                     height="300px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a data-toggle="modal">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block img-responsive memberModalAvatar1"
                                                     width="300px"
                                                     height="300px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a data-toggle="modal">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block img-responsive memberModalAvatar2"
                                                     width="300px"
                                                     height="300px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a data-toggle="modal">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block img-responsive memberModalAvatar3"
                                                     width="300px"
                                                     height="300px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Left and right controls -->
                                    <a class="left carousel-control" href="#myGuestCarousel" role="button"
                                       data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myGuestCarousel" role="button"
                                       data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>

                            <form role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo $i18n->member_name(); ?>: </label>
                                    <div class="col-sm-8"><label class="memberModalName label-for-guest "></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo $i18n->member_gender(); ?>
                                        : </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalGender label-for-guest"
                                               data-female="<?php echo $i18n->female(); ?>"
                                               data-male="<?php echo $i18n->male(); ?>"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->birth_date(); ?>: </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalBirthDate label-for-guest"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->address(); ?>: </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalAddress label-for-guest "></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->birth_place(); ?>: </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalBirthPlace label-for-guest "></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->status(); ?>: </label>
                                    <div class="col-sm-8">
                                    <label class="memberModalStatus label-for-guest"
                                           data-alive="<?php echo $i18n->status_alive(); ?>"
                                           data-dead="<?php echo $i18n->status_dead(); ?>"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->marital_status(); ?>: </label>
                                    <div class="col-sm-8">
                                    <label class="memberModalMaritalStatus label-for-guest"
                                           data-married="<?php echo $i18n->marital_status_married(); ?>"
                                           data-single="<?php echo $i18n->marital_status_single(); ?>"></label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                    class="glyphicon glyphicon-remove"></span> <?php echo $i18n->cancel(); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <div id="partner2" class="partner tab-pane fade">
                    <form class="form-horizontal">
                        <div class="modal-body">
                            <p class="error-msg"></p>
                            <div class="member-modal-avatar">
                                <div>
                                    <div>
                                        <div>
                                            <a id="hrefChangeAvatar">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle img-responsive memberModalAvatar"
                                                     alt="/*name*/">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo $i18n->member_name(); ?>: </label>
                                    <div class="col-sm-8"><label class="memberModalName label-for-guest "></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo $i18n->member_gender(); ?>
                                        : </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalGender label-for-guest"
                                               data-female="<?php echo $i18n->female(); ?>"
                                               data-male="<?php echo $i18n->male(); ?>"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->birth_date(); ?>: </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalBirthDate label-for-guest"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->address(); ?>: </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalAddress label-for-guest "></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->birth_place(); ?>: </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalBirthPlace label-for-guest "></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?php echo $i18n->status(); ?>: </label>
                                    <div class="col-sm-8">
                                        <label class="memberModalStatus label-for-guest"
                                               data-alive="<?php echo $i18n->status_alive(); ?>"
                                               data-dead="<?php echo $i18n->status_dead(); ?>"></label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                    class="glyphicon glyphicon-remove"></span> <?php echo $i18n->cancel(); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ~~ Member-see-info-only-modal -->


<!-- Member-info-modal -->
<div id="modal-edit-user" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Someone's Information</h4>
            </div>

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#info"><?php echo $i18n->information(); ?></a></li>
                <li><a data-toggle="tab" href="#partner"><?php echo $i18n->partner(); ?></a></li>
            </ul>

            <div class="tab-content">
                <div id="info" class="info tab-pane fade in active">
                  <form class="form-horizontal">
                      <div class="modal-body">
                          <p class="error-msg"></p>
                          <div class="member-modal-avatar">
                              <div id="myCarousel" class="carousel slide" interval="false" data-ride="carousel" data-interval="false">
                                  <!-- Indicators -->
                                  <ol class="carousel-indicators">
                                      <li data-target="#myCarousel" data-slide-to="0" class="active indicator0"></li>
                                      <li data-target="#myCarousel" data-slide-to="1" class="indicator1"></li>
                                      <li data-target="#myCarousel" data-slide-to="2" class="indicator2"></li>
                                      <li data-target="#myCarousel" data-slide-to="3" class="indicator3"></li>
                                  </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
                                            <a data-toggle="modal" data-target="#modal-upload-avatar">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block img-responsive memberModalAvatar0"
                                                     style="width:300px; height:215px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a data-toggle="modal" data-target="#modal-upload-avatar">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block img-responsive memberModalAvatar1"
                                                     style="width:300px; height:215px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a data-toggle="modal" data-target="#modal-upload-avatar">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block img-responsive memberModalAvatar2"
                                                     style="width:300px; height:215px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a data-toggle="modal" data-target="#modal-upload-avatar">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block img-responsive memberModalAvatar3"
                                                     style="width:300px; height:215px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Left and right controls -->
                                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" role="button"
                                       data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>

                            <form role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><span
                                            class="requiredField">*</span><?php echo $i18n->member_name(); ?>: </label>
                                    <div class="col-sm-9"><input type="text" class="memberModalName form-control"
                                                                  value="Nguyễn Xuân Thái" required></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><?php echo $i18n->member_gender(); ?>
                                        : </label>
                                    <div class="col-sm-9">
                                        <select class="memberModalGender form-control">
                                            <option value="male"><?php echo $i18n->male(); ?></option>
                                            <option value="female" selected><?php echo $i18n->female(); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span
                                            class="requiredField">*</span><?php echo $i18n->birth_date(); ?>: </label>
                                    <div class="col-sm-9"><input type="date" class="memberModalBirthDate form-control"
                                                                  required></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $i18n->address(); ?>: </label>
                                    <div class="col-sm-9">
                                        <select class="memberModalAddress form-control">
                                            <option value="angiang">An Giang</option>
                                            <option value="vungtau">Bà Rịa - Vũng Tàu</option>
                                            <option value="baclieu">Bạc Liêu</option>
                                            <option value="backan">Bắc Kan</option>
                                            <option value="bacgiang">Bắc Giang</option>
                                            <option value="bacninh">Bắc ninh</option>
                                            <option value="bentre">Bến Tre</option>
                                            <option value="binhduong">Bình Dương</option>
                                            <option value="binhdinh">Bình Định</option>
                                            <option value="binhphuoc">Bình Phước</option>
                                            <option value="binhthuan">Bình Thuận</option>
                                            <option value="camau">Cà Mau</option>
                                            <option value="caobang">Cao Bằng</option>
                                            <option value="cantho">Cần Thơ</option>
                                            <option value="danang">Đà Nẵng</option>
                                            <option value="daklak">Dacklak</option>
                                            <option value="daknong">DakNong</option>
                                            <option value="dongnai">Đồng Nai</option>
                                            <option value="dongthap">Đông Tháp</option>
                                            <option value="dienbien">Điện Biên</option>
                                            <option value="gialai">Gia Lai</option>
                                            <option value="hagiang">Hà Giang</option>
                                            <option value="hanam">Hà Nam</option>
                                            <option value="hanoi">Hà Nội</option>
                                            <option value="hatinh">Hà Tỉnh</option>
                                            <option value="haiduong">Hải Dương</option>
                                            <option value="danang">Da Nang</option>
                                            <option value="dongthap">Đông Tháp</option>
                                            <option value="dienbien">Điện Biên</option>
                                            <option value="gialai">Gia Lai</option>
                                            <option value="hagiang">Hà Giang</option>
                                            <option value="hanam">Hà Nam</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span
                                            class="requiredField">*</span><?php echo $i18n->birth_place(); ?>: </label>
                                    <div class="col-sm-9"><select class="memberModalBirthPlace form-control">
                                        <option value="angiang">An Giang</option>
                                        <option value="vungtau">Bà Rịa - Vũng Tàu</option>
                                        <option value="baclieu">Bạc Liêu</option>
                                        <option value="backan">Bắc Kan</option>
                                        <option value="bacgiang">Bắc Giang</option>
                                        <option value="bacninh">Bắc ninh</option>
                                        <option value="bentre">Bến Tre</option>
                                        <option value="binhduong">Bình Dương</option>
                                        <option value="binhdinh">Bình Định</option>
                                        <option value="binhphuoc">Bình Phước</option>
                                        <option value="binhthuan">Bình Thuận</option>
                                        <option value="camau">Cà Mau</option>
                                        <option value="caobang">Cao Bằng</option>
                                        <option value="cantho">Cần Thơ</option>
                                        <option value="danang">Đà Nẵng</option>
                                        <option value="daklak">Dacklak</option>
                                        <option value="daknong">DakNong</option>
                                        <option value="dongnai">Đồng Nai</option>
                                        <option value="dongthap">Đông Tháp</option>
                                        <option value="dienbien">Điện Biên</option>
                                        <option value="gialai">Gia Lai</option>
                                        <option value="hagiang">Hà Giang</option>
                                        <option value="hanam">Hà Nam</option>
                                        <option value="hanoi">Hà Nội</option>
                                        <option value="hatinh">Hà Tỉnh</option>
                                        <option value="haiduong">Hải Dương</option>
                                        <option value="danang">Da Nang</option>
                                        <option value="dongthap">Đông Tháp</option>
                                        <option value="dienbien">Điện Biên</option>
                                        <option value="gialai">Gia Lai</option>
                                        <option value="hagiang">Hà Giang</option>
                                        <option value="hanam">Hà Nam</option>
                                    </select></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $i18n->status(); ?>: </label>
                                          <span class="radio-inline"><input type="radio" name="radioStatus"
                                                                            value="Alive"
                                                                            checked id="edit-radio-alive">
                                              <label for="edit-radio-alive"><?php echo $i18n->status_alive(); ?></label></span>
                                          <span class="radio-inline"><input type="radio" name="radioStatus" value="Dead"
                                                                            id="edit-radio-dead">
                                              <label
                                                  for="edit-radio-dead"><?php echo $i18n->status_dead(); ?></label></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo $i18n->marital_status(); ?>
                                        : </label>
                                              <span class="radio-inline"><input type="radio" name="radioMarried"
                                                                                value="Yes"
                                                                                id="edit-radio-yes">
                                                  <label
                                                      for="edit-radio-yes"><?php echo $i18n->marital_status_married(); ?></label></span>
                                              <span class="radio-inline"><input type="radio" name="radioMarried"
                                                                                value="No"
                                                                                checked id="edit-radio-no">
                                                  <label
                                                      for="edit-radio-no"><?php echo $i18n->marital_status_single(); ?></label></span>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btnUpdate btn btn-success" id="btnUpdate"><span
                                    class="glyphicon glyphicon-upload"></span> <?php echo $i18n->update(); ?>
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                    class="glyphicon glyphicon-remove"></span> <?php echo $i18n->cancel(); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <div id="partner" class="partner tab-pane fade">
                    <form class="form-horizontal">
                        <div class="modal-body">
                            <p class="error-msg"></p>
                            <div class="member-modal-avatar">
                                <div>
                                    <div>
                                        <div>
                                            <a id="hrefChangeAvatar" data-toggle="modal"
                                               data-target="#modal-upload-avatar">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle center-block memberModalAvatar img-responsive"
                                                     width="250px" height="250px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3"><?php echo $i18n->member_name(); ?>: </label>
                                <div class="col-sm-9"><input type="text" class="memberModalName form-control"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3"><?php echo $i18n->member_gender(); ?>: </label>
                                <div class="col-sm-9">
                                    <select class="memberModalGender form-control">
                                        <option value="male"><?php echo $i18n->male(); ?></option>
                                        <option value="female"><?php echo $i18n->female(); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->birth_date(); ?>: </label>
                                <div class="col-sm-9"><input type="date" class="memberModalBirthDate form-control"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->address(); ?>: </label>
                                <div class="col-sm-9">
                                  <select class="memberModalAddress form-control">
                                      <option value="angiang">An Giang</option>
                                      <option value="vungtau">Bà Rịa - Vũng Tàu</option>
                                      <option value="baclieu">Bạc Liêu</option>
                                      <option value="backan">Bắc Kan</option>
                                      <option value="bacgiang">Bắc Giang</option>
                                      <option value="bacninh">Bắc ninh</option>
                                      <option value="bentre">Bến Tre</option>
                                      <option value="binhduong">Bình Dương</option>
                                      <option value="binhdinh">Bình Định</option>
                                      <option value="binhphuoc">Bình Phước</option>
                                      <option value="binhthuan">Bình Thuận</option>
                                      <option value="camau">Cà Mau</option>
                                      <option value="caobang">Cao Bằng</option>
                                      <option value="cantho">Cần Thơ</option>
                                      <option value="danang">Đà Nẵng</option>
                                      <option value="daklak">Dacklak</option>
                                      <option value="daknong">DakNong</option>
                                      <option value="dongnai">Đồng Nai</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                      <option value="hanoi">Hà Nội</option>
                                      <option value="hatinh">Hà Tỉnh</option>
                                      <option value="haiduong">Hải Dương</option>
                                      <option value="danang">Da Nang</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->birth_place(); ?>: </label>
                                <div class="col-sm-9">
                                  <select class="memberModalBirthPlace form-control">
                                      <option value="angiang">An Giang</option>
                                      <option value="vungtau">Bà Rịa - Vũng Tàu</option>
                                      <option value="baclieu">Bạc Liêu</option>
                                      <option value="backan">Bắc Kan</option>
                                      <option value="bacgiang">Bắc Giang</option>
                                      <option value="bacninh">Bắc ninh</option>
                                      <option value="bentre">Bến Tre</option>
                                      <option value="binhduong">Bình Dương</option>
                                      <option value="binhdinh">Bình Định</option>
                                      <option value="binhphuoc">Bình Phước</option>
                                      <option value="binhthuan">Bình Thuận</option>
                                      <option value="camau">Cà Mau</option>
                                      <option value="caobang">Cao Bằng</option>
                                      <option value="cantho">Cần Thơ</option>
                                      <option value="danang">Đà Nẵng</option>
                                      <option value="daklak">Dacklak</option>
                                      <option value="daknong">DakNong</option>
                                      <option value="dongnai">Đồng Nai</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                      <option value="hanoi">Hà Nội</option>
                                      <option value="hatinh">Hà Tỉnh</option>
                                      <option value="haiduong">Hải Dương</option>
                                      <option value="danang">Da Nang</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->status(); ?>: </label>
                                      <span class="radio-inline"><input type="radio" name="radioStatus" value="Alive"
                                                                        checked id="edit-radio-alive">
                                          <label
                                              for="edit-radio-alive"><?php echo $i18n->status_alive(); ?></label></span>
                                      <span class="radio-inline"><input type="radio" name="radioStatus" value="Dead"
                                                                        id="edit-radio-dead">
                                          <label
                                              for="edit-radio-dead"><?php echo $i18n->status_dead(); ?></label></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btnUpdate btn btn-success" id="btnUpdate"><span
                                    class="glyphicon glyphicon-upload"></span> <?php echo $i18n->update(); ?>
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                    class="glyphicon glyphicon-remove"></span> <?php echo $i18n->cancel(); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ~~ Member-info-modal -->

<!--Member-add-modal -->
<div id="modal-add-user" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $i18n->new_member(); ?></h4>
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#info1"><?php echo $i18n->information(); ?></a></li>
                <li><a data-toggle="tab" href="#partner1"><?php echo $i18n->partner(); ?></a></li>
            </ul>

            <div class="tab-content">
                <div id="info1" class="info tab-pane fade in active">
                    <form class="form-horizontal">
                        <div class="modal-body">
                            <p class="error-msg"></p>
                            <div class="member-modal-avatar">
                                <div>
                                    <div>
                                        <div>
                                            <a id="hrefChangeAvatar" data-toggle="modal"
                                               data-target="#modal-upload-avatar">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle memberModalAvatar img-responsive"
                                                     width="250px" height="250px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3"><span
                                        class="requiredField">*</span><?php echo $i18n->member_name(); ?>: </label>
                                <div class="col-sm-9"><input type="text" class="memberModalName form-control"
                                                              required></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3"><?php echo $i18n->member_gender(); ?>: </label>
                                <div class="col-sm-9">
                                    <select class="memberModalGender form-control">
                                        <option value="male"><?php echo $i18n->male(); ?></option>
                                        <option value="female" selected><?php echo $i18n->female(); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><span
                                        class="requiredField">*</span><?php echo $i18n->birth_date(); ?>: </label>
                                <div class="col-sm-9"><input type="date" class="memberModalBirthDate form-control"
                                                              required></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->address(); ?>: </label>
                                <div class="col-sm-9">
                                  <select class="memberModalAddress form-control">
                                      <option value="angiang">An Giang</option>
                                      <option value="vungtau">Bà Rịa - Vũng Tàu</option>
                                      <option value="baclieu">Bạc Liêu</option>
                                      <option value="backan">Bắc Kan</option>
                                      <option value="bacgiang">Bắc Giang</option>
                                      <option value="bacninh">Bắc ninh</option>
                                      <option value="bentre">Bến Tre</option>
                                      <option value="binhduong">Bình Dương</option>
                                      <option value="binhdinh">Bình Định</option>
                                      <option value="binhphuoc">Bình Phước</option>
                                      <option value="binhthuan">Bình Thuận</option>
                                      <option value="camau">Cà Mau</option>
                                      <option value="caobang">Cao Bằng</option>
                                      <option value="cantho">Cần Thơ</option>
                                      <option value="danang">Đà Nẵng</option>
                                      <option value="daklak">Dacklak</option>
                                      <option value="daknong">DakNong</option>
                                      <option value="dongnai">Đồng Nai</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                      <option value="hanoi">Hà Nội</option>
                                      <option value="hatinh">Hà Tỉnh</option>
                                      <option value="haiduong">Hải Dương</option>
                                      <option value="danang">Da Nang</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                  </select>
                                </div>
                                <!-- <div class="col-sm-9"><input type="text" class="memberModalAddress form-control"
                                                              placeholder="Enter Addess here..." required></div> -->
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><span
                                        class="requiredField">*</span><?php echo $i18n->birth_place(); ?>: </label>
                                <div class="col-sm-9">
                                  <select class="memberModalBirthPlace form-control">
                                      <option value="angiang">An Giang</option>
                                      <option value="vungtau">Bà Rịa - Vũng Tàu</option>
                                      <option value="baclieu">Bạc Liêu</option>
                                      <option value="backan">Bắc Kan</option>
                                      <option value="bacgiang">Bắc Giang</option>
                                      <option value="bacninh">Bắc ninh</option>
                                      <option value="bentre">Bến Tre</option>
                                      <option value="binhduong">Bình Dương</option>
                                      <option value="binhdinh">Bình Định</option>
                                      <option value="binhphuoc">Bình Phước</option>
                                      <option value="binhthuan">Bình Thuận</option>
                                      <option value="camau">Cà Mau</option>
                                      <option value="caobang">Cao Bằng</option>
                                      <option value="cantho">Cần Thơ</option>
                                      <option value="danang">Đà Nẵng</option>
                                      <option value="daklak">Dacklak</option>
                                      <option value="daknong">DakNong</option>
                                      <option value="dongnai">Đồng Nai</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                      <option value="hanoi">Hà Nội</option>
                                      <option value="hatinh">Hà Tỉnh</option>
                                      <option value="haiduong">Hải Dương</option>
                                      <option value="danang">Da Nang</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->status(); ?>: </label>
                                        <span class="radio-inline"><input type="radio" name="radioStatus" value="Alive"
                                                                          checked id="add-radio-alive">
                                            <label
                                                for="add-radio-alive"><?php echo $i18n->status_alive(); ?></label></span>
                                        <span class="radio-inline"><input type="radio" name="radioStatus" value="Dead"
                                                                          id="add-radio-dead">
                                            <label
                                                for="add-radio-dead"><?php echo $i18n->status_dead(); ?></label></span>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->marital_status(); ?>: </label>
                                        <span class="radio-inline"><input type="radio" name="radioMarried" value="Yes"
                                                                          id="add-radio-yes">
                                            <label
                                                for="add-radio-yes"><?php echo $i18n->marital_status_married(); ?></label></span>
                                        <span class="radio-inline"><input type="radio" name="radioMarried" value="No"
                                                                          checked id="add-radio-no">
                                            <label
                                                for="add-radio-no"><?php echo $i18n->marital_status_single(); ?></label></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btnAdd btn btn-success" id="btnAdd"><span
                                    class="glyphicon glyphicon-plus"></span> <?php echo $i18n->add(); ?>
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                    class="glyphicon glyphicon-remove"></span> <?php echo $i18n->cancel(); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <div id="partner1" class="partner tab-pane fade">
                    <form class="form-horizontal">
                        <div class="modal-body">
                            <p class="error-msg"></p>
                            <div class="member-modal-avatar">
                                <div>
                                    <div>
                                        <div>
                                            <a id="hrefChangeAvatar" data-toggle="modal"
                                               data-target="#modal-upload-avatar">
                                                <img src="images/avatar-default.png"
                                                     class="img-circle memberModalAvatar img-responsive"
                                                     width="250px" height="250px"
                                                     alt="/*name*/">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3"><?php echo $i18n->member_name(); ?>: </label>
                                <div class="col-sm-9"><input type="text" class="memberModalName form-control"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3"><?php echo $i18n->member_gender(); ?>: </label>
                                <div class="col-sm-9">
                                    <select class="memberModalGender form-control">
                                        <option value="male"><?php echo $i18n->male(); ?></option>
                                        <option value="female" selected><?php echo $i18n->female(); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->birth_date(); ?>: </label>
                                <div class="col-sm-9"><input type="date" class="memberModalBirthDate form-control"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->address(); ?>: </label>
                                <div class="col-sm-9">
                                  <select class="memberModalAddress form-control">
                                      <option value="angiang">An Giang</option>
                                      <option value="vungtau">Bà Rịa - Vũng Tàu</option>
                                      <option value="baclieu">Bạc Liêu</option>
                                      <option value="backan">Bắc Kan</option>
                                      <option value="bacgiang">Bắc Giang</option>
                                      <option value="bacninh">Bắc ninh</option>
                                      <option value="bentre">Bến Tre</option>
                                      <option value="binhduong">Bình Dương</option>
                                      <option value="binhdinh">Bình Định</option>
                                      <option value="binhphuoc">Bình Phước</option>
                                      <option value="binhthuan">Bình Thuận</option>
                                      <option value="camau">Cà Mau</option>
                                      <option value="caobang">Cao Bằng</option>
                                      <option value="cantho">Cần Thơ</option>
                                      <option value="danang">Đà Nẵng</option>
                                      <option value="daklak">Dacklak</option>
                                      <option value="daknong">DakNong</option>
                                      <option value="dongnai">Đồng Nai</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                      <option value="hanoi">Hà Nội</option>
                                      <option value="hatinh">Hà Tỉnh</option>
                                      <option value="haiduong">Hải Dương</option>
                                      <option value="danang">Da Nang</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->birth_place(); ?>: </label>
                                <div class="col-sm-9">
                                  <!-- <nput type="text" class="memberModalBirthPlace form-control"> -->
                                  <select class="memberModalBirthPlace form-control">
                                      <option value="angiang">An Giang</option>
                                      <option value="vungtau">Bà Rịa - Vũng Tàu</option>
                                      <option value="baclieu">Bạc Liêu</option>
                                      <option value="backan">Bắc Kan</option>
                                      <option value="bacgiang">Bắc Giang</option>
                                      <option value="bacninh">Bắc ninh</option>
                                      <option value="bentre">Bến Tre</option>
                                      <option value="binhduong">Bình Dương</option>
                                      <option value="binhdinh">Bình Định</option>
                                      <option value="binhphuoc">Bình Phước</option>
                                      <option value="binhthuan">Bình Thuận</option>
                                      <option value="camau">Cà Mau</option>
                                      <option value="caobang">Cao Bằng</option>
                                      <option value="cantho">Cần Thơ</option>
                                      <option value="danang">Đà Nẵng</option>
                                      <option value="daklak">Dacklak</option>
                                      <option value="daknong">DakNong</option>
                                      <option value="dongnai">Đồng Nai</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                      <option value="hanoi">Hà Nội</option>
                                      <option value="hatinh">Hà Tỉnh</option>
                                      <option value="haiduong">Hải Dương</option>
                                      <option value="danang">Da Nang</option>
                                      <option value="dongthap">Đông Tháp</option>
                                      <option value="dienbien">Điện Biên</option>
                                      <option value="gialai">Gia Lai</option>
                                      <option value="hagiang">Hà Giang</option>
                                      <option value="hanam">Hà Nam</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo $i18n->status(); ?>: </label>
                                        <span class="radio-inline"><input type="radio" name="radioStatus" value="Alive"
                                                                          checked id="add-radio-alive">
                                            <label
                                                for="add-radio-alive"><?php echo $i18n->status_alive(); ?></label></span>
                                        <span class="radio-inline"><input type="radio" name="radioStatus" value="Dead"
                                                                          id="add-radio-dead">
                                            <label
                                                for="add-radio-dead"><?php echo $i18n->status_dead(); ?></label></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btnAdd btn btn-success" id="btnAdd"><span
                                    class="glyphicon glyphicon-plus"></span> <?php echo $i18n->add(); ?>
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                    class="glyphicon glyphicon-remove"></span> <?php echo $i18n->cancel(); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ~~Member-add-modal -->

<!-- Modal Delete  -->
<div class="modal fade" id="modal-delete-user" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align Heading"><?php echo $i18n->delete(); ?></h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span
                        class="glyphicon glyphicon-warning-sign"></span> <?php echo $i18n->delete_prompt(); ?>
                </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" id="btnDelete" data-dismiss="modal"><span
                        class="glyphicon glyphicon-ok-sign"></span> <?php echo $i18n->yes(); ?>
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> <?php echo $i18n->no(); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ~~ Modal Delete -->

<!-- Modal Upload Avatar  -->
<div class="modal fade" id="modal-upload-avatar" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align Heading">Image upload</h4>
            </div>
            <div class="modal-body">
                <img class="img-responsive" id="imgNewAvatar"
                     src="images/avatar-default.png"
                     alt="New Avatar"
					 style="margin:0 auto">
                <div class="row" style="margin-top:2em">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <input type="file" id="file-input">
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" id="btnUploadAvatar" data-dismiss="modal"><span
                        class="glyphicon glyphicon-ok-sign"></span> <?php echo $i18n->upload(); ?>
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> <?php echo $i18n->cancel(); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ~~ Modal Upload Avatar -->

<!-- Modal Uploading  -->
<div class="modal fade" id="modal-uploading" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img class="center-block" id="imgUploading" src="http://www.bis.org/img/uploading.gif"
                     alt="Uploading..."
                     width="100em"
                     height="100em">
            </div>
        </div>
    </div>
</div>
<!-- ~~ Modal Uploading -->





<!--<div class="modal-wrapper">

</div>-->

</body>
</html>
