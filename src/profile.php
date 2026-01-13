<?php session_start();
include "./func/database.php";

if (!isset($_GET['user'])) {
    $name = $_SESSION['username'];
    $row = profile($name);
} else {
    $name = $_GET['user'];
    $row = profile($name);
}

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-sm-10">
            <h1><?php echo $row['username']; ?></h1>
        </div>
        <div class="col-sm-2"><a href="" class="pull-right"><img title="profile image" class="img-circle img-responsive" src="http://www.gravatar.com/avatar/28fd20ccec6865e2d5f0e1f4446eb7bf?s=100"></a></div>
    </div>
    <div class="row">
        <div class="col-sm-3"><!--left col-->


            <div class="text-center">
                <img src="./uploads/<?php echo $row['avatars']; ?>" class="avatar img-circle img-thumbnail" alt="avatar">
                <h6>Upload a different photo...</h6>
                <form action="./func/upload.php" method="post" enctype="multipart/form-data">
                    <input type="file" class="text-center center-block file-upload" name="fileupload">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
            </hr><br>
        </div><!--/col-3-->
        <div class="col-sm-9">
            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <hr>
                    <form class="form" action="./admin/update.php" method="post" id="registrationForm">
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="phone">
                                    <h4>Phone</h4>
                                </label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="enter phone" title="enter your phone number if any." value="<?php echo $row['phone'] ?>">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="email">
                                    <h4>Email</h4>
                                </label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="you@email.com" title="enter your email." value="<?php echo $row['email'] ?>">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="email">
                                    <h4>Location</h4>
                                </label>
                                <input type class="form-control" name="location" id="location" placeholder="somewhere" title="enter a location" value="<?php echo $row['location'] ?>">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="password">
                                    <h4>Full Name</h4>
                                </label>
                                <input class="form-control" name="fullname" id="password" placeholder="fullname" title="enter your full name." value="<?php echo $row['fullname'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <br>
                                <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                <button class="btn btn-lg btn-yellow"><a href="<?php if ($_SESSION['role'] == 'admin')  echo './admin/index.php';
                                                                                else echo 'index.php'; ?>"><i class="glyphicon "></i> Return</a></button>
                                <button class="btn btn-lg"><a href="logout.php"><i class="glyphicon glyphicon-repeat"></i> Log Out</a></button>
                            </div>
                        </div>
                    </form>

                </div><!--/tab-pane-->
            </div><!--/tab-pane-->
        </div><!--/tab-content-->

    </div><!--/col-9-->
</div><!--/row-->