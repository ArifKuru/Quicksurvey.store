<?php
$pageTitle="AD";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";


$survey_hash_id=$_GET["h"];

$survey=Survey::getByHashId($survey_hash_id);


// Şu anki tarihi al
$current_date = date('Y-m-d'); // Yıl-ay-gün formatında al

// Survey expiration date kontrolü
if (isset($survey["exp_date"]) && strtotime($survey["exp_date"]) < strtotime($current_date)) {
    // hash_id_from_cookie değerini al
    $hash_id_from_cookie = $survey_hash_id ?? ''; // Çerezden al

    // Başarılı sayfaya yönlendir
    header("Location: /success?h=" . urlencode($hash_id_from_cookie));
    exit; // Yönlendirme sonrası kodun devamını engelle
}
//NAVIGATION FOR EXPIRE AND CASE REFILL
// Check if the cookie exists
if (isset($_COOKIE["survey_hash_id"]) && $_COOKIE["survey_hash_id"]==$_GET["h"]) {
    $hash_id_from_cookie = $_COOKIE["survey_hash_id"];
    header("Location: /success?h=" . urlencode($hash_id_from_cookie));
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Web Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            font-family: 'Poppins', sans-serif;
        }

        .social-icons {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 13px;
            z-index: 1000;
        }

        .social-icons a {
            color: #1DA1F2;
            font-size: 28px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #ffeb3b;
        }

        .bottom-left-image {
            position: fixed;
            margin-left: 5px;
            bottom: 0;
            left: 0;
            width: 150px;
            height: auto;
        }

        .video-container {
            position: relative;
            width: 90%;
            height: 75%;
            overflow: hidden;
            background-color: #f5f5fc;
        }

        video {
            position: absolute;
            top: 50%;
            left: 20%;
            transform: translate(-50%, -50%);
            width: auto;
            height: 100%;
            object-fit: cover;
        }

        .form-container {
            position: absolute;
            right: 8%;
            top: 12%;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-container:hover {
            box-shadow: 0 25px 35px rgba(0, 0, 0, 0.15);
        }

        .form-container input,
        .form-container button {
            width: 100%;
            margin-bottom: 20px;
            padding: 15px;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-container input:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .form-container button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .form-container input {
            background-color: #f9f9f9;
            color: #333;
            box-sizing: border-box;
        }

        .form-container select {
            cursor: pointer;
            background-image: url('data:image/svg+xml,...');
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        .welcome-text {
            position: fixed;
            top: 0;
            left: 0;
            margin-left: 77px;
            width: auto;
            height: auto;
            z-index: 100;
            text-align: left;
        }

        .welcome-text h1, .welcome-text p, .welcome-text .team-name {
            margin: 0;
            padding: 5px 0;
        }

        @keyframes fadeInPlace {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .welcome-text h1 {
            color: black;
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
        }

        .welcome-text .team-name {
            font-size: 11px;
            animation: fadeInPlace 3s ease-out forwards;
        }

        .welcome-text p {
            margin: 0;
            padding: 5px 0;
            font-size: 12px;
        }

        /* Mobil uyumluluk */
        @media (max-width: 768px) {

            .form-container {
                width: auto; /* Mobilde daha geniş, yüzde 80 */
                height: auto; /* Yükseklik dinamik olacak */
                top: 62%;
                right: 0%;
                padding: 20px 30px; /* İç boşluklar aynı kaldı */
                margin: 0 auto; /* Merkezi yerleştirmek için margin */
                position: relative; /* Konumlandırma için relative kullanıldı */
                box-sizing: border-box; /* Padding'in boyutu etkilememesi için */
            }

            .form-container select,
            .form-container input {
                width: 100%; /* Full width for smaller screens */
                margin: 0;
                border-radius: 0; /* Remove border-radius for full width */
                height: 400; /* Allow height to adjust dynamically */
                padding: 15px;
            }
            .form-container button{
                width: 100%; /* Mobilde genişlik yüzde 100 olacak */
                top: 5%;
                padding: 15px; /* İç boşlukları azaltabiliriz */
                box-sizing: border-box; /* Padding'in boyutu etkileyebilmesi için */
                position: relative; /* Z-index için konumlandırma ekledik */
                z-index: 10; /* Buton ve input'un diğer elemanlar üstünde görünmesi için z-index */
            }
            .social-icons {
                position: fixed; /* Sabit pozisyon */
                top: 10px;       /* Ekranın üst kısmına 10px uzaklık */
                right: 10px;     /* Ekranın sağ kısmına 10px uzaklık */
                display: flex;   /* Flexbox kullanarak öğeleri hizalama */
                justify-content: center; /* İkonları yatayda ortalama */
                gap: 15px;        /* İkonlar arasındaki boşluğu azalttık */
                z-index: 1000;   /* Diğer öğelerin önünde görünmesini sağlar */
            }

            .social-icons a {
                font-size: 25px; /* İkon boyutunu koruduk */
            }
            .welcome-text h1 {
                position: fixed;
                top: 0;
                left: 0;
                margin: 10px; /* İsteğe bağlı, başlık ile ekran kenarı arasında boşluk bırakmak için */
                font-size: 100px; /* İsteğe bağlı, yazı boyutunu ayarlamak için */
            }
            .welcome-text {
                position: fixed;
                top: 5%;
                left: 0;
                margin-left: 12px;
                width: auto;
                height: auto;
                z-index: 100;
                text-align: left;
            }

            video {
                top: 30%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
                height: auto;

            }

            .social-icons {
                top: 10px;
                right: 10px;
                font-size: 22px;
            }

            .bottom-left-image {
                position: fixed; /* Sabit pozisyon */
                bottom: 10px;    /* Ekranın altına 10px uzaklık */
                left: 5px;      /* Ekranın soluna 10px uzaklık */
                width: 100px;    /* Sabit genişlik */
                height: auto;    /* Yükseklik oranına göre ayarlanacak */
                z-index: 1000;   /* Diğer öğelerin önünde görünmesini sağlar */
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 15px 20px;
                font-size: 14px;
            }

            .form-container input,
            .form-container button {
                padding: 10px;
                font-size: 14px;
            }

            .social-icons a {
                font-size: 20px;
            }

            .welcome-text h1 {
                font-size: 12px;
            }

            .welcome-text p {
                font-size: 9px;
            }

            .welcome-text .team-name {
                font-size: 8px;
            }

            .bottom-left-image {
                width: 80px;
            }
        }
    </style>
</head>
<body>
<div class="video-container">
    <video autoplay loop muted>
        <source src="/public/video/templates-rotation-homepage.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="form-container">
        <form action="/main/start.php" method="POST">
            <label for="name">First Name</label>
            <input type="hidden" id="hash_id" name="hash_id" value="<?=$_GET["h"]?>">
            <input type="text" id="name" name="name" placeholder="Enter your first name" required>

            <label for="surname">Last Name</label>
            <input type="text" id="surname" name="surname" placeholder="Enter your last name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <button type="submit">Start</button>
        </form>

    </div>

    <div class="social-icons">
        <a href="https://twitter.com" target="_blank"><i class="fa-brands fa-twitter"></i></a>
        <a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i></a>
        <a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
        <a href="https://www.linkedin.com" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
    </div>

    <img src="/public/img/resim5.png" alt="Logo" class="bottom-left-image">

    <div class="welcome-text">
        <h1>Welcome to QuickSurvey</h1>
        <p>
            We value your feedback! Please let us know how we did by rating our service and leaving your comments.
            Your input helps us improve and serve you better.
        </p>
        <div class="team-name">~ QuickSurvey Team</div>
    </div>

</div>
</body>
</html>
