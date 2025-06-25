<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role']; // role selected from dropdown

    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        echo '<div class="center-container">
            <div style="padding: 20px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 10px; width: fit-content; text-align: center; color: #155724;">
                ✅ Registration successful! <a href="login.php">Login here</a>
            </div>
          </div>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="center-container">
    <form method="POST" action="">
        <h2 style="text-align:center;">Register</h2>

        Name: <input type="text" name="name" required>
        Email: <input type="email" name="email" required>
        Password: <input type="password" name="password" required>

        <label>Register as:</label>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="reader">Reader</option>
            <option value="author">Author</option>
        </select>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>

