function openChat(chatId) {
    const userInfo = JSON.parse(window.localStorage.userinfo);

    $.ajax({
        url: './php/openChat.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: `username=${userInfo.user}&password=${userInfo.password}&chatId=${chatId}`,
        success: displayChat,
        error: eFnction
    });
}

function displayChat(result, status, xhr) {
    console.log(result);
    $("#chat-wrapper").html(result); 
}