<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";
session_start();
// API URL
$url = "https://qs-api-3.onrender.com/generate-survey";

// Gönderilecek veri (JSON formatında)
$prompt=$_GET["request"];
$data = [
    "prompt" => $prompt
];

// cURL oturumunu başlat
$ch = curl_init($url);

// cURL ayarları
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// İstek gönder ve yanıtı al
$response = curl_exec($ch);

// Hata kontrolü
if (curl_errno($ch)) {
    echo json_encode([
        "success" => false,
        "message" => "cURL Error: " . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

// Yanıtı kapat
curl_close($ch);
$response_data = json_decode($response, true);

if (isset($response_data['survey'])) {
    // `survey` alanındaki metni temizle
    $clean_json = preg_replace("/```json\n|\n```/", "", $response_data['survey']); // Markdown formatını kaldır
    $clean_json = trim($clean_json); // Fazla boşlukları temizle

    // Temizlenmiş JSON'u çözümle
    $parsed_json = json_decode($clean_json, true);

    if ($parsed_json) {
        try {
            $hash_id = bin2hex(random_bytes(8)); // 16 karakterlik rastgele bir string

            $survey_instance = Survey::create($_SESSION["user_id"], $parsed_json["title"], $parsed_json["description"], $parsed_json["exp_date"], $hash_id);
            $survey = Survey::getByHashId($hash_id);

            if (!$survey) {
                throw new Exception("Survey could not be retrieved after creation.");
            }

            foreach ($parsed_json['fields'] as $field) {
                $survey_field_id = Survey_fields::createSurveyFields($survey["id"]);
                Survey_fields::update_survey_fields($survey_field_id, $field['type'], $survey["id"], $field['label']);
            }

            // Başarılı JSON yanıtı döndür
            echo json_encode([
                "success" => true,
                "message" => "Survey successfully created.",
                "hash_id" => $hash_id
            ]);

        } catch (Exception $e) {
            // Hata JSON yanıtı döndür
            echo json_encode([
                "success" => false,
                "message" => "Error: " . $e->getMessage()
            ]);
        }

    }
} else {
    echo "Error: 'survey' key is missing.";
}
