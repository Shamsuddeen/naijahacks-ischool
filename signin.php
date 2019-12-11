<?php
    session_start();
    require('inc/build.php');
    $username   = $_REQUEST['username'];
    $email      = $_REQUEST['username'];
    $password   = $_REQUEST['password'];

    $password   = crypt($password, hash('sha512', '@DSC$0987615423_LMS!go'));
    $password   = hash('sha512', $password);
    $password   = md5($password);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (loginWithEmail($email, $password) == "logged") {
            echo "
                <div class='alert alert-success'>
                    You're Logged In!
                </div>
            ";
            echo '
                <script> window.location="./index.php"; </script>
            ';
        } else {
            echo loginWithEmail($email, $password);
        }
        
    } elseif (is_string($username)) {
        if (loginWithUsername($username, $password) == "logged") {
            echo "
                <div class='alert alert-success'>
                    You're Logged In!
                </div>
            ";
            echo '
                <script> window.location="./index.php"; </script>
            ';
        } else {
            echo loginWithUsername($username, $password);
        }
    }else{
        echo "
            <div class='alert alert-danger'>
                Invalid Username/Email.
            </div>
        ";
    }
?>