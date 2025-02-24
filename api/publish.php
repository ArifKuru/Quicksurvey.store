<?php
// Veritabanı bağlantısını içeren dosyayı ekleyin
require_once $_SERVER["DOCUMENT_ROOT"].'/classes/survey.class.php'; // publishTheSurvey fonksiyonunu içeren sınıfı ekleyin

header('Content-Type: application/json');

try {
    // Gelen isteğin HTTP metodunu kontrol et
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['success' => false, 'message' => 'Only POST method is allowed.']);
        exit;
    }

    // İstek gövdesinden veriyi alın
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Gerekli alanları kontrol et
    if (!isset($data['id']) || !is_numeric($data['id'])) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Invalid survey ID.']);
        exit;
    }

    // Survey sınıfından publishTheSurvey metodunu çağır
    $result = Survey::publishTheSurvey(['id' => $data['id']]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Survey published successfully.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Failed to publish the survey.']);
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'An unexpected error occurred.', 'error' => $e->getMessage()]);
}
