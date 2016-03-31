

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>
        Admin Page
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
    <script src="js/admin-page.js"></script>
    <script src="bower_components/selectize/dist/js/standalone/selectize.js"></script>
    <script src="js/search.js"></script>
    <link rel="stylesheet" type="text/css" href="css/modal.css">

</head>

<body>

<!-- Navigation -->
<header>

</header>
<!-- Full Width Image Header -->


<!-- Page Content -->

<main>
    <div class="container">

        <h1 class="thick-heading">
            List Users
        </h1>


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
                        <th>UserName</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </thead>

                        <tbody>
                        <?php
                        /*$reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;

                        // loop through results of database query, displaying them in the table
                        for ($i = $start; $i < $end; $i++) {
                            // make sure that PHP doesn't try to show results that don't exist
                            if ($i == $total_results) {
                                break;
                            }

                            // echo out the contents of each row into a table
                            echo '<tr id="user'.$result[$i]['ID'].'">';
                            echo '<td><input type=\'checkbox\' class=\'checkthis\' /></td>';
                            echo '<td>' . $result[$i]['ID']. '</td>';
                            echo '<td>' . $result[$i]['Username']. '</td>';
                            echo '<td>' . $result[$i]['Email']. '</td>';
                            echo '<td>' . $result[$i]['Name']. '</td>';
                            echo '<td><p data-placement="top" data-toggle="tooltip" title="Edit">'.
                                '<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-pencil"></span></button></p></td>';
                            echo '<td><p data-placement="top" data-toggle="tooltip" title="Delete">'.
                                '<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"><span class="glyphicon glyphicon-trash"></span></button></p></td>';
                            echo "</tr>";
                        }
                        // ~~
                        */?>
                        </tbody>

                    </table>



                    <!-- Pagination here -->
                    <?php
                    /*//$reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
                    echo '<ul class="pagination pull-right ">';
                    if ($total_pages > 1)
                        echo paginate($reload, $shown_page, $total_pages);
                    echo "</ul>";*/
                    ?>

                    <!--<ul class="pagination pull-right">
                        <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
                    </ul>-->

                    <div class="clearfix"></div>

                </div>

            </div>

            <button type="button" class="btn btn-info" style="margin: 2em auto" data-title='Add' data-toggle='modal' data-target='#add'>
                <span class="glyphicon glyphicon-plus-sign"></span> Add User
            </button>
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
                <h4 class="modal-title custom_align Heading" >Edit User Detail</h4>
            </div>
            <form  class="form-horizontal">
                <div class="modal-body">
                    <p class="error-msg"></p>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>ID: </label>
                        <input class="form-control userID" type="text" readonly>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>UserName: </label>
                        <input class="form-control userName" type="text" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Email: </label>
                        <input class="form-control userEmail" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Name: </label>
                        <input class="form-control name" type="text">
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" id="btnUpdate"
                            ><span class="glyphicon glyphicon-ok-sign"></span> Update
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
                <h4 class="modal-title custom_align Heading" >New User</h4>
            </div>
            <form  class="form-horizontal">
                <div class="modal-body">
                    <p class="error-msg"></p>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>UserName: </label>
                        <input class="form-control userName" type="text" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Password: </label>
                        <input class="form-control userPassword" type="password" required>
                    </div>
                    <div class="form-group">
                        <label><span class="requiredField">*</span>Email: </label>
                        <input class="form-control userEmail" type="email"
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                    <div class="form-group">
                        <label>Name: </label>
                        <input class="form-control name" type="text">
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-warning btn-lg" style="width: 100%;" id="btnAdd"
                            ><span class="glyphicon glyphicon-plus-sign"></span> Add
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
                <h4 class="modal-title custom_align Heading" >Delete this entry</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" id="btnDelete" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
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
