<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/responses.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/survey_fields.class.php";

$survey_id = $_GET["surveyId"];
$survey_fields = Survey_fields::getSurveyFieldTexts($survey_id);

$responseData = [];

foreach ($survey_fields as $survey_field) {
    $response = Responses::getValueCounts($survey_field["id"]);
    $responseData[] = [
        "type_id" => $survey_field["type_id"],
        "title" => $survey_field["title"],
        "data" => $response
    ];
}

// JSON formatında çıktı döndür
header('Content-Type: application/json');
echo json_encode($responseData);
