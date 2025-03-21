<?php

namespace App\UI;

require_once '../Authentication/Auth.php';

use App\Authentication\Auth;
session_start();
$auth = new Auth();

// Check if user is logged in
if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit();
}
if (!$auth->logout()) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" content=>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jouture Beauty Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    </head>
<body>
    <div class="dashboard">

	<!-- Jouture Logo -->
    <img src="../assets/images/jblogo.jpg" alt="Jouture Logo" class="logo">
	<a href="?logout=true" class="btn logout-btn">Logout</a>

        <h1>Welcome to Jouture Beauty Inventory</h1>
        <p>Manage your jewelry collection with ease.</p>
        <div class="buttons">
            <a href="add_item.php" class="btn">Add Item</a>
            <a href="delete_item.php" class="btn">Delete Item</a>
            <a href="search_item.php" class="btn">Search Item</a>
            <a href="update_item.php" class="btn">Update Item</a>
            <a href="view_item.php" class="btn">View Items</a>
        </div>
    </div>
</body>
</html>