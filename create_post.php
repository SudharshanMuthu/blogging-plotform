<?php
session_start();
include 'db.php';

// Redirect if not logged in or not author/admin
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'author' && $_SESSION['user']['role'] !== 'admin')) {
    echo "Access denied.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title      = $_POST['title'];
    $content    = $_POST['content'];
    $category   = $_POST['category'];
    $author_id  = $_SESSION['user']['id'];
    $image_url  = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO posts (title, content, category_id, author_id, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiis", $title, $content, $category, $author_id, $image_url);
    if ($stmt->execute()) {
        echo "Post created successfully. <a href='view_posts.php'>View Posts</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Create a New Blog Post</h2>

<div class="center-container">
    <form method="POST" action="">
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Content:</label>
        <textarea name="content" rows="5" required></textarea>

        <label>Category:</label>
        <select name="category" required>
            <?php while ($row = $categories->fetch_assoc()): ?>
                <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label>Image URL (optional):</label>
        <input type="text" name="image_url" placeholder="e.g. assets/img1.jpg">

        <button type="submit">Create Post</button>
    </form>
</div>

</body>
</html>

