<!DOCTYPE html>

<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('63324601fe9aaebda8c5', {
            cluster: 'ap2',
            forceTLS: true
        });

        var channel = pusher.subscribe('new-user');
        channel.bind('NewUserHasRegisteredEvent', function(data) {
            console.log(data);
            alert(JSON.stringify(data));
        });
    </script>
</head>

<body>
    <h1>Pusher Test</h1>
    <p>
        Try publishing an event to channel <code>my-channel</code>
        with event name <code>my-event</code>.
    </p>
</body>