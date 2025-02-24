<?php
// Gerekli dosyaları dahil et
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";

// CORS (Opsiyonel: Gerekirse diğer originlerden gelen istekleri kabul etmek için kullanılır)
header("Content-Type: application/json");

// HTTP method kontrolü
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only DELETE requests are allowed']);
    exit;
}

// JSON girdisini al ve çözümle
$data = json_decode(file_get_contents("php://input"), true);

// survey_fields_id kontrolü
if (!isset($data['survey_fields_id']) || !is_numeric($data['survey_fields_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid or missing survey_fields_id']);
    exit;
}

$survey_fields_id = (int) $data['survey_fields_id'];

try {
    // Kaydı silmek için metodu çağır
    $success = Survey_fields::delete_survey_fields($survey_fields_id);

    if ($success) {
        // Başarılı durum
        echo json_encode([
            'success' => true,
            'message' => 'Survey field deleted successfully'
        ]);
    } else {
        // Silme işlemi başarısız olduysa
        http_response_code(404); // Not Found
        echo json_encode([
            'success' => false,
            'message' => 'Survey field not found or already deleted'
        ]);
    }
} catch (PDOException $e) {
    // Hata durumunda yanıt
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}
