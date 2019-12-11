<?php 
    $response = array( 
        'status' => 0, 
        'message' => 'Form submission failed, please try again.' 
    );
    $data = array();
    $files = array();
    if(isset($_POST['submit'])){
        // Count total files
        $countfiles = count($_FILES['file']['name']);
        
        // Looping all files
        for($i=0;$i<$countfiles;$i++){
            $filename = $_FILES['file']['name'][$i];
            // $data['id']     = $i;
            $data[$i] = array('id' => $i, 'file' => $filename, 'type' => 'image');


            // Upload file
            // move_uploaded_file($_FILES['file']['tmp_name'][$i],'assignments/'.$filename);
            
        }
    } 
    echo json_encode($data);

?>