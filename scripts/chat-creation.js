function openChatCreation() {
    const userInfo = JSON.parse(window.localStorage.userinfo);

    $.ajax({
        url: './php/openChatCreation.php',
        dataType: 'html',
        method: 'POST',
        async: true,
        data: `username=${userInfo.user}&password=${userInfo.password}`,
        success: displayInChatWrapper,
        error: eFnction
    });
}

function openUserSelection(type) {
    const userInfo = JSON.parse(window.localStorage.userinfo);

    $.ajax({
        url: './php/openUserSelection.php',
        dataType: 'html',
        method: 'POST',
        async: true,
        data: `username=${userInfo.user}&password=${userInfo.password}&type=${type}`,
        success: displayInChatWrapper,
        error: eFnction
    });
}

function createChat(userId) {
    const userInfo = JSON.parse(window.localStorage.userinfo);

    $.ajax({
        url: './php/createChat.php',
        dataType: 'html',
        method: 'POST',
        async: true,
        data: `username=${userInfo.user}&password=${userInfo.password}&userId=${userId}`,
        success: successNewChat,
        error: eFnction
    });
}

function successNewChat(result, status, xhr) {
    console.log(result);

    const chatId = parseInt(result);

    // openChat(chatId);

    // conn.subscribe(`c_${chatId}`, function(topic, data) {
    //     onNewMessage(JSON.stringify(data));
    // });
}