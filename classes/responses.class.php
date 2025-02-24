<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/config/config.php";
class Responses
{
    private $id;
    private $survey_fields_id;
    private $value;
    private $created_at;
    private $profile_id;

    public static function create($survey_fields_id,$value,$profile_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO responses (survey_fields_id, value, profile_id) VALUES (:survey_fields_id, :value, :profile_id)");
        $stmt->bindParam(':survey_fields_id', $survey_fields_id);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':profile_id', $profile_id);
        return $stmt->execute();
    }

    public static function getCountResponses($survey_id) {
        global $pdo;

        try {
            // Öncelikle verilen survey_id ile survey_fields tablosundan eşleşen survey_fields_id'leri alalım.
            $query = "SELECT id FROM survey_fields WHERE survey_id = :survey_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':survey_id', $survey_id, PDO::PARAM_INT);
            $stmt->execute();

            $survey_fields_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (empty($survey_fields_ids)) {
                // Eğer eşleşen bir survey_fields_id yoksa, 0 döndür.
                return 0;
            }

            // survey_fields_id listesi oluştur.
            $placeholders = implode(',', array_fill(0, count($survey_fields_ids), '?'));

            // responses tablosunda farklı profile_id sayısını al.
            $query = "SELECT COUNT(DISTINCT profile_id) FROM responses WHERE survey_fields_id IN ($placeholders)";
            $stmt = $pdo->prepare($query);
            $stmt->execute($survey_fields_ids);

            $distinct_profile_count = $stmt->fetchColumn();

            return $distinct_profile_count;
        } catch (Exception $e) {
            // Hata durumunda bir hata mesajı ya da uygun bir yanıt dönebilirsiniz.
            error_log("Error in getCountResponses: " . $e->getMessage());
            return 0;
        }
    }

    public static function getValueCounts($survey_fields_id)
    {
        global $pdo;
        $sql = "
        SELECT value, COUNT(*) as count 
        FROM responses 
        WHERE survey_fields_id = :survey_fields_id 
        GROUP BY value
    ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':survey_fields_id', $survey_fields_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}