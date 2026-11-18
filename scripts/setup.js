let conn;

function initUser(username, password) {
    window.localStorage.userinfo = JSON.stringify({user: username, password: password});

    conn = new ab.Session('wss://192.168.188.135/ws',
        function() {
            $.ajax({
                url: './php/userChats.php',
                dataype: 'json',
                type: 'POST',
                async: true,
                data: `username=${username}&password=${password}`,
                success: successChats,
                error: eFnction
            });

            console.log('Websocket connection ready');
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );

}

function successChats(result, status, xhr) {
    try {
        const res = JSON.parse(result);

        conn.subscribe(`u_${res.user}`, function(topic, data) {
            // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
            console.log('New article published to category "' + topic + '" : ' + data);
        });

        res.chats.forEach(el => {
           conn.subscribe(`c_${el}`, function(topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                console.log('New article published to category "' + topic + '" : ' + JSON.stringify(data));
            });
        })
    } catch(e) {
        console.error(e, result);
    }
}