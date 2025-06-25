<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dashboard</title>
<style>
  body, html {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f06, #48f);
    color: white;
  }
  .container {
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: rgba(0,0,0,0.5); /* translucent black overlay */
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 0 20px rgba(255,255,255,0.3);
    max-width: 500px;
    margin: auto;
  }
  h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
  }
  p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
  }
  h3 {
    margin: 20px 0 10px;
    color: #ffd700; /* gold color */
    text-shadow: 1px 1px 2px #000;
  }
  a {
    margin: 0 15px;
    text-decoration: none;
    color: #ffdd57; /* bright yellow */
    font-weight: 600;
    font-size: 1.1rem;
    transition: color 0.3s ease;
  }
  a:hover {
    color: #fff;
    text-shadow: 0 0 10px #ffdd57;
  }
</style>
</head>
<body>

<div class="container">
  <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
  <p>You are logged in as: <?php echo htmlspecialchars($user['role']); ?></p>

  <div>
    <a href="create_post.php">Create Post</a> |
    <a href="view_posts.php">View All Posts</a> |
    <?php if ($user['role'] === 'admin'): ?>
      <h3>Admin Panel</h3>
      <a href="admin_users.php">Manage Users</a> |
      <a href="admin_categories.php">Manage Categories</a><br><br>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
  </div>
</div>

</body>
</html>
