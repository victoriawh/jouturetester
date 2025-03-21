<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "jouture_beauty";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all inventory items
$result = $conn->query("SELECT * FROM inventory ORDER BY item_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Inventory</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

    <!-- Jouture Logo -->
    <img src="../assets/images/jblogo.jpg" alt="Jouture Logo" class="logo">

    <div class="container">
        <h2>Inventory List</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price ($)</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= number_format($row['price'], 2) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No items found</td>
                </tr>
            <?php endif; ?>
        </table>

        <!-- Back Button -->
        <a href="Dashboard.php" class="back-button">Back to Dashboard</a>
    </div>

</body>
</html>
<?php
$conn->close();
?>