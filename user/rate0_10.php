<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";
$survey_fields=Survey_fields::getSurveyFieldsById($_GET["sf"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Question</title>
    <style>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #4b0082; /* Purple background */
            color: #fff;
            display: flex;
            justify-content: flex-end; /* Align to the right */
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .survey-container {
            background-color:  <?= $_GET["bg"] ?>; /* Slightly darker purple */
            padding: 20px;
            border-radius: 8px;
            width: 600px; /* Enini büyüttük */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative; /* To place the buttons at the bottom */
            box-sizing: border-box;
            margin-right: 65px;
            height: 350px; /* Adjusted height */
        }

        .question-number {
            font-size: 14px;
            color: #aaa;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .rating-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .star {
            font-size: 30px;
            cursor: pointer;
            color: #aaa;
            transition: color 0.3s ease-in-out;
        }

        .star.selected {
            color: #FFD700; /* Gold for selected stars */
        }

        .buttons-container {
            display: flex;
            justify-content: end;
            position: absolute;
            bottom: 40px;
            width: 90%;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50; /* Green color for other buttons */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 0 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        #prevButton {
            background-color: #FFA500; /* Orange color for Prev button */
        }

        #prevButton:hover {
            background-color: #ff8c00;
        }

        #prevButton:active {
            transform: scale(0.95); /* Button press animation */
        }

        .button:hover {
            background-color: #45a049;
        }

        .button:active {
            transform: scale(0.95); /* Button press animation */
        }
        @media screen and (max-width: 768px) {
            .survey-container {
                width: 100%; /* Daha dar ekranlarda genişliği %100 yapalım */
                margin-right: 0; /* Sağdaki boşluğu sıfırlıyoruz */
                margin-left: 0; /* Soldan da boşluk bırakmıyoruz */
                padding: 15px; /* İç padding'i ayarlıyoruz */
                height: auto; /* Yükseklik içeriğe göre uyumlu hale gelsin */
            }

            button {
                font-size: 14px; /* Buton metnini küçültüyoruz */
                padding: 8px 16px; /* Butonun iç padding'ini küçültüyoruz */
            }

            .star {
                font-size: 18px; /* Yıldızları orantılı şekilde küçültüyoruz */
            }

            h2 {
                font-size: 16px; /* Başlık boyutunu küçültüyoruz */
            }
        }


        @media screen and (max-width: 480px) {
            .survey-container {
                width: 95%; /* Ekran daha küçükse %95 genişlik verelim */
                padding: 15px; /* İç padding'i küçültüyoruz */
            }

            .star {
                font-size: 16px; /* Yıldızları daha da küçültüyoruz */
            }

            button {
                font-size: 12px; /* Buton font boyutunu küçük yapıyoruz */
                padding: 6px 12px; /* Buton padding'ini küçük yapıyoruz */
            }
        }
    </style>

    </style>

</head>
<body>
<div class="survey-container">
    <div class="question-number"><?= Survey_fields::getOrderOfSurveyField($_GET["sf"])?> of <?= Survey::getCountOfFields($survey_fields["survey_id"])?></div>
    <h2><?= $_GET["field_title"]?></h2>
    <form action="next.php" method="POST">
    <input type="hidden" name="survey_field_id" value="<?= $_GET["sf"]?>">
    <input type="hidden" name="value" id="rateBox" value="">
    <div class="rating-container">
        <div class="rating-box" data-value="0">0</div>
        <div class="rating-box" data-value="1">1</div>
        <div class="rating-box" data-value="2">2</div>
        <div class="rating-box" data-value="3">3</div>
        <div class="rating-box" data-value="4">4</div>
        <div class="rating-box" data-value="5">5</div>
        <div class="rating-box" data-value="6">6</div>
        <div class="rating-box" data-value="7">7</div>
        <div class="rating-box" data-value="8">8</div>
        <div class="rating-box" data-value="9">9</div>
        <div class="rating-box" data-value="10">10</div>
    </div>

    <div class="buttons-container">
        <button class="button" id="nextButton" type="submit"<?php
        if($_GET["e"]==1) {
            ?> disabled <?php
        }
        ?>>Next</button>
    </div></form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/user/base.php";?>

<style>
    .rating-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .rating-box {
        width: 40px;
        height: 30px;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(65, 91, 145, 0.8); /* Transparent background */
        color: white;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }


    .rating-box.selected {
        background-color: burlywood; /* Gold color for selected box */
        color: #fff;
    }

    .rating-box:hover {
        background-color:  <?= $_GET["bg"] ?>; /* Slightly darker purple on hover */
        color: #fff;
    }
</style>

<script>
    const boxes = document.querySelectorAll('.rating-box');
    let selectedValue = 0;

    boxes.forEach(box => {
        box.addEventListener('click', () => {
            // Remove selected class from all boxes
            boxes.forEach(b => b.classList.remove('selected'));

            // Add selected class to the clicked box
            box.classList.add('selected');
            selectedValue = parseInt(box.dataset.value);
            document.getElementById("rateBox").value = selectedValue; // Set the hidden input field value to the selected value
            console.log(`Selected Value: ${selectedValue}`);
        });
    });
</script>


</body>
</html>
