<?php
    include('../inc/build.php');
    include('./user.php');
    require "../vendor/autoload.php";
    // $apiKey     = info('opentok_api_key');
    // $apiSecret  = info('opentok_secret_key');
    $apiKey     = "46472052";
    $apiSecret  = "94f02730f0dfc50d5696e81d4d96ead0e038b9d5";

    use OpenTok\OpenTok;

    $opentok = new OpenTok($apiKey, $apiSecret);

    use OpenTok\MediaMode;
    // use OpenTok\ArchiveMode;
    use OpenTok\Session;
    use OpenTok\Role;

    if($_POST){
        $department = trim($_POST['dept']);
        $course     = trim($_POST['course']);
        $time       = trim($_POST['time']);
        // Create a session that attempts to use peer-to-peer streaming:
        $session = $opentok->createSession();
        
        // A session that uses the OpenTok Media Router, which is required for archiving:
        $session = $opentok->createSession(array( 'mediaMode' => MediaMode::ROUTED ));
        
        // A session with a location hint:
        // $session = $opentok->createSession(array( 'location' => '12.34.56.78' ));
        
        // An automatically archived session:
        $sessionOptions = array(
            'mediaMode' => MediaMode::ROUTED
        );
        $session = $opentok->createSession($sessionOptions);
        // Store this sessionId in the database for later use
        $sessionId = $session->getSessionId();

        // $opentok = new OpenTok($apiKey, $apiSecret);
        // // Replace with meaningful metadata for the connection:
        // $connectionMetaData = "username=$first_name,userLevel=4";

        // // Generate a Token from just a sessionId (fetched from a database)
        // $token = $opentok->generateToken($sessionId);
        // // Generate a Token by calling the method on the Session (returned from createSession)
        // $token = $sessioniD->generateToken();
        
        // Set some options in a token
        $token = $session->generateToken(array(
            'role'       => Role::MODERATOR,
            'expireTime' => time()+(($time * 60 * 60) + (2 * 60 * 60)), // in $time to start class + Class ends to 2hours
            'data'       => 'name='.$first_name,
            'initialLayoutClassList' => array('focus')
        ));

        // print "\n"; 
        $msg = createLectureClass($sessionId, $token, $department, $course, $time);
        notifyStudentsLecture($department, $course, $time);
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

                                    <?php if(isset($msg)){ ?>
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>Title!</strong> <?php echo $msg; ?>
                                    </div>
                                    <?php } ?>
                                    
                                    <form id="form" method="POST" action="#" data-parsley-validate
                                        class="form-horizontal form-label-left">
                                        <div id="info"></div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Select Department <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="dept" required="required" id="departments">
                                                    <option selected disabled>Choose Option</option>
 
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Select Course <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" name="course" required="required"
                                                    id="courses">
                                                    <option selected disabled>Choose Option</option>
                                                    <?php
                                                        $courses = getCoursesByStaff($stf_id);
                                                        foreach ($courses as $course){
                                                    ?>
                                                    <option value="<?php echo $course->course_id; ?>">
                                                        <?php echo $course->course_title; ?></option>
                                                    <?php 
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Start in (time in hour) <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" name="time" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <!-- <button class="btn btn-primary" type="button">Cancel</button> -->
                                                <button class="btn btn-primary" type="reset">Reset</button>
                                                <button type="submit" class="btn btn-success submitBtn"
                                                    name="bio">Submit</button>
                                            </div>
                                        </div>

                                    </form>
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
    <script>
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                data: $(form).serialize(),
                url: "get-depts.php",
                success: function (msg) {
                    $('#form').fadeTo("slow", 1, function () {
                        $('#departments').html(msg);
                    })
                },
                error: function (msg) {
                    $('#form').fadeTo("slow", 1, function () {
                        $('#departments').html(msg);
                    })
                }
            })
        })
    </script>
</body>

</html>