<!DOCTYPE html>
<html lang="en">
<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey.class.php";
$hash_id= $_GET["h"];
$survey=Survey::getByHashId($hash_id);
$bg=$survey["backgroundColor"];
$f=$survey["fontColor"];
$title=$survey["title"];
$description=$survey["description"];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You Page</title>
    <link rel="icon" type="image/x-icon" href="/public/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hint.css/2.7.0/hint.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: <?= $bg ?>;
            color: <?= $f ?>;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: start;
            padding: 10px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            box-sizing: border-box;
        }
        .title {
            font-size: 2em;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .description {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        .social-icons {
            margin-top: 20px;
        }
        .social-icons a {
            margin: 0 10px;
            color: white;
            text-decoration: none;
            font-size: 1.8em;
        }
        .social-icons a:hover {
            color: #1abc9c;
        }
        .thank-you {
            font-size: 1.5em;
            margin-top: 20px;
        }
        .image img {
            max-width: 100%;
            height: auto;
        }
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
                text-align: center;
            }
            .col-6 {
                width: 100%;
                margin-bottom: 20px;
            }
            .social-icons a {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row d-flex flex-wrap justify-content-between">
        <div class="col-6">
            <div class="title"> <?= $title ?></div>
            <div class="description"> <?= $description ?></div>
            <div class="thank-you">Thank you for participating in our survey!</div>
            <div class="social-icons d-flex justify-content-center">
                <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <a href="/" class="btn btn-primary btn-md">Home</a>
            </div>
        </div>
        <div class="col-6 image">
            <img src="/public/img/like.png" alt="Like Icon">
        </div>
    </div>
</div>
</body>
</html>
