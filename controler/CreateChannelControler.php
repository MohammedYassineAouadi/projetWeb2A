<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the necessary fields are set
    if (!isset($_POST['name']) || !isset($_POST['description'])) {
        echo json_encode(["status" => "error", "message" => "Missing fields"]);
        exit;
    }

    $channelName = $_POST['name'];
    $channelDescription = $_POST['description'];
    $createdBy = isset($_POST['created_by']) ? $_POST['created_by'] : 1; // Default value

    // Check if the image was uploaded
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image_url']['tmp_name'];
        $imageName = $_FILES['image_url']['name'];
        $imagePath = '../uploads/' . $imageName;

        if (move_uploaded_file($imageTmpPath, $imagePath)) {

            $imageUrl = $imagePath;
        } else {
            header('Location: ../view/ChannelBackOffice.html?error=true');
            exit;
        }
    } else {

        $imageUrl = null;
    }

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=DBforum', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query
        $stmt = $pdo->prepare("INSERT INTO channel (name, description, image_url, created_by) VALUES (?, ?, ?, ?)");
        $stmt->execute([$channelName, $channelDescription, $imageUrl, $createdBy]);

        header('Location: ../view/ChannelBackOffice.html?error=true');
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
}
?>
