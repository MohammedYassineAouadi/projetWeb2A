const form = document.getElementById("messageForm");
const chatBox = document.getElementById("chatBox");
const input = document.getElementById("messageInput");

form.addEventListener("submit", function (e) {
    e.preventDefault();
    const message = input.value.trim();
    if (message !== "") {
        const msgElement = document.createElement("div");
        msgElement.textContent = message;
        chatBox.appendChild(msgElement);
        input.value = "";
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});
