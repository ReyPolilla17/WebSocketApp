function eFnction(xhr, status, error) {
    console.log(xhr, status, error)
}

function displayInChatWrapper(result, status, xhr) {
    $("#chat-wrapper").html(result);
}