<?php
namespace App\InventoryManagement;

class InventoryManager {
    private $conn;

    public function __construct($host = "localhost", $username = "root", $password = "", $dbname = "jouture_beauty") {
        $this->conn = new mysqli($host, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function addItem($category, $itemName, $quantity, $price, $supplier) {
        $stmt = $this->conn->prepare("INSERT INTO inventory (category, item_name, quantity, price, supplier) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssids", $category, $itemName, $quantity, $price, $supplier);
        return $stmt->execute();
    }

    public function deleteItem($id) {
        $stmt = $this->conn->prepare("DELETE FROM inventory WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updateItem($id, $category, $itemName, $quantity, $price, $supplier) {
        $stmt = $this->conn->prepare("UPDATE inventory SET category=?, item_name=?, quantity=?, price=?, supplier=? WHERE id=?");
        $stmt->bind_param("ssidsi", $category, $itemName, $quantity, $price, $supplier, $id);
        return $stmt->execute();
    }

    public function searchItem($term) {
        $term = "%$term%";
        $stmt = $this->conn->prepare("SELECT * FROM inventory WHERE item_name LIKE ?");
        $stmt->bind_param("s", $term);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function viewItems() {
        $result = $this->conn->query("SELECT * FROM inventory");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
