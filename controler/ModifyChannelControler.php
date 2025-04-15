<?php
ob_start();
require_once '../model/ModelChannel.php';



ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fallback-safe variable handling
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $created_by = isset($_POST['created_by']) ? $_POST['created_by'] : '';
    $image_url = '';

    // Handle image upload
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['image_url']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $targetPath)) {
            $image_url = $targetPath;
        }
    }


    $channel = new Channel();
    $channel->setId($id);
    $channel->setName($name);
    $channel->setDescription($description);
    $channel->setImageUrl($image_url);
    $channel->setCreatedBy($created_by);


    if ($channel->updateChannel()) {
        header("Location: ../view/channels.html?success=1");
        exit;
    } else {
        header("Location: ../view/channels.html?error=1");
        exit;
    }
}
ob_end_flush();
?>
