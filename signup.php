<?php
    session_start();

    include('inc/build.php');
    $email      = trim($_REQUEST['email']);
    $username   = trim($_REQUEST['username']);
    $id_number  = trim($_REQUEST['id_number']);

    // Senitize Username
    $string     = str_replace(' ', '-', $username); // Replaces all spaces with hyphens.
    $string2    = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    $username   = strtolower(preg_replace('/-+/', '-', $string2)); // Replaces multiple hyphens with single one.

    $password   = $_REQUEST['password'];
    $password   = crypt($password, hash('sha512', '@DSC$0987615423_LMS!go'));
    $password   = hash('sha512', $password);
    $password   = md5($password);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (strlen($username) > 25) {
            $fmsg = "
                <div class='alert alert-danger'>
                    Username must be less than 24 character
                </div>
            ";
        } else {
            echo registerUser($email, $id_number, $username, $password);
        }
    }else {
        $fmsg = "
            <div class='alert alert-danger'>
                Invalid Email address.
            </div>
        ";
    }

?>