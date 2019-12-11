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
        }
    }  
?>

<html>
<head>
    <title> myClass </title>
    <link href="css/app.css" rel="stylesheet" type="text/css">
    <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
    <style>
        body, html {
            background-color: gray;
            height: 100%;
        }

        #videos {
            position: relative;
            width: 100%;
            height: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        #subscriber {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
        }

        #publisher {
            position: absolute;
            width: 360px;
            height: 240px;
            bottom: 10px;
            left: 10px;
            z-index: 100;
            border: 3px solid white;
            border-radius: 3px;
        }
    </style>
</head>
<body>

    <div id="videos">
        <div id="subscriber"></div>
        <div id="publisher"></div>
        <a href="finish.php?ref=<?php echo $ref; ?>" id='finished'  onClick="finished();">Finish Class</a>
    </div>
    <!-- <script type="text/javascript" src="app.js"></script> -->
    <script>
        // replace these values with those generated in your TokBox Account
        var apiKey = '46472052';
        var sessionId = '<?php echo $sessionID; ?>';
        var token = '<?php echo $tokenID; ?>';

        // (optional) add server code here
        initializeSession();

        // Handling all of our errors here by alerting them
        function handleError(error) {
            if (error) {
                alert(error.message);
            }
        }

        function initializeSession() {
            var session = OT.initSession(apiKey, sessionId);

            // Subscribe to a newly created stream

            // Create a publisher
            var publisher = OT.initPublisher('publisher', {
                insertMode: 'append',
                width: '100%',
                height: '100%'
            }, handleError);

            // Connect to the session
            session.connect(token, function (error) {
                // If the connection is successful, publish to the session
                if (error) {
                    handleError(error);
                } else {
                    session.publish(publisher, handleError);
                }
            });
        }

        function finished(){
            window.location="finish.php?ref=<?php echo $ref; ?>";
        }

        session.on('streamCreated', function (event) {
            session.subscribe(event.stream, 'subscriber', {
                insertMode: 'append',
                width: '100%',
                height: '100%'
            }, handleError);
        });
        
        session.on("sessionDisconnected", function(event) {
            alert("The session disconnected. " + event.reason);
        });
    </script>
    <?php
        use OpenTok\OpenTok;

        $opentok = new OpenTok($apiKey, $apiSecret);

        use OpenTok\MediaMode;
        use OpenTok\ArchiveMode;
        use OpenTok\Session;
        use OpenTok\Role;
        
        $archive = $opentok->startArchive($sessionID);

        // Store this archiveId in the database for later use
        $archiveId = $archive->id;
        setArchive($sessionID, $archiveId);
    ?>
</body>
</html>