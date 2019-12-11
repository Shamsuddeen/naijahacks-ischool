<?php
    session_start();
    // require('../inc/connect.php');
    include('../inc/build.php');
    $id_no    =   $_SESSION['id_no'];
    $query    =   "SELECT * FROM students WHERE id_number =:id_no";
    $resQuery =   $pdo->prepare($query);
    $resQuery->execute(['id_no'=>$id_no]);
    $students    = $resQuery->fetchAll();
    foreach ($students as $student) {
        $first_name = $student->first_name;
        $last_name  = $student->last_name;
        $passport   = $student->profile_pic;
        $uLevel     = $student->level;
        $department = $student->department;
        $student_id = $student->student_id;
    }
  
?>