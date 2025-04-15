<?php
require_once 'database.php';

class Channel
{
    private $conn;

    public $id;
    public $name;
    public $description;
    public $image_url;
    public $created_by;
    public $created_at;


    public function __construct($id = null, $name = "", $description = "", $image_url = "", $created_by = null, $created_at = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->created_by = $created_by;
        $this->created_at = $created_at;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getImageUrl() {
        return $this->image_url;
    }

    public function setImageUrl($image_url) {
        $this->image_url = $image_url;
    }

    public function getCreatedBy() {
        return $this->created_by;
    }

    public function setCreatedBy($created_by) {
        $this->created_by = $created_by;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public static function afficherChannels()
    {
        try {
            $db = config::getConnexion();
            $query = $db->query("SELECT * FROM channel");


            if ($query->rowCount() > 0) {
                $channels = [];
                while ($row = $query->fetch()) {
                    // Collect channel data
                    $channels[] = [
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'description' => $row['description'],
                        'image_url' => $row['image_url'] // Ensure image_url is returned
                    ];
                }

                echo json_encode($channels);
            } else {
                echo json_encode(["message" => "No channels found."]);
            }

        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    }




    public function ajoutChannel()
    {
        $db = config::getConnexion();

        // SQL query to insert a new channel
        $sql = "INSERT INTO channel (name, description, image_url, created_by, created_at) 
                VALUES (:name, :description, :image_url, :created_by, NOW())";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $this->image_url, PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $this->created_by, PDO::PARAM_INT);

        try {

            $stmt->execute();
            echo "Channel added successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function validateChannelData()
    {
        // Check if the name and description are not empty
        if (empty($this->name) || empty($this->description) || empty($this->image_url)) {
            throw new Exception('Name, description, and image URL are required.');
        }

        // Check if the name is too long (e.g., 100 characters max)
        if (strlen($this->name) > 100) {
            throw new Exception('Name is too long. Maximum length is 100 characters.');
        }

        // Check if the description is too long (e.g., 255 characters max)
        if (strlen($this->description) > 255) {
            throw new Exception('Description is too long. Maximum length is 255 characters.');
        }

        // Optionally: Validate the image URL format (can be improved based on your requirements)
        if (!filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid image URL format.');
        }
    }
    public function updateChannel()
    {
        $db = config::getConnexion();

        $sql = "UPDATE channel 
            SET name = :name, 
                description = :description, 
                image_url = :image_url, 
                created_by = :created_by
            WHERE id = :id";

        try {
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':image_url', $this->image_url);
            $stmt->bindParam(':created_by', $this->created_by);

            $stmt->execute();
            echo "Channel updated successfully!";
        } catch (PDOException $e) {
            echo "Error updating channel: " . $e->getMessage();
        }
    }

    public static function supprimerChannel($id)
    {
        try {
            $db = Config::getConnexion();
            $sql = "DELETE FROM channel WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            echo "Channel with ID $id deleted successfully.";
        } catch (PDOException $e) {
            echo "Error deleting channel: " . $e->getMessage();
        }
    }




    public function sanitizeOutput($data)
    {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}