<?php
// Detect environment and set DB details accordingly
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // 👉 Localhost settings
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'blogdb';  // Your local DB name
} else {
    // 👉 Online hosting (InfinityFree) settings
    $host = 'sql213.infinityfree.com';             // Your online DB host
    $username = 'if0_39131355';                    // Your InfinityFree DB username
    $password = 'sudharshan24';                    // Your DB password (same as vPanel)
    $dbname = 'if0_39131355_blog_db';              // Your online DB name
}

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
