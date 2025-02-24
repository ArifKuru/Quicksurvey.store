<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $pdo;
    $response = array();
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];
    $password = $data['password'];

    if ($email && $password) {
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Kullanıcı giriş yaptı
                if ($user['isEmailVerified'] != 1) {
                    // E-posta doğrulaması yapılmamışsa, register/success sayfasına yönlendir
                    $response['status'] = 'error';
                    $response['message'] = 'Your email is not verified yet. Please verify your email.';
                } else {
                    // E-posta doğrulandıysa, oturum başlat
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $response['status'] = 'success';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Invalid email or password!';
            }
        } catch (PDOException $e) {
            $response['status'] = 'error';
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Please fill in all fields!';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
