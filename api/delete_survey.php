<?php
// Veritabanı bağlantısı ve Survey sınıfını dahil edin
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/survey.class.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // JSON verisini oku
    $input = json_decode(file_get_contents('php://input'), true);

    // İd parametresini kontrol et
    if (isset($input['id']) && is_numeric($input['id'])) {
        $id = intval($input['id']);

        try {
            // Survey sınıfındaki delete fonksiyonunu çağır
            $result = Survey::delete($id);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Survey successfully marked as deleted.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to mark survey as deleted.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid or missing survey ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
