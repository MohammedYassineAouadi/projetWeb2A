<?php
require_once '../model/ModelChannel.php'; // Adjust the path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['channel_id']) && is_numeric($_POST['channel_id'])) {
        $channelId = intval($_POST['channel_id']);

        // Call the method to delete the channel
        Channel::supprimerChannel($channelId);

        // Redirect to the channels page with a success message
        header("Location: ../view/channels.html");
        exit();
    } else {
        // Invalid or missing ID
        header("Location: ../view/channels.html*");
        exit();
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Method Not Allowed";
}
