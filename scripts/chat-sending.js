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
    const oppenedChat = document.getElementById("oppened-chat");
    const recvData = JSON.parse(data)

    console.log(recvData);

    if(oppenedChat !== null && oppenedChat.value === data.conversation_id) {
        console.log(data);
    }
}