<?php 
    include('../inc/build.php');
    include('./user.php');

    $uploadDir = '../uploads/assignments/'; 
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    );
    $data = array();

    // If form is submitted 
    if(isset($_POST['title']) || isset($_POST['course']) || isset($_POST['file'])){ 
        // Get the submitted form data 
        $name       = trim($_POST['title']);
        $course     = trim($_POST['course']);
        $content    = trim($_POST['content']);

        $countfiles = count($_FILES['assignment']['name']);

        // Check whether submitted data is not empty 
        if(!empty($name) && !empty($course)){
            // Validate course 
            $uploadStatus = 1; 
             
            // Upload file 
            $uploadedFile = '';
            // Looping all files
            for($i=0;$i<$countfiles;$i++){
                if(!empty($_FILES["assignment"]["name"][$i])){ 
                    
                    // File path config 
                    // $fileName       = basename($_FILES["assignment"]["name"]); 

                    $fileName       = purifyFile($_FILES["assignment"]["name"][$i]);
                    $targetFilePath = $uploadDir . $fileName; 
                    $fileType       = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
                    // Allow certain file formats 
                    $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'mp3', 'mp4', 'webm'); 
                    if(in_array($fileType, $allowTypes)){ 
                        // Upload file to the server 
                        if(move_uploaded_file($_FILES["assignment"]["tmp_name"][$i], $targetFilePath)){ 
                            $uploadedFile   = $fileName;
                            $targetFilePath = "uploads/assignments/". $fileName;
                            $data[$i] = array('id' => $i, 'file' => $targetFilePath, 'type' => $fileType);
                        }else{ 
                            $uploadStatus = 0; 
                            $response['message'] = 'Sorry, there was an error uploading your file.'; 
                        }
                    }else{ 
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.'; 
                    } 
                } 
            }

            $files = json_encode($data);

            if($uploadStatus == 1){ 
                // Insert form data in the database 
                // $name, $content, $files, $course, $stf_id
                $insert = addAssignment($name, $content, $files, $course, $stf_id);
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