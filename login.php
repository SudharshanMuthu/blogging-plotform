<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $selectedRole = $_POST['role']; // Get selected role

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        // Role mismatch check
        if ($user['role'] !== $selectedRole) {
            echo '<div class="center-container">
                    <div style="padding: 15px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 10px; width: fit-content; text-align: center; color: #721c24;">
                        ❌ Role mismatch. Please select the correct role.
                    </div>
                  </div>';
            exit();
        }

        $_SESSION['user'] = $user;

        if ($user['role'] == 'reader') {
            echo "You are logged in as reader. <a href='view_posts.php'>View Blogs</a>";
        } else if ($user['role'] == 'author') {
            echo "You are logged in as author. <a href='dashboard.php'>Go to Dashboard</a>";
        } else if ($user['role'] == 'admin') {
            echo "You are logged in as admin. <a href='dashboard.php'>Go to Admin Panel</a>";
        } else {
            echo "Unknown role.";
        }
        exit();
    } else {
        echo '<div class="center-container">
                <div style="padding: 15px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 10px; width: fit-content; text-align: center; color: #721c24;">
                    ❌ Invalid email or password.
                </div>
              </div>';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="center-container">
    <form method="POST" action="">
        <h2 style="text-align:center;">Login</h2>

        Email: <input type="email" name="email" required>
        Password: <input type="password" name="password" required>

        <label>Login as:</label>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="reader">Reader</option>
            <option value="author">Author</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>


