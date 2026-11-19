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

    console.log(recvData);

    if(oppenedChat !== null && oppenedChat.value === recvData.conversation_id) {
        console.log("AAAA");
        // $.ajax({
            // {message_id: '53', message_timestamp: '2026-11-18 18:10:49', message_content: 'Grd', user_id: '2', conversation_id: '1'}
        // })
    }
}