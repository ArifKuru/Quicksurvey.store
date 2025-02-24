<style>
    body {
        font-family: Arial, sans-serif;
        background-color: <?= $_GET["bg"] ?>; /* Purple background */
        color: <?= $_GET["font"] ?>;
        display: flex;
        justify-content: flex-end; /* Align content to the right */
        align-items: center;
        height: 100vh;
        margin: 0;
        padding: 0;
    }


    .social-icons {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        gap: 10px;
    }

    .social-icons a {
        color: white;
        font-size: 25px;
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: #ffeb3b;
    }

    .welcome-text {
        position: absolute;
        left: 25px;
        top: 40%;
        transform: translateY(-50%);
        text-align: left;
        width: 500px;
    }

    .welcome-text h1 {
        font-size: 20px;
        margin: 0;
    }

    .welcome-text p {
        font-size: 14px;
        margin: 10px 0;
    }

    .team-name {
        font-style: italic;
        font-size: 14px;
    }

    .bottom-left-image {
        position: absolute;
        bottom: 10px;
        left: 10px;
        width: 150px;
        height: auto;
    }

    /* Mobil uyumlu tasarım */
    @media screen and (max-width: 768px) {
        body {
            justify-content: center;
            align-items: flex-start;
        }

        .survey-container {
            margin-top: 250px;
        }

        .welcome-text {
            width: 90%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            text-align: center;
        }

        .social-icons {
            top: 10px;
            right: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .social-icons a {
            font-size: 20px;
        }

        .bottom-left-image {
            position: relative;
            bottom: 0;
            left: 0;
            width: 100px;
            height: auto;
        }
    }
    @media screen and (max-width: 768px) {
        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
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


        .welcome-text {
            text-align: center;
            width: 100%;
            position: absolute; /* Mutlak konum */
            top: 10%; /* Ekranın üstünden %10 aşağıda */
            left: 50%; /* Yatayda merkezle */
            transform: translate(-50%, 0); /* Ortalamayı tamamlama */
        }

        .bottom-left-image {
            position: fixed; /* Sabit pozisyon */
            bottom: 10px;    /* Ekranın altına 10px uzaklık */
            left: 10px;      /* Ekranın soluna 10px uzaklık */
            width: 100px;    /* Sabit genişlik */
            height: auto;    /* Yükseklik oranına göre ayarlanacak */
            z-index: 1000;   /* Diğer öğelerin önünde görünmesini sağlar */
        }

    }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="social-icons">
    <a href="https://twitter.com" target="_blank"><i class="fa-brands fa-twitter"></i></a>
    <a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i></a>
    <a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
    <a href="https://www.linkedin.com" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
</div>

<div class="welcome-text">
    <h1 style="font-size: 36px;"><?= $_GET["title"] ?> </h1>
    <p style="font-size: 20px;">
        <?= $_GET["desc"] ?>
    </p>
    <div class="team-name" style="font-size: 18px;">- <?= $_GET["company"] ?></div>
</div>

<img src="/public/img/resim5.png" alt="Logo" class="bottom-left-image">