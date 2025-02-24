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
            background-color: <?= $_GET["bg"] ?>; /* Slightly darker purple */
            padding: 20px;
            border-radius: 8px;
            width: 410px; /* Increased width */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            box-sizing: border-box;
            margin-right: 65px;
            height: 400px; /* Increased height */
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

        .yes-no-buttons {
            display: flex;
            flex-direction: column;
            gap: 21px; /* Space between Yes and No buttons */
            align-items: center; /* Butonları ortalamak için */
        }

        .yes-no-buttons button {
            width: 100%; /* Butonları tam genişlikte yap */
            background-color: rgba(65, 91, 145, 0.8); /* Default color for Yes/No buttons */
            transition: all 0.3s ease;
            padding: 12px;
            border-radius: 8px;
        }

        .yes-no-buttons button:hover {
            transform: scale(1.1); /* Grow effect on hover */
        }

        #yesButton.selected {
            background-color: #45b045; /* Yeşil renk */
            border: 3px solid #fff; /* Beyaz çerçeve */
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8); /* Işık efekti */
        }

        #noButton.selected {
            background-color: #ff4d4d; /* Kırmızı renk */
            border: 3px solid #fff; /* Beyaz çerçeve */
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8); /* Işık efekti */
        }

        #yesButton:hover {
            background-color: #45b045; /* Yeşil renk */
        }

        #noButton:hover {
            background-color: #ff4d4d; /* Kırmızı renk */
        }

        @keyframes buttonClickAnimation {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(0.9);
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
                height: 330px; /* Allow height to adjust dynamically */
                padding: 15px;
            }

            .buttons-container {
                justify-content: flex-end;
                bottom: 20px; /* Adjusted position for mobile */
            }

            .yes-no-buttons {
                width: 100%; /* Ensure buttons take full width */
            }

            .yes-no-buttons button {
                width: 100%; /* Full width for Yes/No buttons */
                font-size: 14px; /* Adjust text size for smaller screens */
                padding: 12px;
            }
        }
    </style>
</head>
<body>
<div class="survey-container">
    <div class="question-number"><?= Survey_fields::getOrderOfSurveyField($_GET["sf"])?> of <?= Survey::getCountOfFields($survey_fields["survey_id"])?></div>
    <h2><?= $_GET["field_title"]?></h2>
    <form
            action="/main/next.php" method="POST">
        <input type="hidden" name="survey_field_id" value="<?= $_GET["sf"]?>">
        <input type="hidden" name="value" id="valueInput" value="">
    <div class="yes-no-buttons">
        <button class="button" type="button" id="yesButton">Yes</button>
        <button class="button" type="button" id="noButton">No</button>
    </div>

    <div class="buttons-container">
        <button class="button" id="nextButton" type="submit"<?php
        if($_GET["e"]==1) {
            ?> disabled <?php
        }
        ?>>Next</button>
    </div>
    </form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/user/base.php";?>

<script>
    // Button selection animation for Yes and No
    document.getElementById("yesButton").addEventListener("click", function() {
        this.classList.add("selected");
        document.getElementById("noButton").classList.remove("selected"); // Remove selected from No
        document.getElementById("valueInput").value="1";
    });

    document.getElementById("noButton").addEventListener("click", function() {
        this.classList.add("selected");
        document.getElementById("yesButton").classList.remove("selected"); // Remove selected from Yes
        document.getElementById("valueInput").value="0";

    });


</script>
</body>
</html>
