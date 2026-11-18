function sendMessage(chatId) {
    const userInfo = JSON.parse(window.localStorage.userinfo);
    
    const input = document.getElementById("send-message");
    const message = input.value.trim();

    input.value = '';

    $.ajax({
        url: './php/sendMessage.php',
        datatype: 'html',
        method: 'POST',
        async: true,
        data: `username=${userInfo.user}&password=${userInfo.password}&chatId=${chatId}&message=${message}`,
        success: successSend,
        error: eFnction
    });

    return false;
}

function successSend(result, status, xhr) {
    console.log(result);
}