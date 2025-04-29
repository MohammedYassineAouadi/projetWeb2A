<?php
require_once 'messageControler.php';

$controller = new MessageController();

// Create a new message
$responseCreate = $controller->createMessage(1, 2, "m3ana Basma");
echo json_encode($responseCreate);

// Get all messages for a channel
$responseGet = $controller->getMessagesByChannel(1);
echo json_encode($responseGet);

// Delete a message
$responseDelete = $controller->deleteMessage(1); // assuming ID 3
echo json_encode($responseDelete);
?>