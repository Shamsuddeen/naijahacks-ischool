<?php
    include('../inc/build.php');
    $faculty = $_POST['faculty'];

    $depts = getDepartments($faculty);
    foreach ($depts as $row){
?>
        <option value="<?php echo $row->dept_id; ?>"><?php echo $row->dept_name; ?></option>
<?php 
    }
?>