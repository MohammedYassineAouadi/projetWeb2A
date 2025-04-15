
function sendMessage() {
    const input = document.getElementById('messageInput');
    const messageText = input.value.trim();
    if (!messageText) return;

    const msg = document.createElement('div');
    msg.classList.add('message');
    msg.innerHTML = `<span class="username">You</span> <span class="text">${messageText}</span>`;

    const chat = document.getElementById('chat-messages');
    chat.appendChild(msg);
    input.value = '';
    chat.scrollTop = chat.scrollHeight;
}


function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const output = document.getElementById('imagePreview');
        output.style.display = 'block';
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}


function loadChannels() {
    fetch('controler/getChannels.php')
        .then(response => response.json())
        .then(channels => {
            const sidebar = document.getElementById('channelSidebar');
            sidebar.innerHTML = '';

            channels.forEach(channel => {
                const div = document.createElement('div');
                div.classList.add('channel-icon');
                div.innerHTML = `
                    <img 
                        src="${channel.image_url || 'img/default.png'}" 
                        alt="${channel.name}" 
                        title="${channel.name}" 
                        onclick="switchChannel('${channel.name}')">
                `;
                sidebar.appendChild(div);
            });

            if (channels.length > 0) {
                switchChannel(channels[0].name);
            }
        })
        .catch(error => console.error('Error loading channels:', error));
}

// === Switch Active Channel ===
function switchChannel(name) {
    document.getElementById('channelTitle').textContent = `# ${name}`;
    document.getElementById('chat-messages').innerHTML = '';
}

// === Modal Handling ===
function setupModalHandlers() {
    const icon = document.getElementById("openFormIcon");
    const modal = document.getElementById("channelModal");
    const closeBtn = document.getElementById("closeModal");
    const mainContainer = document.querySelector(".main-container");
    const chatWindow = document.querySelector(".chat-window");

    icon?.addEventListener("click", function () {
        modal.style.display = "flex";
        mainContainer.classList.add("blurred");
        chatWindow.classList.add("blurred");
    });

    closeBtn?.addEventListener("click", function () {
        modal.style.display = "none";
        mainContainer.classList.remove("blurred");
        chatWindow.classList.remove("blurred");
    });

    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
            mainContainer.classList.remove("blurred");
            chatWindow.classList.remove("blurred");
        }
    });
}

// === Profile Icon Setup ===
function setupTopRightIcon() {
    const icon = document.querySelector('.top-right-icon img');
    icon?.addEventListener('click', function () {
        alert('Icon clicked! You can link this to profile/settings.');
        // Example: window.location.href = 'profile.html';
    });
}

// === Initialize Page ===
document.addEventListener("DOMContentLoaded", function () {
    setupTopRightIcon();
    setupModalHandlers();
    loadChannels();
});

    function loadChannels() {
    fetch('getChannels.php') // adjust path if needed
        .then(response => response.json())
        .then(data => {
            const sidebar = document.getElementById('channelSidebar');
            sidebar.innerHTML = ''; // Clear existing

            if (data.length === 0 || data.error) {
                sidebar.innerHTML = '<p>No channels found.</p>';
                return;
            }

            data.forEach(channel => {
                const div = document.createElement('div');
                div.className = 'channel-item';
                div.innerHTML = `
                        <h5># ${channel.name}</h5>
                        <p>${channel.description}</p>
                    `;
                sidebar.appendChild(div);
            });
        })
        .catch(error => {
            console.error('Error loading channels:', error);
        });
}

    window.onload = loadChannels;

function loadChannels() {
    fetch('getChannels.php')
        .then(response => response.json())
        .then(data => {
            const sidebar = document.getElementById('channelSidebar');
            sidebar.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) {
                sidebar.innerHTML = '<p class="text-muted">No channels found.</p>';
                return;
            }

            data.forEach(channel => {
                const div = document.createElement('div');
                div.className = 'channel-item';
                div.innerHTML = `<h5># ${channel.name}</h5><p>${channel.description}</p>`;
                sidebar.appendChild(div);
            });
        })
        .catch(error => {
            console.error('Error loading channels:', error);
        });
}

function sendMessage() {
    const input = document.getElementById("messageInput");
    const message = input.value.trim();
    if (message) {
        const messagesDiv = document.getElementById("chat-messages");
        const msgDiv = document.createElement("div");
        msgDiv.textContent = message;
        messagesDiv.appendChild(msgDiv);
        input.value = "";
    }
}

window.onload = loadChannels;
