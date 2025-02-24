<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";

header("Content-Type: application/json");

// HTTP method kontrolü
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only POST requests are allowed']);
    exit;
}

// Girdi doğrulama
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['survey_id']) || !is_numeric($data['survey_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid or missing survey_id']);
    exit;
}

$survey_id = (int) $data['survey_id'];

try {
    // Sınıfı kullanarak survey field oluştur
    $lastInsertId = Survey_fields::createSurveyFields($survey_id);

    // Başarılı yanıt
    echo json_encode([
        'success' => true,
        'message' => 'Survey field created successfully',
        'field_id' => $lastInsertId
    ]);
} catch (PDOException $e) {
    // Hata durumunda yanıt
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}