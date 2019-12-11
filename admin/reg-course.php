<?php
    include('../inc/build.php');
    include('./user.php');

    $title          = trim($_POST['title']);
    $unit           = trim($_POST['unit']);
    $semester       = trim($_POST['semester']);
    $dept           = trim($_POST['dept']);
    $faculty        = trim($_POST['faculty']);
    $identity       = trim($_POST['identity']);
    $level          = trim($_POST['level']);

    $fmsg = "";

    if (empty($title) || $title == "") {
        $fmsg .= "Course Title is required!";
    }
    if (empty($unit) || $unit == "") {
        $fmsg .= "Course Unit is required!";
    }
    if (empty($dept) || $dept == "") {
        $fmsg .= "Department is required!";
    }
    if (empty($level) || $level == "") {
        $fmsg .= "Course Level is required!";
    }
    if (empty($identity) || $identity == "") {
        $fmsg .= "Course Code is required!";
    }

    if($fmsg == "" || empty($fmsg)){
        echo addCourse($title, $identity, $unit, $semester, $faculty, $dept, $level);
    }

    if (isset($fmsg) && !empty($fmsg)) {
?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Err!</strong> <?php echo $fmsg; ?>
        </div>
<?php
    }
?>

<?php
    if (isset($smsg) && !empty($smsg)) {
?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Success!</strong> <?php echo $smsg; ?>
        </div>
<?php
    }
?>