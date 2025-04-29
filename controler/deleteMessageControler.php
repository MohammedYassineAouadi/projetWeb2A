<?php

require_once '../model/Message.php'; // Adjust this path if needed
require_once 'messageControler.php'; // Adjust if your controller is in another folder

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing message ID.'
    ]);
    exit;
}

$id = intval($_GET['id']);

$controller = new MessageController();
$result = $controller->deleteMessage($id);

echo json_encode($result);

