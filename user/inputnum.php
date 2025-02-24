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
        body {
            font-family: Arial, sans-serif;
            background-color: #4b0082;
            color: #fff;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .survey-container {
            background-color:  <?= $_GET["bg"] ?>;
            padding: 20px;
            border-radius: 8px;
            width: 410px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            box-sizing: border-box;
            margin-right: 65px;
            height: 340px;
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

        .input-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .input-container input[type="number"] {
            background-color: rgba(65, 91, 145, 0.8);
            border: none;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-container input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 15px;
            background: linear-gradient(to right, red, green);
            border-radius: 5px;
            outline: none;
        }

        .input-container input[type="range"]:hover {
            background: linear-gradient(to right, red, green);
        }

        .input-container input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            cursor: pointer;
        }

        .input-container input[type="range"]:active::-webkit-slider-thumb {
            background: #ff8c00;
        }

        .range-value {
            font-size: 16px;
            color: #fff;
            text-align: center;
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
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            margin: 0 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        #prevButton {
            background-color: #FFA500;
        }

        #prevButton:hover {
            background-color: #ff8c00;
        }

        #prevButton:active {
            transform: scale(0.95);
        }

        .button:hover {
            background-color: #45a049;
        }

        .button:active {
            transform: scale(0.95);
        }

        .button.selected {
            background-color: #36c36c;
            animation: buttonAnimation 0.5s ease-in-out;
        }

        @keyframes buttonAnimation {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 576px) {
            body {
                justify-content: center;
            }

            .survey-container {
                width: 100%;
                margin: 20px auto 0;
                border-radius: 10px;
                height: auto;
                padding: 15px;
            }

            .buttons-container {
                justify-content: space-between;
                position: static;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
<div class="survey-container">
    <div class="question-number"><?= Survey_fields::getOrderOfSurveyField($_GET["sf"])?> of <?= Survey::getCountOfFields($survey_fields["survey_id"])?></div>
    <h2><?= $_GET["field_title"]?></h2>

    <form method="POST" action="/main/next.php">
        <input type="hidden" name="survey_field_id" value="<?= $_GET["sf"]?>">
    <div class="input-container">
        <input type="number" id="satisfactionInput" name="value" min="0" max="100" value="50" step="1" />
        <input type="range" id="satisfactionRange" min="0" max="100" value="50" step="1" />
        <div class="range-value" id="rangeValue">50</div>
    </div>

    <div class="buttons-container">
        <button class="button" id="nextButton" type="submit" <?php
        if($_GET["e"]==1) {
            ?> disabled <?php
        }
        ?>>Next</button>
    </div>
    </form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/user/base.php";?>
<script>
    // Prev button: Redirect to multiplechoice.php

    // Next button: Redirect to polarquestions.php

    // Synchronize input and range slider
    const satisfactionInput = document.getElementById('satisfactionInput');
    const satisfactionRange = document.getElementById('satisfactionRange');
    const rangeValue = document.getElementById('rangeValue');

    satisfactionInput.addEventListener('input', function() {
        satisfactionRange.value = satisfactionInput.value;
        rangeValue.textContent = satisfactionInput.value;
    });

    satisfactionRange.addEventListener('input', function() {
        satisfactionInput.value = satisfactionRange.value;
        rangeValue.textContent = satisfactionRange.value;
    });
</script>
</body>
</html>
