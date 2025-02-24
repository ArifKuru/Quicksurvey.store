<?php
$pageTitle="Survey | QuickSurvey";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";

$survey_hash_id=$_GET["h"];

$survey=Survey::getByHashId($survey_hash_id);

//NAVIGATION FOR EXPIRE AND CASE REFILL
?>

<html lang="en">
<head>
    <?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/partials/dependencies.php";
    ?>
</head>
<body class="p-0" style="background-color: <?= $survey["backgroundColor"] ?> ">
<iframe src="/user/landing.php?h=<?= $_GET["h"] ?>" style="height: 100%;width: 100%" class="p-0 m-0"></iframe>
</body>
</html>
