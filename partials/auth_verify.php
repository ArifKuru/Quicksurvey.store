<?php
session_start();

// Tam URL'yi al ve query parametrelerini parse et
$request_uri = $_SERVER['REQUEST_URI']; // Tam URL (path ve query ile birlikte)
$parsed_url = parse_url($request_uri);  // URL'yi parse ediyoruz
parse_str($parsed_url['query'] ?? '', $query_params); // Query parametrelerini ayıklıyoruz

// Path kısmını alıyoruz (sadece yol kısmı)
$path = trim($parsed_url['path'], '/'); // Path'i alıyoruz

// Kullanıcı giriş yapmamışsa
if (!isset($_SESSION['user_id'])) {
    // Eğer kullanıcı login, register, register/verify veya register/success sayfalarına gitmiyorsa, login sayfasına yönlendir
    if (!in_array($path, ['login', 'register', 'register/verify', 'register/success'])) {
        header("Location: login");
        exit;
    }
} else {
    // Eğer kullanıcı giriş yaptıysa ve login veya register sayfalarına gitmek istiyorsa, dashboard sayfasına yönlendir
    if (in_array($path, ['login', 'register'])) {
        header("Location: dashboard");
        exit;
    }
}
?>
