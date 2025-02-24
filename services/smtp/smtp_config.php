<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



require $_SERVER["DOCUMENT_ROOT"].'/services/smtp/PHPMailer/src/PHPMailer.php';
require $_SERVER["DOCUMENT_ROOT"].'/services/smtp/PHPMailer/src/SMTP.php';
require $_SERVER["DOCUMENT_ROOT"].'/services/smtp/PHPMailer/src/Exception.php';

function sendMail($email, $message,$subject) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Ayarları
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com'; // SMTP Sunucusu
        $mail->SMTPAuth = true;
        $mail->Username = '814f10001@smtp-brevo.com'; // SMTP Kullanıcı Adı
        $mail->Password = 'bKaDP2V8FWGUvYwZ'; // SMTP Şifre
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Şifreleme Türü
        $mail->Port = 587; // SMTP Portu

        // Gönderici ve Alıcı Bilgileri
        $mail->setFrom('aktasoguzhan80@gmail.com', 'Quick Survey'); // Gönderen
        $mail->addAddress($email); // Alıcı e-posta

        // E-posta İçeriği
        $mail->isHTML(true); // HTML içerik gönderimi
        $mail->Subject = $subject; // E-posta Konusu
        $mail->Body = $message; // HTML Mesaj
        $mail->AltBody = strip_tags($message); // Alternatif düz metin mesajı

        // E-posta Gönderimi
        $mail->send();
        return "E-posta başarıyla gönderildi.";
    } catch (Exception $e) {
        return "E-posta gönderilemedi. Hata: " . $mail->ErrorInfo;
    }
}


