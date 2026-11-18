function sendMessage() {
    const input = document.getElementById("send-message");
    const message = input.value.trim();

    console.log(message);
    input.value = '';

    return false;
}