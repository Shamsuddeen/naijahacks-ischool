<?php
    include('../inc/build.php');
    include('./user.php');
    // echo $password   = 'shamsomacy';

    // $password   = crypt($password, hash('sha512', '@DSC$0987615423_LMS!go'));
    // $password   = hash('sha512', $password);

    // echo $password;
    // $assignments    = getAssignment(1);
    // foreach ($assignments as $res) {
    //     $results    = json_decode($res->files, true);
    //     foreach ($results as $key) {
    //         echo $key['file'].' - '. $key['type'] ."<br>";
    //     }
    //     // print_r($res->files);
    //     // print_r($res);
    // }

    // require_once '../vendor/autoload.php';
    // $basic  = new \Nexmo\Client\Credentials\Basic('ca333ae9', 'ISijwDzaA0vmknEv');
    // $client = new \Nexmo\Client($basic);
    // try {
    //     $message = $client->message()->send([
    //         'to' => '+2347033870337',
    //         'from' => 'iSchool',
    //         'text' => ' Lectures start in 1 hour'
    //     ]);
    //     $response = $message->getResponseData();
    //     if($response['messages'][0]['status'] == 0) {
    //         echo "The message was sent successfully\n";
    //     } else {
    //         echo "The message failed with status: " . $response['messages'][0]['status'] . "\n";
    //     }
    // } catch (Exception $e) {
    //     echo "The message was not sent. Error: " . $e->getMessage() . "\n";
 
    require_once("../vendor/autoload.php"); //Install first by executing: composer require SociallyDev/Spaces-API in your project's directory.

    $key        = "P45VYWIUUE4KMVXVRLH6";
    $secret     = "ouv2cxiAZLK7qrai5/2Ah52HySKPbvfaLwy9ncL/tMU";
    $space_name = "ischool";
    $region     = "sfo2";
    
    $space = new SpacesConnect($key, $secret, $space_name, $region);

    if($_POST){
        try {
            // $space->CreateSpace("dev");
            $path_to_file = $_FILES["file"]["tmp_name"];
            $space->UploadFile($path_to_file, "public");
        } catch (\SpacesAPIException $e) {
            $error = $e->GetError();
        
            //Error management code.
            echo "<pre>";
            print_r($error);
            /*
            EG:
            Array (
            [message] => Bucket already exists
            [code] => BucketAlreadyExists
            [type] => client
            [http_code] => 409
            )
            */
        }
    }
    
?>

    <form method='post' action='#' enctype='multipart/form-data'>
        <input type="file" name="file" id="file">

        <input type='submit' name='submit' value='Upload'>
    </form>