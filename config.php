<?php
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'vulkanik';

$conn = null;

try {
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        $conn = null;
    } else {
        $conn->set_charset("utf8");
    }
} catch (Throwable $e) {
    $conn = null;
}

function sanitize($data) {
    global $conn;
    if ($conn) {
        return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
    }
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fungsi upload foto
function uploadFoto($file) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        @mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $file_name = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $file_name;
    
    // Validasi file
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_extension, $allowed_extensions)) {
        return false;
    }
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    }
    
    return false;
}
?>