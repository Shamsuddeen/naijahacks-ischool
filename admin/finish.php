<?php
    include('../inc/build.php');
    include('./user.php');
    require "../vendor/autoload.php";
    $apiKey     = "46472052";
    $apiSecret  = "94f02730f0dfc50d5696e81d4d96ead0e038b9d5";

    $ref        = trim($_GET['ref']);
    $lectures   = getClass($ref);
    
    foreach ($lectures as $lecture) {
        if($lecture->expired == 1){
            header("Location: ./msg=Expired");
        }else{
            $sessionID  = $lecture->session_id;
            $tokenID    = $lecture->token;
            $archiveId  = $lecture->archive_id;
        }
    }

    doneClass($ref);

    use OpenTok\OpenTok;

    $opentok = new OpenTok($apiKey, $apiSecret);

    use OpenTok\MediaMode;
    use OpenTok\ArchiveMode;
    use OpenTok\Session;
    use OpenTok\Role;
        
    $archive = $opentok->startArchive($sessionID);

    // Stop an Archive from an archiveId (fetched from database)
    $opentok->stopArchive($archiveId);
    // Stop an Archive from an Archive instance (returned from startArchive)
    $archive->stop();

    header("Location: ./msg=Expired");
