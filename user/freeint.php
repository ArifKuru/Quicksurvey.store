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
            padding: 0;
        }

        .survey-container {
            background-color:  <?= $_GET["bg"] ?>; /* Slightly darker purple */
            padding: 20px;
            border-radius: 8px;
            width: 410px; /* Adjusted width */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative; /* To place the buttons at the bottom */
            box-sizing: border-box;
            margin-right: 65px;
            height: 300px; /* Adjusted height */
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
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
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

        .button.selected {
            background-color: #36c36c;
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

        @media (max-width: 576px) {
            body {
                justify-content: center; /* Center align for smaller screens */
            }

            .survey-container {
                width: 100%; /* Full width for smaller screens */
                margin: 0;
                border-radius: 0; /* Remove border-radius for full width */
                height: 400; /* Allow height to adjust dynamically */
                padding: 15px;
            }

            .buttons-container {
                justify-content: flex-end;
                bottom: 20px; /* Adjusted position for mobile */
            }
        }
    </style>
</head>
<body>
<div class="survey-container">
    <div class="question-number"><?= Survey_fields::getOrderOfSurveyField($_GET["sf"])?> of <?= Survey::getCountOfFields($survey_fields["survey_id"])?></div>
    <h2><?= $_GET["field_title"]?></h2>
<form method="POST" action="next.php">
    <div class="input-container">
        <input type="hidden"
        name="survey_field_id"
        value="<?= $_GET["sf"]?>"
        >
        <input type="number" name="value" id="satisfactionInput" min="0" max="10" value="5" step="1" />
    </div>

    <div class="buttons-container">
        <button class="button" id="nextButton" type="submit" <?php
        if($_GET["e"]==1) {
            ?> disabled <?php
        }
        ?>>Finish</button>
    </div>
</form>
</div>
<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/user/base.php";
?>

</body>
</html>
