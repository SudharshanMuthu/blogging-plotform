<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "Access denied. Admins only.";
    exit();
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="center-container"> <!-- Move this div here, wrap whole page content -->

    <h2>Manage User Roles</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Change Role</th>
        </tr>
        <?php while ($row = $users->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']); ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['email']); ?></td>
            <td><?= htmlspecialchars($row['role']); ?></td>
            <td>
                <form method="POST" action="update_role.php">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']); ?>">
                    <select name="role">
                        <option value="reader" <?= $row['role'] === 'reader' ? 'selected' : ''; ?>>Reader</option>
                        <option value="author" <?= $row['role'] === 'author' ? 'selected' : ''; ?>>Author</option>
                        <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</div> <!-- close center-container -->

</body>
</html>

