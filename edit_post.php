<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$post = $conn->query("SELECT * FROM posts WHERE id = $id AND author_id = ".$_SESSION['user']['id'])->fetch_assoc();

if (!$post) { echo "Post not found or not yours."; exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    header("Location: view_posts.php");
}
?>

<h2>Edit Post</h2>
<form method="POST">
    Title: <input type="text" name="title" value="<?php echo $post['title']; ?>" required><br><br>
    Content: <textarea name="content" required><?php echo $post['content']; ?></textarea><br><br>
    <button type="submit">Update</button>
</form>
