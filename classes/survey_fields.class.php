<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey.class.php";

class Survey_fields {

    public static function getSurveyField($survey_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM survey_fields WHERE survey_id = :survey_id order by id asc");
        $stmt->bindParam(':survey_id', $survey_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getSurveyFieldNumerics($survey_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("
    SELECT * 
    FROM survey_fields 
    WHERE survey_id = :survey_id 
    AND type_id IN (3, 4, 5, 6, 9, 10, 11) 
    ORDER BY id ASC
");
        $stmt->bindParam(':survey_id', $survey_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getSurveyFieldTexts($survey_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("
    SELECT * 
    FROM survey_fields 
    WHERE survey_id = :survey_id 
    AND type_id IN (7,8) 
    ORDER BY id ASC
");
        $stmt->bindParam(':survey_id', $survey_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public static function createSurveyFields($survey_id){
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO survey_fields (survey_id) VALUES (:survey_id)");
        $stmt->bindParam(':survey_id', $survey_id);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    public static function delete_survey_fields($survey_fields_id){
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM survey_fields WHERE id = :survey_fields_id");
        $stmt->bindParam(':survey_fields_id', $survey_fields_id);
        return $stmt->execute();
    }


    public static function update_survey_fields(
        $id,
        $form_type = null,
        $survey_id = null,
        $title = null,
        $description = null,
        $min = null,
        $max = null,
        $isOptional = null
    ) {
        global $pdo;

        // Güncellenebilir alanlar
        $fields = [
            'type_id' => $form_type,
            'survey_id' => $survey_id,
            'title' => $title,
            'description' => $description,
            'min' => $min,
            'max' => $max,
            'isOptional' => $isOptional
        ];

        // Sadece null olmayan değerleri filtrele
        $updates = [];
        $params = [];
        foreach ($fields as $column => $value) {
            if ($value !== null) {
                $updates[] = "$column = :$column";
                $params[":$column"] = $value;
            }
        }

        // Eğer güncellenecek bir alan yoksa hata döndür
        if (empty($updates)) {
            throw new InvalidArgumentException("No fields to update.");
        }

        // SQL sorgusunu oluştur
        $sql = "UPDATE survey_fields SET " . implode(", ", $updates) . " WHERE id = :id";
        $params[":id"] = $id;

        // Sorguyu hazırla ve çalıştır
        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Hata durumunda istisna fırlat
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public static function getSurveyFieldsById($id){
        global $pdo;
        $sql = "SELECT * FROM survey_fields WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Parametre bağlama
        $stmt->execute(); // Sorguyu çalıştırma
        return $stmt->fetch(PDO::FETCH_ASSOC); // Tüm sonuçları döndürme
    }


    public static function getNextSurveyField($id) {
        global $pdo;

        try {
            // 1. Mevcut ID'nin survey_id'sini öğren
            $sqlCurrent = "SELECT survey_id FROM survey_fields WHERE id = :id LIMIT 1";
            $stmtCurrent = $pdo->prepare($sqlCurrent);
            $stmtCurrent->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtCurrent->execute();

            $current = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

            // Eğer mevcut ID bulunamazsa null döndür
            if (!$current) {
                return null;
            }

            $survey_id = $current['survey_id'];

            // 2. Aynı survey_id'ye sahip bir sonraki survey_field'i getir
            $sqlNext = "
            SELECT id 
            FROM survey_fields 
            WHERE survey_id = :survey_id AND id > :id 
            ORDER BY id ASC 
            LIMIT 1
        ";
            $stmtNext = $pdo->prepare($sqlNext);
            $stmtNext->bindParam(':survey_id', $survey_id, PDO::PARAM_INT);
            $stmtNext->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtNext->execute();

            $next = $stmtNext->fetch(PDO::FETCH_ASSOC);

            // Eğer sonraki survey_field bulunamazsa null döndür
            if (!$next) {
                return null;
            }

            return $next['id'];
        } catch (PDOException $e) {
            // Hata durumunda hata mesajını loglamanız önerilir
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public static function getPreviousSurveyField($id) {
        global $pdo;

        try {
            // 1. Mevcut ID'nin survey_id'sini öğren
            $sqlCurrent = "SELECT survey_id FROM survey_fields WHERE id = :id LIMIT 1";
            $stmtCurrent = $pdo->prepare($sqlCurrent);
            $stmtCurrent->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtCurrent->execute();

            $current = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

            // Eğer mevcut ID bulunamazsa null döndür
            if (!$current) {
                return null;
            }

            $survey_id = $current['survey_id'];

            // 2. Aynı survey_id'ye sahip bir önceki survey_field'i getir
            $sqlPrevious = "
            SELECT id 
            FROM survey_fields 
            WHERE survey_id = :survey_id AND id < :id 
            ORDER BY id DESC 
            LIMIT 1
        ";
            $stmtPrevious = $pdo->prepare($sqlPrevious);
            $stmtPrevious->bindParam(':survey_id', $survey_id, PDO::PARAM_INT);
            $stmtPrevious->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtPrevious->execute();

            $previous = $stmtPrevious->fetch(PDO::FETCH_ASSOC);

            // Eğer önceki survey_field bulunamazsa null döndür
            if (!$previous) {
                return null;
            }

            return $previous['id'];
        } catch (PDOException $e) {
            // Hata durumunda hata mesajını loglamanız önerilir
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public static function getOrderOfSurveyField($id)
    {
        global $pdo;

        try {
            // 1. Verilen id'nin survey_id'sini öğren
            $sqlCurrent = "SELECT survey_id FROM survey_fields WHERE id = :id LIMIT 1";
            $stmtCurrent = $pdo->prepare($sqlCurrent);
            $stmtCurrent->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtCurrent->execute();

            $current = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

            // Eğer mevcut ID bulunamazsa null döndür
            if (!$current) {
                return null;
            }

            $survey_id = $current['survey_id'];

            // 2. Aynı survey_id'ye sahip tüm survey_fields'i al
            $sqlFields = "
        SELECT id 
        FROM survey_fields 
        WHERE survey_id = :survey_id
        ORDER BY id ASC
        ";
            $stmtFields = $pdo->prepare($sqlFields);
            $stmtFields->bindParam(':survey_id', $survey_id, PDO::PARAM_INT);
            $stmtFields->execute();

            $surveyFields = $stmtFields->fetchAll(PDO::FETCH_ASSOC);

            // 3. Verilen id'nin sırasını bul
            $order = array_search($id, array_column($surveyFields, 'id'));

            // Eğer sırası bulunamazsa null döndür
            return $order !== false ? $order + 1 : null;

        } catch (PDOException $e) {
            // Hata durumunda hata mesajını loglamanız önerilir
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }




}