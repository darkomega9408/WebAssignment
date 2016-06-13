<?php
require('./../../i18n/i18n.php');
if (!isset($_COOKIE['lang'])) {
  setcookie('lang', 'en');
  $i18n = new i18n("en");
}
else {
  $i18n = new i18n($_COOKIE['lang']);
}
?>
<!-- membercard -->
<div class ='membercard-wrapper' >
    <div class="membercard panel panel-default text-center effect-winston">
        <div class="panel-body">
            <div class="member-avatar">
                <img src="" class="img-rounded img-responsive memberAvatar" alt="/*AVATAR*/">
            </div>
            <div class="info">
                <strong class="memberName">Nguyễn Xuân Thái</strong>
                <img src="">
            </div>
            <div>
                <p>
                    <a href="#"><i class="fa fa-fw fa-pencil fa-2x"></i><span><?php echo $i18n->edit(); ?></span></a>
                    <a href="#"><i class="fa fa-fw fa-plus fa-2x"></i><span><?php echo $i18n->add_child(); ?></span></a>
                    <a href="#"><i class="fa fa-fw fa-times fa-2x"></i><span><?php echo $i18n->delete(); ?></span></a>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
