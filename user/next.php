<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/responses.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/surveyFrameGenerator.php";

$survey_field_id = $_POST['survey_field_id'];
$value = $_POST["value"];
$profile_id = $_SESSION["profile_id"];

$result = Responses::create($survey_field_id, $value, $profile_id);

$next_survey_field_id = Survey_fields::getNextSurveyField($survey_field_id);

$frame = SurveyFrameGenerator::generateFrameSrc($next_survey_field_id);

$frame_src = $frame["frame_src"] ?? null;

if ($frame_src) {
    header("Location: $frame_src");
} else {

    $survey_field=Survey_fields::getSurveyFieldsById($survey_field_id);
    $survey=Survey::getById($survey_field["survey_id"]);
    $hash_id = $survey["hash_id"];
    $link="/success"."?h=".urlencode($hash_id);
    setcookie("survey_hash_id", $hash_id, time() + 48 * 3600, "/", "", false, true);
    header("Location: $link");
}
exit;
