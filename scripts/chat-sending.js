function sendMessage(chatId) {
    const userInfo = JSON.parse(window.localStorage.userinfo);
    
    const input = document.getElementById("send-message");
    const message = input.value.trim();
    
    input.value = '';

    if(message.length) {
        $.ajax({
            url: './php/sendMessage.php',
            datatype: 'html',
            method: 'POST',
            async: true,
            data: `username=${userInfo.user}&password=${userInfo.password}&chatId=${chatId}&message=${message}`,
            error: eFnction
        });
    }

    return false;
}

function onNewMessage(data) {
    const userInfo = JSON.parse(window.localStorage.userinfo);
    const oppenedChat = document.getElementById("oppened-chat");
    const recvData = JSON.parse(data)

    if(oppenedChat !== null && oppenedChat.value === recvData.conversation_id) {
        $.ajax({
            url: './php/recieveMessage.php',
            datatype: 'html',
            method: 'POST',
            async: true,
            data: `username=${userInfo.user}&password=${userInfo.password}&chatId=${recvData.conversation_id}&messageId=${recvData.message_id}`,
            success: successNewMessage,
            error: eFnction
        })
    }
}

function successNewMessage(result, status, xhr) {
    $("#messages-wrapper").preppend(result);
}