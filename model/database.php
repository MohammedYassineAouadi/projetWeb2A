
<?php
require_once 'ModelChannel.php';

class Config
{
    private static $pdo = null;

    public static function getConnexion()
    {
        if (self::$pdo === null) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "DBforum";

            try {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $image_url = isset($_POST['image_url']) ? trim($_POST['image_url']) : '';
    $created_by = isset($_POST['created_by']) ? (int)$_POST['created_by'] : 1;

    if (!empty($name) && !empty($description) && !empty($image_url)) {
        $channel = new Channel();
        $channel->name = $name;
        $channel->description = $description;
        $channel->image_url = $image_url;
        $channel->created_by = $created_by;

        $channel->ajoutChannel();
        echo "Channel added successfully!";
    } else {
        echo "Please fill in all the fields.";
    }

    Channel::afficherChannels();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $channel = new Channel();
    $channel->setId($_POST['id']);
    $channel->setName($_POST['name']);
    $channel->setDescription($_POST['description']);
    $channel->setImageUrl($_POST['image_url']);
    $channel->setCreatedBy($_POST['created_by']);

    $channel->updateChannel();
    echo "Channel updated successfully!";
    Channel::afficherChannels();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $idToDelete = $_POST['delete_id'];
    Channel::supprimerChannel($idToDelete);
    echo "Channel deleted successfully!";
    Channel::afficherChannels();
}
?>

<form method="POST" action="">
    <label for="id">Channel ID to update:</label>
    <input type="number" name="id" id="id" required><br>

    <label for="name">New Channel Name:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="description">New Description:</label>
    <textarea name="description" id="description" required></textarea><br>

    <label for="image_url">New Image URL:</label>
    <input type="text" name="image_url" id="image_url" required><br>

    <label for="created_by">Created By (User ID):</label>
    <input type="number" name="created_by" id="created_by" required><br>

    <button type="submit">Update Channel</button>
</form>

<h2>Delete Channel</h2>
<form method="POST" action="">
    <label for="delete_id">Channel ID to delete:</label>
    <input type="number" name="delete_id" id="delete_id" required><br>
    <button type="submit">Delete Channel</button>
</form>

<h2>Create New Channel</h2>
<form method="POST" action="">
    <label for="name">Channel Name:</label>
    <input type="text" name="name" id="name" required><br>
    <label for="description">Description:</label>
    <textarea name="description" id="description" required></textarea><br>
    <label for="image_url">Image URL:</label>
    <input type="text" name="image_url" id="image_url" required><br>
    <label for="created_by">Created By (User ID):</label>
    <input type="number" name="created_by" id="created_by" required><br>
    <button type="submit">Create Channel</button>
</form>

<?php
Channel::afficherChannels();
?>
