<?php
session_start();
include 'db.php';

$posts = $conn->query("SELECT posts.*, users.name AS author, categories.name AS category
    FROM posts
    JOIN users ON posts.author_id = users.id
    JOIN categories ON posts.category_id = categories.id
    ORDER BY posts.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Blog Posts</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .blog-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin: 20px auto;
            width: 80%;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .blog-card h3 {
            margin-top: 10px;
            color: #333;
        }

        .blog-card small {
            color: #555;
        }

        .like-form button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .like-form button:hover {
            background-color: #388e3c;
        }

        .comment-box input {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .comment-box button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px;
            margin-top: 8px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .comment-box button:hover {
            background-color: #388e3c;
        }

        .edit-links {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>All Blog Posts</h2>

<?php while ($row = $posts->fetch_assoc()): ?>
    <div class="blog-card">

        <?php if (!empty($row['image_url'])): ?>
            <img src="<?php echo $row['image_url']; ?>" alt="Blog Image">
        <?php endif; ?>

        <h3><?php echo $row['title']; ?></h3>
        <p><?php echo $row['content']; ?></p>
        <small>By <?php echo $row['author']; ?> in <?php echo $row['category']; ?> on <?php echo $row['created_at']; ?></small><br>

        <!-- Like Button -->
        <?php
        $post_id = $row['id'];
        $like_count = $conn->query("SELECT COUNT(*) AS count FROM likes WHERE post_id = $post_id")->fetch_assoc()['count'];
        $user_like = 0;
        if (isset($_SESSION['user'])) {
            $uid = $_SESSION['user']['id'];
            $chk = $conn->query("SELECT * FROM likes WHERE post_id = $post_id AND user_id = $uid");
            $user_like = $chk->num_rows;
        }
        ?>
        <form action="like_post.php" method="GET" class="like-form">
            <input type="hidden" name="id" value="<?php echo $post_id; ?>">
            <button type="submit"><?php echo $user_like ? "Unlike" : "Like"; ?> (<?php echo $like_count; ?>)</button>
        </form>

        <!-- Comment Form -->
        <?php if (isset($_SESSION['user'])): ?>
            <form action="comment_post.php" method="POST" class="comment-box">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <input type="text" name="content" placeholder="Add a comment" required>
                <button type="submit">Comment</button>
            </form>
        <?php endif; ?>

        <!-- Show Comments -->
        <?php
        $comments = $conn->query("SELECT comments.*, users.name FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = $post_id ORDER BY created_at DESC");
        while ($c = $comments->fetch_assoc()):
        ?>
            <p><strong><?php echo $c['name']; ?>:</strong> <?php echo $c['content']; ?> <em>(<?php echo $c['created_at']; ?>)</em></p>
        <?php endwhile; ?>

        <!-- Edit/Delete for Owner -->
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $row['author_id']): ?>
            <div class="edit-links">
                <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_post.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this post?')">Delete</a>
            </div>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

</body>
</html>


