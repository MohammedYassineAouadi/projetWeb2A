// === Global State ===
let currentChannel = 'general';
let currentChannelId = null;
const currentUserId = 1; // This can be dynamically set later
let editingMessageId = null; // <-- Track the message being edited

// === Utility Functions ===

/**
 * Escapes HTML to prevent XSS attacks.
 * @param {string} text - The text to escape.
 * @returns {string} - The escaped HTML.
 */
const escapeHTML = (text) => {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
};

/**
 * Formats a timestamp to HH:MM format.
 * @param {string} timestamp - The timestamp to format.
 * @returns {string} - The formatted time.
 */
const formatTimestamp = (timestamp) => {
    const date = new Date(timestamp);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};

// === Channel Management ===

/**
 * Loads channels from the server and populates the sidebar.
 */
const loadChannels = async () => {
    try {
        const response = await fetch('../controler/getchannels.php');
        const channels = await response.json();
        const sidebar = document.getElementById('channelSidebar');
        sidebar.innerHTML = '';

        if (!Array.isArray(channels) || channels.length === 0) {
            sidebar.innerHTML = '<div class="channel-icon"><p>No channels found.</p></div>';
            return;
        }

        channels.forEach(channel => {
            const div = document.createElement('div');
            div.classList.add('channel-icon');
            div.dataset.name = channel.name;
            div.dataset.id = channel.id;
            div.innerHTML = `<img src="${channel.image_url || 'img/default.png'}" alt="${channel.name}">`;
            div.addEventListener('click', () => switchChannel(channel.name, channel.id));
            sidebar.appendChild(div);
        });

        // Automatically switch to the first channel
        switchChannel(channels[0].name, channels[0].id);
    } catch (error) {
        console.error('Error loading channels:', error);
        document.getElementById('channelSidebar').innerHTML =
            '<div class="channel-icon"><p>Error loading channels.</p></div>';
    }
};

/**
 * Switches to the selected channel and loads its messages.
 * @param {string} name - The name of the channel.
 * @param {number} channelId - The ID of the channel.
 */
const switchChannel = (name, channelId) => {
    currentChannel = name;
    currentChannelId = channelId;

    const titleElement = document.getElementById('channelTitle');
    if (titleElement) {
        titleElement.textContent = `# ${name}`;
    }

    const inputElement = document.getElementById('messageInput');
    if (inputElement) {
        inputElement.placeholder = `Message #${name}`;
        inputElement.value = '';
    }

    const chatContainer = document.getElementById('chat-messages');
    if (chatContainer) {
        chatContainer.innerHTML = '';
    }

    const channelIcons = document.querySelectorAll('.channel-icon');
    channelIcons.forEach(icon => {
        if (icon.dataset.name === name) {
            icon.classList.add('active');
        } else {
            icon.classList.remove('active');
        }
    });

    fetchMessages();
};

// === Message Handling ===

/**
 * Fetches messages for the current channel from the server.
 */
const fetchMessages = async () => {
    if (!currentChannelId) {
        console.error('Cannot fetch messages: No channel selected.');
        return;
    }

    try {
        // Explicitly use window.location to navigate and force a GET request
        const url = `../controler/getmessageControler.php?action=fetchMessages&channel_id=${currentChannelId}`;

        console.log('Fetching messages with GET:', url);

        // Make sure we're using GET with no options that might default to POST
        const response = await fetch(url, {
            method: 'GET',  // Explicitly set the method to GET
            cache: 'no-cache'  // Don't use cached results
        });

        const data = await response.json();
        console.log('Fetched data:', data);

        const chatContainer = document.getElementById('chat-messages');
        chatContainer.innerHTML = '';

        if (data.status === 'success' && Array.isArray(data.messages)) {
            // This is the part of your channels.js that needs to be updated
// Replace the existing message creation code with this in the fetchMessages function

            data.messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message';
                messageDiv.dataset.messageId = msg.id;
                messageDiv.innerHTML = `
        <div class="message-header">
            <span class="username">User ${msg.user_id}</span>
            <span class="timestamp">${formatTimestamp(msg.sent_at)}</span>
            <div class="message-actions">
                <button class="message-menu-button" onclick="toggleMessageMenu(${msg.id})">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div id="message-menu-${msg.id}" class="message-menu">
                    <ul>
                        <li><a href="#" onclick="editMessage(${msg.id}); return false;"><i class="fa fa-edit"></i> Edit</a></li>
                        <li><a href="#" onclick="deleteMessage(${msg.id}); return false;"><i class="fa fa-trash"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="message-content">${escapeHTML(msg.content)}</div>
    `;
                chatContainer.appendChild(messageDiv);
            });


            chatContainer.scrollTop = chatContainer.scrollHeight;
        } else {
            console.warn('No messages or failed fetch:', data.message);
            chatContainer.innerHTML = `<div class="no-messages">${escapeHTML(data.message || 'No messages yet.')}</div>`;
        }
    } catch (error) {
        console.error('Network error while fetching messages:', error);
        document.getElementById('chat-messages').innerHTML =
            '<div class="error">Error loading messages. Please try again later.</div>';
    }
};

