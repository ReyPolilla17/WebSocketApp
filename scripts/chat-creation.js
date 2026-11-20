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