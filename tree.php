<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require("lib/vendor/firebase/php-jwt/src/JWT.php");
use Firebase\JWT\JWT;
if (!isset($_COOKIE['token'])) header('Location: index.php');
else {
  $token = $_COOKIE['token'];
  $data = (array) JWT::decode($token, Token::$jwt_key, ['alg' => 'HS512']);
  $personData = (array) $data['data'];
  $id = $personData['id'];
}
?>
<!DOCTYPE html>

<html>
<head>
    <title>Tree Demo userID <?php echo $id; ?></title>

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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" >
    <link rel="stylesheet" type="text/css" href="css/modal.css">


    <script src="js/bootstrap.min.js"></script>
    <script src="js/membercard.js"></script>
    <script src="js/cookie-management.js"></script>
    <script src="js/tree.js"></script>
    <script src="bower_components/selectize/dist/js/standalone/selectize.js"></script>
    <script src="js/search.js"></script>
    <script src="js/render/html2canvas.js"></script>

</head>
<body>


<header data-id="<?php echo $id ?>"></header>


<div class="tree" style="margin-top:5em">
</div>

<!-- Member-info-modal -->
<div id="modal-edit-user" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Someone's Information</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <p class="error-msg"></p>
                    <div class="member-modal-avatar">
                        <a id="hrefChangeAvatar" data-toggle="modal" data-target="#modal-upload-avatar">
                            <img src="images/avatar-default.png" class="img-circle img-responsive memberModalAvatar"
                                 alt="/*name*/">
                        </a>
                    </div>

                    <form role="form" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-2"><span class="requiredField">*</span>Name: </label>
                            <div class="col-sm-10"><input type="text" class="memberModalName form-control"
                                                          value="Nguyễn Xuân Thái" required></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Gender: </label>
                            <div class="col-sm-10">
                                <select class="memberModalGender form-control">
                                    <option value="male">Male</option>
                                    <option value="female" selected>Female</option>
                                    <option value="undefined">Undefined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span class="requiredField">*</span>Date of birth: </label>
                            <div class="col-sm-10"><input type="date" class="memberModalBirthDate form-control"
                                                          value="October 29, 1994" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address: </label>
                            <div class="col-sm-10"><input type="text" class="memberModalAddress form-control"
                                                          value="Too long, lazy to type" required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span class="requiredField">*</span>Birthplace: </label>
                            <div class="col-sm-10"><input type="text" class="memberModalBirthPlace form-control"
                                                          value="HCMC"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status: </label>
                                    <span class="radio-inline"><input type="radio" name="radioStatus" value="Alive"
                                                                      checked id="edit-radio-alive">
                                        <label for="edit-radio-alive">Alive</label></span>
                                    <span class="radio-inline"><input type="radio" name="radioStatus" value="Dead"
                                                                      id="edit-radio-dead">
                                        <label for="edit-radio-dead">Dead</label></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnUpdate"><span
                            class="glyphicon glyphicon-upload"></span> Update
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove"></span> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ~~ Member-info-modal -->


<div id="modal-add-user" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form  class="form-horizontal">
                <div class="modal-body">
                    <p class="error-msg"></p>
                    <div class="member-modal-avatar">
                        <a id="hrefChangeAvatar" data-toggle="modal" data-target="#modal-upload-avatar">
                            <img src="images/avatar-default.png" class="img-circle img-responsive memberModalAvatar"
                                 alt="/*name*/">
                        </a>
                    </div>


                        <div class="form-group">
                            <label class="control-label col-sm-2"><span class="requiredField">*</span>Name: </label>
                            <div class="col-sm-10"><input type="text" class="memberModalName form-control"
                                                          placeholder="Enter Name here..." required></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Gender: </label>
                            <div class="col-sm-10">
                                <select class="memberModalGender form-control">
                                    <option value="male">Male</option>
                                    <option value="female" selected>Female</option>
                                    <option value="undefined">Undefined</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span class="requiredField">*</span>Date of birth: </label>
                            <div class="col-sm-10"><input type="date" class="memberModalBirthDate form-control"
                                                          required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address: </label>
                            <div class="col-sm-10"><input type="text" class="memberModalAddress form-control"
                                                          placeholder="Enter Addess here..." required></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span class="requiredField">*</span>Birthplace: </label>
                            <div class="col-sm-10"><input type="text" class="memberModalBirthPlace form-control"
                                                          placeholder="Enter Birthplace here..."></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status: </label>
                                    <span class="radio-inline"><input type="radio" name="radioStatus" value="Alive"
                                                                      checked id="add-radio-alive">
                                        <label for="add-radio-alive">Alive</label></span>
                                    <span class="radio-inline"><input type="radio" name="radioStatus" value="Dead"
                                                                      id="add-radio-dead">
                                        <label for="add-radio-dead">Dead</label></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnAdd"><span
                            class="glyphicon glyphicon-plus"></span> Add
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove"></span> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Delete  -->
<div class="modal fade" id="modal-delete-user" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align Heading">Delete this entry</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure
                    you want to delete this member?
                </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" id="btnDelete" data-dismiss="modal"><span
                        class="glyphicon glyphicon-ok-sign"></span> Yes
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> No
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ~~ Modal Delete -->

<!-- Modal Upload Avatar  -->
<div class="modal fade" id="modal-upload-avatar" tabindex="-1" role="dialog" aria-labelledby="edit"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align Heading">Change Avatar</h4>
            </div>
            <div class="modal-body">
                <img width="300px" height="300px" class="img-circle center-block" id="imgNewAvatar"
                     src="https://image.freepik.com/free-icon/user-male-shape-in-a-circle--ios-7-interface-symbol_318-35357.png"
                     alt="New Avatar">
                <div class="row" style="margin-top:2em">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <input type="file" id="file-input">
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" id="btnUploadAvatar" ><span
                        class="glyphicon glyphicon-ok-sign"></span> Upload
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> Cancel
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
                <img class="center-block" id="imgUploading" src="http://www.bis.org/img/uploading.gif" alt="Uploading..."
                     width="100em"
                     height="100em">
            </div>
        </div>
    </div>
</div>
<!-- ~~ Modal Uploading -->

<button id="btnAddMember" data-toggle="modal" data-target="#modal-add-user" type="button" class="btn btn-success center-block">Add Member</button>
<script type="text/javascript">
    function clone(){
      $('header').hide();
      $('#clone').hide();
      $('[data-toggle="tooltip"]').hide();
      $('.membercard img').css('border','0px solid white');
      html2canvas(document.body, {
        onrendered: function(canvas) {
          var a = document.createElement('a');
          a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
          a.download = 'somefilename.jpg';
          a.click();
        },
        useCORS: true,
        background: 'white'
      });
      $('.membercard img').css('border','');
      $('#clone').show();
      $('header').show();
      $('[data-toggle="tooltip"]').show();
    }
</script>
<input style="position:fixed; z-index:10000;" id = "clone" onclick="clone()"  type="button" class="btn btn-success center-block" value="Export"></input>




<!--<div class="modal-wrapper">

</div>-->

</body>
</html>
