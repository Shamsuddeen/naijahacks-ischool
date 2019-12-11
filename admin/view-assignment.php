<?php
    include('../inc/build.php');
    include('./user.php');
    $assignment  = trim($_GET['ref']);
    $assignments = getAssignment($assignment);
    foreach ($assignments as $row) {
        $file       = $row->assign_title;
        $content    = $row->assign_body;
        $course     = $row->course_code;
        $department = $row->dept_name;
        $level      = $row->level; 
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
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
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
                                    <table class="table table-striped table-bordered">
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
                                    
                                    <textarea name="" id="input" class="form-control" rows="3" readonly="readonly"><?php echo $content; ?></textarea>
                                    
                                    <br><hr>
                                    <div class="row">                                        
                                        <?php
                                            $assignments    = getAssignment($assignment);
                                            foreach ($assignments as $res) {
                                                $results    = json_decode($res->files, true);
                                                foreach ($results as $key) {
                                                    $source = $key['file'];
                                                    $type   = $key['type'];
                                                    echo "
                                                        <div class='col-md-4 col-xs-12'> 
                                                    ";
                                                    if ($type == 'mp4' || $type ==  '3gp' || $type == 'webm') {
                                                        echo "
                                                            <video src=".'../'.$source." controls></video>
                                                        ";
                                                    }elseif ($type == 'doc' || $type ==  'docx' || $type == 'pdf') {
                                                        echo "<a href=".'../'.$source.">".
                                                            str_replace('uploads/assignments/', '', $source)
                                                        ."</a>";

                                                    }elseif ($type == 'mp3' || $type == 'mp4a' || $type == 'midi') {
                                                        echo "<audio src=".'../'.$source." controls></audio>";
                                                    }else{
                                                        echo "
                                                            <a href=".'../'.$source.">
                                                                <img src=".'../'.$source." class='img-responsive'>
                                                            </a>
                                                        ";
                                                    }
                                                    echo "
                                                        </div> 
                                                    ";
                                                }
                                            }
                                        ?>
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-danger submitBtn">Close Submission</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submissions -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Submitted</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Department</th>
                                                <th>Level</th>
                                                <th>Time</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $results = getSubmissions($assignment);
                                                foreach ($results as $res) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $res->id_number; ?></td>
                                                        <td><?php echo $res->dept_name; ?></td>
                                                        <td>
                                                            <?php
                                                                echo $res->level;
                                                            ?>
                                                        </td>
                                                        <td><?php echo timeElapsed($res->time_submitted); ?></td>
                                                        <td><a href="view-submitted.php?ref=<?php echo $res->submit_id; ?>&student=<?php echo $res->student_id; ?>">View</a></td>
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    
                                    <!-- <br><hr>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button type="submit" class="btn btn-danger submitBtn">Close Submission</button>
                                        </div>
                                    </div> -->
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
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</body>

</html>