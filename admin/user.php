<?php
    session_start();
    require('../inc/connect.php');
    if (isset($_SESSION['staff_id']) && isset($_SESSION['stf_email'])) {
        $staff_id   = $_SESSION['staff_id'];
        $email      = $_SESSION['stf_email'];

        $getUser    = "SELECT * FROM `staffs` WHERE `stf_email` = :email AND `staff_id` = :staff";
        $stmt       = $pdo->prepare($getUser);
        $stmt->execute(['email' => $email, 'staff' => $staff_id]);
        
        if ($stmt->rowCount() > 0) {
            while ($result = $stmt->fetch()) {
                $email          = $result->stf_email;
                $username       = $result->staff_id;
                $phone          = $result->stf_phone;
                $first_name     = $result->stf_first_name;
                $last_name     = $result->stf_last_name;
                $status         = $result->status;
                $stf_id         = $result->stf_id;
            }
        }else {
            header("Location: logout.php");           
        }

    }else {
        header("Location: login.html");
    }
?>