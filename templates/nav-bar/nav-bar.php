<!-- Navigation -->
<nav class="navbar navbar-findcond navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img class="img-responsive" src="../../images/family-tree-logo.png" >
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-fw fa-bell-o"></i> Notification <span class="badge">0</span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#"><i class="fa fa-fw fa-tag"></i> <span class="badge">Music</span> ABC <span class="badge">Video</span> Sun Sun Sun </a></li>
                        <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Music</span> Sun Sun Sun</a></li>
                        <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Video</span> Sun Sun Sun</a></li>
                        <li><a href="#"><i class="fa fa-fw fa-thumbs-o-up"></i> <span class="badge">Game</span> Sun Sun Sun</a></li>
                    </ul>
                </li>-->
                <li class="family-tree-tab">
                    <a href="tree"><i class="fa fa-fw fa-sitemap active"></i> <?php echo $i18n->tree_tab(); ?></a>
                </li>
                <li class="guests-man-tab">
                    <a href="management"><i class="fa fa-fw fa-users"></i> <?php echo $i18n->management_tab(); ?></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="navbar-user-name" role="button" aria-expanded="false"><?php echo $name;?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a id="hrefExport" href="#"><?php echo $i18n->export(); ?></a></li>
                        <li class="divider"></li>
                        <li><a id="hrefLogOut" href="#exit"><?php echo $i18n->logout(); ?></a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-right search-form" role="search">
                <input  multiple style="width:15em" class="form-control" type="text"  id="search"  placeholder="<?php echo $i18n->search(); ?>">
            </form>
        </div>
    </div>
</nav>
