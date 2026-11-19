function filterChats() {
    const userInfo = JSON.parse(window.localStorage.userinfo);
    const searchInput = document.getElementById('chat-search').value;

    console.log("A");

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
    console.log(result);
    $("#chat-collection").html(result);
}