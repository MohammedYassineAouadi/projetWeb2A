<?php



require_once '../model/ModelChannel.php'; // Adjust the path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['channel_id']) && is_numeric($_POST['channel_id'])) {
        $channelId = intval($_POST['channel_id']);


        Channel::supprimerChannel($channelId);


        header("Location: ../view/channel.html?deleted=1");
        exit();
    } else {
        // Invalid or missing ID
        header("Location: ../view/supprimer_channel.html?error=invalid_id");
        exit();
    }
} else {

    header("HTTP/1.1 405 Method Not Allowed");
    echo "Method Not Allowed";
}

