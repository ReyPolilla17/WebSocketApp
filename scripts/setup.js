let conn;

function initUser(username, password) {
    window.localStorage.userinfo = JSON.stringify({user: username, password: password});

    conn = new ab.Session('wss://192.168.188.135/ws',
        function() {
            console.log('Websocket connection ready');
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );

    $.ajax({
        url: './php/userChats.php',
        dataype: 'json',
        type: 'POST',
        async: true,
        data: `username=${username}&password=${password}`,
        success: successChats,
        error: eFnction
    })

    conn.subscribe(`${username}`, function(topic, data) {
        // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
        console.log('New article published to category "' + topic + '" : ' + data.title);
    });
}

function successChats(result, status, xhr) {
    console.log(JSON.parse(result));
}

function eFnction(xhr, status, error) {
    console.log(xhr, status, error)
}