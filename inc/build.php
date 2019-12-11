<?php
    require('connect.php');

    function info($data){
        global $pdo;
        $getInfo    = "SELECT $data FROM `settings`";
        $stmt       = $pdo->prepare($getInfo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            switch ($data) {
                case $data:
                    // echo "DSC::LMS";
                    foreach ($result as $res) {
                        echo $res->$data;
                    }
                    break;
                default:
                    echo "Undefined ";
                break;
            }
        }else {
            echo "Undefined Data";
        }
    }

    function loginWithEmail($email, $password){
        global $pdo;
        $getUser    = "SELECT * FROM `staffs` WHERE `stf_email` = :email AND `stf_password` = :password";
        $stmt       = $pdo->prepare($getUser);
        $stmt->execute(['email' => $email, 'password' => $password]);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($stmt->rowCount() > 0) {
                while ($result = $stmt->fetch()) {
                    $email      = $result->stf_email;
                    $username   = $result->staff_id;
                    $phone      = $result->stf_phone;
                    $status     = $result->status;
                    $stf_id     = $result->stf_id;
                }
    
                // Check if User account is verified
                if ($status == 0) {
                    $fmsg = "
                        <div class='alert alert-danger'>
                            Account not verified. Check your Email to verify.
                        </div>
                    ";
                }else {
                    // If account is verified
                    // Check if User request for password change

                    $_SESSION['staff_id']   = $username;
                    $_SESSION['stf_email']      = $email;
                    $_SESSION['stf_id']    = $stf_id;

                    $smsg = "logged";

                    return $smsg;
                    header("Location: ./index.php");
                }
    
                // If username,email/password is wrong
            } else {
                $fmsg = "
                    <div class='alert alert-danger'>
                        Something is wrong with your Email/Password. User not Found!
                    </div>
                ";
                return $fmsg;
            }
        }else {
            $fmsg = "
                <div class='alert alert-danger'>
                    Invalid Email address.
                </div>
            ";
            return $fmsg;
        }
    }

    function loginWithUsername($username, $password){
        global $pdo;
        $getUser    = "SELECT * FROM `staffs` WHERE `staff_id` = :username AND `stf_password` = :password";
        $stmt       = $pdo->prepare($getUser);
        $stmt->execute(['username' => $username, 'password' => $password]);
        if (is_string($username)) {
            if ($stmt->rowCount() > 0) {
                while ($result = $stmt->fetch()) {
                    $email      = $result->stf_email;
                    $username   = $result->staff_id;
                    $phone      = $result->stf_phone;
                    $status     = $result->status;
                    $stf_id     = $result->stf_id;
                }
    
                // Check if User account is verified
                if ($status == 0) {
                    $fmsg = "
                        <div class='alert alert-danger'>
                            Account not verified. Check your Email to verify.
                        </div>
                    ";
                }else {
                    // If account is verified
                    // Check if User request for password change
                    $_SESSION['staff_id']   = $username;
                    $_SESSION['stf_email']      = $email;
                    $_SESSION['stf_id']    = $stf_id;
                    
                    $smsg = "logged";
                    return $smsg;
                    header("Location: ./index.php");
                }
    
                // If username,email/password is wrong
            } else {
                $fmsg = "
                    <div class='alert alert-danger'>
                        Something is wrong with your Username/Password. User not Found!
                    </div>
                ";
                return $fmsg;
            }
        }else {
            $fmsg = "
                <div class='alert alert-danger'>
                    Invalid Useraname.
                </div>
            ";
            return $fmsg;
        }
    }

    function allBooks(){
        global $pdo;
        $query = "SELECT * FROM `books` ORDER BY book_title ASC";
        $resQuery = $pdo->prepare($query);
        $resQuery->execute([]);
        $data = $resQuery->fetchAll();
    
        foreach ($data as $datas) {
            $booktitle   =   $datas->book_title;
            $bookdesc    =   $datas->book_desc;
            $thumb       =   $datas->thumb;
            $author      =   $datas->author;
            $edition     =   $datas->edition;
            $publishers  =   $datas->publishers;
            $year        =   $datas->pub_year;
            $isbn        =   $datas->isbn;
            $quantity    =   $datas->quantity;
            $bookId      =   $datas->book_id;   
    
            echo '
                <div class="col-md-55">
                    <div class="thumbnail">
                        <div class="image view view-first">
                                <img style="width: 100%; display: block;" src="'.$thumb.'" alt="image" />
                            <div class="mask">
                                <p>Your Text</p>
                                <div class="tools tools-bottom">
                                    <a href="#"><i class="fa fa-link"></i></a>
                                    <a href="#"><i class="fa fa-pencil"></i></a>
                                    <a href="#"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="caption">
                            <p><strong><a type="button" data-toggle="modal" data-target=".bs-example-modal-sm'.$bookId.'">'.$booktitle.'</a></strong></p> 
                        </div>
                    </div>
                </div>
    
              
                <div class="modal fade bs-example-modal-sm'.$bookId.'" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                            </div>
                            <div class="modal-body">
                                <h4><i class="fa fa-book"></i>'.$booktitle.'</h4> <hr><br>
                                <small><i class="fa fa-book"></i> Book Description </small>
                                <p>'.$bookdesc.'</p> <hr>
                                <small> <i class="fa fa-user"></i> Book Author:</small> '.$author.'<br>
                                <small> <i class="fa fa-institution"></i> Book Publishers:</small> '.$publishers.'<br>
                                <small> <i class="fa fa-user"></i> Book ISBN:</small> '.$isbn.'<br>
                                <small> <i class="fa fa-calender"></i> Book Year:</small> '.$year.'<br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <a href="book-view.php?id='.$bookId.'" class="btn btn-primary">View</a>
                                <a href="add-to-cart.php?id='.$bookId.'" class="btn btn-primary">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    }

    function getFaculties(Type $var = null){
        global $pdo;

        $getFaculties   = "SELECT * FROM `faculties` ";
        $stmt           = $pdo->prepare($getFaculties);
        $stmt->execute();

        if($faculties = $stmt->fetchAll()){
            return $faculties;
        }else{
            echo "Error ";
        }
    }

    function getDepartments($faculty = null){
        global $pdo;

        $getDepts   = "SELECT * FROM `departments` ";
        $stmt       = $pdo->prepare($getDepts);
        if (isset($faculty) && $faculty != NULL) {
            $getDepts   .= "WHERE `faculty` = :faculty";
            $stmt       = $pdo->prepare($getDepts);
            $stmt->execute(['faculty' => $faculty]);
        } else {
            $stmt->execute();
        }

        if($departments = $stmt->fetchAll()){
            return $departments;
        }else{
            echo "Error ";
        }
    }

    function addCourse($courseTitle, $courseCode, $courseUnit, $courseSemester, $faculty, $department, $courseLevel){
        global $pdo;

        $getCourse  = "SELECT * FROM `courses` WHERE `course_code` = :course_code";
        $stmt       = $pdo->prepare($getCourse);
        $stmt->execute(['course_code' => $courseCode]);
        if ($stmt->rowCount() > 0) {
            $fmsg = '<div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        This Course Code Already Exist!
                    </div>';

            return $fmsg;
        } else {
            $addCourse  = "INSERT INTO `courses`(`course_code`, `course_title`, `faculty`, `department`, `semester`, `unit`, `level`) 
                                        VALUES ('$courseCode', '$courseTitle', '$faculty', '$department', '$courseSemester', '$courseUnit', '$courseLevel')";
            $stmt       = $pdo->prepare($addCourse);
            if ($stmt->execute()) {
                $smsg = '<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Course registered successfully!
                        </div>';

                return $smsg;
            } else {
                $fmsg = '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Cannot register course
                        </div>';

                return $fmsg;
            }   
        }
    }

    function getCourses($department = null){
        global $pdo;
        $getCourses = "SELECT * FROM `courses` c INNER JOIN `departments` d ON c.department = d.dept_id";
        $stmt       = $pdo->prepare($getCourses);
        if (isset($department) && $department != NULL) {
            $getCourses .= "WHERE `dapartment` = :dapartment";
            $stmt       = $pdo->prepare($getCourses);
            $stmt->execute(['department' => $department]);
        } else {
            $stmt->execute();
        }

        if($courses = $stmt->fetchAll()){
            return $courses;
        }else{
            echo "Error ";
        }
    }

    function getCoursesByStaff($staff){
        global $pdo;
        $getCourses = "SELECT * FROM `courses` WHERE `course_master` = :staff";
        $stmt       = $pdo->prepare($getCourses);
        $stmt->execute(['staff' => $staff]);

        if($courses = $stmt->fetchAll()){
            return $courses;
        }else{
            echo "Error ";
        }
    }

    function addMaterial($name, $file, $type, $course, $stf_id){
        global $pdo;
        $addMaterial = "INSERT INTO `course_materials`(`file_name`, `file_loc`, `file_type`, `course_id`) 
                                                VALUES ('$name','$file', '$type', '$course')";
        $stmt       = $pdo->prepare($addMaterial);
        return $stmt->execute();
    }

    function getMaterials($staff = null){
        global $pdo;
        $getMaterials = "SELECT * FROM `course_materials` m INNER JOIN `courses` c ON m.course_id = c.course_id INNER JOIN `departments` d ON c.department = d.dept_id";
        $stmt       = $pdo->prepare($getMaterials);
        if (isset($staff) && $staff != NULL) {
            $getMaterials .= " WHERE c.course_master = :staff";
            $stmt       = $pdo->prepare($getMaterials);
            $stmt->execute(['staff' => $staff]);
        } else {
            $stmt->execute();
        }

        if($materials = $stmt->fetchAll()){
            return $materials;
        }else{
            echo "Error ";
        }
    }


    function getMaterial($material){
        global $pdo;
        $getMaterial = "SELECT * FROM `course_materials` m INNER JOIN `courses` c ON m.course_id = c.course_id INNER JOIN `departments` d ON c.department = d.dept_id WHERE m.mat_id = :material";
        $stmt       = $pdo->prepare($getMaterial);
        $stmt->execute(['material' => $material]);

        if($material = $stmt->fetchAll()){
            return $material;
        }else{
            echo "Error ";
        }
    }

    function addAssignment($name, $content, $files, $course, $stf_id){
        global $pdo;
        $addAssignment  = "INSERT INTO `assignments`(`assign_title`, `assign_body`, `files`, `course_id`, `staff_id`) 
                                        VALUES ('$name', '$content', '$files', '$course', '$stf_id')";
        $stmt           = $pdo->prepare($addAssignment);

        $getStudents    = "SELECT * FROM `students`";
        $stmt1           = $pdo->prepare($getStudents);
        $stmt1->execute(['department' => $department]);
        $students       = $stmt1->fetchAll();

        foreach ($students as $student) {
            $getCourses     = "SELECT * FROM `courses` WHERE `course_id` = :course";
            $stmt2          = $pdo->prepare($getCourses);
            $stmt2->execute(['course' => $course]);
    
            $courses = $stmt2->fetchAll();
            foreach ($courses as $key) {
                $courseCode = $key->course_code;
            }

            require_once '../vendor/autoload.php';
            $basic  = new \Nexmo\Client\Credentials\Basic('ca333ae9', 'ISijwDzaA0vmknEv');
            $client = new \Nexmo\Client($basic);
            try {
                $message = $client->message()->send([
                    'to' => $student->phone,
                    'from' => 'iSchool',
                    'text' => $courseCode.' Lectures start in '.$time.' hour(s)'
                ]);
                $response = $message->getResponseData();
                if($response['messages'][0]['status'] == 0) {
                    return $msg = "The message was sent successfully\n";
                } else {
                    return $msg = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
                }
            } catch (Exception $e) {
                return $msg = "The message was not sent. Error: " . $e->getMessage() . "\n";
            }
        }
        return $stmt->execute();
    }

    function getAssignments($staff = null){
        global $pdo;
        $getMaterials = "SELECT * FROM `assignments` m INNER JOIN `courses` c ON m.course_id = c.course_id INNER JOIN `departments` d ON c.department = d.dept_id";
        $stmt       = $pdo->prepare($getMaterials);
        if (isset($staff) && $staff != NULL) {
            $getMaterials .= " WHERE c.course_master = :staff";
            $stmt       = $pdo->prepare($getMaterials);
            $stmt->execute(['staff' => $staff]);
        } else {
            $stmt->execute();
        }

        if($materials = $stmt->fetchAll()){
            return $materials;
        }else{
            echo "Error ";
        }
    }

    function getAssignment($assignment){
        global $pdo;
        $getAssignment = "SELECT * FROM `assignments` a INNER JOIN `courses` c ON a.course_id = c.course_id INNER JOIN `departments` d ON c.department = d.dept_id WHERE a.assignment_id = :assignment";
        $stmt       = $pdo->prepare($getAssignment);
        $stmt->execute(['assignment' => $assignment]);

        if($assignment = $stmt->fetchAll()){
            return $assignment;
        }else{
            echo "Error ";
        }
    }

    function addSubmission($content, $files, $course, $assignment, $student){
        global $pdo;
        $addSubmission  = "INSERT INTO `assignment_submitted`(`student_id`, `submit_content`, `sub_files`, `course_id`, `assignment_id`) 
                                                        VALUES ('$student', '$content', '$files', '$course', '$assignment')";
        $stmt           = $pdo->prepare($addSubmission);
        return $stmt->execute();
    }

    function getSubmissions($assignment){
        global $pdo;
        $getAssignment = "SELECT * FROM `assignment_submitted` a 
                            INNER JOIN `courses` c ON a.course_id = c.course_id 
                            INNER JOIN `assignments` d ON d.assignment_id = d.assignment_id 
                            INNER JOIN `students` s ON s.student_id = a.student_id 
                            INNER JOIN `departments` r ON r.dept_id = c.department 
                            WHERE a.assignment_id = :assignment";
        $stmt       = $pdo->prepare($getAssignment);
        $stmt->execute(['assignment' => $assignment]);

        if($assignment = $stmt->fetchAll()){
            return $assignment;
        }else{
            echo "Error ";
        }
    }

    function countSubmissions($assignment){
        global $pdo;
        $getAssignment  = "SELECT * FROM `assignment_submitted` WHERE assignment_id = :assignment";
        $stmt           = $pdo->prepare($getAssignment);
        $stmt->execute(['assignment' => $assignment]);
        if($assignment = $stmt->rowCount()){
            echo $assignment;
        }else{
            echo "Error ";
        }
    }

    function getSubmission($assignment, $student){
        global $pdo;
        $getAssignment = "SELECT * FROM `assignment_submitted` a INNER JOIN `courses` c ON a.course_id = c.course_id INNER JOIN `assignments` e ON a.assignment_id = e.assignment_id 
                            INNER JOIN `students` s ON a.student_id = s.student_id INNER JOIN `departments` d ON d.dept_id = s.department WHERE a.submit_id = :submitted";
        $stmt       = $pdo->prepare($getAssignment);
        $stmt->execute(['submitted' => $assignment]);

        if($assignment = $stmt->fetchAll()){
            return $assignment;
        }else{
            echo "Error ";
        }
    }

    function getSubmittedAssignment($assignment, $student){
        global $pdo;
        $getAssignment = "SELECT * FROM `assignment_submitted` a INNER JOIN `courses` c ON a.course_id = c.course_id INNER JOIN `assignments` d ON d.assignment_id = d.assignment_id WHERE a.submit_id = :submitted AND `student_id` = :student";
        $stmt       = $pdo->prepare($getAssignment);
        $stmt->execute(['submitted' => $assignment, 'student' => $student]);

        if($stmt->rowCount() > 0){
            $assignment = $stmt->fetchAll();
            return $assignment;
        }else{
            echo 0;
        }
    }

    function createLectureClass($sessionId, $tokenId, $department, $course, $time){
        global $pdo;
        if($time == 0){
            $started = TRUE;
            $addClass   = "INSERT INTO `class_rooms`(`session_id`, `token`, `department`, `course`, `started`) 
                                        VALUES ('$sessionId', '$tokenId', '$department', '$course', '$started')";
        }else{
            $started    = FALSE;
            $addClass   = "INSERT INTO `class_rooms`(`session_id`, `token`, `department`, `course`, `started`, `start_time`) 
                                VALUES ('$sessionId', '$tokenId', '$department', '$course', '$started', NOW() + INTERVAL $time HOUR)";
        }

        $stmt       = $pdo->prepare($addClass);
        if($stmt->execute()){
            echo "Class Added successfully!";
        }else{
            echo "Error: ".$pdo->error;
        }
    }

    function notifyStudentsLecture($department, $course, $time = null){
        global $pdo;
        $getStudents    = "SELECT * FROM `students` WHERE `department` = :department";
        $stmt           = $pdo->prepare($getStudents);
        $stmt->execute(['department' => $department]);
        $students       = $stmt->fetchAll();

        $getCourses     = "SELECT * FROM `courses` WHERE `department` = :department AND `course_id` = :course";
        $stmt2          = $pdo->prepare($getCourses);
        $stmt2->execute(['department' => $department, 'course' => $course]);

        $courses = $stmt2->fetchAll();
        foreach ($courses as $key) {
            $courseCode = $key->course_code;
        }

        foreach ($students as $student) {
            // require_once __DIR__ . '/../config.php';
            require_once '../vendor/autoload.php';
            $basic  = new \Nexmo\Client\Credentials\Basic('ca333ae9', 'ISijwDzaA0vmknEv');
            $client = new \Nexmo\Client($basic);
            try {
                $message = $client->message()->send([
                    'to' => $student->phone,
                    'from' => 'iSchool',
                    'text' => $courseCode.' Lectures start in '.$time.' hour(s)'
                ]);
                $response = $message->getResponseData();
                if($response['messages'][0]['status'] == 0) {
                    return $msg = "The message was sent successfully\n";
                } else {
                    return $msg = "The message failed with status: " . $response['messages'][0]['status'] . "\n";
                }
            } catch (Exception $e) {
                return $msg = "The message was not sent. Error: " . $e->getMessage() . "\n";
            }
        }
    }

    function getLiveLectures($department, $level){
        global $pdo;
        $getCourses = "SELECT * FROM `courses` WHERE `department` = :department AND `level` = :level";
        $stmt       = $pdo->prepare($getCourses);
        $stmt->execute(['department' => $department, 'level' => $level]);

        if($courses = $stmt->fetchAll()){
            foreach ($courses as $key) {
                $course         = $key->course_id;
                $getLectures    = "SELECT * FROM `class_rooms` l INNER JOIN `courses` c ON l.course = c.course_id WHERE l.department = :department AND l.course = :course ORDER BY l.class_id DESC";
                $stmt           = $pdo->prepare($getLectures);
                $stmt->execute(['department' => $department, 'course' => $course]);
                $lectures = $stmt->fetchAll();
                return $lectures;
            }
        }else{
            echo "Error ";
        }
    }

    function getLectures($staff){
        global $pdo;
        $getCourses = "SELECT * FROM `courses` WHERE `course_master` = :staff";
        $stmt       = $pdo->prepare($getCourses);
        $stmt->execute(['staff' => $staff]);

        if($courses = $stmt->fetchAll()){
            foreach ($courses as $key) {
                $course         = $key->course_id;
                $getLectures    = "SELECT * FROM `class_rooms` l INNER JOIN `courses` c ON l.course = c.course_id WHERE l.course = :course ORDER BY l.class_id DESC";
                $stmt           = $pdo->prepare($getLectures);
                $stmt->execute(['course' => $course]);
                $lectures = $stmt->fetchAll();
                return $lectures;
            }
        }else{
            echo "Error ";
        }
    }

    function setArchive($session, $archive){
        global $pdo;
        $setArchive = "UPDATE `class_rooms` SET `archive_id`= :archive WHERE `session_id` = :session";
        $stmt       = $pdo->prepare($setArchive);
        return $stmt->execute(['archive' => $archive, 'session' => $session]);

    }

    function doneClass($class){
        global $pdo;
        $setExpired = "UPDATE `class_rooms` SET `expired` = :expired WHERE `class_id` = :class";
        $stmt       = $pdo->prepare($setExpired);
        return $stmt->execute(['expired' => 1, 'class' => $class]);

    }

    function getClass($class){
        global $pdo;
        $getLectures    = "SELECT * FROM `class_rooms` WHERE `class_id` = :class";
        $stmt           = $pdo->prepare($getLectures);
        $stmt->execute(['class' => $class]);
        $lectures = $stmt->fetchAll();

        return $lectures;
    }

    function registerUser($email, $id_number, $username, $password){
        global $pdo;

        $getID = "SELECT * FROM `students` WHERE `id_number` = :id_number";
    }

    function purifyFile($file){
        $string         = str_replace(' ', '-', $file); // Replaces all spaces with hyphens.
        $string2        = preg_replace('/\s+/', '', $string); // Removes special chars.
        $fileName       = strtolower(preg_replace('/-+/', '-', $string2)); // Replaces multiple hyphens with

        return $fileName;
    }

    // Time Ago for Human Readavle
    function timeElapsed($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach($string as $k => & $v) {
            if ($diff->$k) {
                $v = $diff->$k.
                ' '.$v.($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string).
        ' ago': 'just now';
    }

    function isLoggedIn(){
        if(!empty($_SESSION['id_no'])){
        return true;
        } else{
            header ("Location: login.php");
        }
    }

    //check whether the user is loggedIn
    function login(){
        global $pdo;
        if(isset($_POST['submit'])){
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $password = md5($password);
            if(isset($username) && isset($password)){
                $getUser = "SELECT * FROM `students` WHERE `id_number` = :id_no AND `password` =:password";
                $resUser = $pdo->prepare($getUser);
                $resUser->execute(['id_no'=>$username, 'password'=>$password]);
                    if ($resUser->rowCount() > 0) {
                        $data = $resUser->fetchAll();
                        foreach ($data as $user) {
                            $id_no = $user->id_number;
                            $id  = $user->student_id;
                        }
                        $_SESSION['id_no']  = $id_no;
                        $_SESSION['user_id']  = $id;
                        echo '<script> window.location="../student/index.php"; </script>';
                    } else {
                        $fmsg = "Invalid User Credentials";
                    }
            }
        }
    }