/**
 * Sends a new message to the server.
 */
/**
 * Sends a new message to the server.
 */
const sendMessage = async (e) => {
    if (e) e.preventDefault();

    const input = document.getElementById('messageInput');
    const messageText = input.value.trim();

    if (!currentChannelId) {
        console.error('Cannot send message: No channel selected.');
        return;
    }

    if (!messageText) {
        console.error('Cannot send empty message.');
        return;
    }

    // If editing, update the message
    if (editingMessageId) {
        try {
            const url = `../controler/updateMessageControler.php?id=${editingMessageId}&content=${encodeURIComponent(messageText)}`;
            const response = await fetch(url, {
                method: 'GET',
                cache: 'no-cache'
            });

            const data = await response.json();
            console.log('Update response:', data);

            if (data.success) {
                input.value = '';
                input.placeholder = `Message #${currentChannel}`;
                editingMessageId = null; // Clear editing mode
                fetchMessages();
            } else {
                alert('Failed to update message: ' + data.message);
            }
        } catch (error) {
            console.error('Error updating message:', error);
        }
        return;
    }

    // If not editing, send a normal new message
    try {
        console.log("Sending message:", messageText, currentChannelId, currentUserId);

        const url = `../controler/sendmessagecontroler.php?action=sendMessage&channel_id=${currentChannelId}&user_id=${currentUserId}&content=${encodeURIComponent(messageText)}`;

        const response = await fetch(url, {
            method: 'GET',
            cache: 'no-cache'
        });

        const data = await response.json();
        console.log(data);

        if (data.status === 'success') {
            input.value = '';
            fetchMessages();
        } else {
            console.error('Error sending message:', data.message || 'Unknown error');
        }
    } catch (error) {
        console.error('Network error while sending message:', error);
    }
};


const deleteMessage = async (messageId) => {
    if (!confirm('Are you sure you want to delete this message?')) {
        return;
    }

    try {
        const url = `../controler/deleteMessageControler.php?id=${messageId}`;
        const response = await fetch(url, {
            method: 'GET',
            cache: 'no-cache'
        });

        const data = await response.json();
        console.log('Delete response:', data);

        if (data.success) {
            fetchMessages(); // Refresh messages
        } else {
            alert('Failed to delete message: ' + data.message);
        }
    } catch (error) {
        console.error('Error deleting message:', error);
    }
};

const editMessage = (messageId) => {
    const input = document.getElementById('messageInput');
    if (!input) return;

    editingMessageId = messageId; // Set the message we want to edit
    input.placeholder = 'Editing message...'; // Show user that they are editing
    input.focus(); // Focus input box
};


// === Event Listeners ===

document.addEventListener('DOMContentLoaded', () => {
    loadChannels();

    const messageInput = document.getElementById('messageInput');
    if (messageInput) {
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }

    const sendButton = document.getElementById('sendMessageButton');
    if (sendButton) {
        sendButton.addEventListener('click', sendMessage);
    }
});
document.getElementById('sendMessageButton').addEventListener('click', sendMessage);