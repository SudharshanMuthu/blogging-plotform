<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "Access denied.";
    exit();
}

// Handle add category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
}

// Handle delete category
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
    <link rel="stylesheet" href="style.css">
    <style>
        ul.category-list {
            width: 90%;
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        ul.category-list li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
        }

        ul.category-list li:last-child {
            border-bottom: none;
        }

        ul.category-list a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        ul.category-list a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Manage Categories</h2>

<div class="center-container">
    <form method="POST" style="margin-bottom: 30px;">
        <label>New Category Name:</label>
        <input type="text" name="name" required>
        <button type="submit" name="add">Add Category</button>
    </form>

    <ul class="category-list">
        <?php while ($row = $categories->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($row['name']) ?>
                <a href="admin_categories.php?delete=<?= $row['id']; ?>" onclick="return confirm('Delete this category?')">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

</body>
</html>
