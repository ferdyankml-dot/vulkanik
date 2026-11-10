<?php
session_start();

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $cookieParams = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $cookieParams['path'],
        $cookieParams['domain'],
        $cookieParams['secure'],
        $cookieParams['httponly']
    );
}

session_destroy();

$redirect = ($_GET['redirect'] ?? '') === 'public' ? 'index.php' : 'login.php';
header("Location: " . $redirect);
exit();
?>
