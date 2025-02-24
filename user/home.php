<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";
$survey_fields=Survey_fields::getSurveyFieldsById($_GET["sf"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickSurvey Feedback</title>
    <style>
        .survey-container {
            background-color: <?= $_GET["bg"] ?>; /* Slightly darker purple */
            padding: 20px;
            border-radius: 8px;
            width: 450px; /* Adjusted width */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            box-sizing: border-box;
            margin-right: 65px;
            height: 400px; /* Adjusted height */
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

        .emoji-rating {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 20px 0;
        }

        .emoji-rating input {
            display: none;
        }

        .emoji-rating label {
            cursor: pointer;
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .emoji-box {
            margin-top: 55px;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #ccc;
            border-radius: 10px;
            transition: transform 0.3s ease, background-color 0.3s ease;
            font-size: 30px;
        }

        .emoji-rating input:checked + label .emoji-box {
            background-color: #ffeb3b;
            border-color: orange;
        }

        .emoji-rating label:hover .emoji-box {
            transform: scale(1.2);
        }

        .buttons-container {
            display: flex;
            justify-content: flex-end;
            position: absolute;
            bottom: 40px;
            width: 90%;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        button:active {
            transform: scale(0.95); /* Button press animation */
        }

        @media screen and (max-width: 768px) {
            body {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                flex-direction: column;
            }
            .survey-container {
                width: 100%;
                margin-right: 0;
                height: auto;
            }

            .survey-container {
                width: 100%;
                height: auto;
            }

            .emoji-rating {
                flex-direction: row; /* Dikey hizalama */
                justify-content: space-between;
                align-items: center;
            }

            .emoji-rating label {
                width: 100%; /* iketleri tam genişlikte yap */
                text-align: center;
                margin-bottom: 65px;
            }

            .buttons-container {
                width: 90%;
                display: flex;
                justify-content: flex-end;
                margin-top: 20px;

            }


        }

    </style>
</head>
<body>
<div class="survey-container">
    <form action="next.php" method="POST">
        <input type="hidden" name="survey_field_id" value="<?= $_GET["sf"]?>">
        <input type="hidden" id="ratingInput" name="value" value=""> <!-- Gizli input alanı -->

        <div class="question-number"><?= Survey_fields::getOrderOfSurveyField($_GET["sf"])?> of <?= Survey::getCountOfFields($survey_fields["survey_id"])?></div>
        <h2><?= $_GET["field_title"]?></h2>

        <div class="emoji-rating">
            <input type="radio" name="rating" id="rating-1" value="1">
            <label for="rating-1">
                <div class="emoji-box" onclick="setRating(1)">😡</div>
            </label>

            <input type="radio" name="rating" id="rating-2" value="2">
            <label for="rating-2">
                <div class="emoji-box" onclick="setRating(2)">😕</div>
            </label>

            <input type="radio" name="rating" id="rating-3" value="3">
            <label for="rating-3">
                <div class="emoji-box" onclick="setRating(3)">😐</div>
            </label>

            <input type="radio" name="rating" id="rating-4" value="4">
            <label for="rating-4">
                <div class="emoji-box" onclick="setRating(4)">🙂</div>
            </label>

            <input type="radio" name="rating" id="rating-5" value="5">
            <label for="rating-5">
                <div class="emoji-box" onclick="setRating(5)">😍</div>
            </label>
        </div>

        <div class="buttons-container">
            <button type="submit" id="nextButton" <?php
            if($_GET["e"]==1) {
                ?> disabled <?php
            }
            ?>>Next</button>
        </div>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}
?>


</div>
<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/user/base.php";
?><script>
    function setRating(value) {
        // Rating input değerini güncelle
        document.getElementById('ratingInput').value = value;

        // Seçilen emojiye görsel efekt ekleyin (isteğe bağlı)
        document.querySelectorAll('.emoji-box').forEach(box => box.classList.remove('selected'));
        event.target.classList.add('selected');
    }
</script>
</body>
</html>
