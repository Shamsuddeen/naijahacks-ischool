<?php 
    include('../inc/build.php');
    include('./user.php');
    require_once("../vendor/autoload.php"); //Install first by executing: composer require SociallyDev/Spaces-API in your project's directory.

    $key        = "P45VYWIUUE4KMVXVRLH6";
    $secret     = "ouv2cxiAZLK7qrai5/2Ah52HySKPbvfaLwy9ncL/tMU";
    $space_name = "iSchool";
    $region     = "nyc3";
    
    $space = new SpacesConnect($key, $secret, $space_name, $region);

    $uploadDir = '../uploads/'; 
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    );
 
    // If form is submitted 
    if(isset($_POST['title']) || isset($_POST['course']) || isset($_POST['file'])){ 
        // Get the submitted form data 
        $name   = $_POST['title']; 
        $course = $_POST['course']; 
        
        // Check whether submitted data is not empty 
        if(!empty($name) && !empty($course)){
            // Validate course 
            $uploadStatus = 1; 
             
            // Upload file 
            $uploadedFile = ''; 
            if(!empty($_FILES["material"]["name"])){ 
                 
                // File path config 
                // $fileName       = basename($_FILES["material"]["name"]); 

                $fileName       = purifyFile($_FILES["material"]["name"]);
                $targetFilePath = $uploadDir . $fileName; 
                $fileType       = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                // Allow certain file formats 
                $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'mp3', 'mp4', 'webm'); 
                if(in_array($fileType, $allowTypes)){ 
                    // Don't start any path with a forward slash, or it will give "SignatureDoesNotMatch" exception
                    $path_to_file = $_FILES["material"]["tmp_name"];

                    $space->UploadFile($path_to_file, "public");
                    // Upload file to the server 
                    if(move_uploaded_file($_FILES["material"]["tmp_name"], $targetFilePath)){ 
                        $uploadedFile   = $fileName;
                    }else{ 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, there was an error uploading your file.'; 
                    } 
                }else{ 
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.'; 
                } 
            } 
             
            if($uploadStatus == 1){ 
                $targetFilePath = "uploads/". $fileName;
                // Insert form data in the database 
                $insert = addMaterial($name, $targetFilePath, $fileType, $course, $stf_id);
                if($insert){ 
                    $response['status'] = 1; 
                    $response['message'] = 'Form data submitted successfully!'; 
                } 
            } 

        }else{ 
            $response['message'] = 'Please fill all the mandatory fields (name and course).'; 
        } 
    } 
    
    // Return response 
    echo json_encode($response);