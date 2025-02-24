<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";
header("Content-Type: application/json");

// HTTP method kontrolü
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

// `survey_id` parametresinin alınması
if (!isset($_GET['survey_id']) || !is_numeric($_GET['survey_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid or missing survey_id']);
    exit;
}

$survey_id = (int) $_GET['survey_id'];

try {
    // Sınıfı kullanarak survey field'leri getir
    $fields = Survey_fields::getSurveyField($survey_id);

    // Eğer sonuç boşsa
    if (empty($fields)) {
        echo json_encode([
            'success' => false,
            'message' => 'No survey fields found for the given survey_id'
        ]);
        exit;
    }

    // Başarılı yanıt
    echo json_encode([
        'success' => true,
        'fields' => $fields
    ]);
} catch (PDOException $e) {
    // Hata durumunda yanıt
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}