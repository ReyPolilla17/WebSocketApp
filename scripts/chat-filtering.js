function filterChats() {
    const userInfo = JSON.parse(window.localStorage.userinfo);
    const searchInput = document.getElementById('chat-search').value;

    $.ajax({
        url: './php/filterChats.php',
        dataType: 'html',
        type: 'POST',
        async: true,
        data: `username=${userInfo.user}&password=${userInfo.password}&searchInput=${searchInput}`,
        success: displayFilterdChats,
        error: eFnction
    })
}

function displayFilterdChats(result, status, xhr) {
    $("#chat-collection").html(result);
}