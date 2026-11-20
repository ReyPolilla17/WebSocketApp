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