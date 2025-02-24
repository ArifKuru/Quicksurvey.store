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
            background-color: #4b0082; /* Purple background */
            color: #fff;
            display: flex;
            justify-content: flex-end; /* Align to the right */
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0; /* Remove padding to ensure proper layout */
        }

        .survey-container {
            background-color: <?= $_GET["bg"] ?>; /* Slightly darker purple */
            padding: 20px;
            border-radius: 8px;
            width: 410px; /* Enini büyüttük */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative; /* To place the buttons at the bottom */
            box-sizing: border-box; /* Ensure padding does not affect layout */
            margin-right: 65px; /* Add space between the container and the right edge */
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

        .options {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 50px; /* Adjust bottom margin for button space */
            flex-grow: 1; /* Allow options to take more space */
        }

        .option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(65, 91, 145, 0.8); /* Darker purple for options */
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .option input[type="radio"] {
            display: none;
        }

        .option .circle {
            width: 20px;
            height: 20px;
            border: 2px solid #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .option:hover .circle {
            border-color: #36c36c; /* Highlight on hover */
        }

        .option input[type="radio"]:checked + .circle {
            background-color: #36c36c; /* Green fill for selected */
            border-color: #36c36c;
        }

        .option input[type="radio"]:checked + .circle::after {
            content: "✓";
            color: #fff;
            font-size: 14px;
            animation: tickAppear 0.3s ease-in-out;
        }

        .option span {
            font-size: 16px;
            flex-grow: 1;
            margin-left: 10px;
            text-align: left;
        }

        /* Tick Animation */
        @keyframes tickAppear {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .buttons-container {
            display: flex;
            justify-content: end;
            position: absolute;
            bottom: 20px;
            width: 90%;
            box-sizing: border-box; /* Butonların container'a düzgün sığmasını sağlar */
        }

        button {
            background-color: #4CAF50; /* Green color for other buttons */
            border: none;
            color: white;
            padding: 10px 20px; /* Diktörgen şekil için genişlik ve yükseklik ayarı */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 0 10px; /* Butonlar arasına aralık */
            cursor: pointer;
            border-radius: 5px; /* Kenarları hafif yuvarlatılmış */
        }

        #prevButton {
            background-color: #FFA500; /* Orange color for Prev button */
        }

        #prevButton:hover {
            background-color: #ff8c00; /* Darker orange on hover */
        }

        #prevButton:active {
            transform: scale(0.95); /* Button press animation */
        }

        .button:hover {
            background-color: #45a049; /* Green background on hover */
        }

        .button:active {
            transform: scale(0.95); /* Button press animation */
        }

        .button.selected {
            background-color: #36c36c; /* Selected button color */
            animation: buttonAnimation 0.5s ease-in-out;
        }

        /* Button selection animation */
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

        /* Mobile optimization */
        @media (max-width: 576px) {
            body {
                justify-content: center;
            }

            .survey-container {
                width: 100%;
                margin: 0;
                border-radius: 0; /* Remove border-radius for full width */
                height: auto; /* Allow height to adjust dynamically */
                padding: 15px;
            }

            .buttons-container {
                justify-content: flex-end;
                bottom: 10px; /* Adjusted position for mobile */
            }
        }
    </style>
</head>
<body>
<div class="survey-container">
    <div class="question-number"><?= Survey_fields::getOrderOfSurveyField($_GET["sf"])?> of <?= Survey::getCountOfFields($survey_fields["survey_id"])?></div>
    <h2><?= $_GET["field_title"]?></h2>
    <form action="/main/next.php" method="POST">
        <input type="hidden" name="survey_field_id" value="<?= $_GET["sf"]?>">
        <input type="hidden" id="recommendInput" name="value" value="">

        <div class="options">
        <label class="option">
            <input type="radio" name="recommend" value="no"  onclick="setRecommendValue('no')">
            <div class="circle"></div>
            <span>No</span>
        </label>
        <label class="option">
            <input type="radio" name="recommend" value="maybe"  onclick="setRecommendValue('maybe')" checked>
            <div class="circle"></div>
            <span>Maybe</span>
        </label>
        <label class="option">
            <input type="radio" name="recommend" value="probably"  onclick="setRecommendValue('probably')">
            <div class="circle"></div>
            <span>Probably</span>
        </label>
        <label class="option">
            <input type="radio" name="recommend" value="sure"  onclick="setRecommendValue('sure')">
            <div class="circle"></div>
            <span>100% Sure</span>
        </label>
    </div>

    <!-- Button container inside the main survey box -->
    <div class="buttons-container">
        <button class="button" id="nextButton" type="submit" <?php
        if($_GET["e"]==1) {
            ?> disabled <?php
        }
        ?>>Next</button>
    </div></form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/user/base.php";?>

<script>
    function setRecommendValue(value) {
        document.getElementById('recommendInput').value = value;
    }

</script>
</body>
</html>
