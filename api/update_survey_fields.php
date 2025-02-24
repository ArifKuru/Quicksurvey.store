<?php
// Gerekli dosyaları dahil et
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";

// CORS (Opsiyonel: Başka domainlerden gelen istekleri kabul etmek için kullanılır)
header("Content-Type: application/json");

// HTTP method kontrolü
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only PUT requests are allowed']);
    exit;
}

// JSON girdisini al ve çözümle
$data = json_decode(file_get_contents("php://input"), true);

// Girdi doğrulama
if (!isset($data['id']) || !is_numeric($data['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid or missing ID']);
    exit;
}

// Değişkenleri ata (nullable alanları destekler)
$id = (int) $data['id'];
$form_type = $data['form_type'] ?? null;
$survey_id = $data['survey_id'] ?? null;
$title = $data['title'] ?? null;
$description = $data['description'] ?? null;
$min = isset($data['min']) ? (int) $data['min'] : null;
$max = isset($data['max']) ? (int) $data['max'] : null;
$isOptional = isset($data['isOptional']) ? (bool) $data['isOptional'] : null;

try {
    // Güncelleme fonksiyonunu çağır
    $result = Survey_fields::update_survey_fields(
        $id,
        $form_type,
        $survey_id,
        $title,
        $description,
        $min,
        $max,
        $isOptional
    );

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Survey field updated successfully'
        ]);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode([
            'success' => false,
            'message' => 'No changes were made or invalid field ID'
        ]);
    }
} catch (InvalidArgumentException $e) {
    // Gerekli alanlar eksikse
    http_response_code(400); // Bad Request
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    // Veritabanı veya genel hata durumunda
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'An error occurred while updating the survey field',
        'details' => $e->getMessage()
    ]);
}
