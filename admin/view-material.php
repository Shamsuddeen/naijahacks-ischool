<?php
    include('../inc/build.php');
    include('./user.php');
    $material  = trim($_GET['ref']);
    $materials = getMaterial($material);
    foreach ($materials as $row) {
        $file       = $row->file_name;
        $source     = $row->file_loc;
        $course     = $row->course_code;
        $department = $row->dept_name;
        $level      = $row->level; 
        $file       = $row->file_name;
        $type       = $row->file_type;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php info('site_name'); ?> | Dashboard</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <?php include('inc/sidebar.php'); ?>
            <?php include('inc/top.php'); ?>
            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Plain Page</h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Plain Page</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Course Code</th>
                                                <th>Department</th>
                                                <th>Level</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $file; ?></td>
                                                <td><?php echo $course; ?></td>
                                                <td>
                                                    <?php
                                                        echo $department;
                                                    ?>
                                                </td>
                                                <td><?php echo $level; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br><hr>

                                    <?php
                                        if ($type == 'mp4' || $type ==  '3gp' || $type == 'webm') {
                                            echo "
                                                <video src=".'../'.$source." controls></video>
                                            ";
                                        }elseif ($type == 'doc' || $type ==  'docx' || $type == 'pdf') {
                                            # code...
                                        }elseif ($type == 'mp3' || $type == 'mp4a' || $type == 'midi') {
                                            # code...
                                        }else{
                                            echo "
                                                <img src=".'../'.$source." class='img-responsive'>
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <?php include('inc/footer.php'); ?>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</body>

</html>