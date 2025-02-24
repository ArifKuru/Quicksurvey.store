<?php
// Gerekli dosyaları dahil et
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/survey.class.php";

// CORS (isteğe bağlı)
header("Access-Control-Allow-Headers: Content-Type");
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
    echo json_encode(['error' => 'Invalid or missing survey ID']);
    exit;
}

// Parametreleri al (nullable alanlar için varsayılan null değerleri atanır)
$id = (int) $data['id'];
$title = $data['title'] ?? null;
$description = $data['description'] ?? null;
$exp_date = $data['exp_date'] ?? null;
$isPrivacyMode = isset($data['isPrivacyMode']) ? (bool) $data['isPrivacyMode'] : null;
$backgroundColor = $data['backgroundColor'] ?? null;
$fontColor = $data['fontColor'] ?? null;

try {
    // Güncelleme fonksiyonunu çağır
    $result = Survey::update(
        $id,
        $title,
        $description,
        $exp_date,
        $isPrivacyMode,
        $backgroundColor,
        $fontColor
    );

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Survey updated successfully'
        ]);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode([
            'success' => false,
            'message' => 'No fields were updated or invalid survey ID'
        ]);
    }
} catch (Exception $e) {
    // Genel hata yönetimi
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'error' => 'An error occurred while updating the survey',
        'details' => $e->getMessage()
    ]);
}
