<?php
namespace App\InventoryManagement;

class InventoryManager {
    private $conn;

    public function __construct($host = "localhost", $username = "root", $password = "", $dbname = "jouture_beauty") {
        $this->conn = new \mysqli($host, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Handle action dispatcher
   public function handleAction($postData = null) {
    switch ($postData['action'] ?? 'default') {
        case 'add':
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($postData["name"])) {
                $result = $this->addItem(
                    $postData["name"],
                    $postData["description"],
                    $postData["quantity"],
                    $postData["price"]
                );
                return $result ? "<p class='success'> Item added successfully!</p>" : "<p class='error'> Failed to add item.</p>";
            } else {
                //Return the form HTML
                return $this->add_item();
            }

        default:
            return "";
    }
}

   private function add_item() {
    return <<<HTML
    <style>
            .form-container {
                margin-top: 40px;
                text-align: left;
            }
            .form-container form {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }
            .form-container label {
                font-weight: bold;
            }
            .form-container input {
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 6px;
            }
            .back-btn {
                padding: 10px 25px;
                border-radius: 7px;
                font-size: 15px;
                background-color: #b8860b;
                color: white;
                text-decoration: none;
                margin-left: 600px;
            }

            .back-btn:hover {
                background-color: #a87905;
            }

            .form-container button {
                background-color: #b8860b;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
            }
            .form-container button:hover {
                background-color: #a87905;
            }
            .success {
                color: green;
                margin-top: 10px;
            }
            .error {
                color: red;
                margin-top: 10px;
            }
        </style>
    <div class="form-container">
      <h2>Add New Inventory Item</h2>
      <form method="POST">
        <input type="hidden" name="action" value="add" />

        <label>Name</label>
        <input type="text" name="name" required />

        <label>Description</label>
        <input type="text" name="description" required />

        <label>Quantity</label>
        <input type="number" name="quantity" required />

        <label>Price</label>
        <input type="number" step="0.01" name="price" required />

        <button type="submit">Add Item</button>
      </form>
    </div>
HTML;
}

private function addItem($name, $description, $quantity, $price) {
    $created_by = $_SESSION['user_id'] ?? null;

    if (!$created_by) {
        die("User not authenticated.");
    }

    $stmt = $this->conn->prepare(
        "INSERT INTO inventory (name, description, quantity, price, created_by) 
         VALUES (?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare failed: " . $this->conn->error);
    }

    $stmt->bind_param("ssiii", $name, $description, $quantity, $price, $created_by);

    $success = $stmt->execute();
    if (!$success) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    return $success;
}

}

?>
