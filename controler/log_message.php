<?php

// Read the POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if the required fields exist
if (!$data || !isset($data['type'], $data['user_id'], $data['channel_id'], $data['content'], $data['timestamp'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

// Set the log file path (use a simple path for testing)
$logFilePath = __DIR__ . '/logs/messages.txt';  // You can adjust this path as needed

// Prepare the log message
$logMessage = "[" . $data['timestamp'] . "] " .
    "User: " . $data['user_id'] . " | " .
    "Channel: " . $data['channel_id'] . " | " .
    "Content: " . str_replace(["\n", "\r"], ['\\n', ''], $data['content']) . "\n";

// Write the log message to the file
file_put_contents($logFilePath, $logMessage, FILE_APPEND);

echo json_encode(['status' => 'logged']);
?>
