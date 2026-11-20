function eFnction(xhr, status, error) {
    console.log(xhr, status, error)
}

function displayInChatWrapper(result, status, xhr) {
    console.log(result);
    $("#chat-wrapper").html(result);
}