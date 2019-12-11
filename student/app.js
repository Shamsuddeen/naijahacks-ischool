// replace these values with those generated in your TokBox Account
var apiKey = '46472052';
var sessionId = '1_MX40NjQ3MjA1Mn5-MTU3NTQ2NDg3ODg3N35iUUZ5NUs0c1NsNjNCWjYvUDg2RWRHZGN-fg';
var token =
    'T1==cGFydG5lcl9pZD00NjQ3MjA1MiZzaWc9YWY2ZWQwOThhMGRiNWRhNzkwODg1ZWNhMDg5ZGM0YzgyNDc2Zjk5MTpzZXNzaW9uX2lkPTFfTVg0ME5qUTNNakExTW41LU1UVTNOVFEyTkRnM09EZzNOMzVpVVVaNU5VczBjMU5zTmpOQ1dqWXZVRGcyUldSSFpHTi1mZyZjcmVhdGVfdGltZT0xNTc1NDY0ODc5JnJvbGU9bW9kZXJhdG9yJm5vbmNlPTE1NzU0NjQ4NzkuMDY4OTkyMjU3ODU4MyZleHBpcmVfdGltZT0xNTc2MDY5Njc5JmNvbm5lY3Rpb25fZGF0YT1uYW1lJTNEU2hhbXN1ZGRlZW4maW5pdGlhbF9sYXlvdXRfY2xhc3NfbGlzdD1mb2N1cw==';

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

session.on('streamCreated', function (event) {
    session.subscribe(event.stream, 'subscriber', {
        insertMode: 'append',
        width: '100%',
        height: '100%'
    }, handleError);
});