<?php
// Oturum başlat
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Gerekli sınıfları dahil et
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/form_types.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/user.class.php";

// CORS (isteğe bağlı)
header("Content-Type: application/json");

// survey_fields_id kontrolü
if (!isset($_GET["survey_fields_id"]) || !is_numeric($_GET["survey_fields_id"])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid or missing survey_fields_id']);
    exit;
}

try {
    // survey_fields_id al
    $survey_fields_id = $_GET["survey_fields_id"];

    // Oturumdan kullanıcı bilgilerini al
    if (!isset($_SESSION["user_id"])) {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }


    // Survey field bilgilerini al
    $survey_fields = Survey_fields::getSurveyFieldsById($survey_fields_id);

    if (!$survey_fields) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Survey field not found']);
        exit;
    }

    // Survey bilgilerini al
    $survey = Survey::getById($survey_fields["survey_id"]);
    $user = User::getUserById($survey["created_by"]);

    if (!$survey) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Survey not found']);
        exit;
    }

    // Form türünü al
    $form_types = Form_types::get_form_type($survey_fields["type_id"]);

    if (!$form_types) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Form type not found']);
        exit;
    }

    // Frame src URL'sini oluştur
    $frame_src = $form_types["path_name"]
        ."?bg=".urlencode($survey["backgroundColor"])
        ."&font=".urlencode($survey["fontColor"])
        ."&title=".urlencode($survey["title"])
        ."&desc=".urlencode($survey["description"])
        ."&company=".urlencode($user["company_name"])
        ."&field_title=".urlencode($survey_fields["title"])
        ."&sf=".urlencode($survey_fields_id)
        ."&e="."1";

    // JSON olarak frame src'yi döndür
    echo json_encode([
        'success' => true,
        'frame_src' => $frame_src
    ]);

} catch (Exception $e) {
    // Genel hata yönetimi
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'An error occurred',
        'details' => $e->getMessage()
    ]);
}
